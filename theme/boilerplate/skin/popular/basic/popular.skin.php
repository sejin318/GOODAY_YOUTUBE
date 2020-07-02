<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/popular/popular.basic.css">', 50);
?>

<!-- 인기검색어 시작 { -->
<section id="popular" class='popular-wrap'>
    <h2 class='sr-only'>인기검색어</h2>
    <!-- Swiper -->
    <div class="swiper-container popular-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="popular-list">
                    <ul class='pop-link'>
                        <?php
                        if (isset($list) && is_array($list)) {
                            for ($i = 0; $i < count($list); $i++) {
                        ?>
                                <li class="d-block mr-1"><a href="<?php echo G5_BBS_URL ?>/search.php?sfl=wr_subject&amp;sop=and&amp;stx=<?php echo urlencode($list[$i]['pp_word']) ?>" class='btn btn-xs btn-secondary'><?php echo get_text($list[$i]['pp_word']); ?></a></li>
                        <?php
                            }   //end for
                        }   //end if
                        ?>
                    </ul>
                </div>
            </div>
            <!-- Add Scroll Bar -->
            <div class="swiper-scrollbar"></div>
        </div>

    </div>
</section>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.popular-container', {
        slidesPerView: 'auto',
        freeMode: true,
        scrollbar: {
            el: '.swiper-scrollbar',
        }
    });
</script>