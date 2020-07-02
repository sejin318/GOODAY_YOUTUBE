<?php

/**
 * 데모 기능 
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
//컬러셋 선택
if (get_session('BP_SS_COLORSET')) {
    $config['bp_colorset'] = "colorset.{$_SESSION['BP_SS_COLORSET']}.css";
}
//폰트사이즈
if (get_session('BP_FONT_SIZE')) {
    if ($_SESSION['BP_FONT_SIZE'] == 14) {
        $config['bp_font_size'] = true;
    }
    if ($_SESSION['BP_FONT_SIZE'] == 16) {
        $config['bp_font_size'] = false;
    }
}

//컨테이너
if (get_session('BP_CONTAINER')) {
    $config['bp_container'] = $_SESSION['BP_CONTAINER'];
}
//메뉴컨테이너
if (get_session('BP_MENU_CONTAINER')) {
    if ($_SESSION['BP_MENU_CONTAINER'] == 'fluid') {
        $config['bp_pc_menu_container'] = false;
    }
    if ($_SESSION['BP_MENU_CONTAINER'] == 'container') {
        $config['bp_pc_menu_container'] = true;
    }
}
//메뉴배경색
if (get_session('BP_MENU_BG')) {
    $config['bp_pc_menu_color'] = $_SESSION['BP_MENU_BG'];
}
//ASIDE
if (get_session('BP_HEADER_FOOTER')) {
    $config['bp_header_footer'] = $_SESSION['BP_HEADER_FOOTER'];
}
