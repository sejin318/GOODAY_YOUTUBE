<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
if(is_ie11() == true){
    return;
}

/*
if (is_mobile() == false) {
    return;
}
*/
/**
 * default
 * Mobile 기본 메뉴
 * 함수로 로딩되기 떄문에 외부 변수 사용시 상단에 global로 선언하세요.
 */
//global $var;
add_stylesheet('<link rel="stylesheet" href="' . BP_MOBILE_MENU_URL . DIRECTORY_SEPARATOR . $config['bp_mobile_menu'] . '/mobile-menu.css">', 20);
?>
<script>
    $(function() {
        $(document).on("beforecreate.offcanvas", function(e) {
            var dataOffcanvas = $(e.target).data('offcanvas-component');
            //console.log(dataOffcanvas);
            dataOffcanvas.onInit = function() {
                //console.log(this);
            };
        });
        $(document).on("create.offcanvas", function(e) {
            var dataOffcanvas = $(e.target).data('offcanvas-component');
            //console.log(dataOffcanvas);
            dataOffcanvas.onOpen = function() {
                //console.log('Callback onOpen');
            };
            dataOffcanvas.onClose = function() {
                //console.log('Callback onClose');
            };

        });
        $(document).on("clicked.offcanvas-trigger clicked.offcanvas", function(e) {
            var dataBtnText = $(e.target).text();
            //console.log(e.type + '.' + e.namespace + ': ' + dataBtnText);
        });
        $(document).on("open.offcanvas", function(e) {
            var dataOffcanvasID = $(e.target).attr('id');
            //console.log(e.type + ': #' + dataOffcanvasID);
        });
        $(document).on("resizing.offcanvas", function(e) {
            var dataOffcanvasID = $(e.target).attr('id');
            //console.log(e.type + ': #' + dataOffcanvasID);
        });
        $(document).on("close.offcanvas", function(e) {
            var dataOffcanvasID = $(e.target).attr('id');
            //console.log(e.type + ': #' + dataOffcanvasID);
        });
        $(document).on("destroy.offcanvas", function(e) {
            var dataOffcanvasID = $(e.target).attr('id');
            //console.log(e.type + ': #' + dataOffcanvasID);
        });
        $('#top').on("create.offcanvas", function(e) {
            var api = $(this).data('offcanvas-component');

            console.log(api);
            $('.js-destroy').on('click', function() {
                api.destroy();
                //$( '#top' ).data('offcanvas-component').destroy();
                //console.log(api);
                //console.log($('#top').data());
            });
        });

        $('#left').offcanvas({
            modifiers: "left,overlay",
            triggerButton: '.js-left'
        });


        $('.js-enhance').on('click', function() {
            console.log('enhance');
            $(document).trigger("enhance");
        });

        $(document).trigger("enhance");
    });
</script>

<!-- Mobile Left side menu -->
<div class="js-offcanvas mobile-menu-wrap" data-offcanvas-options='{"modifiers":"left,push"}' id="left-side-menu" role="complementary">
<!--
    <div class='mobile-menu-header'>
        <h2>Menu</h2>
        <a class='mobile-menu-close js-offcanvas-close' aria-controls="left-side-menu" href="#close-mobile-menu"><span class="sr-only">Close</span><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
    </div>
-->
    <div class='mobile-menu-body'>
        <?php
        //게시판 즐겨찾기 출력 - 테마 기본환경설정
        echo bp_favorite_list();
        ?>
        <ul id="mobile-menu" class='mobile-menu'>
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
                echo "<li class='nav-link {$add_class}'>";
                echo "<a href='{$row['me_link']}' target='_{$row['me_target']}' class='nav-first-node'><i class='fa fa-caret-right' aria-hidden='true'></i> {$row['me_name']}</a>";
                $k = 0;
                foreach ((array) $row['sub'] as $row2) {
                    if (empty($row2)) {
                        continue;
                    }
                    if ($k == 0) {
                        echo '<span class="sr-only">하위분류</span> <ul class="sub-menu-list">' . PHP_EOL;
                    }
                    echo "<li class='nav-link'><a href='{$row2['me_link']}' target='_{$row2['me_target']}' class=''>{$row2['me_name']}</a></li>";
                    $k++;
                }   //end foreach $row2

                if ($k > 0) {
                    echo '</ul> ' . PHP_EOL;
                }
                echo "</li><!--//.nav-link-->" . PHP_EOL;

                $i++;
            }   //end foreach $row
            ?>

            <?php
            $main_menu = ob_get_contents();
            ob_end_clean();
            echo $main_menu;
            ?>
        </ul>
    </div>
</div>
<!-- Mobile Right side menu -->
<nav class="js-offcanvas mobile-member-wrap" data-offcanvas-options=' {"modifiers":"right,push"}' id="right-side-menu" role="complementary">
    <div class='mobile-menu-header'>
<!--#6c757d
        <h2>Member</h2>
        <a class='mobile-menu-close js-offcanvas-close' aria-controls="right-side-menu" href="#close-mobile-menu"><span class="sr-only">Close</span><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
-->
    </div>
    <!-- 아웃로그인 -->
    <div class='outlogin-mobile-wrap'>
        <?php echo outlogin('theme/mobile-basic'); ?>
    </div>
</nav>