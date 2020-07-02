<?php
if (!defined("_GNUBOARD_")) {
    exit;
}
global $config;
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/css/live_settings.css">', 200);

//깜밖임 처리
if ($_COOKIE['style_selector_status'] == 'disabled') {
    echo "<style>#style-selector{width: 280px; right: -280px;}</style>";
}
?>
<iframe class='hiddenframe d-none' name='hiddenframe'></iframe>
<div id="style-selector">
    <div class="style-toggle">
        <i class="fa fa-cog" aria-hidden="true"></i>
    </div>
    <div id="style-selector-container" class='container pt-2'>
        <h3 class='text-center p-2 mb-3'>Boilerplate Theme 미리보기</h3>
        <div class="btn-navbar text-center mb-2">
            <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=reset' class='btn btn-success btn-sm' target="hiddenframe"><i class="fa fa-refresh" aria-hidden="true"></i> 설정 기본값 복원</a>
        </div>
        <section class='border-bottom m-0 pb-1'>
            <h4 class='p-2 mb-0 border-bottom border-light'><i class="fa fa-info-circle" aria-hidden="true"></i> 컬러셋 선택</h4>
            <div class="btn-navbar text-center">
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=colorset&amp;color=default' class='btn btn-secondary btn-sm <?php echo $config['bp_colorset'] == 'colorset.default.css' ? "active" : ""; ?>' target="hiddenframe">Default</a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=colorset&amp;color=dark' class='btn btn-secondary btn-sm <?php echo $config['bp_colorset'] == 'colorset.dark.css' ? "active" : ""; ?>' target="hiddenframe">Dark</a>
            </div>
        </section>
        <section class='border-bottom m-0 pb-1'>
            <h4 class='p-2 mb-0 border-bottom border-light'><i class="fa fa-info-circle" aria-hidden="true"></i> 폰트크기 선택</h4>
            <div class="btn-navbar text-center">
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=fontsize&amp;size=16' class='btn btn-secondary btn-sm <?php echo $config['bp_font_size'] == false ? "active" : ""; ?>' target="hiddenframe">1rem</a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=fontsize&amp;size=14' class='btn btn-secondary btn-sm <?php echo $config['bp_font_size'] == true ? "active" : ""; ?>' target="hiddenframe">0.875rem</a>
            </div>
        </section>
        <section class='border-bottom m-0 pb-1'>
            <h4 class='p-2 mb-0 border-bottom border-light'><i class="fa fa-info-circle" aria-hidden="true"></i> 사이트 컨테이너</h4>
            <div class="btn-navbar text-center">
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=box&amp;model=fluid' class='btn btn-secondary btn-sm <?php echo $config['bp_container'] == 'container-fluid' ? "active" : ""; ?>' target="hiddenframe">전체사용</a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=box&amp;model=container' class='btn btn-secondary btn-sm <?php echo $config['bp_container'] != 'container-fluid'  ? "active" : ""; ?>' target="hiddenframe">박스형</a>
            </div>
        </section>
        <?php if ($config['bp_container'] != 'container-fluid') { ?>
            <section class='border-bottom m-0 pb-1'>
                <h4 class='p-2 mb-0 border-bottom border-light'><i class="fa fa-info-circle" aria-hidden="true"></i> PC 메뉴 컨테이너 - 박스형 사이트에만 적용</h4>
                <div class="btn-navbar text-center">
                    <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubox&amp;model=fluid' class='btn btn-secondary btn-sm <?php echo $config['bp_pc_menu_container'] == false ? "active" : ""; ?>' target="hiddenframe">전체사용</a>
                    <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubox&amp;model=container' class='btn btn-secondary btn-sm <?php echo $config['bp_pc_menu_container'] == true  ? "active" : ""; ?>' target="hiddenframe">박스형</a>
                </div>
            </section>
        <?php } ?>

        <section class='border-bottom m-0 pb-1'>
            <h4 class='p-2 mb-0 border-bottom border-light'><i class="fa fa-info-circle" aria-hidden="true"></i> PC 메뉴 배경색</h4>
            <div class="btn-navbar text-center">
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubg&amp;color=default' class='btn btn-dark btn-sm border' target="hiddenframe"><?php echo $config['bp_pc_menu_color'] == 'dark' ? '<i class="fa fa-check" aria-hidden="true"></i>' : "&nbsp;"; ?></a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubg&amp;color=primary' class='btn btn-primary btn-sm border' target="hiddenframe"><?php echo $config['bp_pc_menu_color'] == 'primary' ? '<i class="fa fa-check" aria-hidden="true"></i>' : "&nbsp;"; ?></a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubg&amp;color=secondary' class='btn btn-secondary btn-sm border' target="hiddenframe"><?php echo $config['bp_pc_menu_color'] == 'secondary' ? '<i class="fa fa-check" aria-hidden="true"></i>' : "&nbsp;"; ?></a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubg&amp;color=danger' class='btn btn-danger btn-sm border' target="hiddenframe"><?php echo $config['bp_pc_menu_color'] == 'danger' ? '<i class="fa fa-check" aria-hidden="true"></i>' : "&nbsp;"; ?></a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubg&amp;color=warning' class='btn btn-warning btn-sm border' target="hiddenframe"><?php echo $config['bp_pc_menu_color'] == 'warning' ? '<i class="fa fa-check" aria-hidden="true"></i>' : "&nbsp;"; ?></a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubg&amp;color=success' class='btn btn-success btn-sm border' target="hiddenframe"><?php echo $config['bp_pc_menu_color'] == 'success' ? '<i class="fa fa-check" aria-hidden="true"></i>' : "&nbsp;"; ?></a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubg&amp;color=info' class='btn btn-info btn-sm border' target="hiddenframe"><?php echo $config['bp_pc_menu_color'] == 'info' ? '<i class="fa fa-check" aria-hidden="true"></i>' : "&nbsp;"; ?></a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubg&amp;color=light' class='btn btn-light btn-sm border' target="hiddenframe"><?php echo $config['bp_pc_menu_color'] == 'light' ? '<i class="fa fa-check" aria-hidden="true"></i>' : "&nbsp;"; ?></a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=menubg&amp;color=white' class='btn btn-white btn-sm border' target="hiddenframe"><?php echo $config['bp_pc_menu_color'] == 'white' ? '<i class="fa fa-check" aria-hidden="true"></i>' : "&nbsp;"; ?></a>
            </div>
        </section>

        <section class='border-bottom m-0 pb-1'>
            <h4 class='p-2 mb-0 border-bottom border-light'><i class="fa fa-info-circle" aria-hidden="true"></i> ASIDE 사용</h4>
            <div class="btn-navbar text-center">
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=aside&amp;model=left' class='btn btn-secondary btn-sm <?php echo $config['bp_header_footer'] == 'left-aside' ? "active" : ""; ?>' target="hiddenframe">왼쪽</a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=aside&amp;model=no' class='btn btn-secondary btn-sm <?php echo $config['bp_header_footer'] == 'no-aside'  ? "active" : ""; ?>' target="hiddenframe">미사용</a>
                <a href='<?php echo G5_URL ?>/demo/preview-settings.php?type=aside&amp;model=right' class='btn btn-secondary btn-sm <?php echo $config['bp_header_footer'] == 'right-aside'  ? "active" : ""; ?>' target="hiddenframe">오른쪽</a>
            </div>
        </section>

        <span class="ss-title"><a href='/demo/preview.php' class="btn btn-primary mt-2" target="_blank"><i class="fa fa-tablet" aria-hidden="true"></i> 미리보기</a></span>
    </div>
