<?php

/**
 * 마이페이지 콘텐츠 목록에서 다운받기
 */
include_once('./_common.php');
$idx = Asktools::clean($idx);

// clean the output buffer
ob_end_clean();

// 댓글 토큰을 이용해 다른곳에서 다운 하지 못하게 체크
$download_token = get_session('ss_comment_token');
set_session('ss_comment_token', '');
if (!($token && $download_token == $token)) {
    alert('토큰 에러로 다운로드가 불가합니다.');
    exit;
}

//비회원 차단
if ($is_guest) {
    alert('회원전용입니다.');
    exit;
}

//구매한 컨텐츠인지 체크
$sql = "SELECT * from `" . BP_DOWNLOAD_TABLE . "` where `bd_mb_id` = '" . escape_trim($member['mb_id']) . "' and `bd_idx` = '{$idx}'";
$down = sql_fetch($sql);
if (!$down) {
    alert('정보가 존재하지 않습니다.');
    exit;
}

//파일정보
$file = ASKDB::get_file($down['bd_bo_table'], $down['bd_wr_id'], $down['bd_bf_no']);
if (!$file['bf_file']) {
    alert('파일 정보가 존재하지 않습니다.');
    exit;
}

// JavaScript 불가일 때
if ($js != 'on') {
    die('스크립트를 실행을 할 수 없습니다 ');
    exit;
}

$board = ASKDB::get_board_info($down['bd_bo_table']);
if ($member['mb_level'] < $board['bo_download_level']) {
    $alert_msg = '다운로드 권한이 없습니다.';
    if ($member['mb_id']) {
        alert($alert_msg);
        exit;
    } else {
        alert($alert_msg . '\\n회원이시라면 로그인 후 이용해 보십시오.', G5_BBS_URL . '/login.php?wr_id=' . $down['bd_wr_id'] . '&amp;' . $qstr . '&amp;url=' . urlencode(get_pretty_url($down['bd_bo_table'], $down['bd_wr_id'])));
        exit;
    }
}

$filepath = G5_DATA_PATH . '/file/' . $down['bd_bo_table'] . '/' . $file['bf_file'];
$filepath = addslashes($filepath);
$file_exist_check = (!is_file($filepath) || !file_exists($filepath)) ? false : true;

if (false === run_replace('download_file_exist_check', $file_exist_check, $file)) {
    alert($filepath . '파일이 존재하지 않습니다.');
    exit;
}

//컨텐츠 구매 목록에 다운로드 카운트 증가
$sql = "UPDATE `" . BP_DOWNLOAD_TABLE . "` set `bd_down_count` = `bd_down_count` + 1 where `bd_idx` = '{$idx}' limit 1";
sql_query($sql, true);
// 다운로드 카운트 증가
$sql = " UPDATE `{$g5['board_file_table']}` set `bf_download` = bf_download + 1 where `bo_table` = '{$down['bd_bo_table']}' and `wr_id` = '{$down['bd_wr_id']}' and `bf_no` = '{$down['bd_bf_no']}' ";
sql_query($sql);


$g5['title'] = '다운로드 &gt; ' . conv_subject($down['bd_content'], 255);

$original = urlencode($file['bf_source']);

if (preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    header("content-length: " . filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-transfer-encoding: binary");
} else if (preg_match("/Firefox/i", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: file/unknown");
    header("content-length: " . filesize("$filepath"));
    header("content-disposition: attachment; filename=\"" . basename($file['bf_source']) . "\"");
    header("content-description: php generated data");
} else {
    header("content-type: file/unknown");
    header("content-length: " . filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
flush();

$fp = fopen($filepath, 'rb');
$download_rate = 10;

while (!feof($fp)) {
    print fread($fp, round($download_rate * 1024));
    flush();
    usleep(1000);
}
fclose($fp);
flush();
