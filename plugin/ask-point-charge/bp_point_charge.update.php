<?php

/**
 * 포인트 충전 
 */
include_once "./_common.php";
if (!$is_member) {
    alert('로그인 후 이용하세요.');
    exit;
}
// 댓글 토큰을 이용해 체크
$charge_token = get_session('ss_comment_token');
set_session('ss_comment_token', '');

if (!($token && $charge_token == $token)) {
    alert('토큰 에러로 처라기 불가합니다.');
    exit;
}

if (!$_POST) {
    alert('잘못된 접속입니다.');
    exit;
}
//등록
if ($_POST && !$w && !$idx) {
    $charge_point = Asktools::clean($bo_point);
    if ($bo_point_customer) {
        $charge_point = Asktools::clean($bo_point_customer);
    }
    $bo_bank = Asktools::clean($bo_bank);
    $bo_name = Asktools::clean($bo_name);
    $bo_email = Asktools::clean($bo_email);
    $mb_id = Asktools::clean($member['mb_id']);

    $sql = "INSERT into `" . BP_POINT_CHARGE_TABLE . "` set `bo_mb_id` = '{$mb_id}',
                                                            `bo_point` = '{$charge_point}',
                                                            `bo_datetime` = '" . G5_TIME_YMDHIS . "',
                                                            `bo_bank` = '{$bo_bank}',
                                                            `bo_name` = '{$bo_name}',
                                                            `bo_email` = '{$bo_email}',
                                                            `bo_order_state` = '주문',
                                                            `bo_ip` = '{$_SERVER['REMOTE_ADDR']}'";
    sql_query($sql);
    $last_id = sql_insert_id();
    alert('포인트 충전 신청이 완료되었습니다.', './bp_point_charge.php?w=u&idx=' . $last_id);
    exit;
}

//수정
if ($_POST && $w == 'u' && $idx) {
    $idx = Asktools::clean($idx);
    $mb_id = Asktools::clean($member['mb_id']);
    //취소
    if ($bo_cancel) {
        $sql = "UPDATE  `" . BP_POINT_CHARGE_TABLE . "` set `bo_name` = '{$bo_name}', `bo_email` = '{$bo_email}', `bo_order_state` = '취소', `bo_cancel_datetime`= '" . G5_TIME_YMDHIS . "'   where `bo_mb_id`='{$mb_id}' and `bo_idx` = '{$idx}' limit 1";
        sql_query($sql, true);
        alert('포인트 충전 신청이 취소되었습니다.', './bp_point_charge.php?w=u&idx=' . $idx);
        exit;
    } else {
        $sql = "UPDATE  `" . BP_POINT_CHARGE_TABLE . "` set `bo_name` = '{$bo_name}', `bo_email` = '{$bo_email}' where `bo_mb_id`='{$mb_id}' and `bo_idx` = '{$idx}' limit 1";
        sql_query($sql);
        alert('포인트 충전 신청이 수정되었습니다.', './bp_point_charge.php?w=u&idx=' . $idx);
        exit;
    }
}
