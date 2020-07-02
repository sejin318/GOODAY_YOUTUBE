<?php
include_once('./_common.php');
include_once(G5_THEME_PATH . '/head.sub.php');
$with = 1248;
if ($device == 'mobile') {
    $with = 375;
}
if ($device == 'tablet') {
    $with = 768;
}
if ($device == 'laptop') {
    $with = 1248;
}
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/css/live_preview.css">', 200);
?>
<nav class="navbar navbar-dark bg-dark navbar-expand-sm fixed-top">
    <a class="navbar-brand" href="#">Preview</a>
    <ul id="wdn_switcher" class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li id="desktop" title="Desktop">Desktop</li>
        <li id="tablet-landscape" title="Tablet Landscape">Tablet Landscape</li>
        <li id="tablet-portrait" title="Tablet Portrait">Tablet Portrait</li>
        <li id="smartphone-landscape" title="Smartphone Landscape">Smartphone Landscape</li>
        <li id="smartphone-portrait" title="Smartphone Portrait">Smartphone Portrait</li>
    </ul>
    <button class="btn btn-outline-success ml-auto" type="button" onclick="window.close();">닫기</button>
</nav>
<div class='container-fluid h-100'>
    <div id="wdn_framer" class="desktop">
        <div id="mask"></div>
        <iframe src="<?php echo bp_get_hostname();?>">
            <h1>Rats, your browser doesn't support this.</h1>
        </iframe>
    </div>
</div>
<script type="text/javascript">
    function setURLVar(variable, state) {
        history.pushState("", "Title", variable);
    }

    $("#wdn_switcher li").click(function() {
        $("#wdn_framer").attr("class", $(this).attr("id"));
        $("#wdn_switcher li.active").removeClass("active");
        $(this).addClass("active");
    });
</script>
<?php
include_once(G5_THEME_PATH . '/tail.sub.php');
