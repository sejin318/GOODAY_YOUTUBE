<?php

/**
 * 슬라이더의 페이지 삭제
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
    $sql = "SELECT * from `" . BP_SLIDER_LIST_TABLE . "` where `bss_idx` = '{$idx}'";
    $del_item = sql_fetch($sql);

    //이미지 삭제
    @unlink(BP_SLIDERSAVE_DIR . DIRECTORY_SEPARATOR . $del_item['bss_image']);
    //DB 삭제
    sql_query("DELETE from `" . BP_SLIDER_LIST_TABLE . "` where `bss_idx` = '{$idx}' limit 1");
    //페이지 수 업데이트
    sql_query("UPDATE `" . BP_SLIDER_TABLE . "` set `bs_page_count` = `bs_page_count` - 1 where `bs_idx` = '{$del_item['bss_parent']}' limit 1");

    $_SESSION['message'] = "{$del_item['bss_name']} 페이지가 삭제되었습니다.";
    goto_url('./bp_slider.php?w=u&idx=' . $del_item['bss_parent']);
}
