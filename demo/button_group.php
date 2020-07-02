<?php
include_once "./_common.php";

/**
 * DEMO Page
 */
$g5['title'] = "PAGES - Button Group";
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/css/bp_pages.css">', 200);
add_javascript("<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js'></script>", 110);
include_once(G5_THEME_PATH . '/head.php');
?>
<div class="jumbotron p-4">
    <h1 class="display-5">Button Group</h1>
    <p class="lead">Button Group 컴포넌트 데모</p>
    <hr class="my-4">
    <p>다양한 크기, 상태등을 지원하는 버튼입니다. 버튼을 그룹화 해서 한줄에 사용 가능합니다. </p>
</div>
<!-- Alert -->
<section class='contents-section'>
 
    <div class='contents-section-body'>
        <h3 class='body-title'>기본</h3>
        <?php ob_start(); ?>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary">Left</button>
            <button type="button" class="btn btn-secondary">Middle</button>
            <button type="button" class="btn btn-secondary">Right</button>
        </div>

        <button type="button" class="btn btn-link">Link</button>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap1', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Button toolbar</h3>
        <?php ob_start(); ?>
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="First group">
                <button type="button" class="btn btn-secondary">1</button>
                <button type="button" class="btn btn-secondary">2</button>
                <button type="button" class="btn btn-secondary">3</button>
                <button type="button" class="btn btn-secondary">4</button>
            </div>
            <div class="btn-group mr-2" role="group" aria-label="Second group">
                <button type="button" class="btn btn-secondary">5</button>
                <button type="button" class="btn btn-secondary">6</button>
                <button type="button" class="btn btn-secondary">7</button>
            </div>
            <div class="btn-group" role="group" aria-label="Third group">
                <button type="button" class="btn btn-secondary">8</button>
            </div>
            <?php
            $code_views = ob_get_contents();
            ob_end_flush();
            echo _display_code_view('codewrap2', $code_views);
            ?>
        </div>
        <div class='contents-section-body'>
            <h3 class='body-title'>Toolbar, Input Group mix</h3>
            <?php ob_start(); ?>
            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="First group">
                    <button type="button" class="btn btn-secondary">1</button>
                    <button type="button" class="btn btn-secondary">2</button>
                    <button type="button" class="btn btn-secondary">3</button>
                    <button type="button" class="btn btn-secondary">4</button>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupAddon">@</div>
                    </div>
                    <input type="text" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
                </div>
            </div>

            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    <button type="button" class="btn btn-secondary">1</button>
                    <button type="button" class="btn btn-secondary">2</button>
                    <button type="button" class="btn btn-secondary">3</button>
                    <button type="button" class="btn btn-secondary">4</button>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text" id="btnGroupAddon2">@</div>
                    </div>
                    <input type="text" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon2">
                </div>
            </div>
            <?php
            $code_views = ob_get_contents();
            ob_end_flush();
            echo _display_code_view('codewrap3', $code_views);
            ?>
        </div>
        <div class='contents-section-body'>
            <h3 class='body-title'>Sizing</h3>
            <?php ob_start(); ?>
            <div class="btn-group btn-group-lg" role="group" aria-label="Large button group">
                <button type="button" class="btn btn-secondary">Left</button>
                <button type="button" class="btn btn-secondary">Middle</button>
                <button type="button" class="btn btn-secondary">Right</button>
            </div>
            <hr />
            <div class="btn-group" role="group" aria-label="Default button group">
                <button type="button" class="btn btn-secondary">Left</button>
                <button type="button" class="btn btn-secondary">Middle</button>
                <button type="button" class="btn btn-secondary">Right</button>
            </div>
            <hr />
            <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                <button type="button" class="btn btn-secondary">Left</button>
                <button type="button" class="btn btn-secondary">Middle</button>
                <button type="button" class="btn btn-secondary">Right</button>
            </div>
            <?php
            $code_views = ob_get_contents();
            ob_end_flush();
            echo _display_code_view('codewrap4', $code_views);
            ?>
        </div>
        <div class='contents-section-body'>
            <h3 class='body-title'>Nesting</h3>
            <?php ob_start(); ?>
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <button type="button" class="btn btn-secondary">1</button>
                <button type="button" class="btn btn-secondary">2</button>

                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="#">Dropdown link</a>
                        <a class="dropdown-item" href="#">Dropdown link</a>
                    </div>
                </div>
            </div>
            <?php
            $code_views = ob_get_contents();
            ob_end_flush();
            echo _display_code_view('codewrap5', $code_views);
            ?>
        </div>
        <div class='contents-section-body'>
            <h3 class='body-title'>Vertical variation</h3>
            <?php ob_start(); ?>
            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                <button type="button" class="btn btn-secondary">Button</button>
                <button type="button" class="btn btn-secondary">Button</button>
                <button type="button" class="btn btn-secondary">Button</button>
                <button type="button" class="btn btn-secondary">Button</button>
                <button type="button" class="btn btn-secondary">Button</button>
                <button type="button" class="btn btn-secondary">Button</button>
            </div>
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
            <hr />
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
