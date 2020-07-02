<?php

/**
 * 포인트 환불
 */
include_once "./_common.php";
if (!$is_member) {
    alert('로그인 후 이용하세요.');
    exit;
}
// 댓글 토큰을 이용해 체크
$refund_token = get_session('ss_comment_token');
set_session('ss_comment_token', '');

if (!($token && $refund_token == $token)) {
    alert('토큰 에러로 처라기 불가합니다.');
    exit;
}

if (!$_POST) {
    alert('잘못된 접속입니다.');
    exit;
}

//환불요청 등록
if ($_POST && !$w && !$idx) {
    $refund_point = Asktools::clean($br_point);
    $br_bank_name = Asktools::clean($br_bank_name);
    $br_bank_acount = Asktools::clean($br_bank_acount);
    $br_name = Asktools::clean($br_name);
    $br_email = Asktools::clean($br_email);
    $mb_id = Asktools::clean($member['mb_id']);

    $sql = "INSERT into `" . BP_POINT_REFUND_TABLE . "` set `br_mb_id` = '{$mb_id}',
                                                            `br_point` = '{$refund_point}',
                                                            `br_datetime` = '" . G5_TIME_YMDHIS . "',
                                                            `br_bank_name` = '{$br_bank_name}',
                                                            `br_bank_acount` = '{$br_bank_acount}',
                                                            `br_name` = '{$br_name}',
                                                            `br_email` = '{$br_email}',
                                                            `br_ip` = '{$_SERVER['REMOTE_ADDR']}'";
    sql_query($sql);
    $last_id = sql_insert_id();
    alert('포인트 환불 신청이 완료되었습니다.', './bp_point_refund.php?w=u&idx=' . $last_id);
    exit;
}

//수정
if ($_POST && $w == 'u' && $idx) {
    $idx = Asktools::clean($idx);
    $mb_id = Asktools::clean($member['mb_id']);
    //취소
    if ($br_cancel) {
        $sql = "DELETE from  `" . BP_POINT_REFUND_TABLE . "` where `br_mb_id`='{$mb_id}' and `br_idx` = '{$idx}' limit 1";
        sql_query($sql, true);
        alert('포인트 환불 신청이 취소되었습니다.', './bp_point_refund_list.php');
        exit;
    } else {
        $sql = "UPDATE  `" . BP_POINT_REFUND_TABLE . "` set `br_bank_name` = '{$br_bank_name}',
                                                            `br_bank_acount` = '{$br_bank_acount}',
                                                            `br_name` = '{$br_name}',
                                                            `br_email` = '{$br_email}'
                                                            where `br_mb_id`='{$mb_id}' and `br_idx` = '{$idx}' limit 1";
        sql_query($sql);
        alert('포인트 환불 신청이 수정되었습니다.', './bp_point_refund.php?w=u&idx=' . $idx);
        exit;
    }
}
