<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

//필수 lib 로딩
include_once G5_PLUGIN_PATH . "/ask-ads/banner_display.php";
include_once G5_PLUGIN_PATH . "/ask-alarm/alarm.lib.php";
/**
 * ASK-MEMBER 파일 로딩
 */
include_once G5_PLUGIN_PATH . "/ask-member/am-constant.php";
include_once G5_PLUGIN_PATH . "/ask-member/lib/am-board.class.php";
include_once G5_PLUGIN_PATH . "/ask-member/lib/am-member.class.php";
include_once G5_PLUGIN_PATH . "/ask-member/lib/am-tools.class.php";
include_once G5_PLUGIN_PATH . "/ask-member/lib/Util.php";

