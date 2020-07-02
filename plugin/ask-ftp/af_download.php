<?php
include_once './_common.php';
include_once './php-ftp-client/src/FtpClient/FtpClient.php';
include_once './php-ftp-client/src/FtpClient/FtpException.php';
include_once './php-ftp-client/src/FtpClient/FtpWrapper.php';
include_once './ask_ftp.const.php';
include_once './ask_ftp.lib.php';
include_once './ask_ftp.auth.php';

if ($af_file) {
    $file_path = $af_file;
    $size = $ftp->size($file_path);

    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=" . basename($file_path));
    header("Content-Length: $size");

    //확장자
    $last_arr = array_pop(explode('/', $af_file));
    $ext = pathinfo($last_arr);
    $ext['extension'] = strtolower($ext['extension']);
    //ASCII 파일인지 확장자 검사
    if (in_array($ext['extension'], explode(',', AF_ASCII))) {
        $ftp_mode = FTP_ASCII;
    } else {
        $ftp_mode = FTP_BINARY;
    }

    $ftp->get("php://output", $file_path, $ftp_mode);
}