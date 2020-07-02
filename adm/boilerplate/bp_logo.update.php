<?php
$sub_menu = "800101";
include_once './_common.php';

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

check_admin_token();


//삭제
if ($w == 'de' && $idx) {
    $sql = "SELECT * from `" . BP_LOGO_TABLE . "` where `lm_idx` = '{$idx}'";
    $_del = sql_fetch($sql);
    //이미지 삭제
    unlink(BP_FILE_DIR . DIRECTORY_SEPARATOR . $_del['lm_file']);
    //DB 삭제 
    sql_query("DELETE from `" . BP_LOGO_TABLE . "` where `lm_idx` = '{$idx}' limit 1");
    $_SESSION['message'] = "{$_del['lm_alt']} 로고가 삭제되었습니다.";
    goto_url('./bp_logo.php');
}

if (!$_POST) {
    alert('잘못된 접속입니다!.');
    exit;
}


//이미지 삭제
if ($lm_file_delete) {
    unlink(BP_FILE_DIR . DIRECTORY_SEPARATOR . $lm_file_delete);
    $image_file_query =  " `lm_file` = '', ";
}

//업로드
if ($_FILES) {
    $image_file_query = '';
    $image = pathinfo($_FILES['lm_file']['name']);
    $img_ext = array('jpg', 'jpeg', 'gif', 'png');

    //이미지만 업로드
    if (in_array($image['extension'], $img_ext)) {
        $file_name = "lm_logo_" . time() . md5($image['basename']) . "." . $image['extension'];
        $dest_file  = BP_FILE_DIR . DIRECTORY_SEPARATOR . $file_name;
        move_uploaded_file($_FILES['lm_file']['tmp_name'], $dest_file) or die($_FILES['lm_file']['error'][$i]);
        chmod($dest_file, G5_FILE_PERMISSION);
        $image_file_query =  " `lm_file` = '{$file_name}', ";
    }
}

//신규 등록
if (!$w) {
    $sql = "INSERT into `" . BP_LOGO_TABLE . "` set `lm_alt` = '{$lm_alt}',
                                                    `lm_link` = '{$lm_link}',
                                                    $image_file_query
                                                    `lm_order` = '{$lm_order}',
                                                    `lm_startday` = '{$lm_startday}',
                                                    `lm_endday` = '{$lm_endday}'";
    sql_query($sql, true);
    $idx = sql_insert_id();
    $_SESSION['message'] = "{$lm_alt} 로고가 신규로 등록되었습니다.";
} elseif ($w == 'u' && $idx) {

    //업데이트
    $sql = "UPDATE `" . BP_LOGO_TABLE . "` set `lm_alt` = '{$lm_alt}',
                                                `lm_link` = '{$lm_link}',
                                                $image_file_query
                                                `lm_order` = '{$lm_order}',
                                                `lm_startday` = '{$lm_startday}',
                                                `lm_endday` = '{$lm_endday}'
                                                where `lm_idx` = '{$idx}'";
    sql_query($sql, true);
    $_SESSION['message'] = "{$lm_alt} 로고가 수정되었습니다.";
}
goto_url('./bp_logo.php?w=u&idx=' . $idx);
