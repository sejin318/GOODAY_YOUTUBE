<?php

/**
 *  노사이드바용 Head
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
?>
<!--  # 컨텐츠 시작 # -->
<div class='<?php echo $config['bp_container'] ?> global-container '>
    <?php
    if (defined('_INDEX_')) { // index에서만 실행
        if (is_mobile() == true) {
            # 모바일 팝업
            include G5_THEME_PATH . '/newwin.inc.php';
        } else {
            # PC 팝업
            include G5_BBS_PATH . '/newwin.inc.php';
        }
    }
    ?>
    <div class='row global-row'>
        <!-- contents -->
        <div class='col-sm-12 col-md-12 col-lg-12 contents-wrap'>
            <div class='contents'>