<?php

/**
 * Slider 기본 스킨
 * 
 */
if (isset($_cfg['bs_use']) && $_cfg['bs_use'] == false) {
    //echo "<div class='alert alert-danger'>이 슬라이더는 사용 중지된 슬라이더입니다.</div>";
    echo "<!-- 이 슬라이더는 사용 중지된 슬라이더입니다. -->";
    return;
}
$uniqe_id = get_uniqid();
add_stylesheet('<link rel="stylesheet" href="' . BP_SLIDER_SKIN_URL . '/bg-slider/slider.css">');
?>
<section class='bg-slider-wrap'>
    <?php if ($_cfg['bs_crossfade'] == true) {
        //크로스 페이드
        $crossfade = "carousel-fade";
    }

    ?>
    <div id="bg-slider_<?php echo $uniqe_id ?>" class="carousel slide <?php echo $crossfade ?> " data-ride="carousel">
        <?php
        $i = 0;
        if ($_cfg['bs_indicator'] == true) {
            echo "<ol class='carousel-indicators'>" . PHP_EOL;
            foreach ($item as $_c) {
                $i == 0 ? $active = "class='active'" : "";
                echo "<li data-target='#bg-slider_{$uniqe_id}' data-slide-to='{$i}' {$active} ></li>" . PHP_EOL;
                $i++;
            }
            echo "</ol>" . PHP_EOL;
        }
        ?>
        <div class="carousel-inner overflow-hidden">
            <?php
            $x = 0;
            foreach ($item as $_item) {
                $slider_image_tag = " style='background-color:#999'";
                if ($_item['bss_image']) {
                    $slider_image_tag = " style='background-image:url(" . BP_SLIDERSAVE_URL . DIRECTORY_SEPARATOR . $_item['bss_image'] . ")' ";
                }
                $active = '';
                if ($x == 0) {
                    $active = 'active';
                }
                $interval = '';
                if ($_item['bss_interval']) {
                    $interval = "data-interval='{$_item['bss_interval']}'";
                    $autoplay = true;
                } else {
                    $autoplay = false;
                    $interval = "data-interval='false'";
                }
                echo "'<div class='carousel-item {$active} carousel-item-num{$x} {$_item['bss_class']}' {$interval} data-pause='hover' >" . PHP_EOL;

                echo "<div class='carousel-bg-image embed-responsive {$_cfg['bs_ratio']}' id='ytp-wrap-{$video_id}{$x}' {$slider_image_tag}> " . PHP_EOL;
                if ($_item['bss_subject'] != '' || $_item['bss_content'] != '') {
                    echo '<div class="carousel-caption animate ">' . PHP_EOL;
                    if ($_item['bss_url']) {
                        echo "<h5><a href='{$_item['bss_url']}'>{$_item['bss_subject']}</a></h5>" . PHP_EOL;
                        echo "<p><a href='{$_item['bss_url']}'>{$_item['bss_content']}</a></p>" . PHP_EOL;
                    } else {
                        echo "<h5>{$_item['bss_subject']}</h5>" . PHP_EOL;
                        echo "<p>{$_item['bss_content']}</p>" . PHP_EOL;
                    }
                    echo '</div>' . PHP_EOL;
                }

                echo "</div>" . PHP_EOL;
                echo '</div>' . PHP_EOL;
                $x++;
            } ?>
        </div>
        <?php if ($_cfg['bs_control'] == true) { ?>
            <a class="carousel-control-prev" href="#bg-slider_<?php echo $uniqe_id ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#bg-slider_<?php echo $uniqe_id ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        <?php } ?>

    </div>

</section>
<script>
    $(function() {
        <?php if($autoplay == false){ ?>
        $("bg-slider_<?php echo $uniqe_id ?>").carousel({
            interval: false
        });
    <?php } ?>
    
        var sliderItem = $(this).find('.carousel-caption');
        setTimeout(function() {
            sliderItem.addClass('slide-in-blurred-top');
        }, 200);
        //Events
        $('#bg-slider_<?php echo $uniqe_id ?>').on('slide.bs.carousel', function() {
            //console.log('Slider 호출');
            var sliderItem = $(this).find('.carousel-caption');
            sliderItem.removeClass('slide-in-blurred-top');

        });
        $('#bg-slider_<?php echo $uniqe_id ?>').on('slid.bs.carousel', function() {
            //console.log('Slider 완료');
            var sliderItem = $(this).find('.carousel-caption');

            setTimeout(function() {
                sliderItem.addClass('slide-in-blurred-top');
            }, 200);
            sliderItem.removeClass('slide-in-blurred-top');
        });

    });
</script>