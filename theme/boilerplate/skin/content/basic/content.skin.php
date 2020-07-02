<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/content/content.basic.css">', 50);
?>

<article id="ctt" class="content_wrap ctt_<?php echo $co_id; ?> background-7 border-color-8 mb-4">
    <h2 class="page-title border-bottom border-color-6 pb-2"><?php echo $g5['title']; ?></h2>

    <div id="ctt_con" class="contents">
        <?php echo $str; ?>
    </div>

</article>