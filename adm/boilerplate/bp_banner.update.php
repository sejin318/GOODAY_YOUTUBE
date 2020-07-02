<?php

/**
 * 배너 등록, 수정, 삭제
 */
$sub_menu = "800115";
include_once './_common.php';

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

check_admin_token();

//삭제 처리
if ($w == 'de' && $idx) {
    $sql = "SELECT * from `" . BP_BANNER_TABLE . "` where bb_idx = '{$idx}'";
    $del_item = sql_fetch($sql);
    //텍스트배너
    if ($del_item['bb_type'] == 'text') {
        sql_query("DELETE from `" . BP_BANNER_TABLE . "` where bb_idx = '{$idx}'");
    }
    //HTML 배너
    if ($del_item['bb_type'] == 'html') {
        sql_query("DELETE from `" . BP_BANNER_TABLE . "` where bb_idx = '{$idx}'");
    }
    //이미지
    if ($del_item['bb_type'] == 'image') {
        //이미지삭제
        unlink(BP_FILE_DIR . DIRECTORY_SEPARATOR . $del_item['bb_image']);
        sql_query("DELETE from `" . BP_BANNER_TABLE . "` where bb_idx = '{$idx}'");
    }

    $_SESSION['message'] = "<strong>{$del_item['bb_name']}</strong> 배너가 삭제되었습니다.";
    goto_url("./bp_banner_list.php");
    exit;
}

if (!$_POST) {
    alert('잘못된 접속입니다!.');
    exit;
}



//이미지 삭제
if ($bb_image_delete) {
    unlink(BP_FILE_DIR . DIRECTORY_SEPARATOR . $bb_image_delete);
    $image_file_query =  " `bb_image` = '', ";
}

//업로드
if ($_FILES) {
    $image_file_query = '';
    $image = pathinfo($_FILES['bb_image']['name']);
    $img_ext = array('jpg', 'jpeg', 'gif', 'png');

    //이미지만 업로드
    if (in_array($image['extension'], $img_ext)) {
        $file_name = "banner-" . time() . md5($image['basename']) . "." . $image['extension'];
        $dest_file  = BP_FILE_DIR . DIRECTORY_SEPARATOR . $file_name;
        move_uploaded_file($_FILES['bb_image']['tmp_name'], $dest_file) or die($_FILES['bb_image']['error'][$i]);
        chmod($dest_file, G5_FILE_PERMISSION);
        $image_file_query =  " `bb_image` = '{$file_name}', ";
    }
}

if ($bb_type == 'text') {
    $add_query = " bb_url = '{$bb_url}', ";
}

if ($bb_type == 'image') {
    $add_query = " {$image_file_query} bb_url = '{$bb_url}', ";
}

if ($bb_type == 'html') {
    $bb_html = $bb_html;
    $add_query = " bb_html = '{$bb_html}', ";
}

//신규 등록
if (!$w) {
    $sql = "INSERT into `" . BP_BANNER_TABLE . "` set   `bb_name` = '{$bb_name}',
                                                        `bb_area` = '{$bb_area}',
                                                        `bb_type` = '{$bb_type}',
                                                        {$add_query}
                                                        `bb_tag` = '{$bb_tag}',
                                                        `bb_startday` = '{$bb_startday}',
                                                        `bb_endday` = '{$bb_endday}'";
    sql_query($sql, true);
    $insert_id  = sql_insert_id();
    $_SESSION['message'] = "{$bb_name} 배너가 신규 등록되었습니다.";
} elseif ($w == 'u' && $bb_idx) {
    //업데이트
    $sql = "UPDATE `" . BP_BANNER_TABLE . "` set    `bb_name` = '{$bb_name}',
                                                    `bb_area` = '{$bb_area}',
                                                    `bb_type` = '{$bb_type}',
                                                    {$add_query}
                                                    `bb_tag` = '{$bb_tag}',
                                                    `bb_startday` = '{$bb_startday}',
                                                    `bb_endday` = '{$bb_endday}'
                                                    where `bb_idx` = '{$bb_idx}'";
    sql_query($sql, true);
    $insert_id  = $bb_idx;
    $_SESSION['message'] = "{$bb_name} 배너가 수정되었습니다.";
}
goto_url('./bp_banner.php?w=u&idx=' . $insert_id);
