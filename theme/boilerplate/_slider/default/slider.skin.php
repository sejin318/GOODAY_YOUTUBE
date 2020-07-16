<?php

/**
 * Slider 기본 스킨
 *
 */
if (isset($_cfg['bs_use']) && $_cfg['bs_use'] == false) {
    echo "<div class='alert alert-danger'>이 슬라이더는 사용 중지된 슬라이더입니다.</div>";
    return;
}
add_stylesheet('<link rel="stylesheet" href="' . BP_SLIDER_SKIN_URL . '/default/slider.css">');
?>
<section class='w-slider slider-default-wrap slider-default-wrap-max' >
    <?php if ($_cfg['bs_crossfade'] == true) {
        //크로스 페이드
        $crossfade = "carousel-fade";
    }

    ?>
    <div id="default-slider" class="carousel slide <?php echo $crossfade ?>" data-ride="carousel">
        <?php
        $i = 0;
        if ($_cfg['bs_indicator'] == true) {
            echo "<ol class='carousel-indicators'>" . PHP_EOL;
            foreach ($item as $_c) {
                $i == 0 ? $active = "class='active'" : "";
                echo "<li data-target='#default-slider' data-slide-to='{$i}' {$active} ></li>" . PHP_EOL;
                $i++;
            }
            echo "</ol>" . PHP_EOL;
        }
        ?>
        <div class="carousel-inner">
            <?php
            $x = 0;
            foreach ($item as $_item) {
                $slider_image_tag = '';
                if ($_item['bss_image']) {
                    $slider_image_tag = "<img src='" . BP_SLIDERSAVE_URL . DIRECTORY_SEPARATOR . $_item['bss_image'] . "' class='d-block w-100' alt='{$_item['bss_name']}'>";
                }
                $active = '';
                if ($x == 0) {
                    $active = 'active';
                }
                $interval = '';
                if ($_item['bss_interval']) {
                    $interval = "data-interval='{$_item['bss_interval']}'";
                }
                echo "'<div class='carousel-item {$active} carousel-item-num{$x} {$_item['bss_class']}' {$interval}>";
                // only put a link to the entire img when the index equals to 2
                if($x == 2){
                    echo "<a href='https://www.goodayoutube.com/bbs/board.php?bo_table=notice&wr_id=2'>$slider_image_tag</a>";
                } else {
                    echo $slider_image_tag;
                }
//                echo $slider_image_tag;
                if ($_item['bss_subject'] != '' || $_item['bss_content'] != '') {
                    echo '<div class="carousel-caption carousel-caption-media">';
                    if ($_item['bss_url']) {
                        echo "<h5><a href='{$_item['bss_url']}'>{$_item['bss_subject']}</a></h5>";
                        echo "<p><a href='{$_item['bss_url']}'>{$_item['bss_content']}</a></p>";
                    } else {
                        echo "<h5>{$_item['bss_subject']}</h5>";
                        echo "<p>{$_item['bss_content']}</p>";
                    }
                    echo '</div>';
                }
                echo '</div>';
                $x++;
            } ?>
        </div>
        <?php if ($_cfg['bs_control'] == true) { ?>
            <a class="carousel-control-prev" href="#default-slider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#default-slider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        <?php } ?>

    </div>
</section>
<script>
    $(function() {
        //Events
        $('#default-slider').on('slide.bs.carousel', function() {
            //console.log('Slider 호출');
        });
        $('#default-slider').on('slid.bs.carousel', function() {
            //console.log('Slider 완료');
        });
    });
</script>
