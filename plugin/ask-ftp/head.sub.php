<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

$begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
} else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | " . af_Decrypt($_SESSION['SS_FTP_HOST']);
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/' . G5_ADMIN_DIR . '/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">
    <meta name="HandheldFriendly" content="true">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=11,chrome=1">
    <link rel="stylesheet" href="<?php echo G5_PLUGIN_URL ?>/ask-ftp/style.css">
    <link rel="stylesheet" href="<?php echo G5_JS_URL ?>/font-awesome/css/font-awesome.min.css">
    <title><?php echo $g5_head_title; ?></title>
    <script>
        // 자바스크립트에서 사용하는 전역변수 선언
        var g5_url = "<?php echo G5_URL ?>";
        var g5_bbs_url = "<?php echo G5_BBS_URL ?>";
        var g5_is_member = "<?php echo isset($is_member) ? $is_member : ''; ?>";
        var g5_is_admin = "<?php echo isset($is_admin) ? $is_admin : ''; ?>";
        var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
        var g5_bo_table = "<?php echo isset($bo_table) ? $bo_table : ''; ?>";
        var g5_sca = "<?php echo isset($sca) ? $sca : ''; ?>";
        var g5_editor = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor']) ? $config['cf_editor'] : ''; ?>";
        var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
        <?php if (defined('G5_IS_ADMIN')) { ?>
            var g5_admin_url = "<?php echo G5_ADMIN_URL; ?>";
        <?php } ?>
    </script>
    <script src="<?php echo G5_PLUGIN_URL ?>/ask-ftp/js/jquery.min.js?ver=<?php echo G5_JS_VER; ?>"></script>
    <script src="<?php echo G5_PLUGIN_URL ?>/ask-ftp/bootstrap/dist/js/bootstrap.bundle.min.js?ver=<?php echo G5_JS_VER; ?>"></script>

    <script src="<?php echo G5_JS_URL ?>/common.js?ver=<?php echo G5_JS_VER; ?>"></script>
    <script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>
    <script src="<?php echo G5_PLUGIN_URL ?>/ask-ftp/ace/ace.js" type="text/javascript" charset="utf-8"></script>
</head>

<body class="askftp">
    <nav class="navbar navbar-expand-lg navbar-dark bg-gradient-dark">
        <a class="navbar-brand" href="./ask_ftp.php">ASK-FTP</a>
        <a class="navbar-brand" href="<?php echo G5_ADMIN_URL ?>"><i class="fa fa-cog" aria-hidden="true"></i></a>
        <?php
        if ($_SESSION['SS_FTP_LOGIN'] == true) { ?>
            <a class="btn btn-outline-success ml-auto" href='#'>FTP 접속중</a>
        <?php } ?>
    </nav>
    <div class="container">
        <div class="jumbotron jumbotron-sm mt-2">
            <h2 class="display-5"><?php echo af_Decrypt($_SESSION['SS_FTP_HOST']) ?> <span>ASK-FTP</span></h2>
            <?php if (!$dir && !$edit_file && !strstr($_SERVER['PHP_SELF'], 'af_login')) { ?>
                <hr class="my-4">
                <p>ASK-FTP는 php ftp를 이용해 파일을 업로드, 파일 생성, 수정, 삭제하는 프로그램입니다. Linux 에서만 테스트 되었습니다. 윈도우 서버용이 아닙니다. </p>
                <p>웹브라우저는 최소 IE11 이상, 크롬, 또는 파이어폭스를 이용하세요. 여러 파일을 한번에 업로드 가능합니다.</p>
                <p>PHP FTP이기 때문에 웹서버 권한(nobody, apache, nginx)으로 생성된 파일(업로드파일,data 폴더)은 읽기만 가능합니다. 수정, 삭제 불가입니다.</p>
                <p>ASK-FTP는 웹에서 실행되는 FTP입니다. 웹서버가 로컬입니다. PC에서 업로드 후 파일을 웹서버로컬->웹사이트로 FTP로 업로드 됩니다.</p>
                <p>PHP 파일 업로드 크기에 영향을 받습니다. 대용량 파일 또는 폴더 업로드는 Filezilla 와 같은 FTP 앱을 사용하세요.</p>
                <p>Server Type : <?php echo $ftp->systype() ?></p>
            <?php } ?>
        </div>