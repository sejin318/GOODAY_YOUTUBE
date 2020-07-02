<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
###########################
# Boilerplate 상수
###########################
//DB table
define("BP_CONFIG_TABLE", 'boilerplate_config');
define("BP_SLIDER_TABLE", 'boilerplate_slider');
define("BP_SLIDER_LIST_TABLE", 'boilerplate_slider_list');
define("BP_LOGO_TABLE", 'boilerplate_logo');
define("BP_FAVORITE_TABLE", 'boilerplate_favorite');
define("BP_BANNER_TABLE", 'boilerplate_banner');
define("BP_ALARM_TABLE", 'boilerplate_alarm');
define("BP_MEMBER_TABLE", 'boilerplate_member');
define("BP_MEMBER_MEMO_TABLE", 'boilerplate_member_memo');
define("BP_BANNER_HOOK_TABLE", 'boilerplate_hook_banner');
define("BP_DUMMY_TABLE", 'boilerplate_dummy_log');
define("BP_BOARD_TABLE", 'boilerplate_board');
define("BP_POINT_CHARGE_TABLE", 'boilerplate_point_charge');
define("BP_POINT_REFUND_TABLE", 'boilerplate_point_refund');
define("BP_DOWNLOAD_TABLE", 'boilerplate_download');

//경로
define("BP_ASSETS", '_assets');
define("BP_ASSETS_URL", G5_URL . DIRECTORY_SEPARATOR . BP_ASSETS);
define("BP_JS", BP_ASSETS_URL . DIRECTORY_SEPARATOR . 'js');
define("BP_CSS", BP_ASSETS_URL . DIRECTORY_SEPARATOR . 'css');
define("BP_BOOTSTRAP", BP_ASSETS_URL . DIRECTORY_SEPARATOR . 'bootstrap');
define("BP_FONTAWESOME", BP_ASSETS_URL . DIRECTORY_SEPARATOR . 'font-awesome');
define("BP_MMENU", BP_ASSETS_URL . DIRECTORY_SEPARATOR . 'mmenu-js');
define("BP_MHEAD", BP_ASSETS_URL . DIRECTORY_SEPARATOR . 'mhead-js');
define("BP_OFFCANVAS", BP_ASSETS_URL . DIRECTORY_SEPARATOR . 'js-offcanvas');
define("BP_SWIPER", BP_ASSETS_URL . DIRECTORY_SEPARATOR . 'swiper');
define("BP_PLYR", BP_ASSETS_URL . DIRECTORY_SEPARATOR . 'plyr');
define("BP_MYPAGE_PATH", G5_PATH . DIRECTORY_SEPARATOR . '_mypage');
define("BP_MYPAGE_URL", G5_URL . DIRECTORY_SEPARATOR . '_mypage');

//테마 파일 업로드 경로
define("BP_FILE_DIR", G5_DATA_PATH . DIRECTORY_SEPARATOR . 'bp_file');
define("BP_FILE_URL", G5_DATA_URL . DIRECTORY_SEPARATOR . 'bp_file');

//슬라이더저장경로
define("BP_SLIDERSAVE_DIR", G5_DATA_PATH . DIRECTORY_SEPARATOR . 'bp_slider');
define("BP_SLIDERSAVE_URL", G5_DATA_URL . DIRECTORY_SEPARATOR . 'bp_slider');

//메뉴 템플릿 경로
define("BP_MENU_PATH", G5_THEME_PATH . DIRECTORY_SEPARATOR . '_menu');
define("BP_PC_MENU", BP_MENU_PATH . DIRECTORY_SEPARATOR . 'pc');
define("BP_MOBILE_MENU", BP_MENU_PATH . DIRECTORY_SEPARATOR . 'mobile');
define("BP_MENU_URL", G5_THEME_URL . DIRECTORY_SEPARATOR . '_menu');
define("BP_PC_MENU_URL", BP_MENU_URL . DIRECTORY_SEPARATOR . 'pc');
define("BP_MOBILE_MENU_URL", BP_MENU_URL . DIRECTORY_SEPARATOR . 'mobile');

//헤더푸터 템플릿 경로
define("BP_HEADER_FOOTER_PATH", G5_THEME_PATH . DIRECTORY_SEPARATOR . '_header_footer');
define("BP_HEADER_FOOTER_URL", G5_THEME_URL . DIRECTORY_SEPARATOR . '_header_footer');

//업로더 템플릿 경로
define("BP_UPLOADER_PATH", G5_THEME_PATH . DIRECTORY_SEPARATOR . '_uploader');
define("BP_UPLOADER_URL", G5_THEME_URL . DIRECTORY_SEPARATOR . '_uploader');

//슬라이더 스킨 경로
define("BP_SLIDER_SKIN_PATH", G5_THEME_PATH . DIRECTORY_SEPARATOR . '_slider');
define("BP_SLIDER_SKIN_URL", G5_THEME_URL . DIRECTORY_SEPARATOR . '_slider');

//HERO Heaer
define("BP_HERO_PATH", G5_THEME_PATH . DIRECTORY_SEPARATOR . '_hero');


//Vendor 경로
define('BP_VENDOR_PATH', G5_PATH . DIRECTORY_SEPARATOR . 'vendor');
define('BP_GOOGLE_API_KEY', '');

//HOOK
//배너용 HOOK
define('BP_BANNER_HOOK', array('메인상단배너', '메인하단배너', '게시판목록상단', '게시판목록하단', '게시판내용상단', '게시판내용하단','커뮤니티메인좌측배너','커뮤니티메인우측배너','사이드하단배너', '메인 배너'));


//php minify
define("BP_MIN_URL", G5_URL . DIRECTORY_SEPARATOR . 'min');
define("BP_MIN_JS1", BP_MIN_URL . DIRECTORY_SEPARATOR . '?f=/js/jquery.menu.js,/js/common.js,/js/wrest.js,/js/placeholders.min.js,/js/modernizr.custom.70111.js,/_assets/js-offcanvas/dist/_js/js-offcanvas.pkgd.min.js,/_assets/bootstrap/dist/js/bootstrap.bundle.min.js,/_assets/bootstrap4-toggle/js/bootstrap4-toggle.min.js');
define("BP_MIN_JS2", BP_MIN_URL . DIRECTORY_SEPARATOR . '?f=/_assets/swiper/js/swiper.min.js,/_assets/scrollmagic/scrollmagic/minified/ScrollMagic.min.js,/_assets/jquery-match-height/dist/jquery.matchHeight-min.js,/_assets/sticky-sidebar/dist/jquery.sticky-sidebar.min.js,/_assets/jquery.mb.ytplayer/jquery.mb.YTPlayer.min.js,/_assets/js/jarallax.js,/_assets/js/bp_common.js');
define("BP_MIN_CSS", BP_MIN_URL . DIRECTORY_SEPARATOR . '?f=/_assets/font-awesome/css/font-awesome.min.css,/_assets/jquery.mb.ytplayer/css/jquery.mb.YTPlayer.min.css,/_assets/mhead-js/dist/mhead.css,/_assets/js-offcanvas/dist/_css/js-offcanvas.css');


###########
# 각종설정
###########
//포인트 다운로드 커미션
define("BP_POINT_COMMISSION", 30);
