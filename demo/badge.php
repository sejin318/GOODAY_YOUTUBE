<?php
include_once "./_common.php";

/**
 * DEMO Page
 */
$g5['title'] = "PAGES - Badge";
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/css/bp_pages.css">', 200);
add_javascript("<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js'></script>", 110);
include_once(G5_THEME_PATH . '/head.php');
?>
<div class="jumbotron p-4">
    <h1 class="display-5">Badge</h1>
    <p class="lead">Badge 컴포넌트 데모</p>
    <hr class="my-4">
    <p>궁금한 사항은 질문답변 게시판을 이용해 주세요.</p>
</div>
<!-- Alert -->
<section class='contents-section'>
 
    <div class='contents-section-body'>
        <h3 class='body-title'>기본</h3>
        <?php ob_start(); ?>
        <h1>Example heading <span class="badge badge-secondary">New</span></h1>
        <h2>Example heading <span class="badge badge-secondary">New</span></h2>
        <h3>Example heading <span class="badge badge-secondary">New</span></h3>
        <h4>Example heading <span class="badge badge-secondary">New</span></h4>
        <h5>Example heading <span class="badge badge-secondary">New</span></h5>
        <h6>Example heading <span class="badge badge-secondary">New</span></h6>
        <?php
        $badge = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('badge', $badge);
        ?>
        <h3 class='body-title'>Count</h3>
        <?php ob_start(); ?>
        <button type="button" class="btn btn-primary">
            Notifications <span class="badge badge-light">4</span>
        </button>
        <button type="button" class="btn btn-primary">
            Profile <span class="badge badge-light">9</span>
            <span class="sr-only">unread messages</span>
        </button>
        <?php
        $badge_count = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('count', $badge_count);
        ?>
        <h3 class='body-title'>Contextual variations</h3>
        <?php ob_start(); ?>
        <span class="badge badge-primary">Primary</span>
        <span class="badge badge-secondary">Secondary</span>
        <span class="badge badge-success">Success</span>
        <span class="badge badge-danger">Danger</span>
        <span class="badge badge-warning">Warning</span>
        <span class="badge badge-info">Info</span>
        <span class="badge badge-light">Light</span>
        <span class="badge badge-dark">Dark</span>
        <?php
        $code_cv = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('code_cv', $code_cv);
        ?>
        <h3 class="body-title">Pill badges</h3>
        <?php ob_start(); ?>
        <span class="badge badge-pill badge-primary">Primary</span>
        <span class="badge badge-pill badge-secondary">Secondary</span>
        <span class="badge badge-pill badge-success">Success</span>
        <span class="badge badge-pill badge-danger">Danger</span>
        <span class="badge badge-pill badge-warning">Warning</span>
        <span class="badge badge-pill badge-info">Info</span>
        <span class="badge badge-pill badge-light">Light</span>
        <span class="badge badge-pill badge-dark">Dark</span>
        <?php
        $code_pill = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('code_pill', $code_pill);
        ?>

    </div>

</section>
<div class="divider primary"><em></em></div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
