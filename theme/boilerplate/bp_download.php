<?php

/**
 * 파일 개별 포인트 다운로드
 * 다운받을때 항상 포인트 차감한다.
 */
include_once('./_common.php');
$no = Asktools::clean($no);
$bo_table = Asktools::clean($bo_table);
$wr_id = Asktools::clean($wr_id);

// clean the output buffer
ob_end_clean();

// 다른곳에서 링크 거는것을 방지하기 위한 코드
if (!get_session('ss_view_' . $bo_table . '_' . $wr_id)) {
    alert('잘못된 접근입니다.');
    exit;
}

if (!$board['bb_use_download_point']) {
    alert('사용할 수 없습니다.');
    exit;
}
//비회원 차단
if ($is_guest) {
    alert('회원전용입니다.');
    exit;
}
//파일정보
$file = ASKDB::get_file($bo_table, $wr_id, $no);
if (!$file['bf_file']) {
    alert('파일 정보가 존재하지 않습니다.');
    exit;
}
// JavaScript 불가일 때
if ($js != 'on') {
    die('스크립트를 실행을 할 수 없습니다 ');
    exit;
}

if ($member['mb_level'] < $board['bo_download_level']) {
    $alert_msg = '다운로드 권한이 없습니다.';
    if ($member['mb_id']) {
        alert($alert_msg);
        exit;
    } else {
        alert($alert_msg . '\\n회원이시라면 로그인 후 이용해 보십시오.', G5_BBS_URL . '/login.php?wr_id=' . $wr_id . '&amp;' . $qstr . '&amp;url=' . urlencode(get_pretty_url($bo_table, $wr_id)));
        exit;
    }
}

$filepath = G5_DATA_PATH . '/file/' . $bo_table . '/' . $file['bf_file'];
$filepath = addslashes($filepath);
$file_exist_check = (!is_file($filepath) || !file_exists($filepath)) ? false : true;

if (false === run_replace('download_file_exist_check', $file_exist_check, $file)) {
    alert('파일이 존재하지 않습니다.');
    exit;
}

if (($write['mb_id'] && $write['mb_id'] == $member['mb_id']) || $is_admin) {
        //본인, 관리자 통과
    ;
} else if ($board['bo_download_level'] >= 1) // 회원이상 다운로드가 가능하다면
{
    // 다운로드 포인트가 음수이고 회원의 포인트가 0 이거나 작다면
    if ($member['mb_point'] + $file['bf_download_point'] < 0) {
        alert('보유하신 포인트(' . number_format($member['mb_point']) . ')가 없거나 모자라서 다운로드(' . number_format($file['bf_download_point']) . ')가 불가합니다.\\n\\n포인트를 적립하신 후 다시 다운로드 해 주십시오.');
        exit;
    }

    ############################
    # 포인트 차감 - 무조건 차감
    ############################
    $uniq_id = uniqid();
    insert_point($member['mb_id'], -$file['bf_download_point'], "{$board['bo_subject']} - {$write['wr_subject']} ({$file['bf_content']}) 파일 다운로드", $bo_table, $wr_id, "다운로드-{$uniq_id}");

    //등록자에게 포인트 지급 
    if ($board['bb_use_download_save']) {
        insert_point($write['mb_id'], round($file['bf_download_point'] * ((100 - BP_POINT_COMMISSION) / 100)), "{$board['bo_subject']} - {$write['wr_subject']} ({$file['bf_content']}) 파일 판매", $bo_table, $wr_id, "판매-{$uniq_id}");
    }
    //컨텐츠 구매 목록에 저장
    $sql = "INSERT into `" . BP_DOWNLOAD_TABLE . "` set `bd_mb_id` = '{$member['mb_id']}',
                                                        `bd_bo_table` = '{$bo_table}',
                                                        `bd_wr_id` = '{$wr_id}',
                                                        `bd_bf_no` = '{$no}',
                                                        `bd_content` = '{$board['bo_subject']}-{$write['wr_subject']} ({$file['bf_content']})',
                                                        `bd_point` = '{$file['bf_download_point']}',
                                                        `bd_down_count` = `bd_down_count` + 1,
                                                        `bd_datetime` = '" . G5_TIME_YMDHIS . "',
                                                        `bd_ip` = '{$_SERVER['REMOTE_ADDR']}'";
    sql_query($sql, true);
}
// 다운로드 카운트 증가
$sql = " UPDATE `{$g5['board_file_table']}` set `bf_download` = bf_download + 1 where `bo_table` = '{$bo_table}' and `wr_id` = '{$wr_id}' and `bf_no` = '{$no}' ";
sql_query($sql);


$g5['title'] = '다운로드 &gt; ' . conv_subject($write['wr_subject'], 255);

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
