<?php
include_once "./_common.php";
if (!$is_member) {
    exit;
}
// 댓글 토큰을 이용해 체크
$delete_token = get_session('ss_comment_token');
set_session('ss_comment_token', '');

if (!($token && $delete_token == $token)){
    alert('토큰 에러로 삭제 불가합니다.');
    exit;
}



//즐겨찾기 삭제
$sql = "DELETE from `" . BP_FAVORITE_TABLE . "` where bf_idx = '{$idx}' and bf_mb_id = '{$member['mb_id']}' limit 1";
sql_query($sql);
$_SESSION['message'] = "즐겨찾기가 삭제되었습니다.";
//목록으로 이동
goto_url(BP_MYPAGE_URL . DIRECTORY_SEPARATOR . 'my_favorite.php');
