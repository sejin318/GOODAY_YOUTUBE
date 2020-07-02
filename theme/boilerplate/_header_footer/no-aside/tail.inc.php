<?php

/**
 * 사이드바 없음
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
?>
</div>
<!--//.contents -->
</div>
<!--//.contents-wrap -->
</div>
<!--//.row global-->
<!-- 하단 시작 { -->



<!-- } 하단 끝 -->
</div>
<!--//.container-fluid-->
<?php
//사이트 컨테이너 전체 사용
$footer_container = "";
if ($config['bp_container'] == 'container-fluid') {
    $footer_container = $config['bp_container'];
} else {
    //사이트 박스 컨테이너에서 메뉴 컨테이너 설정
    if ($config['bp_pc_menu_container']) {
        //박스형 메뉴면 박스형 Footer
        $footer_container = $config['bp_container'];
    } else {
        //전체형 메뉴면 박스형 Footer
        $footer_container = 'container-fluid';
    }
}
?>
<footer class='tail-wrap <?php echo $footer_container ?>'>
    <div class="footer-container">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-2 tail-login-wrap">
                <?php 
//    echo bp_logo_view($config); 
                ?>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-7 tail-menu-wrap">
                <div class=''>
                    <?php echo visit('theme/basic'); ?>
                </div>
                <div class="tail-contents pt-2 border-top border-color-4">
                    <ul class="tail-item menu-1">
                        <li class=""><a href="<?php echo get_pretty_url('content', 'company'); ?>">회사소개</a></li>
                        <li class=""><a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보처리방침</a></li>
                        <li class=""><a href="<?php echo get_pretty_url('content', 'provision'); ?>">서비스이용약관</a></li>
                    </ul>
                    <ul class="tail-item menu-2">
                        <li class=""><span>대표</span> : 아무거나 브라더스 </li>
<!--                        <li class=""><span>사업자등록번호</span> : 000-00-00000 </li>-->
<!--                        <li class=""><span>통신판매업신고</span> : 제100-서울00-0000호</li>-->
                    </ul>
                    <ul class="tail-item menu-3">
                        <li class=""><span>주소</span> : (000-000) 경상북도 상주시 사벌국면 퇴강물미길 22</li>
<!--                        <li class=""><span>대표전화</span> : 02-000-1234 </li>-->
<!--                        <li class=""><span>개인정보책임자</span> : 책임자 (mail@email.com)</li>-->
                    </ul>
                    <div class='pt-2 mb-4 copyright'>
                        Copyright © <strong><?php echo $_SERVER['HTTP_HOST'] ?></strong> All rights reserved.
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-3">
                <ul class="social-bookmark">
                    <li class="">
                        <a href="https://twitter.com/?lang=ko" target="_blank" class="icon-twitter"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
                    </li>
                    <li class="">
                        <a href="https://www.facebook.com/" target="_blank" class="icon-facebook"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
                    </li>
                    <li class="">
                        <a href="https://plus.google.com/" target="_blank" class="icon-google"><i class="fa fa-google-plus-official fa-2x" aria-hidden="true"></i></a>
                    </li>
                    <li class="">
                        <a href="https://www.youtube.com/?hl=ko&amp;gl=KR" target="_blank" class="icon-youtube"><i class="fa fa-youtube fa-2x" aria-hidden="true"></i></a>
                    </li>
                    <li class="">
                        <a href="https://section.blog.naver.com/BlogHome.nhn" target="_blank" class="icon-blog"><i class="fa fa-rss fa-2x" aria-hidden="true"></i></a>
                    </li>
                    <li class="">
                        <a href="#mail" class="icon-contactus"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>


<?php
if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>
<div id="gotop">
    <a href="#top"><i class="fa fa-arrow-up"></i></a>
</div>
<?php
include_once G5_THEME_PATH . "/tail.sub.php";
