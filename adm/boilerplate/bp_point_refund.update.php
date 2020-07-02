<?php
$sub_menu = "800510";
include_once './_common.php';

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

check_admin_token();
if ($_POST && $br_refund_state) {
    //포인트 체크
    $mb = get_member($br_mb_id);
    if (!($mb['mb_point'] > 0 && $mb['mb_point'] >= $br_point)) {
        alert("환불신청한 포인트 보다 회원의 잔여 포인트가 적습니다.");
        exit;
    }

    if ($br_refund_state == '환불완료') {
        //DB update
        $sql = "UPDATE `" . BP_POINT_REFUND_TABLE . "` set `br_refund_state`='환불완료', `br_refund_datetime`='" . G5_TIME_YMDHIS . "' where `br_mb_id` = '{$br_mb_id}' and `br_idx` = '{$idx}' limit 1";
        sql_query($sql, true);
        (int) $refund_point = -$br_point;
        //포인트 차감 - 랜덤값 넣어줘야함
        $rand_rel = uniqid();
        insert_point($br_mb_id, $refund_point, "{$br_mb_id}님의 {$br_point} Point 환불완료", 'point-refund-' . $rand_rel, $idx . '-' . $rand_rel, '포인트환불 차감완료-' . $rand_rel);

        //쪽지 발송
        ASKDB::memo_send($br_mb_id, $config['cf_admin'], "{$br_mb_id}님의 환불이 완료되었습니다.\n\n {$br_point}포인트가 차감되었습니다.\n\n감사합니다.");
        if ($config['cf_email_use']) {
            //메일 발송
            include_once(G5_LIB_PATH . '/mailer.lib.php');
            mailer($config['cf_admin_email_name'], $config['cf_admin_email'], trim($br_email), "{$config['cf_title']} - 포인트 환불 완료 안내", "안녕하세요. <br/>{$br_mb_id}님, {$config['cf_title']} 입니다. <br/><br/> 요청하신 포인트 환불이 완료 처리 되었습니다. 상세 사항은 마이페이지-포인트 메뉴에서 확인 가능합니다. <br/><br/> 감사합니다.", 1);
        }
        $_SESSION['message'] = "환불처리가 완료되었습니다";
        goto_url("./bp_point_refund.php?w=u&idx={$idx}&page={$page}");
        exit;
    }
    if ($br_refund_state == '환불거부') {
        //DB update
        $sql = "UPDATE `" . BP_POINT_REFUND_TABLE . "` set `br_refund_state`='환불거부', `br_refund_datetime`='" . G5_TIME_YMDHIS . "', `br_refuse_memo` = '{$br_refund_memo}' where `br_mb_id` = '{$br_mb_id}' and `br_idx` = '{$idx}' limit 1";
        sql_query($sql, true);

        $memo = $br_refuse_memo;
        //쪽지 발송
        ASKDB::memo_send($br_mb_id, $config['cf_admin'], "{$br_mb_id}님의 환불이 거부되었습니다. 사유는 아래와 같습니다.\n\n{$br_refuse_memo} \n\n문의는 1:1문의 게시판에 남겨주세요.");
        if ($config['cf_email_use']) {
            //메일 발송
            include_once(G5_LIB_PATH . '/mailer.lib.php');
            mailer($config['cf_admin_email_name'], $config['cf_admin_email'], trim($br_email), "{$config['cf_title']} - 포인트 환불 거부 안내", "안녕하세요. <br/><br/>{$br_mb_id}님의 환불이 거부되었습니다.<br/><br/> 사유는 아래와 같습니다.<br/><br/>{$br_refuse_memo} <br/><br/>문의는 1:1문의 게시판에 남겨주세요. 감사합니다.", 1);
        }
        $_SESSION['message'] = "환불처리가 거부되었습니다";
        goto_url("./bp_point_refund.php?w=u&idx={$idx}&page={$page}");
        exit;
    }
}