</div>
<script type="text/javascript">
    jQuery(document)
        .ready(function() {

            if (jQuery("#style-selector").width() < 281) {
                var e = document.getElementById("style-selector-container"),
                    t = jQuery("#style-selector").width();
                jQuery(".style-selector-wrapper").height() > jQuery(window).height() && (t += e.offsetWidth - e.clientWidth), jQuery("#style-selector").width(t)
            }

            jQuery(window).on("resize", function() {
                    if (jQuery("#style-selector").width() < 281) {
                        var e = document.getElementById("style-selector-container"),
                            t = jQuery("#style-selector").width();
                        jQuery(".style-selector-wrapper").height() > jQuery(window).height() && (t += e.offsetWidth - e.clientWidth), jQuery("#style-selector").width(t)
                    }
                }),
                Cookies.get("boxed_style_selector") &&
                (boxed_style_selector_change(jQuery.cookie("boxed_style_selector")),
                    "Boxed" === Cookies.get("boxed_style_selector") &&
                    (jQuery("#style-selector .boxed-button").addClass("active"), jQuery("#style-selector .wide-button").removeClass("active"))),
                "disabled" === Cookies.get("style_selector_status") ? (jQuery("body").removeClass("ss-close"),
                    jQuery("body").addClass("ss-open"),
                    jQuery("#style-selector").css("right", "-" + jQuery("#style-selector").width() + "px")) : (jQuery("body").removeClass("ss-open"), jQuery("body").addClass("ss-close"), jQuery("#style-selector").css("right", "0px")),

                jQuery("#style-selector .style-toggle").click(function(e) {
                    e.preventDefault(), jQuery("body")
                        .hasClass("ss-close") ? (jQuery("body").removeClass("ss-close"), jQuery("body").addClass("ss-open"), jQuery("#style-selector").animate({
                                right: "-" + jQuery("#style-selector").width() + "px"
                            }, "slow"),
                            Cookies.remove("style_selector_status", {
                                path: "/"
                            }), Cookies.set(
                                "style_selector_status", "disabled", {
                                    path: "/"
                                })) : (jQuery("body")
                            .removeClass("ss-open"), jQuery("body")
                            .addClass("ss-close"), jQuery("#style-selector")
                            .animate({
                                right: "0px"
                            }, "slow"), Cookies.remove(
                                "style_selector_status", {
                                    path: "/"
                                }), Cookies.set(
                                "style_selector_status", "enabled", {
                                    path: "/"
                                }))
                })
        });
</script>