<?php
/**
 * ASK OTP Login
 */
define('G5_IS_ADMIN', true);
include_once '../../../common.php';
include_once G5_ADMIN_PATH . '/admin.lib.php';
include_once "../lib/util.lib.php";

if (isset($token)) {
    $token = @htmlspecialchars(strip_tags($token), ENT_QUOTES);
}
