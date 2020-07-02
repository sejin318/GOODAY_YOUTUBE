<?php
include_once "./_common.php";

/**
 * DEMO Page
 */
$g5['title'] = "PAGES - Buttons";
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/css/bp_pages.css">', 200);
add_javascript("<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js'></script>", 110);
include_once(G5_THEME_PATH . '/head.php');
?>
<div class="jumbotron p-4">
    <h1 class="display-5">Buttons</h1>
    <p class="lead">Buttons 컴포넌트 데모</p>
    <hr class="my-4">
    <p>다양한 크기, 상태등을 지원하는 버튼입니다. </p>
</div>
<!-- Alert -->
<section class='contents-section'>
 
    <div class='contents-section-body'>
        <h3 class='body-title'>기본</h3>
        <?php ob_start(); ?>
        <button type="button" class="btn btn-primary">Primary</button>
        <button type="button" class="btn btn-secondary">Secondary</button>
        <button type="button" class="btn btn-success">Success</button>
        <button type="button" class="btn btn-danger">Danger</button>
        <button type="button" class="btn btn-warning">Warning</button>
        <button type="button" class="btn btn-info">Info</button>
        <button type="button" class="btn btn-light">Light</button>
        <button type="button" class="btn btn-dark">Dark</button>

        <button type="button" class="btn btn-link">Link</button>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap1', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Tags</h3>
        <?php ob_start(); ?>
        <a class="btn btn-primary" href="#" role="button">Link</a>
        <button class="btn btn-primary" type="submit">Button</button>
        <input class="btn btn-primary" type="button" value="Input">
        <input class="btn btn-primary" type="submit" value="Submit">
        <input class="btn btn-primary" type="reset" value="Reset">
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap2', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Outline buttons</h3>
        <?php ob_start(); ?>
        <button type="button" class="btn btn-outline-primary">Primary</button>
        <button type="button" class="btn btn-outline-secondary">Secondary</button>
        <button type="button" class="btn btn-outline-success">Success</button>
        <button type="button" class="btn btn-outline-danger">Danger</button>
        <button type="button" class="btn btn-outline-warning">Warning</button>
        <button type="button" class="btn btn-outline-info">Info</button>
        <button type="button" class="btn btn-outline-light">Light</button>
        <button type="button" class="btn btn-outline-dark">Dark</button>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap3', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Size</h3>
        <?php ob_start(); ?>
        <button type="button" class="btn btn-primary btn-lg">Large button</button>
        <button type="button" class="btn btn-secondary btn-lg">Large button</button>
        <button type="button" class="btn btn-primary btn-sm">Small button</button>
        <button type="button" class="btn btn-secondary btn-sm">Small button</button>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap4', $code_views);
        ?>
        <hr />
        <?php ob_start(); ?>
        <button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button>
        <button type="button" class="btn btn-secondary btn-lg btn-block">Block level button</button>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap4-1', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Active state</h3>
        <?php ob_start(); ?>
        <a href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Primary link</a>
        <a href="#" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Link</a>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap5', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Disabled state</h3>
        <?php ob_start(); ?>
        <button type="button" class="btn btn-lg btn-primary" disabled>Primary button</button>
        <button type="button" class="btn btn-secondary btn-lg" disabled>Button</button>
        <a href="#" class="btn btn-primary btn-lg disabled" tabindex="-1" role="button" aria-disabled="true">Primary link</a>
        <a href="#" class="btn btn-secondary btn-lg disabled" tabindex="-1" role="button" aria-disabled="true">Link</a>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap6', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Toggle states</h3>
        <?php ob_start(); ?>
        <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false">
            Single toggle
        </button>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap7', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Checkbox and radio buttons</h3>
        <?php ob_start(); ?>
        <div class="btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="checkbox" checked> Checked
            </label>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap8', $code_views);
        ?>
        <hr/>
        <?php ob_start(); ?>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" checked> Active
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option2"> Radio
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="options" id="option3"> Radio
            </label>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap8-1', $code_views);
        ?>
    </div>

</section>
<div class="divider primary"><em></em></div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
