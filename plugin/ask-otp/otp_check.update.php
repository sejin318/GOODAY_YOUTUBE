<?php
/**
 * ASK OTP
 * 관리자 OTP 인증 처리
 * otp_check.update.php
 */
include_once './_common.php';

if ($is_admin != 'super') {
    echo "Access Denied.";
    exit;
}

//OTP 체크
if ($ask_otp_key) {
    $oneCode = $_ga->getCode($config['ask_otp_secret_key']);
    $checkResult = $_ga->verifyCode($config['ask_otp_secret_key'], $oneCode, 1);
    if ($checkResult && $oneCode == $ask_otp_key) {
        //OTP 완료
        $_SESSION['ask_otp_auth'] = true;
        alert("OTP 인증이 완료되었습니다." , '/');
        exit;
    } else {
        $_SESSION['ask_otp_auth'] = false;
        alert("OTP 코드가 틀립니다. 6자리 숫자를 정확하게 입력하세요." , '/');
        exit;
    }
}