<?php
define('_GNUBOARD_', true);
include_once './_common.php';
$login_error = null;
include_once './php-ftp-client/src/FtpClient/FtpClient.php';
include_once './php-ftp-client/src/FtpClient/FtpException.php';
include_once './php-ftp-client/src/FtpClient/FtpWrapper.php';
include_once './ask_ftp.const.php';
include_once './ask_ftp.lib.php';
include_once './ask_ftp.auth.php';
if (!$config['bp_ftp_modify']) {
    alert('파일을 편집 할 수 없습니다. 테마 기본설정에서 FTP 편집을 활성화 하세요.');
    exit;
}
if ($edit_file) {

    $file =  stripslashes($contents);
    $tempHandle = fopen('php://temp', 'r+');
    fwrite($tempHandle, $file);
    rewind($tempHandle);
    $stream = $tempHandle;
    $result = $ftp->fput($edit_file, $stream, FTP_ASCII);

    if ($result) {
        // 편집한 파일 업로드
        if (isset($config['bp_ftp_backup']) && $config['bp_ftp_backup']) {

            //편집하기전 파일 저장 - 백업
            $org_file =  stripslashes($contents_org);
            $tempHandle2 = fopen('php://temp', 'r+');
            fwrite($tempHandle2, $org_file);
            rewind($tempHandle2);
            $stream_backup = $tempHandle2;
            $backup_file_name =  date('Ymdhis', G5_SERVER_TIME) . str_replace('/', '-', $edit_file);
            //백업저장
            $ftp->fput($config['bp_ftp_root'] . '/' . $config['bp_ftp_backup'] . '/' . $backup_file_name, $stream_backup, FTP_ASCII);
        }

        $_SESSION['ask_message'] = $edit_file . " 파일이 저장되었습니다.";
        goto_url("./af_editor.php?edit_file={$edit_file}");
        exit;
    } else {
        alert($edit_file . " 파일 저장시 오류가 발생하였습니다.", "./af_editor.php?edit_file={$edit_file}");
        exit;
    }
} else {
    alert('오류 : 데이터가 없습니다.');
}
