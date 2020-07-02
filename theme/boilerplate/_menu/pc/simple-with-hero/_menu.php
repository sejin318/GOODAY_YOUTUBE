<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * simple
 * PC 메뉴
 * 함수로 로딩되기 떄문에 외부 변수 사용시 상단에 global로 선언하세요.
 * hero header 사용
 */
//HERO 사용
define("BP_USE_HERO", true);

//global $var;
add_stylesheet('<link rel="stylesheet" href="' . BP_PC_MENU_URL . DIRECTORY_SEPARATOR . 'simple-web-hero' . '/menu-simple.css">', 20);

?>
<!--
    navbar-expand-* 클래스로 네비바 모바일 모드의 breakpoint 를 설정할 수 있습니다.
    navbar-expand-lg, navbar-expand-md, navbar-expand-sm
-->
<div class='simple-pc-menu-wrap header sticky' id='my-header'>
    <?php
    //사이트 컨테이너 전체 사용
    if ($config['bp_container'] == 'container-fluid') {
        echo "<div class='{$config['bp_container']} menu-container'>";
    } else {
        //사이트 박스 컨테이너에서 메뉴 컨테이너 설정
        if ($config['bp_pc_menu_container']) {
            echo "<div class='{$config['bp_container']} menu-container'>";
        } else {
            echo "<div class='menu-container'>";
        }
    }
    ?>
    <nav class="top-navi navbar navbar-expand-lg simple-background-<?php echo $config['bp_pc_menu_color'] ?>">
        <!-- 모바일용 왼쪽 메뉴 버튼 -->
        <a class="navbar-toggler" data-offcanvas-trigger="left-side-menu" href="#left-side-menu">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </a>
        <!--LOGO -->
        <?php echo bp_logo_view($config); ?>
        <!-- 모바일용 오른쪽 메뉴 버튼 -->
        <a class="navbar-toggler" data-offcanvas-trigger="right-side-menu" href="#right-side-menu">
            <i class="fa fa-user" aria-hidden="true"></i>
        </a>
        <div class='pc-menu-wrap flex-column ml-auto d-none d-lg-flex'>
            <!-- 메인메뉴 -->
            <div class="collapse navbar-collapse">
                <div class='main-menu hover-drop-menu d-flex flex-row'>
                    <?php
                    $menu_datas = get_menu_db(0, true);
                    $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                    $i = 0;
                    foreach ($menu_datas as $row) {
                        if (empty($row)) {
                            continue;
                        }
                        //Sub check
                        //$add_class = (isset($row['sub']) && $row['sub']) ? 'sub-item-wrap' : '';
                        $add_class = (!isset($row['sub']) && !$row['sub']) ? 'nosub-item-wrap' : '';
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
                            $k++;
                        }   //end foreach $row2

                        if ($k > 0) {
                            echo '</div><!--//.dropdown-menu-->' . PHP_EOL;
                        }
                        echo "</div><!--//.main-menu-list-->";
                        $i++;
                    }   //end foreach $row

                    ?>
                    <!--//.main-menu -->
                    <!-- 사용자 추가 메뉴 -->
                    <div class="main-menu-list "><a href="<?php echo BP_MYPAGE_URL ?>" target="_self" class="main-menu-link"><i class="fa fa-user" aria-hidden="true"></i> MY</a>
                        <div class="submenu-wrap shadow">
                            <span class="sr-only">하위분류</span>
                            <a href="<?php echo G5_BBS_URL ?>/new.php" class="sub-menu-link"><i class="fa fa-file-o" aria-hidden="true"></i> 새글</a>
                            <?php if ($is_member) { ?>
                                <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" class="sub-menu-link"><i class="fa fa-user-secret" aria-hidden="true"></i> 정보수정</a>
                                <a href="<?php echo G5_BBS_URL ?>/logout.php" class="sub-menu-link"> <i class="fa fa-sign-out" aria-hidden="true"></i> 로그아웃</a>
                                <a href="<?php echo G5_BBS_URL ?>/scrap.php" class="sub-menu-link"><i class="fa fa-bookmark-o" aria-hidden="true"></i> 스크랩</a>
                                <a href="<?php echo G5_BBS_URL ?>/memo.php" class="sub-menu-link"><i class="fa fa-envelope-o" aria-hidden="true"></i> 쪽지</a>
                                <a class="sub-menu-link" href="<?php echo BP_MYPAGE_URL ?>/my_point.php"><i class="fa fa-money"></i> <?php echo $member['mb_point'] ?> Point</a>
                            <?php } else { ?>
                                <a href="<?php echo G5_BBS_URL ?>/register.php" class="sub-menu-link"> <i class="fa fa-user-plus" aria-hidden="true"></i> 회원가입</a>
                                <a href="<?php echo G5_BBS_URL ?>/login.php" class="sub-menu-link"><i class="fa fa-sign-in" aria-hidden="true"></i> 로그인</a>
                            <?php } ?>
                            <?php if ($is_admin == 'super') { ?>
                                <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>" class="sub-menu-link"> <i class="fa fa-cogs" aria-hidden="true"></i> 관리자</a>
                            <?php } ?>
                        </div>
                        <!--//.dropdown-menu-->
                    </div>
                    <?php if ($i == 0) {  ?>
                        <div class="main-menu-list "><a href="#" target="_self" class="main-menu-link">메뉴 준비중</a>
                            <div class="submenu-wrap shadow">
                                <span class="sr-only">하위분류</span>
                                <div class="sub-menu-link">메뉴 준비 중입니다.</div>
                                <?php if ($is_admin) { ?>
                                    <div class='sub-menu-link'>
                                        <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php" class='text-white'>관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>
                                    </div>
                                <?php } ?>
                            </div>
                            <!--//.dropdown-menu-->
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>
    <div class='shadow-bottom'></div>

    <?php
    //사이트 컨테이너 전체 사용
    if ($config['bp_container'] == 'container-fluid') {
        echo "</div>";
    } else {
        //사이트 박스 컨테이너에서 메뉴 컨테이너 설정
        if ($config['bp_pc_menu_container']) {
            echo "</div>";
        } else {
            echo "</div>";
        }
    }
    ?>
</div>

<script>
    <?php if ($_head_file == true && is_ie11() == false) { ?>
        //	Create the sticky header.1
        new Mhead('.header.sticky', {
            scroll: {
                hide: 150
            },
            hooks: {
                'scrolledIn': function() {
                    //console.log('scrolledIn');
                },
                'scrolledOut': function() {
                    //console.log('scrolledOut');
                }
            }
        });
    <?php } ?>
</script>
