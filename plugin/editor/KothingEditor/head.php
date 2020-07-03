<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
//해더파일 include 체크용
$_head_file = true;
include_once G5_THEME_PATH . '/head.sub.php';
include_once G5_LIB_PATH . '/latest.lib.php';
include_once G5_LIB_PATH . '/outlogin.lib.php';
include_once G5_LIB_PATH . '/poll.lib.php';
include_once G5_LIB_PATH . '/visit.lib.php';
include_once G5_LIB_PATH . '/connect.lib.php';
include_once G5_LIB_PATH . '/popular.lib.php';
// adding one more library //
// include_once G5_THEME_PATH . '/_lib/boilerplate_extend.php';


######################
# 메뉴 출력
######################
bp_main_menu();

######################
# Hero 출력
######################
include_once BP_HERO_PATH . "/hero_default.inc.php";

/**
 * 해더 파일 경로
 * _header_footer
 * 위 폴더 참고하세요.
 */
if (isset($config['bp_header_footer']) && $config['bp_header_footer']) {
  // $header_inc = G5_THEME_PATH . DIRECTORY_SEPARATOR . '_header_footer' . DIRECTORY_SEPARATOR . $config['bp_header_footer'] . DIRECTORY_SEPARATOR . '/head.inc.php';
  $header_inc = G5_THEME_PATH . DIRECTORY_SEPARATOR . '_header_footer' . DIRECTORY_SEPARATOR . 'left-aside' . DIRECTORY_SEPARATOR . '/head.inc.php';
    if (file_exists($header_inc)) {
        include_once $header_inc;
    } else {
        echo "<div class='alert alert-danger'>head 파일이 없습니다.</div>";
    }
}
