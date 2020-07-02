<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

// Hero 사용여부 체크
if ((defined('BP_USE_HERO') && BP_USE_HERO == false) || !defined('BP_USE_HERO')) {
    return;
}

//스타일
add_stylesheet('<link rel="stylesheet" href="' . G5_THEME_URL . DIRECTORY_SEPARATOR . '/_hero/hero_default.css">', 22);

//사이트 컨테이너 전체 사용
$hero_container = "";
if ($config['bp_container'] == 'container-fluid') {
    $hero_container = $config['bp_container'];
} else {
    //사이트 박스 컨테이너에서 메뉴 컨테이너 설정
    if ($config['bp_pc_menu_container']) {
        $hero_container = $config['bp_container'];
    }
}

/******************************************************************
 * 히어로 이미지 및 텍스트 설정
 * 아래 예제를 참고하세요.
 ******************************************************************/
$_hero = array();
##############################
# 기본값 설정
##############################
//기본 배경이미지
$_hero['hero_image'] = "/images/hero/trees-park.jpg";
//타이틀
$_hero['title'] = $g5['title'];
//설명문
$_hero['lead_text'] = "";

##############################
# 인덱스페이지 설정
##############################
if (defined('_INDEX_') && _INDEX_ == true) {
    $_hero['title'] = "GB Boilerplate Theme";
    $_hero['lead_text'] = "HTML5, CSS3, Bootstrap 4 기반의 다기능 테마! 이것은 테마인가 빌더인가?<br /> 원본 수정없이 다양한 기능을 구현한 Boilerplate Theme를 무료로 사용하세요.";
    $_hero['subpage'] = '';
    $_hero['scale_class'] = 'height-scale-down';
} else {
    //하위페이지 높이 줄이기용, 하위페이지도 높이 조절 하지 않으려면  주석처리 또는 삭제.
    $_hero['subpage'] = 'sub-page-hero';
    $_hero['scale_class'] = 'height-scale-down-subpage';
}

##############################
# 게시판일 경우
##############################
if ($bo_table) {
    $_hero['title'] = $board['bo_subject'];
    $_hero['lead_text'] = "";
    //게시판 기본 배경 지정
    $_hero['hero_image'] = '/images/hero/board-board.jpg';

    //본문읽기
    if ($wr_id) {
        //게시물 제목 가져오기
        echo "<script>$(function(){
            var subjectText = $('.bv-subject').text();
            $('.lead-text').text(subjectText);
        });</script>";
    }
}

##############################
# 그룹페이지 경우
##############################
if ($gr_id && !$bo_table) {
    $_hero['title'] = $group['gr_subject'];
    $_hero['lead_text'] = "";
    //그룹 기본 배경이미지
    $_hero['hero_image'] = "/images/hero/forest.jpg";

    //pds 그룹일 경우
    if ($gr_id == 'pds') {
        //제목 직접 입력
        $_hero['title'] = '자료실';
        $_hero['hero_image'] = "/images/hero/beautiful-calm-clouds-dark.jpg";
    }
    if ($gr_id == 'lecture') {
        //lecture 그룹
        $_hero['hero_image'] = '/images/hero/board-photo.jpg';
    }
}

############################################
# 게시판 또는 그룹별 배경이미지 다르게 하기
############################################
if ($bo_table == 'cssbootstrap') {
    // 게시판
    $_hero['hero_image'] = '/images/hero/board-css.jpg';
}
if ($bo_table == 'qna') {
    // 게시판
    $_hero['hero_image'] = '/images/hero/board-qna.jpg';
}
if ($bo_table == 'youtube') {
    // 게시판
    $_hero['hero_image'] = '/images/hero/board-youtube.jpg';
}
if ($bo_table == 'gallery') {
    // 게시판
    $_hero['hero_image'] = '/images/hero/board-photo.jpg';
}


##########################################################
# 일반페이지
# 현재페이지는 echo $_SERVER['PHP_SELF']; 로 확인하세요.
# https://boilerplate.kr/demo/latest.php
##########################################################
if (stristr($_SERVER['PHP_SELF'], 'latest.php')) {
    //URL 중에 latest.php파일이 있다면 처리
    $_hero['hero_image'] = '/images/hero/mist-misty-fog-foggy.jpg';
    //설명글 넣고싶다면 아래 변수 이용
    $_hero['lead_text'] = '최신글 예제를 확인하세요.';
}
//1:1문의
if (stristr($_SERVER['PHP_SELF'], 'qalist.php')) {
    //URL 중에 qalist.php파일이 있다면 처리
    $_hero['hero_image'] = '/images/hero/board-qna.jpg';
    //설명글 넣고싶다면 아래 변수 이용
    $_hero['lead_text'] = '';
}
//Mypage
if (
    stristr($_SERVER['PHP_SELF'], 'mypage') ||
    stristr($_SERVER['PHP_SELF'], 'memo.php') ||
    stristr($_SERVER['PHP_SELF'], 'memo_form.php') ||
    stristr($_SERVER['PHP_SELF'], 'scrap.php')
) {
    //URL 중에 mypage 및 meme, memo 쓰기, 스크랩 페이지가 있다면 처리
    $_hero['hero_image'] = '/images/hero/mykeyboard.jpg';
    //설명글 넣고싶다면 아래 변수 이용
    $_hero['lead_text'] = '';
}

####################################################################
# 랜덤배경
# https://boilerplate.kr/images/hero/폴더 아래 이미지 랜덤 로딩
####################################################################
if (stristr($_SERVER['PHP_SELF'], 'gallery.php')) {
    /**
     * 갤러리 최신글 데모 페이지에 적용
     * 그누보드/images/hero/ jpg 파일 불러옴
     */
    //이미지 읽어오기
    $files = glob(G5_PATH . '/images/hero/*.jpg');
    if (is_array($files)) {
        $tmp_hero_image = array();
        //이미지 파일명 배열 생성
        foreach ((array) $files as $k => $hero_image) {
            $img = pathinfo($hero_image);
            $tmp_hero_image[] = $img['basename'];
        }
        //배열 섞기
        shuffle($tmp_hero_image);
    }
    //첫번째 배열에 있는 이미지 넣기
    $_hero['hero_image'] = '/images/hero/' . $tmp_hero_image[0];
}
?>
<!-- Hero Header -->
<div class='<?php echo $hero_container ?> hero-header-wrap'>
    <section class='top-hero-section <?php echo $_hero['subpage'] ?> background-zoom'>
        <div class='hero-wrap container'>
            <h1 class='hero-title'><?php echo $_hero['title'] ?></h1>
            <p class='lead-text delay-1'>
                <?php echo $_hero['lead_text'] ?>
            </p>
        </div>
    </section>
</div>
<style>
    .top-hero-section::before {
        /* 배경이미지 */
        background-image: url(<?php echo $_hero['hero_image'] ?>);
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;

    }
</style>
<script>
    var menuTrigger = 80;
    var controller = new ScrollMagic.Controller();
    new ScrollMagic.Scene({
        offset: menuTrigger
    }).setClassToggle(".menu-container", "opacity-1").addTo(controller);

    new ScrollMagic.Scene({
        offset: menuTrigger - 10
    }).setClassToggle(".shadow-bottom", "shadow-bottom-image").addTo(controller);

    new ScrollMagic.Scene({
        offset: 120
    }).setClassToggle(".top-hero-section", "<?php echo $_hero['scale_class'] ?>").addTo(controller);
</script>
<!--//Hero Header -->
