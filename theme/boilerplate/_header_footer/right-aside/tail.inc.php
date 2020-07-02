<?php

/**
 * 오른쪽 사이드바용 Tail
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
?>
</div>
<!--//.contents -->
</div>
<!--//.col-sm-12 col-md-4 col-lg-3 aside wrapper-->

<div class='col-12 col-sm-12 col-md-12 col-lg-3 side-wrap d-none side-wrap right-aside-wrap d-lg-flex'>
    <div class="aside w-100">
        <!-- 아웃로그인 -->
        <div class='widget-wrap'>
            <?php echo outlogin('theme/basic'); ?>
        </div>
        <!-- 검색 -->
        <div class='search-wrap widget-wrap'>
            <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
                <input type="hidden" name="sfl" value="wr_subject||wr_content">
                <input type="hidden" name="sop" value="and">
                <label for="sch_stx" class="sr-only">검색어 필수</label>
                <div class=' input-group'>
                    <input type="text" name="stx" id="sch_stx" class="form-control" maxlength="20" placeholder="검색어를 입력해주세요">
                    <button type="submit" id="sch_submit" value="검색" class='btn btn-secondary'><i class="fa fa-search" aria-hidden="true"></i><span class="sr-only">검색</span></button>
                </div>
            </form>

            <script>
                function fsearchbox_submit(f) {
                    if (f.stx.value.length < 2) {
                        alert("검색어는 두글자 이상 입력하십시오.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                    var cnt = 0;
                    for (var i = 0; i < f.stx.value.length; i++) {
                        if (f.stx.value.charAt(i) == ' ')
                            cnt++;
                    }

                    if (cnt > 1) {
                        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    return true;
                }
            </script>
            <?php echo popular('theme/basic'); ?>
        </div>
        <div class='widget-wrap side-menu-wrap'>
            <div class="accordion" id="accordionMenu">
                <div class="card">
                    <div class='card-header'>
                        <h5 class="card-title m-0">MENU</h5>
                    </div>
                    <!-- 사이드 메뉴 -->
                    <ul id="main-menu" class='list-group list-group-flush'>
                        <?php
                        ob_start();
                        $menu_datas = get_menu_db(0, true);
                        $gnb_zindex = 999; // gnb_1dli z-index 값 설정용

                        for ($i = 0; $row = sql_fetch_array($result); $i++) {
                            $menu_datas[$i] = $row;

                            $sql2 = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4' and substring(me_code, 1, 2) = '{$row['me_code']}' order by me_order, me_id ";
                            $result2 = sql_query($sql2);
                            for ($k = 0; $row2 = sql_fetch_array($result2); $k++) {
                                $menu_datas[$i]['sub'][$k] = $row2;
                            }
                        }

                        $i = 0;
                        foreach ($menu_datas as $row) {
                            if (empty($row)) {
                                continue;
                            }
                            $add_class = (isset($row['sub']) && $row['sub']) ? 'sub-menu-wrap' : '';
                            //1단계 메뉴
                            echo "<li class='list-group-item {$add_class} heading{$i}'>";
                            echo "<a href='{$row['me_link']}' target='_{$row['me_target']}' class='nav-first-node'>{$row['me_name']}</a>";
                            if ($row['sub']) {
                                echo '<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '"></button>';
                            } else {;
                            }
                            $k = 0;
                            foreach ((array) $row['sub'] as $row2) {
                                if (empty($row2)) {
                                    continue;
                                }
                                if ($k == 0) {
                                    echo '<span class="sr-only">하위분류</span> <div id="collapse' . $i . '" class="collapse" aria-labelledby="heading' . $i . '" data-parent="#accordionMenu"><ul class="sub-menu-list">' . PHP_EOL;
                                }
                                echo "<li class='sub-link'><a href='{$row2['me_link']}' target='_{$row2['me_target']}' class=''>{$row2['me_name']}</a></li>";
                                $k++;
                            }   //end foreach $row2

                            if ($k > 0) {
                                echo '</ul> </div>' . PHP_EOL;
                            }
                            echo "</li><!--//.nav-link-->" . PHP_EOL;

                            $i++;
                        }   //end foreach $row
                        ?>

                        <?php
                        $main_menu = trim(ob_get_contents());
                        ob_end_clean();
                        if ($main_menu) {
                            echo $main_menu;
                        } else {
                            echo "<li class='text-center'>";
                            echo "<h3 class='title'>메뉴준비중</h3>";
                            if ($is_admin) {
                                echo "<a href='" . G5_ADMIN_URL . "/menu_list.php' class='btn btn-secondary btn-sm'>메뉴 설정</a>";
                            }
                            echo "</li>";
                        }
                        ?>
                    </ul>
                </div>

            </div>
        </div>
        <?php run_event('사이드하단배너', '사이드하단배너'); ?>
        <div class='widget-wrap'>
            <!-- 투표 -->
            <?php echo poll('theme/basic') ?>
        </div>
    </div>

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
                <?php echo bp_logo_view($config); ?>
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
                        <li class=""><span>대표</span> : Boilerplate </li>
                        <li class=""><span>사업자등록번호</span> : 000-00-00000 </li>
                        <li class=""><span>통신판매업신고</span> : 제100-서울00-0000호</li>
                    </ul>
                    <ul class="tail-item menu-3">
                        <li class=""><span>주소</span> : (000-000) 서울 강남구 ㅇㅇ동</li>
                        <li class=""><span>대표전화</span> : 02-000-1234 </li>
                        <li class=""><span>개인정보책임자</span> : 책임자 (mail@email.com)</li>
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
