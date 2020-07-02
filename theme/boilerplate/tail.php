<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * 푸터 파일 경로
 * _header_footer
 * 위 폴더 참고하세요.
 */
if (isset($config['bp_header_footer']) && $config['bp_header_footer']) {
    $tail_inc = G5_THEME_PATH . DIRECTORY_SEPARATOR . '_header_footer' . DIRECTORY_SEPARATOR . $config['bp_header_footer'] . DIRECTORY_SEPARATOR . '/tail.inc.php';
    if (file_exists($tail_inc)) {
        include_once $tail_inc;
    } else {
        echo "<div class='alert alert-danger'>tail 파일이 없습니다.</div>";
    }
}
