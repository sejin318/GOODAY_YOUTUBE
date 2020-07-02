<?php

/**
 * 배너 링크 이동
 */
include_once "./_common.php";

if ($idx && is_numeric($idx)) {
    //URL 조회
    $sql = "SELECT * from `" . BP_BANNER_TABLE . "` where bb_idx = '{$idx}'";
    $url = sql_fetch($sql);
    //히트 업데이트
    $sql = "UPDATE `" . BP_BANNER_TABLE . "` set bb_hit = bb_hit + 1 where bb_idx = '{$idx}'";
    sql_query($sql);
    header("Location:{$url['bb_url']}");
} else if ($idx && is_numeric($idx) && $url) {
    //html url
    $sql = "SELECT * from `" . BP_BANNER_TABLE . "` where bb_idx = '{$idx}'";
    $_type = sql_fetch($sql);
    if ($_type['bb_type'] == 'html') {
        //히트 업데이트
        $sql = "UPDATE `" . BP_BANNER_TABLE . "` set bb_hit = bb_hit + 1 where bb_idx = '{$idx}'";
        sql_query($sql);
        header("Location:{$url}");
    }
}
