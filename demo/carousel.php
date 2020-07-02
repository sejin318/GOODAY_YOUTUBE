<?php
include_once "./_common.php";

/**
 * DEMO Page
 */
$g5['title'] = "PAGES - Cards";
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/css/bp_pages.css">', 200);
add_javascript("<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js'></script>", 110);
include_once(G5_THEME_PATH . '/head.php');
?>
<div class="jumbotron p-4">
    <h1 class="display-5">Carousel</h1>
    <p class="lead">Carousel 컴포넌트 데모</p>
    <hr class="my-4">
    <p>콘텐츠 슬라이더입니다. 이미지, 텍스트, 사용자 정의 마크업과 함께 동작합니다. </p>
</div>
<!-- Alert -->
<section class='contents-section'>

    <div class='contents-section-body'>
        <h3 class='body-title'>기본</h3>
        <?php ob_start(); ?>
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/slide1.jpg" class="d-block w-100" alt='slide image'>
                </div>
                <div class="carousel-item">
                    <img src="/images/slide2.jpg" class="d-block w-100" alt='slide image'>
                </div>
                <div class="carousel-item">
                    <img src="/images/slide3.jpg" class="d-block w-100" alt='slide image'>
                </div>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap1', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>With controls</h3>
        <?php ob_start(); ?>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/slide1.jpg" class="d-block w-100" alt='slide image'>
                </div>
                <div class="carousel-item">
                    <img src="/images/slide2.jpg" class="d-block w-100" alt='slide image'>
                </div>
                <div class="carousel-item">
                    <img src="/images/slide3.jpg" class="d-block w-100" alt='slide image'>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap2', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>With indicators</h3>
        <?php ob_start(); ?>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/slide1.jpg" class="d-block w-100" alt='slide image'>
                </div>
                <div class="carousel-item">
                    <img src="/images/slide2.jpg" class="d-block w-100" alt='slide image'>
                </div>
                <div class="carousel-item">
                    <img src="/images/slide3.jpg" class="d-block w-100" alt='slide image'>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap3', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>With captions</h3>
        <?php ob_start(); ?>
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/slide1.jpg" class="d-block w-100" alt='slide image'>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First slide label</h5>
                        <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/images/slide3.jpg" class="d-block w-100" alt='slide image'>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/images/slide3.jpg" class="d-block w-100" alt='slide image'>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap4', $code_views);
        ?>

    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Crossfade</h3>
        <?php ob_start(); ?>
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/slide1.jpg" class="d-block w-100" alt='slide image'>
                </div>
                <div class="carousel-item">
                    <img src="/images/slide2.jpg" class="d-block w-100" alt='slide image'>
                </div>
                <div class="carousel-item">
                    <img src="/images/slide3.jpg" class="d-block w-100" alt='slide image'>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap5', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>개별 지연시간 사용</h3>
        <?php ob_start(); ?>
        <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-interval="5000">
                    <img src="/images/slide1.jpg" class="d-block w-100" alt='slide image'>
                </div>
                <div class="carousel-item" data-interval="2000">
                    <img src="/images/slide2.jpg" class="d-block w-100" alt='slide image'>
                </div>
                <div class="carousel-item" data-interval="3000">
                    <img src="/images/slide3.jpg" class="d-block w-100" alt='slide image'>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap6', $code_views);
        ?>
    </div>
</section>
<div class="divider primary"><em></em></div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
