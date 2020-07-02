<?php

/**
 * 갤러리 기본 스킨
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

$cssfile = "latest." . $skin_dir . ".css";
add_stylesheet("<link rel='stylesheet' href='" . BP_CSS . "/latest/{$cssfile}'>", 50);
$thumb_width = 400;
$thumb_height = 300;
?>

<div class="gallery-latest latest-skin">
    <h2 class="latest-title"><a href="<?php echo get_pretty_url($bo_table); ?>" class='title-link'><?php echo $bo_subject ?></a></h2>
    <div class='item-list row desktop-latest-view'>
        <?php
        for ($i = 0; $i < count($list); $i++) {
            $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);
            $img_content = "<img src='" . G5_THEME_IMG_URL . "/noimage.png' alt='이미지없음' class='img-fluid'>";
            if ($thumb['src']) {
                $img = $thumb['src'];
                $img_content = "<img src='{$img}' alt='{$thumb['alt']}' class='img-fluid'>";
            }
        ?>
            <div class='items mb-2 col-sm-12 col-md-6 col-lg-4 col-xl-2'>
                <div class="image-box position-relative">
                    <a href="<?php echo $list[$i]['href'] ?>" class="image-link d-block"><?php echo $img_content; ?></a>
                    <?php
                    echo "<div class='item-stats d-flex justify-content-start'>";
                    if ($list[$i]['icon_secret']) {
                        echo "<div class='item-stats-list mr-1'><i class='fa fa-lock' aria-hidden='true'></i><span class='sr-only'>비밀글</span></div> ";
                    }
                    if ($list[$i]['icon_new']) {
                        echo "<div class='item-stats-list mr-1 new_icon'>N<span class='sr-only'>새글</span></div>";
                    }
                    if ($list[$i]['icon_hot']) {
                        echo "<div class='item-stats-list mr-1 hot_icon'><i class='fa fa-thumbs-up' aria-hidden='true'></i><span class='sr-only'>인기글</span></div>";
                    }
                    if ($list[$i]['comment_cnt']) {
                        echo "<span class='item-stats-list mr-1 comments'>{$list[$i]['wr_comment']}</span>";
                    }
                    echo "<div class='item-stats-list datetime'>{$list[$i]['datetime2']}</div>";

                    echo "</div>";
                    ?>
                </div>
                <?php
                echo "<a href='{$list[$i]['href']}' class='subject text-link text-cut d-block'> ";
                if ($list[$i]['is_notice']) {
                    echo "<strong>{$list[$i]['subject']}</strong>";
                } else {
                    echo $list[$i]['subject'];
                }
                echo "</a>";
                ?>
                <div class="writer-info text-center">
                    <span class="lt_nick"><?php echo $list[$i]['name'] ?></span>
                </div>
            </div>
        <?php } //for
        //게시물 없음
        if (count($list) == 0) {
            echo "<div class='col-sm-12'><div class='alert alert-info no-items text-center p-5'>게시물이 없습니다.</div></div>";
        }
        ?>
    </div>

    <div class='mobile-latest-view'>
        <!-- 모바일은 슬라이드로 전환 -->
        <?php $carousel_id = uniqid(rand(), false); ?>
        <!-- https://getbootstrap.com/docs/4.4/components/carousel/#with-captions 슬라이더 설정은 링크참고 -->
        <div id="carousel_latest_<?php echo $carousel_id ?>" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php for ($i = 0; $i < count($list); $i++) {
                    $active = '';
                    if ($i == 0) {
                        $active = "active";
                    }
                    echo "<li data-target='#carousel_latest_{$carousel_id}' data-slide-to='{$i}' class='{$active}'></li>";
                }
                //게시물 없음
                if (count($list) == 0) {
                    echo "<li data-target='#carousel_latest_{$carousel_id}' data-slide-to='0' class='active'></li>";
                }
                ?>
            </ol>
            <div class="carousel-inner">
                <?php
                for ($i = 0; $i < count($list); $i++) {
                    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);
                    $img_content = "<img src='" . G5_THEME_IMG_URL . "/noimage.png' alt='이미지없음' class='img-fluid'>";
                    if ($thumb['src']) {
                        $img = $thumb['src'];
                        $img_content = "<img src='{$img}' alt='{$thumb['alt']}' class='img-fluid'>";
                    }

                    $active = '';
                    if ($i == 0) {
                        $active = "active";
                    }
                    echo "<div class='carousel-item {$active}'>";
                    echo "<a href='{$list[$i]['href']}' class='mobile-image'>{$img_content}</a>";
                    echo "<div class='carousel-caption'><h5 class='subject text-link text-cut'>{$list[$i]['subject']}</h5></div>";
                    echo "</div>";
                }
                //게시물 없음
                if (count($list) == 0) {
                    echo "<div class='carousel-item active text-center'><div class='p-4 text-center'>게시물이 없습니다.</div></div>";
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#carousel_latest_<?php echo $carousel_id ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel_latest_<?php echo $carousel_id ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>