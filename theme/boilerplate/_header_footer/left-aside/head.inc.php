<?php

/**
 * 왼쪽 사이드바용 Head
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
?>

<!--  # 컨텐츠 시작 # -->
<div class='<?php echo $config['bp_container'] ?> global-container '>
    <?php
    if (defined('_INDEX_')) { // index에서만 실행
        if (is_mobile() == true) {
            # 모바일 팝업
            include G5_THEME_PATH . '/newwin.inc.php';
        } else {
            # PC 팝업
            include G5_BBS_PATH . '/newwin.inc.php';
        }
    }
    ?>
    <div class='row global-row no-gutters'>
        <!-- 전체 100% width 이용할 경우
        <div class='col-12'>내용 입력</div>
        -->

        <!-- 왼쪽 사이드 메뉴, 모바일은 출력하지 않음 -->
        <div class='col-12 col-sm-12 col-md-12 col-lg-3 side-wrap d-none d-lg-flex'>
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
        <!--//.col-sm-12 col-md-4 col-lg-3 aside wrapper-->

        <!-- 컨텐츠 영역, 자동 width col class -->
        <div class='col contents-wrap'>
            <div class='contents'>