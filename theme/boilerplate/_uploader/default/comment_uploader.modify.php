<?php
include_once "./_common.php";
/**
 * 댓글 이미지 첨부 목록 출력
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
    //목록 
    $sql = "SELECT * from `{$g5['board_file_table']}` where `wr_id` = '{$wr_id}' and `bo_table` = '{$bo_table}'";
    $result = sql_query($sql);
    $img = array();
    while ($rows = sql_fetch_array($result)) {
        $img[] = $rows;
    }

    echo json_encode($img, JSON_PRETTY_PRINT);
    exit;
} else {
    echo json_encode(array('error' => 'ERROR'), JSON_PRETTY_PRINT);
}
