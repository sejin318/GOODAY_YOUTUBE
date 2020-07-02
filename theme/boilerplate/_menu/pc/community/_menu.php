<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * community
 * PC 커뮤니티형 메뉴
 * 함수로 로딩되기 떄문에 외부 변수 사용시 상단에 global로 선언하세요.
 */
//HERO 미사용
define("BP_USE_HERO", false);
//global $var;
add_stylesheet('<link rel="stylesheet" href="' . BP_PC_MENU_URL . DIRECTORY_SEPARATOR . 'community' . '/menu.css">', 20);
?>
<!--
    navbar-expand-* 클래스로 네비바 모바일 모드의 breakpoint 를 설정할 수 있습니다.
    navbar-expand-lg, navbar-expand-md, navbar-expand-sm
-->
<div class='community-pc-menu-wrap header sticky <?php echo $config['bp_pc_menu_container'] == false ? "shadow" : ""; ?> ' id='my-header'>
    <?php
    //박스형 메뉴
    if ($config['bp_pc_menu_container']) {
        echo "<div class='{$config['bp_container']} menu-container'>";
    }
    ?>
    <nav class="nav-wrap d-flex navbar navbar-expand-lg mobile-bg-<?php echo $config['bp_pc_menu_color'] ?>">
        <!-- 모바일용 왼쪽 메뉴 버튼 -->
        <a class="navbar-toggler" data-offcanvas-trigger="left-side-menu" href="#left-side-menu">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </a>
        <div class='d-lg-none'>
            <!--Mobile LOGO -->
            <?php echo bp_logo_view($config); ?>
        </div>

        <!-- 모바일용 오른쪽 메뉴 버튼 -->
        <a class="navbar-toggler" data-offcanvas-trigger="right-side-menu" href="#right-side-menu">
            <i class="fa fa-user" aria-hidden="true"></i>
        </a>
        <div class='menu-flex-wrap flex-column d-none d-lg-flex w-100'>
            <div class="top-quick-menu-wrap d-flex justify-content-end">
                <ul class="top-quick-menu navbar-nav mt-lg-0">
                    <li class="nav-item">
                        <a href="/" class="nav-link"><i class="fa fa-home" aria-hidden="true"></i> 홈</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo G5_BBS_URL ?>/new.php" class="nav-link"><i class="fa fa-file-o" aria-hidden="true"></i> 새글</a>
                    </li>
                    <?php if ($is_member) { ?>

                        <li class="nav-item">
                            <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" class="nav-link"><i class="fa fa-user-secret" aria-hidden="true"></i> 정보수정</a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo G5_BBS_URL ?>/logout.php" class="nav-link"> <i class="fa fa-sign-out" aria-hidden="true"></i> 로그아웃</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo G5_URL ?>/_mypage/" class="nav-link"><i class="fa fa-user" aria-hidden="true"></i> 마이페이지</a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo G5_BBS_URL ?>/scrap.php" class="nav-link"><i class="fa fa-bookmark-o" aria-hidden="true"></i> <span class='sr-only'>스크랩</span></a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo G5_BBS_URL ?>/memo.php" class="nav-link"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span class='sr-only'>쪽지</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo G5_BBS_URL ?>/point.php"><i class="fa fa-money"></i> <span class='sr-only'><?php echo $member['mb_point'] ?></span></a>
                        </li>

                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="<?php echo G5_BBS_URL ?>/register.php" class="nav-link"> <i class="fa fa-user-plus" aria-hidden="true"></i> 회원가입</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo G5_BBS_URL ?>/login.php" class="nav-link"><i class="fa fa-sign-in" aria-hidden="true"></i> 로그인</a>
                        </li>
                    <?php } ?>
                    <?php if ($is_admin) { ?>
                        <li class="nav-item">
                            <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>" class="nav-link"> <i class="fa fa-cogs" aria-hidden="true"></i></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!--로고, 검색, 인기검색어 -->
            <div class="pc-logo-wrap row justify-content-center no-gutters">
                <div class='col-lg-3 d-flex justify-content-end'>
                    <!-- 배너 등록 : 배너관리자에서 배너위치를 아래와 같이 설정하면 출력됩니다. 반응형 이미지 배너입니다. PC화면만 출력 -->
                    <div class='img-responsive'>
                        <?php run_event('커뮤니티메인좌측배너', '커뮤니티메인좌측배너'); ?>
                    </div>
                </div>
                <div class='col-lg-6'>
                    <!--PC LOGO -->
                    <div class='pc-logo justify-content-center d-flex align-content-center'>
                        <?php echo bp_logo_view($config); ?>
                    </div>
                    <div class="search-widget-wrap ml-auto mr-auto">
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
                </div>
                <div class='col-lg-3 d-flex justify-content-start'>
                    <!-- 배너 등록 : 배너관리자에서 배너위치를 아래와 같이 설정하면 출력됩니다. 반응형 이미지 배너입니다. PC화면만 출력 -->
                    <div class='img-responsive'>
                        <?php run_event('커뮤니티메인우측배너', '커뮤니티메인우측배너'); ?>
                    </div>
                </div>
            </div>

            <div class='pc-menu-wrap d-flex bg-<?php echo $config['bp_pc_menu_color'] ?>'>
                <!-- 메인메뉴 -->
                <div class="community-main-menu collapse navbar-collapse flex-row justify-content-center">
                    <div class='main-menu hover-drop-menu d-flex flex-row '>
                        <?php
                        $menu_datas = get_menu_db(0, true);
                        $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                        $i = 0;
                        foreach ($menu_datas as $row) {
                            if (empty($row)) {
                                continue;
                            }
                            //Sub check
                            $add_class = (isset($row['sub']) && $row['sub']) ? 'sub-item-wrap' : '';
                            // $add_class = (!isset($row['sub']) && !$row['sub']) ? 'nosub-item-wrap' : '';
                            echo "<div class='main-menu-list {$add_class}'>";
                            echo "<a href='{$row['me_link']}' target='_{$row['me_target']}' class='main-menu-link'>{$row['me_name']}</a>";
                            $k = 0;
                            foreach ((array) $row['sub'] as $row2) {
                                if (empty($row2)) {
                                    continue;
                                }

                                //서브메뉴
                                if ($k == 0) {
                                    echo '<div class="submenu-wrap shadow"><span class="sr-only">하위분류</span>' . PHP_EOL;
                                }
                                echo "<a href='{$row2['me_link']}' target='_{$row2['me_target']}' class='sub-menu-link'>{$row2['me_name']}</a>";
                                // echo "<script>console.log('Debug Objects: " . $row2['me_link']. $row2['me_target'] . "' );</script>";
//                                echo $row2; 
                                $k++;
                            }   //end foreach $row2

                            if ($k > 0) {
                                echo '</div><!--//.dropdown-menu-->' . PHP_EOL;
                            }
                            echo "</div><!--//.main-menu-list-->";
                            $i++;
                        }   //end foreach $row

                        if ($i == 0) {  ?>
                            <div class="empty-navigation">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></div>
                        <?php } ?>
                        <!--//.main-menu -->
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <?php if ($_head_file == true && is_ie11() == false) { ?>
        <script>
            //	Create the sticky header.1
            new Mhead('.header.sticky', {
                scroll: {
                    hide: 150
                },
                hooks: {
                    'scrolledIn': function() {
                        console.log('scrolledIn');
                    },
                    'scrolledOut': function() {
                        console.log('scrolledOut');
                    }
                }
            });
        </script>
    <?php } ?>
    <?php
    //박스형 메뉴
    if ($config['bp_pc_menu_container']) {
        echo "</div>";
    }
    ?>
</div>
