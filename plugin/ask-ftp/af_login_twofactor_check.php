<?php

/**
 * Two Factor 인증 처리
 */
include_once './_common.php';
include_once './php-ftp-client/src/FtpClient/FtpClient.php';
include_once './php-ftp-client/src/FtpClient/FtpException.php';
include_once './php-ftp-client/src/FtpClient/FtpWrapper.php';
include_once './ask_ftp.const.php';
include_once './ask_ftp.lib.php';
$g5['title'] = 'ASK-FTP';

//로그인일 경우에만 
if ($_SESSION['SS_FTP_LOGIN'] == true && $_SESSION['SS_FTP_HOST'] && $_SESSION['SS_FTP_ID'] && $_SESSION['SS_FTP_PASSWORD']) {
    //google otp 사용이면 이동
    if (defined('AF_AUTH_OTP') && AF_AUTH_OTP == 1) {
        $otp = ask_2factor_auth(true, $ftp_otp);
        if ($otp == true) {
            //인증 성공
            $_SESSION['SS_FTP_OTP'] = true;
            alert('인증이 완료되었습니다.', './ask_ftp.php');
        } else if ($otp == false) {
            //인증 실패 처리
            $_SESSION['SS_FTP_OTP'] = false;
            alert('OTP 번호가 틀립니다.', './af_login_twofactor.php');
            exit;
        }
    }
} else {
    die('Access Denied.');
}
include_once G5_PLUGIN_PATH . '/ask-ftp/tail.sub.php';
