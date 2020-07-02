<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * 
 * 환경설정 로딩
 */
//kakao api
$_use_gps = false;
if (($config['cf_kakao_rest_key'] && $config['cf_kakao_client_secret'] && $config['cf_kakao_js_apikey']) && $board['bb_exif_gps']) {
    $_use_gps = true;
    add_javascript('<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=' . $config['cf_kakao_js_apikey'] . '&services,clusterer,drawing"></script>', 100);
}
