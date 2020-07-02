<?php
include_once "./_common.php";
/**
 * 댓글 이미지 첨부 삭제
 */
header('Content-type: application/json');

if (!$is_member) {
    echo json_encode(array('error' => '회원전용입니다. 올바른 방법으로 이용해 주세요.#0'), JSON_PRETTY_PRINT);
}


// 토큰체크
$upload_token = trim(get_session('ss_comment_token'));
set_session('ss_comment_token', '');
if (!trim($_POST['comment_image_token']) || !$upload_token || $upload_token != $_POST['comment_image_token']) {

    echo json_encode(array("request" => $_POST, 'error' => '올바른 방법으로 이용해 주세요.#1' . $_POST['comment_image_token'] . '=' . $upload_token), JSON_PRETTY_PRINT);
    exit;
}

if ($_POST) {
    $sql = "SELECT * from `{$g5['board_file_table']}` where `wr_id` = '{$target_key}' and `bo_table` = '{$bo_table}' and `bf_file` = '{$filename}'";
    $row = sql_fetch($sql);

    $delete_file = G5_DATA_PATH . '/file/' . $bo_table . '/' . str_replace('../', '', $row['bf_file']);
    if (file_exists($delete_file)) {
        @unlink($delete_file);
    }
    // 썸네일삭제
    if (preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
        delete_board_thumbnail($bo_table, $row['bf_file']);
    }
    //DB삭제
    $sql = "DELETE from `{$g5['board_file_table']}` where `wr_id` = '{$target_key}' and `bo_table` = '{$bo_table}' and `bf_file` = '{$filename}' limit 1";
    $row = sql_fetch($sql);

    echo json_encode(array('success' => '삭제되었습니다.  '), JSON_PRETTY_PRINT);
    exit;
} else {
    echo json_encode(array('error' => 'ERROR'), JSON_PRETTY_PRINT);
}
