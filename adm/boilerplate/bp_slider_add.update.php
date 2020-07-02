<?php
$sub_menu = "800120";
include_once './_common.php';

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

check_admin_token();

if (!$_POST) {
    alert('잘못된 접속입니다!.');
    exit;
}


//이미지 삭제
if ($bss_image_delete) {
    unlink(BP_SLIDERSAVE_DIR . DIRECTORY_SEPARATOR . $bss_image_delete);
    $image_file_query =  " `bss_image` = '', ";
}

//업로드
if ($_FILES) {
    $image_file_query = '';
    $image = pathinfo($_FILES['bss_image']['name']);
    $img_ext = array('jpg', 'jpeg', 'gif', 'png');

    //이미지만 업로드
    if (in_array($image['extension'], $img_ext)) {
        $file_name = "bp_slider_" . time() . md5($image['basename']) . "." . $image['extension'];
        $dest_file  = BP_SLIDERSAVE_DIR . DIRECTORY_SEPARATOR . $file_name;
        move_uploaded_file($_FILES['bss_image']['tmp_name'], $dest_file) or die($_FILES['bss_image']['error'][$i]);
        //이미지 방향 오류 수정
        bp_image_orientation_fix($dest_file, 85);
        chmod($dest_file, G5_FILE_PERMISSION);
        $image_file_query =  " `bss_image` = '{$file_name}', ";
    }
}

//신규 등록
if (!$w) {
    $sql = "INSERT into `" . BP_SLIDER_LIST_TABLE . "` set `bss_parent` = '{$bss_parent}',
                                                        `bss_name` = '{$bss_name}',
                                                        `bss_subject` = '{$bss_subject}',
                                                        `bss_content` = '{$bss_content}',
                                                        `bss_url` = '{$bss_url}',
                                                        {$image_file_query}
                                                        `bss_order` = '{$bss_order}',
                                                        `bss_startday` = '{$bss_startday}',
                                                        `bss_endday` = '{$bss_endday}',
                                                        `bss_interval` = '{$bss_interval}'";
    sql_query($sql, true);
    $insert_id  = sql_insert_id();

    //페이지 수 업데이트
    sql_query("UPDATE `" . BP_SLIDER_TABLE . "` set `bs_page_count` = `bs_page_count` + 1 where `bs_idx` = '{$bss_parent}' limit 1");
    $_SESSION['message'] = "{$bss_name} 페이지가 추가되었습니다.";
} elseif ($w == 'u' && $bss_idx) {

    //업데이트
    $sql = "UPDATE `" . BP_SLIDER_LIST_TABLE . "` set `bss_parent` = '{$bss_parent}',
                                                    `bss_name` = '{$bss_name}',
                                                    `bss_subject` = '{$bss_subject}',
                                                    `bss_content` = '{$bss_content}',
                                                    `bss_url` = '{$bss_url}',
                                                    `bss_class` = '{$bss_class}',
                                                    `bss_order` = '{$bss_order}',
                                                    {$image_file_query}
                                                    `bss_startday` = '{$bss_startday}',
                                                    `bss_endday` = '{$bss_endday}',
                                                    `bss_interval` = '{$bss_interval}' 
                                                    where `bss_idx` = '{$bss_idx}'";
    sql_query($sql, true);
    $insert_id  = $bss_idx;
    $_SESSION['message'] = "{$bss_name} 페이지가 수정되었습니다.";
}
goto_url('./bp_slider_add.php?w=u&idx=' . $insert_id);
