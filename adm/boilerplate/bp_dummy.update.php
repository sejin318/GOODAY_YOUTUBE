<?php

/**
 * 보일러플레이트 Dummy Update
 */

$sub_menu = "800150";
include_once './_common.php';
include_once G5_ADMIN_PATH . "/boilerplate/lib/faker.lib.php";
check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

check_admin_token();

if (!$_POST) {
    alert('잘못된 접속입니다.');
    exit;
}

//회원 삭제
if ($delete_faker_member && $dummy_type == 'member') {
    sql_query("DELETE FROM `{$g5['point_table']}` WHERE `po_rel_action` = 'faker-member'");
    sql_query("DELETE FROM `{$g5['member_table']}` WHERE mb_10='faker-member'");
    $_SESSION['message'] = "Dummy 회원이 삭제되었습니다.";
}
//회원 생성
if ($dummy_member && $dummy_type == 'member') {
    bp_fake_member($dummy_member);
    $_SESSION['message'] = "{$dummy_member}명의 회원이 생성되었습니다.";
}

//게시물 삭제
if (count($delete_faker_article) > 0) {
    foreach ($delete_faker_article as $del_bo_tabl) {
        bp_delete_all($del_bo_tabl);
    }
    $_SESSION['message'] .= "게시물이 삭제되었습니다. ";
}

//게시물 생성
if ($bo_table && $dummy_board && $dummy_type == 'board') {
    $image_attach = false;
    if ($add_images == true) {
        $image_attach = true;
    }

    $result = bp_faker_board($bo_table, $dummy_board, $image_attach);
    $_SESSION['message'] .= " 게시물이 생성되었습니다. ";
}


goto_url('./bp_dummy.php');
