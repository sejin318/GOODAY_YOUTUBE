<?php
/**
 * FTP Login 처리
 */
include_once './_common.php';
$login_error = null;
include_once './php-ftp-client/src/FtpClient/FtpClient.php';
include_once './php-ftp-client/src/FtpClient/FtpException.php';
include_once './php-ftp-client/src/FtpClient/FtpWrapper.php';
include_once './ask_ftp.const.php';
include_once './ask_ftp.lib.php';

if ($ftp_host && $ftp_id && $ftp_password && $ftp_port) {
    try {
        //FTP Login , host, ssl, port, timeout
        $ftp_connect = $ftp->connect(trim($ftp_host), false, trim($ftp_port), 30);
        $ftp_login = $ftp->login(trim($ftp_id), trim($ftp_password));
        $ftp->set_option(FTP_USEPASVADDRESS, false);
        # Passive
        if ($ftp_pasv) {
            $ftp->pasv(true);
        } else {
            $ftp->pasv(false);
        }

        # UTF8
        $ftp->raw("OPTS UTF8 ON");

        if ($ftp_connect && $ftp_login) {
            $_SESSION['SS_FTP_LOGIN'] = true;
            $_SESSION['SS_FTP_HOST'] = af_Encrypt($ftp_host);
            $_SESSION['SS_FTP_ID'] = af_Encrypt($ftp_id);
            $_SESSION['SS_FTP_PASSWORD'] = af_Encrypt($ftp_password);
            $_SESSION['SS_FTP_PORT'] = af_Encrypt($ftp_port);
            $_SESSION['SS_FTP_PASV'] = $ftp_pasv;

            //google otp 사용이면 이동, 사이트 상관없이 1회만 확인
            if ((defined('AF_AUTH_OTP') && AF_AUTH_OTP == 1) && !$_SESSION['SS_FTP_OTP']) {
                goto_url('./af_login_twofactor.php');
                exit;
            }

            //로그인 처리
            alert('FTP 로그인 되었습니다.', './ask_ftp.php');
            exit;
        }
    } catch (Exception $error) {
        af_unset_session();
        //로그인 실패 처리
        alert('FTP 로그인 실패, FTP ID, Password를 확인하세요.', './af_login.php');
        exit;
    }
}

//로그아웃
if ($logout) {
    af_unset_session();
    alert('FTP 로그아웃 되었습니다.', './af_login.php');
}
