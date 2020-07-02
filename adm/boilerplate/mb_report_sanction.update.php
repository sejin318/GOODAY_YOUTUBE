<?php
$sub_menu = "800221";
include_once './_common.php';
$inc_path = G5_PLUGIN_PATH . DS . "ask-member" . DS . "lib";
include_once $inc_path . DS . "GUMP.php";
include_once $inc_path . DS . "MyGump.php";
include_once $inc_path . DS . "Util.php";
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

//신고 처리하기
if ($_POST) {
    //검증

    $vali = array();
    $filters = array();

    //신고데이터 처리시 검증
    if (!$_POST['new'] && $_POST['newitem'] != 1) {

        $vali = array(
            'ar_idx' => 'required|numeric',
            'as_reporter_id' => 'required|alpha_dash' //신고자
        );
        $filters = array(
            'ar_idx' => 'trim|sanitize_string',
            'as_reporter_id' => 'trim|sanitize_string'
        );
    }

    //사유불충분은 폼검증 일부 제거 
    $required = "required";
    $vali_date = "date";
    if ($_POST['as_type'] === 'reject') {
        $required = "notvali";
        $vali_date = "notvali";
    }
    //신규 처리시 검증
    $vali = array_merge(
        $vali,
        array(
            'as_idx' => 'notvali',
            'as_mb_id' => 'required|alpha_dash', //피신고자
            'as_type' => 'required|alpha', //처리방법
            'as_start_day' => "{$required}|{$vali_date}",
            'as_end_day' => "{$required}|{$vali_date}",
            'as_reason' => "{$required}"
        )
    );
    $filters = array_merge(
        $filters,
        array(
            'as_mb_id' => 'trim|sanitize_string', //피신고자
            'as_type' => 'trim|sanitize_string', //처리방법
            'as_memo' => 'trim|sanitize_string', //사유
            'as_start_day' => 'trim|sanitize_string',
            'as_end_day' => 'trim|sanitize_string',
            'as_reason' => 'trim|sanitize_string'
        )
    );

    $gump = new MyGump();
    //룰
    $gump->validation_rules($vali);
    //필터
    $gump->filter_rules($filters);

    GUMP::set_field_name("as_mb_id", "피신고자"); //필드이름 지정
    GUMP::set_field_name("as_type", "처리방법"); //필드이름 지정
    GUMP::set_field_name("as_reason", "회원메세지"); //필드이름 지정
    GUMP::set_field_name("as_memo", "메모"); //필드이름 지정
    GUMP::set_field_name("as_start_day", "차단시작일"); //필드이름 지정
    GUMP::set_field_name("as_end_day", "차단마지막일"); //필드이름 지정

    $validated_data = $gump->run($_POST);

    //검사 실패
    if ($validated_data === false) {

        $_data['errors'] = $gump->get_readable_errors(true, 'error-label', 'alert alert-warning');
        $_data['flash_message'] = '오류가 발생하였습니다.';

        $_data['report'] = array();
        if ($_POST['ar_idx']) {
            //신고 데이터 가져오기
            $_data['report'] = DB::get_report(Asktools::xss_clean($_POST['ar_idx']));
        }

        //오류 페이지 데이터 넣기
        $_data['report'] = array_merge($_data['report'], $_POST);
        alert($_data['report'], './mb_report_sanction.update.php');
        exit;
    } else {
        //수정 업데이트
        if (($_POST['ar_idx'] || $_POST['as_idx']) && $_POST['w'] === 'u') {
            DB::report_sanction_save($validated_data, true);
        } else {
            //신규저장
            DB::report_sanction_save($validated_data);
        }


        if ($validated_data['as_type'] == 'memo') {
            $type = "[쪽지 보내기] 사용이 금지";
        }
        if ($validated_data['as_type'] == 'write') {
            $type = "[글쓰기, 댓글] 사용이 금지";
        }
        if ($validated_data['as_type'] == 'all') {
            $type = "[쪽지 보내기, 글쓰기, 댓글] 사용이 금지";
        }

        //쪽지 발송
        if ($_POST['send_memo'] == 1 && $validated_data['as_type'] != 'reject') {
            //쪽지발송 - 피신고자에게만 발송함.
            $memo_contents = "\n신고 접수로 인해 아래와 같이 처리되었습니다." . PHP_EOL;
            $memo_contents .= "---------------------------------------------------------------------" . PHP_EOL;
            $memo_contents .= $validated_data['as_reason'] . PHP_EOL;
            $memo_contents .= "---------------------------------------------------------------------" . PHP_EOL;
            $memo_contents .= $validated_data['as_start_day'] . " 부터 " . $validated_data['as_end_day'] . " 까지 " . PHP_EOL;
            $memo_contents .= "{$type} 되었습니다." . PHP_EOL . PHP_EOL . PHP_EOL;
            $memo_contents .= "문의는 1:1 게시판에 문의 바랍니다." . PHP_EOL;

            //피신고자에게 발송
            DB::memo_send($validated_data['as_mb_id'], $member['mb_id'], $memo_contents);
            if (!$_POST['new']) {

                $memo_contents2 = "회원님이 신고한 내용이 아래 같이 {$validated_data['as_datetime']}에 처리되었습니다. \n\n감사합니다." . PHP_EOL;
                $memo_contents2 .= "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -" . PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL;
                $memo_contents2 .= $memo_contents;
                if ($validated_data['as_reporter_id']) {
                    //신고건일경우 신고자에게도 발송
                    DB::memo_send($validated_data['as_reporter_id'], $member['mb_id'], $memo_contents2);
                }
            }
        }

        //신고자에게 포인트 보상 - 직접등록, 신고자 없으면 지급하지 않음.
        if (REPORT_REWARD_POINT > 0 && $validated_data['as_reporter_id'] && $validated_data['as_type'] != 'reject') {
            insert_point($validated_data['as_reporter_id'], (int) REPORT_REWARD_POINT, $validated_data['as_mb_id'] . '님 신고처리(' . $validated_data['ar_idx'] . ') 보상 [' . REPORT_REWARD_POINT . '포인트] 지급', '신고포상' . $validated_data['as_mb_id'] . $validated_data['ar_idx']);
        }

        $_SESSION['message'] = '처리되었습니다.';

        //리다이렉트
        if ($_POST['list'] == 'report') {
            $redirect = "./mb_report_list.php";
        } elseif ($_POST['list'] == 'sanction') {
            $redirect = "mb_report_result.php";
        } else {
            $redirect = "mb_report_result.php";
        }
        Util::redirect($redirect . '?page=' . $_POST['page']);
        exit;
    }
} else {
    //신규도 아니면서 idx 안넘어올경우
    if (!$_GET['idx'] && !$_GET['new'] && !$_GET['as_idx']) {
        $_SESSION['message'] = '잘못된 접속입니다.';
        //리다이렉트
        alert($_SESSION['message'], './mb_report_list.php');
        exit;
    } 
}
