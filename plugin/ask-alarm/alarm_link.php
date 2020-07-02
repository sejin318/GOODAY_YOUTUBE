<?php
include_once "./_common.php";
if (!$is_member) {
    exit;
}
if (!$ba_idx) {
    exit;
}
$sql = "SELECT * from `" . BP_ALARM_TABLE . "` where `ba_idx` = '" . Asktools::xss_clean($ba_idx) . "' and `ba_mb_id` = '" . escape_trim($member['mb_id']) . "'";
$link = sql_fetch($sql);

if ($link) {
    //댓글알람
    if (($link['ba_type'] == 'comment' || $link['ba_type'] == 'reply') && $link['ba_bo_table'] && $link['ba_wr_id']) {
        $_url = get_pretty_url($link['ba_bo_table'], $link['ba_wr_id']);
        //읽음 Update
        $sql = "UPDATE `" . BP_ALARM_TABLE . "` SET `ba_read` = '1' WHERE `ba_idx` = " . Asktools::xss_clean($ba_idx) . " limit 1";
        sql_query($sql);
    }
    if ($link['ba_type'] == 'qna') {
        //읽음 Update
        $_url = G5_BBS_URL . "/qaview.php?qa_id={$link['ba_wr_id']}";
        $sql = "UPDATE `" . BP_ALARM_TABLE . "` SET `ba_read` = '1' WHERE `ba_idx` = " . Asktools::xss_clean($ba_idx) . " limit 1";
        sql_query($sql);
    }
    if ($link['ba_type'] == 'memo') {
        //읽음 Update
        $_url = G5_BBS_URL . "/memo_view.php?me_id={$link['ba_me_id']}&kind=recv";
        $sql = "UPDATE `" . BP_ALARM_TABLE . "` SET `ba_read` = '1' WHERE `ba_idx` = " . Asktools::xss_clean($ba_idx) . " limit 1";
        sql_query($sql);
    }


    header("Location:{$_url}");
}
