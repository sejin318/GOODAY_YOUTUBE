<?php
include_once "./_common.php";
include_once "./lib/GUMP.php";
include_once "./lib/MyGump.php";
include_once "./lib/Util.php";

if (!$is_member) {
    alert_close('회원만 이용가능합니다.');
    exit;
}

if (!$_POST) {
    alert_close('잘못된 접속!!');
    exit;
}

if ($ar_type == 'board') {
    //이미 신고했나?
    $check = ASKDB::check_board_report(Asktools::filter($bo_table), Asktools::filter($wr_id));
    if ($check) {
        alert_close('이미 신고한 게시물을 신고 할 수 없습니다.');
        exit;
    }
} elseif ($ar_type == 'memo') {
    //이미 신고했나?
    $check = ASKDB::check_memo_report($me_id);
    if ($check) {
        alert_close('이 쪽지는 회원님이 이미 신고하였습니다');
        exit;
    }
}

if ($_POST) {
    //데이터 검증
    if ($_POST['bo_table'] && $_POST['wr_id']) {
        //게시물
        $ar_type = "board";
        $vali = array(
            'bo_table' => 'required|alpha_dash', //게시판
            'wr_id' => 'required|numeric' //게시물
        );
        $filters = array(
            'bo_table' => 'trim|sanitize_string', //게시판
            'wr_id' => 'trim|sanitize_string' //게시물
        );
    } else {
        //쪽지
        $ar_type = "memo";
        $vali = array(
            'memo' => 'required', //게시판
            'me_id' => 'required|numeric'
        );
        $filters = array(
            'memo' => 'trim|sanitize_string',
            'me_id' => 'trim|sanitize_string'
        );
    }
    //공통
    $vali = array_merge(
        $vali,
        array(
            'reporter_id' => 'required|alpha_dash', //신고자
            'mb_id' => 'required|alpha_dash', //신고대상
            'reason' => 'required' //사유
        )
    );
    $filters = array_merge(
        $filters,
        array(
            'reporter_id' => 'trim|sanitize_string', //신고자
            'mb_id' => 'trim|sanitize_string', //신고대상
            'reason' => 'trim|sanitize_string' //사유
        )
    );

    $gump = new MyGump();
    //룰
    $gump->validation_rules($vali);
    //필터
    $gump->filter_rules($filters);

    $validated_data = $gump->run($_POST);

    if ($validated_data === false) {
        alert_close('오류 발생!!');
        exit;
    } else {

        //ip 검사
        $gump->validation_rules(array('REMOTE_ADDR' => 'valid_ip'));
        $gump->filter_rules(array('REMOTE_ADDR' => 'trim'));
        $ip = $gump->run($_SERVER);
        $ipaddr = $ip['REMOTE_ADDR'];

        //검사성공, DB 입력
        $validated_data['type'] = $ar_type;
        $validated_data['ip'] = $ipaddr;
        DB::report_save($validated_data);
        Util::alert_close('깨끗한 굿데이유튜브를 만들기 위해 노력해주셔서 감사합니다.\\n\\n신고 내용에 대한 처리 결과는 1일 이내 쪽지로 통보됩니다.\\n\\n신고자의 신고 내용이 타당할 경우, 신고자에게 100포인트가 부여됩니다.\\n\\n단, 반복적으로 허위 신고를 작성한 경우, 신고자도 제재 대상이 될 수 있습니다.');
        exit;
    }
}
