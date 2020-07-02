<?php
include_once "./_common.php";

/**
 * DEMO Page
 */
$g5['title'] = "PAGES - Alert";
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/css/bp_pages.css">', 200);
add_javascript("<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js'></script>", 110);
include_once(G5_THEME_PATH . '/head.php');
?>
<div class="jumbotron p-4">
    <h1 class="display-5">Alert</h1>
    <p class="lead">Alert 컴포넌트 데모</p>
    <hr class="my-4">
    <p>궁금한 사항은 질문답변 게시판을 이용해 주세요.</p>
</div>
<!-- Alert -->
<section class='contents-section'>
 
    <div class='contents-section-body'>
        <h3 class='body-title'>기본</h3>
        <?php ob_start(); ?>
        <div class="alert alert-primary" role="alert">
            A simple primary alert—check it out!
        </div>
        <div class="alert alert-secondary" role="alert">
            A simple secondary alert—check it out!
        </div>
        <div class="alert alert-success" role="alert">
            A simple success alert—check it out!
        </div>
        <div class="alert alert-danger" role="alert">
            A simple danger alert—check it out!
        </div>
        <div class="alert alert-warning" role="alert">
            A simple warning alert—check it out!
        </div>
        <div class="alert alert-info" role="alert">
            A simple info alert—check it out!
        </div>
        <div class="alert alert-light" role="alert">
            A simple light alert—check it out!
        </div>
        <div class="alert alert-dark" role="alert">
            A simple dark alert—check it out!
        </div>
        <?php
        $alert = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('alert', $alert);
        ?>
        <h3 class='body-title'>링크</h3>
        <?php ob_start(); ?>
        <div class="alert alert-primary" role="alert">
            A simple primary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
        </div>
        <div class="alert alert-secondary" role="alert">
            A simple secondary alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
        </div>
        <div class="alert alert-success" role="alert">
            A simple success alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
        </div>
        <div class="alert alert-danger" role="alert">
            A simple danger alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
        </div>
        <div class="alert alert-warning" role="alert">
            A simple warning alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
        </div>
        <div class="alert alert-info" role="alert">
            A simple info alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
        </div>
        <div class="alert alert-light" role="alert">
            A simple light alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
        </div>
        <div class="alert alert-dark" role="alert">
            A simple dark alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
        </div>
        <?php
        $alert_link = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('alert_link', $alert_link);
        ?>
        <h3 class='body-title'>콘텐츠</h3>
        <?php ob_start(); ?>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Well done!</h4>
            <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
            <hr>
            <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
        </div>
        <?php
        $alert_contents = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('alert_contents', $alert_contents);
        ?>
        <h3 class='body-title'>닫기</h3>
        <?php ob_start(); ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong> You should check in on some of those fields below.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
        $alert_close = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('alert_close', $alert_close);
        ?>
    </div>

</section>
<div class="divider primary"><em></em></div>
<style>
    .code {
        position: relative;
        height: 300px;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    .code-view {
        width: 100%;
        border: 1px solid #999;
    }
</style>

<?php
include_once(G5_THEME_PATH . '/tail.php');
