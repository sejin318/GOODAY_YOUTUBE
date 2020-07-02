<?php

/**
 * 슬라이더 삭제
 * 하위 페이지까지 모두 삭제
 */
$sub_menu = "800120";
include_once './_common.php';

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

if (!$_GET || !$idx) {
    alert('잘못된 접속입니다!.');
    exit;
}

if ($w == 'de' && $idx) {
    //페이지 먼저 삭제
    $sql = "SELECT * from `" . BP_SLIDER_LIST_TABLE . "` where `bss_parent` = '{$idx}'";
    $result = sql_query($sql);

    //DB에서 하나씩 삭제
    while ($rows = sql_fetch_array($result)) {
        //이미지 삭제
        @unlink(BP_SLIDERSAVE_DIR . DIRECTORY_SEPARATOR . $rows['bss_image']);
        sql_query("DELETE from `" . BP_SLIDER_LIST_TABLE . "` where `bss_idx` = '{$rows['bss_idx']}' limit 1");
    }
    //슬라이더 삭제
    sql_query("DELETE from `" . BP_SLIDER_TABLE . "` where `bs_idx` = '{$idx}' limit 1");

    $_SESSION['message'] = "슬라이더가 삭제되었습니다.";
    //목록으로 이동
    goto_url('./bp_slider_list.php');
}
