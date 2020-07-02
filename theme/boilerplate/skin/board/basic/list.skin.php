<?php

/**
 * Boilerplate.kr
 * Basic 게시판 목록
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
//board uploader 환경설정
include_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'config.inc.php';
include_once G5_LIB_PATH . '/thumbnail.lib.php';

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/boards/board.basic.css">', 30);
if ($board['bb_use_font']) {
    add_stylesheet('<link href="https://fonts.googleapis.com/css?family=Black+And+White+Picture|Black+Han+Sans|Cute+Font|Do+Hyeon|Dokdo|East+Sea+Dokdo|Gaegu|Gamja+Flower|Gugi|Hi+Melody|Jua|Kirang+Haerang|Nanum+Gothic|Nanum+Myeongjo|Nanum+Pen+Script|Noto+Sans+KR:400,700|Poor+Story|Single+Day|Song+Myung|Stylish|Sunflower:300|Yeon+Sung&display=swap&subset=korean" rel="stylesheet">', 200);
}
?>
<?php run_event('게시판목록상단', '게시판목록상단'); ?>
<div class='board-basic-list'>
    <h2 class="board-title p-2 mb-3">
        <?php echo $board['bo_subject'] ?>
        <span class='board-count-info'>
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </span>
    </h2>

    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
        <!-- 테블릿 이상 출력 -->
        <div class='list-category-wrap d-none d-md-block'>
            <nav class="board-category" aria-label='breadcrumb'>
                <ul class='breadcrumb'>
                    <?php echo str_replace('<li', '<li class="breadcrumb-item"', $category_option) ?>
                </ul>
            </nav>
        </div>
    <?php } ?>
    <!-- } 게시판 카테고리 끝 -->
    <form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">

        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <input type="hidden" name="sw" value="">
        <!-- 게시판 페이지 정보 및 버튼 시작 { -->
        <div class='board-buttons  d-flex mb-2'>
            <div class='btn-group d-none d-md-flex btn-group-sm' role="group" aria-label="Board Buttons">
                <?php if ($is_admin == 'super' || $is_auth) {  ?>
                    <?php if ($is_checkbox) { ?>
                        <button type='button' class='btn btn-info mr-1'><label for="chkall" class="all-check m-0 p-0"><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk m-0 p-0">전체선택</label></button>
                        <button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class='btn btn-danger mr-1'><i class="fa fa-trash-o" aria-hidden="true"></i><span class='sr-only'> 선택삭제</span></button>
                        <button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class='btn btn-info mr-1'><i class="fa fa-files-o" aria-hidden="true"></i><span class='sr-only'> 선택복사</span></button>
                        <button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class='btn btn-info mr-1'><i class="fa fa-arrows" aria-hidden="true"></i><span class='sr-only'> 선택이동</span></button>
                    <?php } ?>
                <?php }  ?>
                <?php if ($admin_href) { ?>
                    <a href="<?php echo $admin_href ?>" class="btn btn-danger mr-1" title="관리자"><i class="fa fa-cog"></i><span class='hide-sm'> 관리자</span></a>
                    <a href="<?php echo G5_ADMIN_URL ?>/boilerplate/bp_board.php?w=u&bo_table=<?php echo $bo_table ?>" class="btn btn-warning mr-1" title="게시판확장관리자"><i class="fa fa-cogs"></i><span class='hide-sm'> 설정</span></a>
                <?php } ?>
            </div>
            <!-- 모바일용 버튼 -->
            <div class='btn-group d-sm-flex d-md-none btn-group-sm' role="group" aria-label="Board Buttons">
                <!-- 모바일용 -->
                <div class='list-category-wrap d-sm-block d-md-none'>
                    <div class="dropdown">
                        <button type="button" id='list-category' class="btn btn-secondary btn-sm dropdown-toggle mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            분류
                        </button>
                        <div class="board-category">
                            <ul class='dropdown-menu' aria-labelledby='list-category'>
                                <?php echo str_replace('<li', '<li class="dropdown-item"', $category_option) ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if ($is_admin == 'super' || $is_auth) {  ?>

                    <div class="dropdown">
                        <button id="mobile-adm-menu" type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            관리
                        </button>
                        <div class="dropdown-menu" aria-labelledby="mobile-adm-menu">
                            <?php if ($is_checkbox) { ?>
                                <button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class='dropdown-item'><i class="fa fa-trash-o" aria-hidden="true"></i><span class=''> 선택삭제</span></button>
                                <button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class='dropdown-item'><i class="fa fa-files-o" aria-hidden="true"></i><span class=''> 선택복사</span></button>
                                <button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class='dropdown-item'><i class="fa fa-arrows" aria-hidden="true"></i><span class=''> 선택이동</span></button>
                            <?php } ?>
                            <?php if ($admin_href) { ?>
                                <a href="<?php echo $admin_href ?>" class="dropdown-item" title="관리자"><i class="fa fa-cog"></i><span class='='> 관리자</span></a>
                                <a href="<?php echo G5_ADMIN_URL ?>/boilerplate/bp_board.php?w=u&bo_table=<?php echo $bo_table ?>" class="dropdown-item" title="게시판확장관리자"><i class="fa fa-cogs"></i><span class='='> 설정</span></a>
                            <?php } ?>
                        </div>
                    </div>
                <?php }  ?>

            </div>

            <div class='ml-auto btn-group btn-group-sm' role="group" aria-label="Board Buttons">
                <?php echo bp_board_favorite($bo_table) ?>
                <?php if ($rss_href) { ?>
                    <a href="<?php echo $rss_href ?>" class="btn btn-secondary mr-1" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class='hide-sm'> RSS</span></a>
                <?php } ?>
                <?php if ($write_href) { ?>
                    <a href="<?php echo $write_href ?>" class="btn btn-primary" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span> <span class='hide-sm-nouse'> 글쓰기</span></span></a>
                <?php } ?>
            </div>
        </div>
        <!-- } 게시판 페이지 정보 및 버튼 끝 -->

        <?php
        /**
         * 목록 스킨
         */
        $list_path = $board_skin_path . DIRECTORY_SEPARATOR . $board['bb_list_skin'];
        if (file_exists($list_path)) {
            include_once $list_path;
        } else {
            echo "<div class='alert alert-danger'> <i class='fa fa-info-circle' aria-hidden='true'></i> 목록 스킨을 설정하세요. 기본 목록스킨이 로딩되었습니다.</div>";
            include_once $board_skin_path . DIRECTORY_SEPARATOR . '_list.text.inc.php';
        }
        ?>
    </form>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
        <div class='bottom-button clearfix mb-3'>
            <div class="button-group pull-right">
                <?php if ($write_href) { ?>
                    <a href="<?php echo $write_href ?>" class="btn btn-primary" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <div class='paging mb-3 pt-3 pb-3'>
        <!-- 페이지 -->
        <?php
        //반응형은 is_mobile() 함수로 모바일 체크해야 한다.
        echo get_paging(is_mobile() ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, get_pretty_url($bo_table, '', $qstr . '&amp;page='));
        ?>
        <!-- 페이지 -->
    </div>


    <!-- 게시판 검색 시작 { -->
    <div class="board-search-wrap">
        <fieldset class="bo_sch">
            <h3 class='sr-only'>검색</h3>
            <form name="fsearch" method="get">
                <div class="input-group mb-3">
                    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                    <input type="hidden" name="sca" value="<?php echo $sca ?>">
                    <input type="hidden" name="sop" value="and">
                    <label for="sfl" class="sr-only">검색대상</label>
                    <div class="input-group-prepend">
                        <select name="sfl" id="sfl" class='form-control'>
                            <?php echo get_board_sfl_select_options($sfl); ?>
                        </select>
                    </div>
                    <label for="stx" class="sr-only">검색어<strong class="sr-only"> 필수</strong></label>
                    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="form-control" size="25" maxlength="20" placeholder=" 검색어 입력">
                    <div class="input-group-append">
                        <button type="submit" value="검색" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>
    <script>
        jQuery(function($) {
            // 게시판 검색
            $(".btn_bo_sch").on("click", function() {
                $(".bo_sch_wrap").toggle();
            })
            $('.bo_sch_bg, .bo_sch_cls').click(function() {
                $('.bo_sch_wrap').hide();
            });
        });
    </script>
    <!-- } 게시판 검색 끝 -->

    <?php if ($is_checkbox) { ?>
        <noscript>
            <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
        </noscript>
    <?php } ?>

    <?php if ($is_checkbox) { ?>
        <script>
            function all_checked(sw) {
                var f = document.fboardlist;

                for (var i = 0; i < f.length; i++) {
                    if (f.elements[i].name == "chk_wr_id[]")
                        f.elements[i].checked = sw;
                }
            }

            function fboardlist_submit(f) {
                var chk_count = 0;

                for (var i = 0; i < f.length; i++) {
                    if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
                        chk_count++;
                }

                if (!chk_count) {
                    alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
                    return false;
                }

                if (document.pressed == "선택복사") {
                    select_copy("copy");
                    return;
                }

                if (document.pressed == "선택이동") {
                    select_copy("move");
                    return;
                }

                if (document.pressed == "선택삭제") {
                    if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
                        return false;

                    f.removeAttribute("target");
                    f.action = g5_bbs_url + "/board_list_update.php";
                }

                return true;
            }

            // 선택한 게시물 복사 및 이동
            function select_copy(sw) {
                var f = document.fboardlist;

                if (sw == "copy")
                    str = "복사";
                else
                    str = "이동";

                var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

                f.sw.value = sw;
                f.target = "move";
                f.action = g5_bbs_url + "/move.php";
                f.submit();
            }

            // 게시판 리스트 관리자 옵션
            jQuery(function($) {
                $(".btn_more_opt.is_list_btn").on("click", function(e) {
                    e.stopPropagation();
                    $(".more_opt.is_list_btn").toggle();
                });
                $(document).on("click", function(e) {
                    if (!$(e.target).closest('.is_list_btn').length) {
                        $(".more_opt.is_list_btn").hide();
                    }
                });
            });
        </script>
    <?php } ?>
    <!-- } 게시판 목록 끝 -->
</div><!-- //.board-basic-wrap-->
<?php run_event('게시판목록하단', '게시판목록하단'); ?>