<?php
include_once "./_common.php";
if (!$is_member) {
    exit;
}
// 댓글 토큰을 이용해 체크
$delete_token = get_session('ss_comment_token');
set_session('ss_comment_token', '');

if (!($token && $delete_token == $token)) {
    alert('토큰 에러로 삭제 불가합니다.');
}


if ($type == 'allread') {
    /**
     * 알람전체 읽기 설정
     */
    $sql = "UPDATE `" . BP_ALARM_TABLE . "` SET `ba_read` = '1' WHERE `ba_mb_id` = '" . Asktools::xss_clean(escape_trim($member['mb_id'])) . "'";
    sql_query($sql, false);
    $_SESSION['message'] = '모든 알람이 읽기 처리 되었습니다.';
    goto_url(BP_MYPAGE_URL . '/my_alarm.php');
    exit;
}

if ($type == 'alldelete') {
    /**
     * 알람전체 삭제하기
     */
    $sql = "DELETE from  `" . BP_ALARM_TABLE . "` WHERE `ba_mb_id` = '" . Asktools::xss_clean(escape_trim($member['mb_id'])) . "'";
    sql_query($sql, false);
    $_SESSION['message'] = '모든 알람이 삭제 처리 되었습니다.';
    goto_url(BP_MYPAGE_URL . '/my_alarm.php');
    exit;
}

if ($type == 'delete' && $ba_idx) {
    /**
     * 알람1개 삭제하기
     */
    $ba_idx = Asktools::xss_clean($ba_idx);
    $sql = "DELETE from  `" . BP_ALARM_TABLE . "` WHERE `ba_idx` = '{$ba_idx}' and `ba_mb_id` = '" . Asktools::xss_clean(escape_trim($member['mb_id'])) . "' limit 1";
    sql_query($sql, true);
    $_SESSION['message'] = '알람이 삭제 처리 되었습니다.';
    goto_url(BP_MYPAGE_URL . '/my_alarm.php?page=' . $page);
    exit;
}
