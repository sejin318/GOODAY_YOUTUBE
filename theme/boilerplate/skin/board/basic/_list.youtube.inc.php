<?php

/**
 * 유튜브 목록 스킨
 * wr_link2, wr_1 필드를 사용합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
/*
require G5_PATH . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
use Intervention\Image\ImageManager;
$manager = new ImageManager(array('driver' => 'gd'));
*/

include_once G5_LIB_PATH . '/thumbnail.lib.php';
$board_cols = 12 / $board['bb_gallery_col'];
?>
<!--######################### 목록 시작#########################-->
<div class="board-gallery-list-wrap mb-4">
    <div class='row'>
        <?php
        for ($i = 0; $i < count($list); $i++) {
            //사용자 폰트 지정
            $use_font = '';
            if ($list[$i]['wr_1'] && $board['bb_use_font']) {
                $use_font = $list[$i]['wr_1'];
            }
        ?>
            <!-- grid-->
            <div class='col-sm-12 col-md-<?php echo $board_cols ?> col-lg-<?php echo $board_cols ?> mb-2'>
                <div class="board-article">
                    <?php
                    $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_mobile_gallery_width'], $board['bo_mobile_gallery_height'], false, true, 'center');

                    $lazy_load = '';
                    $layz_src = '';
                    if ($i > 8) {
                        $lazy_load = 'lazy';
                        $layz_src = 'data-';
                    }
                    if ($thumb['src']) {
                        //$img_content = '<img src="' . $thumb['src'] . '" alt="' . $thumb['alt'] . '" width="' . $board['bo_mobile_gallery_width'] . '" height="' . $board['bo_mobile_gallery_height'] . '">';
                        $img_content = "<img class='list-image {$lazy_load}' {$layz_src}src='{$thumb['src']}' alt='{$thumb['alt']}' width='{$board['bo_mobile_gallery_width']}' height='{$board['bo_mobile_gallery_height']}'>";
                    } else {
                        if($list[$i]['wr_1']){
                            $thumb['src'] = $list[$i]['wr_1'];
                        }else{
                            $thumb['src'] = G5_THEME_URL . "/img/noimage.png";
                        }
                        
                        $img_content = "<img class='list-image {$lazy_load}' {$layz_src}src='{$thumb['src']}' alt='{$thumb['alt']}' width='{$board['bo_mobile_gallery_width']}' height='{$board['bo_mobile_gallery_height']}'>";
                    }
                    ?>
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
                        <div class='position-absolute list-icons-wrap'>
                            <?php
                            if ($list[$i]['icon_new']) {
                                //새글 아이콘
                                echo "<span class='badge badge-primary'><strong class=''>N</strong></span>";
                            }
                            echo "<span class='badge badge-info'>{$list[$i]['wr_hit']}</span>";
                            if ($list[$i]['comment_cnt']) {
                                echo "<span class='badge badge-success'><i class='fa fa-comment-o' aria-hidden='true'></i> {$list[$i]['wr_comment']}</span>";
                            }
                            if (isset($list[$i]['icon_link'])) {
                                //링크 아이콘
                                echo "<span class='badge badge-secondary'><i class='fa fa-link' aria-hidden='true'></i></span>";
                            }
                            if (isset($list[$i]['icon_reply']) && $list[$i]['icon_reply']) {
                                //답글아이콘
                                echo "<span class='badge badge-secondary'><i class='fa fa-reply' aria-hidden='true'></i></span>";
                            }

                            if (isset($list[$i]['icon_secret']) && $list[$i]['icon_secret']) {
                                //비밀글 아이콘
                                echo "<span class='badge badge-secondary'><i class='fa fa-lock' aria-hidden='true'></i></span>";
                            }

                            if (isset($list[$i]['icon_file']) && $list[$i]['icon_file']) {
                                //첨부파일 아이콘
                                echo "<span class='badge badge-secondary'><i class='fa fa-file-o' aria-hidden='true'></i> {$list[$i]['file']['count']}</span>";
                            }

                            if (isset($list[$i]['icon_hot']) && $list[$i]['icon_hot']) {
                                //인기 아이콘
                                echo "<span class='badge badge-secondary'><i class='fa fa-fire' aria-hidden='true'></i></span>";
                            }

                            echo "<span class='badge badge-secondary'>{$list[$i]['datetime2']}</span>";
                            ?>
                        </div>
                        <div class='position-absolute list-good-wrap'>
                            <?php
                            if ($is_good) {
                                echo "<span class='badge badge-warning'><i class='fa fa-thumbs-o-up' aria-hidden='true'></i> {$list[$i]['wr_good']}</span>";
                            }
                            if ($is_nogood) {
                                echo "<span class='badge badge-warning'><i class='fa fa-thumbs-o-down' aria-hidden='true'></i>{$list[$i]['wr_nogood']}</span>";
                            }
                            ?>
                        </div>
                    </div>
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
                                //제목
                                if (is_mobile()) {
                                    echo cut_str($list[$i]['subject'], $board['bo_mobile_subject_len']);
                                } else {
                                    echo $list[$i]['subject'];
                                }

                                ?>
                            </a>

                        </div>
                        <div class='wr-info text-center'>
                            <?php echo $list[$i]['name'] ?></li>
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