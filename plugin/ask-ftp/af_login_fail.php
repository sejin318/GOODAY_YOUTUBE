<?php
include_once './_common.php';
$login_error = null;
include_once './php-ftp-client/src/FtpClient/FtpClient.php';
include_once './php-ftp-client/src/FtpClient/FtpException.php';
include_once './php-ftp-client/src/FtpClient/FtpWrapper.php';
include_once './ask_ftp.const.php';
include_once './ask_ftp.lib.php';

if ($_SESSION['SS_FTP_LOGIN'] == true && $_SESSION['SS_FTP_ID'] && $_SESSION['SS_FTP_PASSWORD']) {
    alert('이미 로그인되어 있습니다!', './ask_ftp.php');
    exit;
}

$g5['title'] = 'ASK-FTP';
include_once G5_PLUGIN_PATH . '/ask-ftp/head.sub.php';
?>
<div class="jumbotron jumbotron-sm">
    <h1 class="display-5">ASK-FTP LOGIN FAIL</h1>
    <hr class="my-4">
    <p>FTP ID, Password를 확인하세요. </p>
    <p>설정한 FTP ID, Password가 틀립니다. 정보를 확인 후 정확한 로그인 정보를 입력하신 후 재시도 하세요.</p>
    <a href='./ask_ftp.php' class="btn btn-primary btn-lg">로그인</a>
</div>
<?php
include_once G5_PLUGIN_PATH . '/ask-ftp/tail.sub.php';
