<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
} else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | " . $config['cf_title'];
}

$g5['title'] = strip_tags($g5['title']);
$g5_head_title = strip_tags($g5_head_title);

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생 
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location']) {
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
}
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/' . G5_ADMIN_DIR . '/') || $is_admin == 'super') $g5['lo_url'] = '';

if ($is_member) {
    $login_class = 'login';
}
?>
<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <?php

    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=1,user-scalable=no">' . PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">' . PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">' . PHP_EOL;
    echo '<meta http-equiv="imagetoolbar" content="no">' . PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">' . PHP_EOL;

    if ($config['cf_add_meta']) {
        echo $config['cf_add_meta'] . PHP_EOL;
    }

    ?>
    <!-- favicon -->
<!--
    <link rel="apple-touch-icon" sizes="60x60" href="/_assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/_assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/_assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/_assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/_assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/_assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/_assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/_assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/_assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/_assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/_assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/_assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#999999">
    <meta name="msapplication-TileImage" content="/_assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#33333">
-->
    
<!--    <link rel="apple-touch-icon" sizes="60x60" href="/_assets/favicon/dog.png">-->
    <link rel="shortcut icon" href="/_assets/favicon/gooday_logo.ico" type="image/x-ico" />

    <title><?php echo $g5_head_title; ?></title>
    <?php

    //스타일테마설정
    $theme_css = "colorset.default.css";
    //기본 컬러셋
    $colorset[1] = 'default';
    if (isset($config['bp_colorset']) && $config['bp_colorset']) {
        $theme_css = $config['bp_colorset'];
        $colorset = explode(".", $config['bp_colorset']);
    }

    //night 모드 사용이면 오후7시부터 오전7시까지 강제 다크 컬러셋 사용
    if ($config['bp_night_mode']) {
        $now_hour = date("H", time());
        if ($now_hour >= 19 || $now_hour <= 7) {
            $theme_css = "colorset.dark.css?theme=darkmode";
            $colorset[1] = 'dark';
        }
    }
    //보일러플레이트 테마 설정 미완료시 안내페이지로 이동

    //14px 폰트 사용
    if (isset($config['bp_font_size']) && $config['bp_font_size']) {
        $theme_css = str_replace(".css", ".font14px.css?font=14", $theme_css);
    }
    ?>
    <link rel="stylesheet" href="<?php echo BP_CSS ?>/<?php echo $theme_css ?>">
    <?php
    //add_stylesheet('<link rel="stylesheet" href="' . BP_FONTAWESOME . '/css/font-awesome.min.css">', 10);
    /*
    add_stylesheet('<link rel="stylesheet" href="' . BP_MHEAD . '/dist/mhead.css">', 11);
    add_stylesheet('<link rel="stylesheet" href="' . BP_OFFCANVAS . '/dist/_css/js-offcanvas.css">', 15);
    */
    //grid
    if ($config['bp_container'] == 'container-xxl') {
        $grid = "grid-xxl.css";
    } else {
        $grid = "grid-xl.css";
    }
    add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/css/' . $grid . '">', 1);
    add_stylesheet('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Pacifico">', 20);
    //구글폰트 Noto Sans KR, Nanum Gothic
    add_stylesheet('<link href="//fonts.googleapis.com/css?family=Nanum+Gothic|Noto+Sans+KR:400,700&display=swap&subset=korean" rel="stylesheet">', 25);
    ?>
    <link rel="stylesheet" href="<?php echo BP_MIN_CSS ?>" />
    <script crossorigin="anonymous" src="//polyfill.io/v3/polyfill.min.js?features=es2016%2Ces2015%2Cdefault%2Ces2017%2Ces2018%2Ces2019%2Ces5%2Ces6%2Ces7"></script>
    <script src="<?php echo BP_JS ?>/jquery.min.js?ver=3.4.1"></script>
    <script src="<?php echo BP_JS ?>/jquery-migrate.min.js"></script>
    <?php
    if (is_ie11() == false) {
        add_javascript('<script src="' . BP_MHEAD . '/dist/mhead.js"></script>', 100);
    }
    ?>
    <!--  
    <script src="<?php echo BP_OFFCANVAS ?>/dist/_js/js-offcanvas.pkgd.min.js"></script>
    <script src="<?php echo BP_BOOTSTRAP ?>/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BP_ASSETS_URL ?>/bootstrap4-toggle/js/bootstrap4-toggle.min.js"></script>
    <script src="<?php echo BP_MHEAD ?>/dist/mhead.js"></script>
    <script src="<?php echo BP_SWIPER ?>/js/swiper.min.js"></script>
    <script src="<?php echo BP_ASSETS_URL ?>/js/bp_common.js"></script>
    <script src="<?php echo BP_ASSETS_URL ?>/scrollmagic/scrollmagic/minified/ScrollMagic.min.js"></script>
    <script src="<?php echo BP_ASSETS_URL ?>/stellar.js/jquery.stellar.min.js"></script>
    -->
    <!-- 스크립트 합치기 -->
    <script src="<?php echo BP_MIN_JS1 ?>"></script>
    <script src="<?php echo BP_MIN_JS2 ?>"></script>

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
    </script>

    <!--
    <script src="<?php echo G5_JS_URL ?>/jquery.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
    <script src="<?php echo G5_JS_URL ?>/common.js?ver=<?php echo G5_JS_VER; ?>"></script>
    <script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>
    <script src="<?php echo G5_JS_URL ?>/placeholders.min.js"></script>
    -->
    <?php
    if (!defined('G5_IS_ADMIN')) {
        echo $config['cf_add_script'];
    }

    ?>

</head>
<?php
//사이트, 메뉴, Hero header 컨테이너 설정, 수정, 삭제 금지
if ($config['bp_container'] == 'container-fluid') {
    $class = 'fullwidth-type';
} else {
    $class = 'box-type';
}
if ($config['bp_pc_menu_container']) {
    $class .= " box-menu-type ";
} else {
    $class .= " fullwidth-menu-type ";
}
?>

<body <?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?> class='<?php echo "{$class} colorset-" . $colorset[1] ?> <?php echo $config['cf_theme'] ?> <?php echo $login_class; ?> <?php echo $config['bp_header_footer'] ?>'>
    <div class="c-offcanvas-content-wrap" role="main">