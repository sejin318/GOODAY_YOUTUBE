<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/faq/faq.basic.css">', 50);
?>
<div class='faq-wrap'>
    <h2 class="page-title p-2 mb-2 border-bottom border-color-6">FAQ 목록</h2>
    <!-- FAQ 시작 { -->
    <?php
    if ($himg_src) {
        echo '<div id="faq_himg" class="faq_img"><img src="' . $himg_src . '" alt=""></div>';
    }
    if ($fm['fm_head_html']) {
        // 상단 HTML
        echo '<div id="faq_hhtml" class="border border-color-6 p-2 mb-2 background-7">' . conv_content($fm['fm_head_html'], 1) . '</div>';
    }
    ?>

    <fieldset id="faq_sch" class='faq-search-wrap d-flex justify-content-center'>
        <div class='search-wrap ml-auto mr-auto'>
            <form name="faq_search_form" method="get">
                <input type="hidden" name="fm_id" value="<?php echo $fm_id; ?>">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="stx" value="<?php echo $stx; ?>" required id="stx" class="form-control">
                        <button type="submit" value="검색" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> 검색</button>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>

    <?php
    if (count($faq_master_list)) {
    ?>
        <h2 class="sr-only"><?php echo $g5['title'] ?></h2>
        <nav class='nav nav-tabs justify-content-center'>
            <?php
            foreach ($faq_master_list as $v) {
                $category_msg = '';
                $category_option = '';
                if ($v['fm_id'] == $fm_id) { // 현재 선택된 카테고리라면
                    $category_option = 'active';
                    $category_msg = '<span class="sr-only">열린 분류 </span>';
                }
            ?>
                <a href="<?php echo $category_href; ?>?fm_id=<?php echo $v['fm_id']; ?>" class='nav-link <?php echo $category_option; ?>'><?php echo $category_msg . $v['fm_subject']; ?></a>
            <?php
            }
            ?>

        </nav>
    <?php } ?>

    <div id="faq_wrap" class="faq_<?php echo $fm_id; ?>">
        <?php // FAQ 내용
        if (count($faq_list)) {
        ?>
            <section class="faq-list">
                <h2 class="sr-only"><?php echo $g5['title']; ?> 목록</h2>
                <div class='accordion' id='faq-accordion'>
                    <?php
                    $i = 0;
                    foreach ($faq_list as $key => $v) {
                        if (empty($v)) {
                            continue;
                        }
                    ?>
                        <div class='card'>
                            <div class="card-header border-bottom border-color-6" id='faq-cont<?php echo $i ?>'>
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#faq-contents<?php echo $i ?>" aria-expanded="true" aria-controls="faq-contents<?php echo $i ?>">
                                    <i class="fa fa-question-circle-o" aria-hidden="true"></i> <?php echo strip_tags($v['fa_subject']); ?>
                                </button>
                            </div>
                            <div id="faq-contents<?php echo $i ?>" class="collapse" aria-labelledby="faq-cont<?php echo $i ?>" data-parent="#faq-accordion">
                                <div class="card-body">
                                    <?php echo conv_content($v['fa_content'], 1); ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        $i++;
                    }
                    ?>
                </div>
            </section>
        <?php

        } else {
            if ($stx) {
                echo '<p class="empty_list">검색된 게시물이 없습니다.</p>';
            } else {
                echo '<div class="empty_list">등록된 FAQ가 없습니다.';
                if ($is_admin)
                    echo '<br><a href="' . G5_ADMIN_URL . '/faqmasterlist.php">FAQ를 새로 등록하시려면 FAQ관리</a> 메뉴를 이용하십시오.';
                echo '</div>';
            }
        }
        ?>
    </div>

    <?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='); ?>

    <?php
    if ($fm['fm_tail_html']) {
        // 하단 HTML
        echo '<div id="faq_thtml" class="border border-color-6 p-2 mb-2 background-7">' . conv_content($fm['fm_tail_html'], 1) . '</div>';
    }
    if ($timg_src)
        echo '<div id="faq_timg" class="faq_img"><img src="' . $timg_src . '" alt=""></div>';
    ?>


    <!-- } FAQ 끝 -->

    <?php
    if ($admin_href)
        echo '<div class="faq_admin"><a href="' . $admin_href . '" class="btn_admin btn" title="FAQ 수정"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">FAQ 수정</span></a></div>';
    ?>

    <script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
    <script>
        $(function() {
            $(".closer_btn").on("click", function() {
                $(this).closest(".con_inner").slideToggle();
            });
        });

        function faq_open(el) {
            $("h3").on("click", function() {
                $(this).addClass("faq_li_open");
            });
            var $con = $(el).closest("li").find(".con_inner");

            if ($con.is(":visible")) {
                $con.slideUp();
            } else {
                $("#faq_con .con_inner:visible").css("display", "none");

                $con.slideDown(
                    function() {
                        // 이미지 리사이즈
                        $con.viewimageresize2();
                    }
                );
            }

            return false;
        }
    </script>
</div>