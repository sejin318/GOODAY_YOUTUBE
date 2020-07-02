<?php

/**
 * 웹진 목록 스킨
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
include_once G5_LIB_PATH . '/thumbnail.lib.php';
$board_cols = 12 / $board['bb_webzine_col'];
?>
<!--######################### 목록 시작#########################-->
<div class="board-webzine-list-wrap mb-4">
    <div class='row'>
        <?php
        for ($i = 0; $i < count($list); $i++) {
            //사용자 폰트 지정
            $use_font = '';
            if ($list[$i]['wr_1'] && $board['bb_use_font']) {
                $use_font = $list[$i]['wr_1'];
            }
        ?>
            <div class='col-sm-12 col-md-12 col-lg-<?php echo $board_cols ?> mb-2'>
                <div class="board-article row no-gutters">
                    <?php
                    $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_mobile_gallery_width'], $board['bo_mobile_gallery_height'], false, true, 'center');
                    $lazy_load = '';
                    $layz_src = '';
                    if ($i > 8) {
                        $lazy_load = 'lazy';
                        $layz_src = 'data-';
                    }
                    if ($thumb['src']) {
                        $img_content = "<img class='list-image {$lazy_load}' {$layz_src}src='{$thumb['src']}' alt='{$thumb['alt']}' width='{$board['bo_mobile_gallery_width']}' height='{$board['bo_mobile_gallery_height']}'>";
                    } else {
                        $img_content = "<img class='list-image {$lazy_load}' {$layz_src}src='" . G5_THEME_URL . "/img/noimage.png' alt='{$thumb['alt']}' width='{$board['bo_mobile_gallery_width']}' height='{$board['bo_mobile_gallery_height']}'>";
                    }
                    ?>
                    <div class='left-side col-sm-12 col-md-5 <?php echo $board_cols == 12 ? "col-lg-3" : ""; ?>'>
                        <div class="board-image-wrap position-relative">
                            <?php if ($is_checkbox) { ?>
                                <div class="board-checkbox position-absolute">
                                    <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="selec_chk">
                                    <label for="chk_wr_id_<?php echo $i ?>">
                                        <span></span>
                                        <b class="sr-only"><?php echo $list[$i]['subject'] ?></b>
                                    </label>
                                </div>
                            <?php } ?>
                            <a href='<?php echo $list[$i]['href'] ?>' class='list-image-link'><?php echo $img_content ?></a>
                        </div>
                    </div>
                    <div class='right-side col-sm-12 col-md-7  <?php echo $board_cols == 12 ? "col-lg-9" : ""; ?>'>
                        <div class='board-contents-wrap position-relative h-100'>
                            <div class='board-subject text-cut'>
                                <?php if ($list[$i]['reply']) {
                                    echo  '<i class="fa fa-reply" aria-hidden="true"></i>';
                                }

                                if ($list[$i]['is_notice']) {
                                    // 공지사항
                                    echo '<i class="fa fa-info-circle" aria-hidden="true"></i> 공지';
                                } else if ($wr_id == $list[$i]['wr_id']) {
                                    // 현재 게시물
                                    echo '<span class="read-current"><i class="fa fa-arrow-right fa-spin" aria-hidden="true"></i></span>';
                                } else {
                                    //번호 출력
                                    //echo $list[$i]['num'];
                                }
                                ?>
                                <!-- 분류 -->
                                <?php if ($is_category && $list[$i]['ca_name']) { ?>
                                    <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="board-category-link"><?php echo $list[$i]['ca_name'] ?></a>
                                <?php } ?>
                                <a href="<?php echo $list[$i]['href'] ?>" class='<?php echo $use_font ?> board-subject-link'>
                                    <?php
                                    echo $list[$i]['icon_reply'];
                                    if (isset($list[$i]['icon_secret'])) {
                                        echo rtrim($list[$i]['icon_secret']);
                                    }

                                    if (is_mobile()) {
                                        echo cut_str($list[$i]['subject'], $board['bo_mobile_subject_len']);
                                    } else {
                                        echo $list[$i]['subject'];
                                    }
                                    if ($list[$i]['icon_new']) {
                                        echo "<span class='new_icon'> <i class='fa fa-book' aria-hidden='true'></i> <span class='sr-only'>새글</span></span>";
                                    }
                                    // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
                                    if (isset($list[$i]['icon_file'])) {
                                        echo rtrim($list[$i]['icon_file']);
                                    }
                                    if (isset($list[$i]['icon_link'])) {
                                        echo rtrim($list[$i]['icon_link']);
                                    }
                                    if (isset($list[$i]['icon_hot'])) {
                                        echo rtrim($list[$i]['icon_hot']);
                                    }
                                    ?>
                                </a>
                                <?php if ($list[$i]['comment_cnt']) { ?>
                                    <span class="sr-only">댓글</span><span class="comments-count"><?php echo $list[$i]['wr_comment']; ?></span><span class="sr-only">개</span>
                                <?php } ?>
                            </div>
                            <div class='board-content'>
                                <div class='block-with-text'>
                                    <?php echo cut_str(strip_tags($list[$i]['content']), 180); ?>
                                </div>
                            </div>
                            <div class='wr-info'>
                                <ul class="breadcrumb p-2 m-0">
                                    <li class='breadcrumb-item'><?php echo $list[$i]['name'] ?></li>
                                    <li class='breadcrumb-item'><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $list[$i]['wr_hit'] ?></li>
                                    <?php if ($is_good) { ?><li class='breadcrumb-item'><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?php echo $list[$i]['wr_good'] ?></li><?php } ?>
                                    <?php if ($is_nogood) { ?><li class='breadcrumb-item'><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> <?php echo $list[$i]['wr_nogood'] ?></li><?php } ?>
                                    <li class='breadcrumb-item'><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$i]['datetime2'] ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--//.board-content-wrap-->
                </div>
            </div>
            <!--//.col-->
        <?php } ?>

    </div>
    <!--//row -->
    <?php if (count($list) == 0) {
        echo '<div class="empty_table">게시물이 없습니다.</div>';
    } ?>
</div>
<!--######################### 목록 끝 #########################-->