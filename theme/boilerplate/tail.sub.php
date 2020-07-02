<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
?>

<?php if ($is_admin == 'super') {  ?>
    <script>
        console.log("GNUBOARD Runtime : " + '<?php echo get_microtime() - $begin_time; ?>');
    </script>
<?php } ?>

<?php //run_event('tail_sub'); ?>


</div>
<!--//.c-offcanvas-content-wrap -->

<?php if ($_head_file == true) { ?>
    <!--  해더파일 inlucde 할 때만 모바일 메뉴 출력한다.-->
    <?php bp_mobile_menu($config); ?>
<?php } ?>

<?php

if ($config['bp_browser_update']) {
    echo Util::browser_update();
}
?>

<script>
    //이미지 지연로딩
    var lazyLoadInstance = new LazyLoad({
        elements_selector: ".lazy",
        load_delay: 100
    });
</script>
</body>

</html>
<?php
echo html_end();
