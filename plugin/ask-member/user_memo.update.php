<?php
include_once "./_common.php";
/**
 *  회원 메모 처리 폼
 */
if (!$config['bp_member_memo']) {
    exit;
}
//본인이 접근시
if($member['mb_id'] == $mb_id){
    header('Content-type: application/json');
    echo json_encode(array('ERROR' => 'Access Denied #1'));
    exit;
}

if (($is_member == false || !$mb_id || !$memo) && $mode != 'delete') {
    header('Content-type: application/json');
    echo json_encode(array('ERROR' => 'Access Denied #2 '));
    exit;
}

// 토큰체크
$_token = trim(get_session('ss_comment_token'));
set_session('ss_comment_token', '');
if (!$_token) {
    header('Content-type: application/json');
    echo json_encode(array("request" => $_POST, 'error' => '올바른 방법으로 이용해 주세요.#1' . $_POST['comment_image_token'] . '=' . $_token), JSON_PRETTY_PRINT);
    exit;
}

if ($_POST) {

    $mb_id = Asktools::xss_clean(trim($mb_id));
    $member['mb_id'] = Asktools::xss_clean(trim($member['mb_id']));
    $memo = Asktools::xss_clean(trim($memo));

    $sql = "SELECT count(*) cnt from `" . BP_MEMBER_MEMO_TABLE . "` where `bm_mb_id` = '{$member['mb_id']}' and `bm_memo_mb_id`  = '{$mb_id}'";
    $count = sql_fetch($sql, true);

    //있으면 수정
    if ($count['cnt'] > 0) {
        //메모 삭제
        if (!$memo && $mode == 'delete') {
            $sql = "DELETE from `" . BP_MEMBER_MEMO_TABLE . "` where `bm_mb_id` = '{$member['mb_id']}' and `bm_memo_mb_id`  = '{$mb_id}' limit 1";
            sql_query($sql);
            header('Content-type: application/json');
            echo json_encode(array('result' => 'Delete'));
            exit;
        }
        //수정
        $sql = "UPDATE `" . BP_MEMBER_MEMO_TABLE . "` set `bm_memo` = '{$memo}'  where  `bm_mb_id` = '{$member['mb_id']}' and `bm_memo_mb_id`  = '{$mb_id}' limit 1";
        sql_query($sql, true);
        header('Content-type: application/json');
        echo json_encode(array('result' => 'Update', 'memo' => $memo));
        exit;
    } else {
        //추가
        $sql = "INSERT into `" . BP_MEMBER_MEMO_TABLE . "` set `bm_mb_id` ='{$member['mb_id']}',
                                                            `bm_memo_mb_id` = '{$mb_id}',
                                                            `bm_memo` = '{$memo}'";
        sql_query($sql, true);
        header('Content-type: application/json');
        echo json_encode(array('result' => 'Insert', 'memo' => $memo));
        exit;
    }
}
