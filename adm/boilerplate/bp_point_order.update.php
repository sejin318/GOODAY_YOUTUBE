<?php
$sub_menu = "800501";
include_once './_common.php';

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

check_admin_token();
/**
 * 주문 상태 처리
 *
 * @param [type] $idx
 * @param [type] $state
 * @return void
 */
function update_order_state($idx, $state)
{
    if ($state == '완료') {
        $date = ", `bo_deposit_datetime`= '" . G5_TIME_YMDHIS . "'";
    }
    if ($state == '취소') {
        $cancel_date = ", `bo_cancel_datetime`= '" . G5_TIME_YMDHIS . "'";
    }
    if ($state == '준비') {
        $cancel_date = ", `bo_cancel_datetime`= '0000-00-00 00:00:00'";
    }
    $sql = "UPDATE `" . BP_POINT_CHARGE_TABLE . "` set `bo_order_state`='{$state}' {$date} {$cancel_date} where `bo_idx`='{$idx}' limit 1";
    sql_query($sql);
    $_SESSION['message'] = "주문이 [{$state}]로 처리되었습니다.";
    return true;
}
if ($_POST) {
    //동일 내용 처리할 내용 없음
    if ($bo_order_state == $bo_order_state_org) {
        $_SESSION['message'] = '처리할 내용이 없습니다.';
        goto_url('./bp_point_order.php?idx=' . $bo_idx . '&w=u&page=' . $page);
    }

    ###################################
    # 취소 -> 주문 처리
    ###################################
    if ($bo_order_state == '주문') {
        if ($bo_order_state_org == '완료' || $bo_order_state_org == '환불요청' || $bo_order_state_org == '환불완료') {
            alert($bo_order_state_org . '상태의 주문건은 [주문]으로 변경 할 수 없습니다.');
            exit;
        }
        if ($bo_order_state_org == '취소') {
            //취소를 주문으로 변경 쪽지 발송
            ASKDB::memo_send($bo_mb_id, $config['cf_admin'], "{$bo_mb_id}님의 주문취소가 주문상태로 변경 되었습니다.\n\n감사합니다.");
            $_SESSION['message'] .= "<br/>{$bo_mb_id}({$bo_name})님 주문취소가 취소 되었습니다.";
            update_order_state($bo_idx, $bo_order_state);
            goto_url('./bp_point_order.php?idx=' . $bo_idx . '&w=u&page=' . $page);
            exit;
        }
    }
    ###################################
    # 주문 -> 완료시 포인트 지급
    ###################################
    if ($bo_order_state == '완료' && $bo_order_state_org == '주문') {
        update_order_state($bo_idx, $bo_order_state);
        insert_point($bo_mb_id, $bo_point, "{$bo_mb_id}({$bo_name})님의 {$bo_point} Point 주문완료", 'point-order', $bo_idx, '포인트주문완료');
        //주문완료 쪽지 발송
        ASKDB::memo_send($bo_mb_id, $config['cf_admin'], "{$bo_mb_id}님의 주문이 완료되었습니다.\n\n{$bo_point} 포인트가 지급되었습니다.\n\n감사합니다.");
        $_SESSION['message'] .= "<br/>{$bo_mb_id}({$bo_name})님께 {$bo_point} 포인트가 지급되었습니다.";
        goto_url('./bp_point_order.php?idx=' . $bo_idx . '&w=u&page=' . $page);
        exit;
    }
    ##################################
    # 주문 -> 취소 처리 가능
    ##################################
    if ($bo_order_state == '취소') {
        //주문건만 취소처리 가능
        if ($bo_order_state_org == '완료' || $bo_order_state_org == '환불요청' || $bo_order_state_org == '환불완료') {
            alert($bo_order_state_org . '상태의 주문건은 [취소]으로 변경 할 수 없습니다.');
            exit;
        }
        //취소처리
        update_order_state($bo_idx, $bo_order_state, G5_TIME_YMDHIS);
        //주문 취소 쪽지 발송
        ASKDB::memo_send($bo_mb_id, $config['cf_admin'], "{$bo_mb_id}님의 주문이 취소되었습니다.\n\n감사합니다.");
        $_SESSION['message'] .= "<br/>{$bo_mb_id}({$bo_name})님 주문이 취소되었습니다.";
        goto_url('./bp_point_order.php?idx=' . $bo_idx . '&w=u&page=' . $page);
        exit;
    }
    ##########################
    # 환불요청은 주문자가 한다.
    ##########################
}
