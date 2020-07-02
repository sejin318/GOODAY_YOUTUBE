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
    <h1 class="display-5">Dropdowns</h1>
    <p class="lead">Dropdowns 컴포넌트 데모</p>
    <hr class="my-4">
    <p>링크목록을 표시하기 위한 오버레이입니다. 클릭시 실행됩니다. </p>
</div>
<!-- Alert -->
<section class='contents-section'>

    <div class='contents-section-body'>
        <h3 class='body-title'>Single button</h3>
        <?php ob_start(); ?>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown button
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
        <hr />
        <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown link
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
        <hr />
        <!-- Example single danger button -->
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap1', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Split button</h3>
        <?php ob_start(); ?>
        <!-- Example split danger button -->
        <div class="btn-group">
            <button type="button" class="btn btn-primary">Action</button>
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-danger">Action</button>
            <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap2', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Sizing</h3>
        <?php ob_start(); ?>
        <!-- Large button groups (default and split) -->
        <div class="btn-group">
            <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Large button
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <div class="btn-group">
            <button class="btn btn-secondary btn-lg" type="button">
                Large split button
            </button>
            <button type="button" class="btn btn-lg btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>

        <!-- Small button groups (default and split) -->
        <div class="btn-group">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Small button
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <div class="btn-group">
            <button class="btn btn-secondary btn-sm" type="button">
                Small split button
            </button>
            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap3', $code_views);
        ?>
    </div>
    <div class="divider primary"><em></em></div>
    <h2>Directions</h2>
    <div class='contents-section-body'>
        <h3 class='body-title'>Dropup</h3>
        <?php ob_start(); ?>
        <!-- Default dropup button -->
        <div class="btn-group dropup">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropup
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>

        <!-- Split dropup button -->
        <div class="btn-group dropup">
            <button type="button" class="btn btn-secondary">
                Split dropup
            </button>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap4', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Dropright</h3>
        <?php ob_start(); ?>
        <!-- Default dropright button -->
        <div class="btn-group dropright">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropright
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>

        <!-- Split dropright button -->
        <div class="btn-group dropright">
            <button type="button" class="btn btn-secondary">
                Split dropright
            </button>
            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropright</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap5', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Dropleft</h3>
        <?php ob_start(); ?>
        <!-- Default dropleft button -->
        <div class="btn-group dropleft">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropleft
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>

        <!-- Split dropleft button -->
        <div class="btn-group">
            <div class="btn-group dropleft" role="group">
                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropleft</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>
            <button type="button" class="btn btn-secondary">
                Split dropleft
            </button>
        </div>

        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap6', $code_views);
        ?>
    </div>

    <div class='contents-section-body'>
        <h3 class='body-title'>Menu items</h3>
        <?php ob_start(); ?>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <span class="dropdown-item-text">텍스트, 링크아님</span>
                <button class="dropdown-item active" type="button">메뉴 Active</button>
                <button class="dropdown-item disabled" type="button">메뉴 Disable</button>
                <button class="dropdown-item" type="button">Something else here</button>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap7', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Menu alignment</h3>
        <div class='alert alert-info'>
            <i class="fa fa-info-circle" aria-hidden="true"></i> .dropdown-menu-right class 를 이용하면 드롭다운 메뉴를 오른쪽으로 정렬할 수 있습니다.
        </div>
        <?php ob_start(); ?>
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Right-aligned menu
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <button class="dropdown-item" type="button">Action</button>
                <button class="dropdown-item" type="button">Another action</button>
                <button class="dropdown-item" type="button">Something else here</button>
            </div>
        </div>

        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap8', $code_views);
        ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Responsive alignment</h3>
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i> .dropdown-menu-right and .dropdown-menu{-sm|-md|-lg|-xl}-left 클래스를 이용하면 반응형으로 좌우 정렬할 수 있습니다.
        </div>
        <?php ob_start(); ?>
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                Left-aligned but right aligned when large screen
            </button>
            <div class="dropdown-menu dropdown-menu-lg-right">
                <button class="dropdown-item" type="button">Action</button>
                <button class="dropdown-item" type="button">Another action</button>
                <button class="dropdown-item" type="button">Something else here</button>
            </div>
        </div>

        <hr />
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                Right-aligned but left aligned when large screen
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                <button class="dropdown-item" type="button">Action</button>
                <button class="dropdown-item" type="button">Another action</button>
                <button class="dropdown-item" type="button">Something else here</button>
            </div>
        </div>
        <?php
        $code_views = ob_get_contents();
        ob_end_flush();
        echo _display_code_view('codewrap9', $code_views);
        ?>
    </div>
    <div class="divider primary"><em></em></div>
    <h2> Menu content </h2>
    <div class='contents-section-body'>
        <h3 class='body-title'>Headers</h3>
        <div class='bd-example'>
            <?php ob_start(); ?>
            <div class="dropdown-menu">
                <h6 class="dropdown-header">Dropdown header</h6>
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
            </div>

            <?php
            $code_views = ob_get_contents();
            ob_end_flush();
            ?>
        </div>
        <?php echo _display_code_view('codewrap10', $code_views); ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Dividers</h3>
        <div class='bd-example'>
            <?php ob_start(); ?>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
            <?php
            $code_views = ob_get_contents();
            ob_end_flush();
            ?>
        </div>
        <?php echo _display_code_view('codewrap11', $code_views); ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Text</h3>
        <div class='bd-example'>
            <?php ob_start(); ?>
            <div class="dropdown-menu p-4 text-muted" style="max-width: 200px;">
                <p>
                    Some example text that's free-flowing within the dropdown menu.
                </p>
                <p class="mb-0">
                    And this is more example text.
                </p>
            </div>
            <?php
            $code_views = ob_get_contents();
            ob_end_flush();
            ?>
        </div>
        <?php echo _display_code_view('codewrap12', $code_views); ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Forms</h3>
        <div class='bd-example'>
            <?php ob_start(); ?>
            <div class="dropdown-menu">
                <form class="px-4 py-3">
                    <div class="form-group">
                        <label for="exampleDropdownFormEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="exampleDropdownFormPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="dropdownCheck">
                            <label class="form-check-label" for="dropdownCheck">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">New around here? Sign up</a>
                <a class="dropdown-item" href="#">Forgot password?</a>
            </div>
            <?php
            $code_views1 = ob_get_contents();
            ob_end_flush();
            ?>
        </div>
        <div class='bd-example'>
            <?php ob_start(); ?>
            <div class="dropdown-menu">
                <form class="px-4 py-3">
                    <div class="form-group">
                        <label for="exampleDropdownFormEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleDropdownFormEmail1" placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="exampleDropdownFormPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="dropdownCheck">
                            <label class="form-check-label" for="dropdownCheck">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">New around here? Sign up</a>
                <a class="dropdown-item" href="#">Forgot password?</a>
            </div>

            <?php
            $code_views2 = ob_get_contents();
            ob_end_flush();
            ?>
        </div>
        <?php echo _display_code_view('codewrap13', $code_views1 . $code_views2); ?>
    </div>
    <div class='contents-section-body'>
        <h3 class='body-title'>Dropdown options</h3>
        <div class='bd-example'>
            <?php ob_start(); ?>
            <div class="d-flex">
                <div class="dropdown mr-1">
                    <button type="button" class="btn btn-secondary dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">
                        Offset
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary">Reference</button>
                    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div>
            </div>
            <?php
            $code_views = ob_get_contents();
            ob_end_flush();
            ?>
        </div>
        <?php echo _display_code_view('codewrap14', $code_views); ?>
    </div>


</section>
<div class="divider primary"><em></em></div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
