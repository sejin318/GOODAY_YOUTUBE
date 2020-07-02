<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

/**
 * FTP 인증
 * 로그인 세션이 있다면 로그인 처리
 */

//FTP 설정이 되어 있다면 로그인
if ($config['bp_ftp_use'] && ($config['bp_ftp_id'] && $config['bp_ftp_password'] && $config['bp_ftp_root'] && $config['bp_ftp_port'])) {
    try {
        //FTP Login , host, ssl, port, timeout
        $ftp_connect = $ftp->connect('localhost', false, $config['bp_ftp_port'], 20);
        $ftp_login = $ftp->login($config['bp_ftp_id'], af_Decrypt($config['bp_ftp_password']));
        $ftp->set_option(FTP_USEPASVADDRESS, false);
        $ftp->pasv($config['bp_ftp_pasv']);
        $ftp->raw("OPTS UTF8 ON");
        $_SESSION['SS_FTP_LOGIN'] = true;
    } catch (Exception $error) {
        af_unset_session();
        //로그인 실패 처리
        alert('FTP 로그인 실패, FTP ID, Password를 확인하세요.',  G5_ADMIN_URL . '/boilerplate/bp_config.php#ftp');
        exit;
    }
} else if (!$config['bp_ftp_use']) {
    alert("FTP를 이용 할 수 없습니다.", '/');
    exit;
} else {
    //오류출력
    alert('FTP 설정을 완료 후 이용하세요.', G5_ADMIN_URL . '/boilerplate/bp_config.php#ftp');
}
