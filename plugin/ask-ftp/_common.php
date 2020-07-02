<?php

/**
 * ASK FTP
 * 유료 프로그램입니다. 불법복제 금지
 */

include_once '../../common.php';
//Extension 체크
if(extension_loaded('ftp') == false){
    die('PHP가 FTP를 지원하지 않는 환경입니다. 서비스를 받고있는 회사에 문의하세요.');
}
if(function_exists('openssl_encrypt') == false){
    die('OpenSSL이 설치되어 있어야 합니다.서비스를 받고있는 회사에 문의하세요.');
}
if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.', '/');
    exit;
}
