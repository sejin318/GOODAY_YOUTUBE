<?php
$sub_menu = "800110";
include_once './_common.php';

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

//신규 등록
if (!$w) {
    //슬라이더 이름 체크 
    $sql = "SELECT count(*) as cnt from `" . BP_SLIDER_TABLE . "` where `bs_name` = '{$bs_name}'";
    $count = sql_fetch($sql);
    if ($count['cnt'] > 0) {
        alert("[{$bs_name}]은 이미 사용중인 슬라이더 이름입니다. 중복 사용이 불가하니 다른 이름을 입력하세요.");
    }

    $sql = "INSERT into `" . BP_SLIDER_TABLE . "` set `bs_use` = '{$bs_use}',
                                                        `bs_name` = '{$bs_name}',
                                                        `bs_skin` = '{$bs_skin}',
                                                        `bs_ratio` = '{$bs_ratio}',
                                                        `bs_autoplay` = '{$bs_autoplay}',
                                                        `bs_control` = '{$bs_control}',
                                                        `bs_indicator` = '{$bs_indicator}',
                                                        `bs_crossfade` = '{$bs_crossfade}'";
    sql_query($sql, true);
    $insert_id  = sql_insert_id();
    $_SESSION['message'] = "슬라이더가 생성되었습니다. 페이지 등록 버튼을 클릭 후 페이지를 등록하세요. $insert_id";
} elseif ($w == 'u' && $bs_idx) {
    //슬라이더 이름 체크 
    $sql = "SELECT count(*) as cnt from `" . BP_SLIDER_TABLE . "` where `bs_name` = '{$bs_name}' and `bs_idx` != '{$bs_idx}'";
    $count = sql_fetch($sql);
    if ($count['cnt'] > 0) {
        alert("[{$bs_name}]은 이미 사용중인 슬라이더 이름입니다. 중복 사용이 불가하니 다른 이름을 입력하세요.");
    }

    //업데이트
    $sql = "UPDATE `" . BP_SLIDER_TABLE . "` set `bs_use` = '{$bs_use}',
                                                        `bs_name` = '{$bs_name}',
                                                        `bs_skin` = '{$bs_skin}',
                                                        `bs_ratio` = '{$bs_ratio}',
                                                        `bs_autoplay` = '{$bs_autoplay}',
                                                        `bs_control` = '{$bs_control}',
                                                        `bs_indicator` = '{$bs_indicator}',
                                                        `bs_crossfade` = '{$bs_crossfade}'
                                                        where `bs_idx` = '{$bs_idx}'";
    sql_query($sql, true);
    $insert_id  = $bs_idx;
    $_SESSION['message'] = "{$bs_name} 슬라이더가 수정되었습니다.";
}
goto_url('./bp_slider.php?w=u&idx=' . $insert_id);
