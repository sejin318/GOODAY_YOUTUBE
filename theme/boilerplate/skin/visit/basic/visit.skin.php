<?php
if (!defined("_GNUBOARD_")) {
    exit; // 개별 페이지 접근 불가
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/visit/visit.basic.css">', 50);
?>

<!-- 접속자집계 시작 { -->
<section id="visit" class="visit-wrap">
    <h2 class="sr-only">접속자집계</h2>
    <nav aria-labelledby="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">오늘 <?php echo number_format($visit[1]) ?></li>
            <li class="breadcrumb-item">어제 <?php echo number_format($visit[2]) ?></li>
            <li class="breadcrumb-item">최대 <?php echo number_format($visit[3]) ?></li>
            <li class="breadcrumb-item">전체 <?php echo number_format($visit[4]) ?></li>
        </ol>
    </nav>
</section>
<!-- } 접속자집계 끝 -->