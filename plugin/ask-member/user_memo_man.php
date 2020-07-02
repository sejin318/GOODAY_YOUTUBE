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

//메모 전체 삭제
if ($type == 'alldelete') {
    /**
     * 전체 삭제하기
     */
    $sql = "DELETE from  `" . BP_MEMBER_MEMO_TABLE . "` WHERE `bm_mb_id` = '" . Asktools::xss_clean(escape_trim($member['mb_id'])) . "'";
    sql_query($sql, false);

    $_SESSION['message'] = '모든 회원메모가 삭제 처리 되었습니다.';
    goto_url(BP_MYPAGE_URL . '/my_memo.php');

    exit;
}

if ($type == 'delete' && $bm_idx) {
    /**
     * 1개 삭제하기
     */
    $bm_idx = Asktools::xss_clean($bm_idx);
    $sql = "DELETE from  `" . BP_MEMBER_MEMO_TABLE . "` WHERE `bm_idx` = '{$bm_idx}' and `bm_mb_id` = '" . Asktools::xss_clean(escape_trim($member['mb_id'])) . "' limit 1";
    sql_query($sql, true);
    $_SESSION['message'] = '삭제 처리 되었습니다';
    goto_url(BP_MYPAGE_URL . '/my_memo.php?page=' . $page);
    exit;
}
