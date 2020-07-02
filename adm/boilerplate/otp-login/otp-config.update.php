<?php

/**
 * ASK-ADMIN-OTP
 * 관리자 Two Factor 인증정보 저장
 * otp-config.update.php
 */
$sub_menu = "100991";
include_once './_common.php';

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

check_admin_token();

if ($otp_test && $reissued) {
    alert('재발급과 테스트는 동시에 할 수 없습니다.', './otp-config.php');
    exit;
}

$sql = " UPDATE {$g5['config_table']} set  `ask_otp_use` = '{$ask_otp_use}', `ask_otp_secret_key` = '" . trim($ask_otp_secret_key) . "'";
sql_query($sql, true);
$_SESSION['message'] = "설정이 저장되었습니다.";
//비밀키 재발급
if ($reissued) {
    $secret_key = $_ga->createSecret();
    $sql = " UPDATE {$g5['config_table']} set  `ask_otp_use` = '', `ask_otp_secret_key` = '" . trim($secret_key) . "'";
    sql_query($sql, true);
    $_SESSION['ask_otp_tested'] = false;
    alert('OTP Secret Key가 재발급 되었습니다. OTP 사용이 중지되었습니다.', './otp-config.php');
    exit;
}

//OTP 테스트
if ($otp_test) {
    $oneCode = $_ga->getCode($config['ask_otp_secret_key']);
    $checkResult = $_ga->verifyCode($config['ask_otp_secret_key'], $oneCode, 1);
    if ($checkResult && $oneCode == $otp_test) {
        $_SESSION['ask_otp_tested'] = true;
        alert($oneCode . ' = ' . $otp_test . ' 코드가 일치합니다. \n테스트완료! \n사용 설정을 하세요.', './otp-config.php');
        exit;
    } else {
        $_SESSION['ask_otp_tested'] = false;
        alert($oneCode . ' != ' . $otp_test . ' 코드가 일치하지 않습니다. OTP 6자리 숫자를 정확하게 입력하세요!', './otp-config.php');
        exit;
    }
}

goto_url('./otp-config.php', false);
