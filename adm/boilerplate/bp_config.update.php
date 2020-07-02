<?php

/**
 * 보일러플레이트 테마 설정 처리
 */

$sub_menu = "800100";
include_once './_common.php';
include_once './_ftp_inc.php';

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

//이미지 삭제
if ($bp_logo_delete) {
    unlink(BP_FILE_DIR . DIRECTORY_SEPARATOR . $bp_logo_delete);
    $image_file_query =  " `bp_logo` = '', ";
}

//업로드
if ($_FILES['bp_logo']) {
    $image = pathinfo($_FILES['bp_logo']['name']);
    $img_ext = array('jpg', 'jpeg', 'gif', 'png');

    //이미지만 업로드
    if (in_array($image['extension'], $img_ext)) {
        $file_name = "bp_logo_" . time() . md5($image['basename']) . "." . $image['extension'];
        $dest_file  = BP_FILE_DIR . DIRECTORY_SEPARATOR . $file_name;
        move_uploaded_file($_FILES['bp_logo']['tmp_name'], $dest_file) or die($_FILES['bp_logo']['error'][$i]);
        chmod($dest_file, G5_FILE_PERMISSION);
        $image_file_query =  " `bp_logo` = '{$file_name}', ";
    }
}

//처음 저장이면 insert 
if (!isset($config['bp_colorset'])) {
    $sql = " INSERT into `" . BP_CONFIG_TABLE . "` set {$image_file_query}
                                                `bp_colorset` = '{$bp_colorset}',
                                                `bp_font_size` = '{$bp_font_size}',
                                                `bp_night_mode` = '{$bp_night_mode}',
                                                `bp_browser_update` = '{$bp_browser_update}',
                                                `bp_use_favorite` = '{$bp_use_favorite}',
                                                `bp_container` = '{$bp_container}',
                                                `bp_header_footer` = '{$bp_header_footer}',
                                                `bp_pc_menu` = '{$bp_pc_menu}',
                                                `bp_pc_menu_container` = '{$bp_pc_menu_container}',
                                                `bp_pc_menu_color` = '{$bp_pc_menu_color}',
                                                `bp_mobile_menu` = '{$bp_mobile_menu}',
                                                `bp_board_uploader` = '{$bp_board_uploader}',
                                                `bp_use_report` = '{$bp_use_report}',
                                                `bp_member_memo` = '{$bp_member_memo}',
                                                `bp_point_charge` = '{$bp_point_charge}',
                                                `bp_point_list` = '{$bp_point_list}',
                                                `bp_bank_list`= '{$bp_bank_list}',
                                                `bp_use_alarm` = '{$bp_use_alarm}',
                                                `bp_ftp_use` = '{$bp_ftp_use}',
                                                `bp_ftp_id` = '{$bp_ftp_id}',
                                                `bp_ftp_password` = '{$bp_ftp_password}',
                                                `bp_ftp_port` = '{$bp_ftp_port}',
                                                `bp_ftp_pasv` = '{$bp_ftp_pasv}',
                                                `bp_ftp_root` = '{$bp_ftp_root}',
                                                `bp_ftp_backup` = '{$bp_ftp_backup}',
                                                `bp_ftp_modify` = '{$bp_ftp_modify}'
                                                ";
    sql_query($sql, true);
} else {
    if ($bp_ftp_password) {
        $bp_ftp_password = af_Encrypt($bp_ftp_password);
        $update_ftp_password = " `bp_ftp_password` = '{$bp_ftp_password}', ";
    }

    if ($bp_ftp_reset) {
        $bp_ftp_use = false;
        $bp_ftp_id = '';
        $bp_ftp_password = '';
        $bp_ftp_port = '';
        $bp_ftp_pasv = false;
        $bp_ftp_root = '';
        $bp_ftp_backup = '';
        $bp_ftp_modify = false;
    }

    $sql = " UPDATE `" . BP_CONFIG_TABLE . "` set {$image_file_query}
                                                `bp_colorset` = '{$bp_colorset}',
                                                `bp_font_size` = '{$bp_font_size}',
                                                `bp_night_mode` = '{$bp_night_mode}',
                                                `bp_browser_update` = '{$bp_browser_update}',
                                                `bp_use_favorite` = '{$bp_use_favorite}',
                                                `bp_container` = '{$bp_container}',
                                                `bp_header_footer` = '{$bp_header_footer}',
                                                `bp_pc_menu` = '{$bp_pc_menu}',
                                                `bp_pc_menu_container` = '{$bp_pc_menu_container}',
                                                `bp_pc_menu_color` = '{$bp_pc_menu_color}',
                                                `bp_mobile_menu` = '{$bp_mobile_menu}',
                                                `bp_board_uploader` = '{$bp_board_uploader}',
                                                `bp_use_report` = '{$bp_use_report}',
                                                `bp_member_memo` = '{$bp_member_memo}',
                                                `bp_point_charge` = '{$bp_point_charge}',
                                                `bp_point_list` = '{$bp_point_list}',
                                                `bp_bank_list`= '{$bp_bank_list}',
                                                `bp_use_alarm` = '{$bp_use_alarm}',
                                                `bp_ftp_use` = '{$bp_ftp_use}',
                                                `bp_ftp_id` = '{$bp_ftp_id}',
                                                $update_ftp_password
                                                `bp_ftp_port` = '{$bp_ftp_port}',
                                                `bp_ftp_pasv` = '{$bp_ftp_pasv}',
                                                `bp_ftp_root` = '{$bp_ftp_root}',
                                                `bp_ftp_backup` = '{$bp_ftp_backup}',
                                                `bp_ftp_modify` = '{$bp_ftp_modify}'
                                                ";
    sql_query($sql, true);
}
$_SESSION['message'] = "테마 기본 설정이 저장되었습니다.";
goto_url('./bp_config.php');
