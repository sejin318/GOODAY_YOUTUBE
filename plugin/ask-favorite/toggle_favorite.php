<?php
include_once "./_common.php";
if (!$is_member) {
    exit;
}
if ($mb_id != $member['mb_id']) {
    exit;
}
if ($_POST) {
    $sql = "SELECT count(*) cnt from `" . BP_FAVORITE_TABLE . "` where bf_bo_table = '{$bo_table}' and bf_mb_id = '{$mb_id}'";
    $count = sql_fetch($sql);
    //있으면 삭제
    if ($count['cnt'] > 0) {
        //즐겨찾기 삭제
        $sql = "DELETE from `" . BP_FAVORITE_TABLE . "` where bf_bo_table = '{$bo_table}' and bf_mb_id = '{$mb_id}' limit 1";
        sql_query($sql);
        header('Content-type: application/json');
        echo json_encode(array('result' => 'delete'));
    } else {
        //즐겨찾기 추가
        $sql = "INSERT into `" . BP_FAVORITE_TABLE . "` set bf_subject ='{$subject}',
                                                            bf_bo_table = '{$bo_table}',
                                                            bf_mb_id = '{$mb_id}'";
        sql_query($sql);
        header('Content-type: application/json');
        echo json_encode(array('result' => 'add'));
    }
}
