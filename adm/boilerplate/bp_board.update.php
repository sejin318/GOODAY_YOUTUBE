<?php
$sub_menu = "800400";
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

if ($w == 'u' && $bb_idx) {

    //업데이트
    $sql = "UPDATE `" . BP_BOARD_TABLE . "` set `bb_idx` = '{$bb_idx}',
                                                    `bb_list_skin` = '{$bb_list_skin}',
                                                    `bb_comment_image` = '{$bb_comment_image}',
                                                    `bb_use_font` = '{$bb_use_font}',
                                                    `bb_gallery_col` = '{$bb_gallery_col}',
                                                    `bb_webzine_col` = '{$bb_webzine_col}',
                                                    `bb_exif_gps` = '{$bb_exif_gps}',
                                                    `bb_use_download_point` = '{$bb_use_download_point}',
                                                    `bb_use_download_level` = '{$bb_use_download_level}',
                                                    `bb_use_download_save` = '{$bb_use_download_save}'
                                                    where `bb_bo_table` = '{$bb_bo_table}'";
    sql_query($sql, true);
    $_SESSION['message'] = "설정이 수정되었습니다.";
}
goto_url('./bp_board.php?w=u&bo_table=' . $bb_bo_table);
