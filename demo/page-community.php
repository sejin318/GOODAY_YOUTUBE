<?php
include_once "./_common.php";

/**
 * DEMO Page
 * 커뮤니티형 페이지
 */
$g5['title'] = "커뮤니티 데모";
//데모용 커뮤니티용 메뉴 강제 선택
$config['bp_pc_menu'] = 'community';

include_once(G5_THEME_PATH . '/head.php');
?>
<section class='community-slider-wrap'>
    <?php
    ################################################################################################
    # 슬라이더 등록 안내
    ################################################################################################
    # 테마관리자->슬라이더
    # 슬라이더 이름을 "커뮤니티메인슬라이더" 로 생성하면 이 페이지 상단에 슬라이더가 등록됩니다.
    ################################################################################################
    run_event('커뮤니티메인슬라이더', '커뮤니티메인슬라이더');
    ?>
</section>
<section class='latest-list row mb-4'>
    <div class='col-sm-12 col-md-4'>
        <?php echo latest('theme/basic-simple', 'demo_board', 5, 33); ?>
    </div>
    <div class='col-sm-12 col-md-4'>
        <?php echo latest('theme/basic-simple', 'demo_board', 5, 33); ?>
    </div>
    <div class='col-sm-12 col-md-4'>
        <?php echo latest('theme/basic-simple', 'demo_board', 5, 33); ?>
    </div>
</section>
<!--  갤러리 -->
<section class='latest-list row mb-4'>
    <div class='col-sm-12 col-md-12'>
        <div class="sample-wrap atest-no-writer">
            <?php echo latest('theme/gallery', 'demo_gallery', 6, 30); ?>
        </div>
    </div>
</section>
<section class='latest-list row'>
    <div class='col-sm-12 col-md-6'>
        <div class='tab-skin-wrap latst-no-title'>
            <?php echo bp_tab_latest('theme/basic-simple', 'demo_board,demo_webzine,demo_card', 5, 33); ?>
        </div>
    </div>
    <div class='col-sm-12 col-md-6'>
        <div class='tab-skin-wrap latst-no-title latest-simple'>
            <?php echo bp_tab_latest('theme/basic-simple', 'demo_gallery,gnuboard,etc,qna', 5, 33); ?>
        </div>
    </div>
</section>

<?php
include_once(G5_THEME_PATH . '/tail.php');
