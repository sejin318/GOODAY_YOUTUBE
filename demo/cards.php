<?php
include_once "./_common.php";

/**
 * DEMO Page
 */
$g5['title'] = "PAGES - Cards";
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/css/bp_pages.css">', 200);
add_javascript("<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js'></script>", 110);
include_once(G5_THEME_PATH . '/head.php');
?>
<div class="jumbotron p-4">
    <h1 class="display-5">Cards</h1>
    <p class="lead">Cards 컴포넌트 데모</p>
    <hr class="my-4">
    <p>카드는 유연하고 확장 가능한 콘텐츠 컨테이너입니다. </p>
</div>
<!-- Alert -->
<section class='contents-section'>

    <div class='contents-section-body'>
        <h3 class='body-title'>기본</h3>
        <?php ob_start(); ?>
        <div class="card" style="width: 18rem;">
            <img src="/images/hero/board-board.jpg" class="card-img-top" alt='card-image'>
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap1', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Body</h3>
        <?php ob_start(); ?>
        <div class="card">
            <div class="card-body">
                This is some text within a card body.
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap2', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Titles, text, and links</h3>
        <?php ob_start(); ?>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap3', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>List groups</h3>
        <?php ob_start(); ?>
        <div class="card" style="width: 18rem;">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap4', $code_views);
        ?>
        <hr />
        <?php ob_start(); ?>
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                Featured
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap4-1', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Kitchen sink</h3>
        <?php ob_start(); ?>
        <div class="card" style="width: 18rem;">
            <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap5', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Header and footer</h3>
        <?php ob_start(); ?>
        <div class="card">
            <div class="card-header">
                Featured
            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <hr />
        <div class="card">
            <h5 class="card-header">Featured</h5>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <hr />
        <div class="card">
            <div class="card-header">
                Quote
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                    <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                </blockquote>
            </div>
        </div>
        <hr />
        <div class="card text-center">
            <div class="card-header">
                Featured
            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
            <div class="card-footer text-muted">
                2 days ago
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap6', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Sizing, Using grid markup</h3>
        <?php ob_start(); ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap7', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Using Utilities</h3>
        <?php ob_start(); ?>
        <div class="card w-75">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Button</a>
            </div>
        </div>
        <hr />
        <div class="card w-50">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Button</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap8', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Text alignment</h3>
        <?php ob_start(); ?>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <hr />
        <div class="card text-center" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <hr />
        <div class="card text-right" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap9', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Navigation</h3>
        <?php ob_start(); ?>
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <hr />
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap10', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Images</h3>
        <?php ob_start(); ?>
        <div class="card mb-3">
            <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
            <img src="/images/hero/mist-misty-fog-foggy.jpg" class="card-img-top" alt="card image">
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap11', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Image overlays</h3>
        <?php ob_start(); ?>
        <div class="card bg-dark text-white">
            <img src="/images/hero/mist-misty-fog-foggy.jpg" class="card-img" alt="card image">
            <div class="card-img-overlay">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text">Last updated 3 mins ago</p>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap12', $code_views);
        ?>
    </div>

    <div class='contents-section-body'>
        <h3 class='body-title'>Horizontal</h3>
        <?php ob_start(); ?>
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="/images/trees-park1by1.jpg" class="card-img" alt="card image">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap13', $code_views);
        ?>
    </div>
    <div class="divider primary"><em></em></div>
    <h2 class='sub-title'>Card styles</h2>
    <div class='contents-section-body'>
        <h3 class='body-title'>Background and color</h3>
        <?php ob_start(); ?>
        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Primary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Secondary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Success card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Danger card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Warning card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Info card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card bg-light mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Dark card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap14', $code_views);
        ?>
    </div>

    <div class='contents-section-body'>
        <h3 class='body-title'>Border</h3>
        <?php ob_start(); ?>
        <div class="card border-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body text-primary">
                <h5 class="card-title">Primary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card border-secondary mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body text-secondary">
                <h5 class="card-title">Secondary card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card border-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body text-success">
                <h5 class="card-title">Success card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card border-danger mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body text-danger">
                <h5 class="card-title">Danger card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card border-warning mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body text-warning">
                <h5 class="card-title">Warning card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card border-info mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body text-info">
                <h5 class="card-title">Info card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card border-light mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body">
                <h5 class="card-title">Light card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card border-dark mb-3" style="max-width: 18rem;">
            <div class="card-header">Header</div>
            <div class="card-body text-dark">
                <h5 class="card-title">Dark card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap15', $code_views);
        ?>
    </div>

    <div class="divider primary"><em></em></div>
    <h2 class='sub-title'>Card layout</h2>
    <div class='contents-section-body'>
        <h3 class='body-title'>Card groups</h3>
        <?php ob_start(); ?>
        <div class="card-group">
            <div class="card">
                <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <div class="card">
                <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <div class="card">
                <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>
        <hr />
        <div class="card-group">
            <div class="card">
                <img src="/images/hero/beautiful-calm-clouds-dark.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div>
            </div>
            <div class="card">
                <img src="/images/hero/beautiful-calm-clouds-dark.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div>
            </div>
            <div class="card">
                <img src="/images/hero/beautiful-calm-clouds-dark.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap16', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Card decks</h3>
        <div class='alert alert-info'>
            <i class="fa fa-info" aria-hidden="true"></i> 분리된 카드를 동일한 너비, 높이의 카드 세트로 만들기
        </div>
        <?php ob_start(); ?>
        <div class="card-deck">
            <div class="card">
                <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <div class="card">
                <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <div class="card">
                <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>
        <hr />
        <div class="card-deck">
            <div class="card">
                <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div>
            </div>
            <div class="card">
                <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div>
            </div>
            <div class="card">
                <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Last updated 3 mins ago</small>
                </div>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap17', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Grid cards</h3>
        <?php ob_start(); ?>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mb-4">
                <div class="card">
                    <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card">
                    <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card">
                    <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card">
                    <img src="/images/hero/forest.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row row-cols-1 row-cols-md-3">
            <div class="col mb-4">
                <div class="card">
                    <img src="/images/hero/mist-misty-fog-foggy.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card">
                    <img src="/images/hero/mist-misty-fog-foggy.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card">
                    <img src="/images/hero/mist-misty-fog-foggy.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card">
                    <img src="/images/hero/mist-misty-fog-foggy.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row row-cols-1 row-cols-md-3">
            <div class="col mb-4">
                <div class="card h-100">
                    <img src="/images/hero/building.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card h-100">
                    <img src="/images/hero/building.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a short card.</p>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card h-100">
                    <img src="/images/hero/building.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card h-100">
                    <img src="/images/hero/building.jpg" class="card-img-top" alt="card image">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap18', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Card columns</h3>
        <div class='alert alert-info'>
            <i class="fa fa-info" aria-hidden="true"></i> Masonry(벽돌) 형식 카드 그리드
        </div>
        <?php ob_start(); ?>
        <div class="card-columns">
            <div class="card">
                <img src="/images/hero/board-css.jpg" class="card-img-top" alert="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title that wraps to a new line1</h5>
                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
            <div class="card p-3">
                <blockquote class="blockquote mb-0 card-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.2</p>
                    <footer class="blockquote-footer">
                        <small class="text-muted">
                            Someone famous in <cite title="Source Title">Source Title</cite>
                        </small>
                    </footer>
                </blockquote>
            </div>
            <div class="card">
                <img src="/images/hero/trees-park.jpg" class="card-img-top" alert="card image">
                <div class="card-body">
                    <h5 class="card-title">Card title3</h5>
                    <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <div class="card bg-primary text-white text-center p-3">
                <blockquote class="blockquote mb-0">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat.4</p>
                    <footer class="blockquote-footer text-white">
                        <small>
                            Someone famous in <cite title="Source Title">Source Title</cite>
                        </small>
                    </footer>
                </blockquote>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Card title5</h5>
                    <p class="card-text">This card has a regular title and short paragraphy of text below it.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <div class="card">
                <img src="/images/hero/forest.jpg" class="card-img-top" alert="card image">
            </div>
            <div class="card p-3 text-right">
                <blockquote class="blockquote mb-0">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.6</p>
                    <footer class="blockquote-footer">
                        <small class="text-muted">
                            Someone famous in <cite title="Source Title">Source Title</cite>
                        </small>
                    </footer>
                </blockquote>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card title7</h5>
                    <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap19', $code_views);
        ?>
    </div>


</section>
<div class="divider primary"><em></em></div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
