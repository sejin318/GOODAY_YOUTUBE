<?php
include_once "./_common.php";
/**
 * Ajax Scrap 
 */
if (!$is_member) {
    exit;
}

if ($_POST) {
    $sql = "SELECT count(*) cnt from `{$g5['scrap_table']}` where (`bo_table` = '{$bo_table}' and `wr_id`='{$wr_id}')and `mb_id` = '{$member['mb_id']}'";
    $count = sql_fetch($sql);
    //있으면 삭제
    if ($count['cnt'] > 0) {
        //Scrap 삭제
        $sql = "DELETE from `{$g5['scrap_table']}` where (`bo_table` = '{$bo_table}' and `wr_id`='{$wr_id}')and `mb_id` = '{$member['mb_id']}' limit 1";
        sql_query($sql);
        header('Content-type: application/json');
        echo json_encode(array('result' => 'delete'));
    } else {
        //즐겨찾기 추가
        $sql = "INSERT into `{$g5['scrap_table']}` set  `wr_id` ='{$wr_id}',
                                                        `bo_table` = '{$bo_table}',
                                                        `mb_id` = '{$member['mb_id']}',
                                                        `ms_datetime` =  '" . G5_TIME_YMDHIS . "' ";
        sql_query($sql);
        header('Content-type: application/json');
        echo json_encode(array('result' => 'add'));
    }
}
