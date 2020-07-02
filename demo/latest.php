<?php
include_once "./_common.php";

/**
 * DEMO Page
 */
$g5['title'] = "최신글 데모";
include_once(G5_THEME_PATH . '/head.php');
?>
<div class="jumbotron p-4">
    <h1 class="display-5">Boilerplate Theme DEMO</h1>
    <p class="lead">최신글 데모 페이지</p>
    <hr class="my-4">
    <p>궁금한 사항은 질문답변 게시판을 이용해 주세요.</p>
</div>
<section class='latest-sample-section mb-5'>
    <div class='alert alert-info position-relative'>
        <i class="fa fa-info" aria-hidden="true"></i> 리스트형 최신글 - 2열, 모바일 1열
        <div class='code-view-button position-absolute'>
            <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#ex-1code" aria-expanded="true" aria-controls="ex-1code">
                <i class="fa fa-code" aria-hidden="true"></i> code
            </button>
        </div>
        <div class="collapse" id="ex-1code">
            <div class='btn-navbar'>
                <button type='button' data-target='ex-1' class='copy-code btn btn-link pull-right btn-sm'><i class="fa fa-clipboard" aria-hidden="true"></i></button>
            </div>
            <textarea class='code-view alert alert-secondary w-100 ex-1' readonly>&lt;div class=&quot;latest-list row&quot;&gt;
    &lt;div class='col-sm-12 col-md-6'&gt;
        &lt;?php echo latest('theme/basic', '게시판테이블명', 5, 33); ?&gt;
    &lt;/div&gt;
    &lt;div class='col-sm-12 col-md-6'&gt;
        &lt;?php echo latest('theme/basic', '게시판테이블명', 5, 33); ?&gt;
    &lt;/div&gt;
&lt;/div&gt;</textarea>
        </div>
    </div>
    <div class="latest-list row">
        <div class='col-sm-12 col-md-6'>
            <?php echo latest('theme/basic', 'demo_board', 5, 33); ?>
        </div>
        <div class='col-sm-12 col-md-6'>
            <?php echo latest('theme/basic', 'demo_board', 5, 33); ?>
        </div>
    </div>
</section>

<section class='latest-sample-section mb-5'>
    <div class='alert alert-info position-relative'>
        <i class="fa fa-info" aria-hidden="true"></i> 리스트형 최신글 - 2열, 모바일 1열, 흰배경
        <div class='code-view-button position-absolute'>
            <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#ex-2code" aria-expanded="true" aria-controls="ex-2code">
                <i class="fa fa-code" aria-hidden="true"></i> code
            </button>
        </div>
        <div class="collapse" id="ex-2code">
            <div class='btn-navbar'>
                <button type='button' data-target='ex-2' class='copy-code btn btn-link pull-right btn-sm'><i class="fa fa-clipboard" aria-hidden="true"></i></button>
            </div>
            <textarea class='code-view alert alert-secondary w-100 ex-2' readonly>&lt;div class=&quot;latest-list latest-simple row&quot;&gt;
    &lt;div class='col-sm-12 col-md-6'&gt;
        &lt;?php echo latest('theme/basic', '게시판테이블명', 5, 33); ?&gt;
    &lt;/div&gt;
    &lt;div class='col-sm-12 col-md-6'&gt;
        &lt;?php echo latest('theme/basic', '게시판테이블명', 5, 33); ?&gt;
    &lt;/div&gt;
&lt;/div&gt;</textarea>
        </div>
    </div>
    <div class="latest-list latest-simple row">
        <div class='col-sm-12 col-md-6'>
            <?php echo latest('theme/basic', 'demo_board', 5, 33); ?>
        </div>
        <div class='col-sm-12 col-md-6'>
            <?php echo latest('theme/basic', 'demo_board', 5, 33); ?>
        </div>
    </div>
</section>

<section class='latest-sample-section mb-5'>
    <div class='alert alert-info position-relative'>
        <i class="fa fa-info" aria-hidden="true"></i> 리스트형 최신글 - Simple Basic
        <div class='code-view-button position-absolute'>
            <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#ex-3code" aria-expanded="true" aria-controls="ex-3code">
                <i class="fa fa-code" aria-hidden="true"></i> code
            </button>
        </div>
        <div class="collapse" id="ex-3code">
            <div class='btn-navbar'>
                <button type='button' data-target='ex-3' class='copy-code btn btn-link pull-right btn-sm'><i class="fa fa-clipboard" aria-hidden="true"></i></button>
            </div>
            <textarea class='code-view alert alert-secondary w-100 ex-3' readonly>&lt;div class=&quot;latest-list row&quot;&gt;
    &lt;div class='col-sm-12 col-md-6'&gt;
        &lt;?php echo latest('theme/basic-simple', '게시판테이블명', 5, 33); ?&gt;
    &lt;/div&gt;
    &lt;div class='col-sm-12 col-md-6'&gt;
        &lt;?php echo latest('theme/basic-simple', '게시판테이블명', 5, 33); ?&gt;
    &lt;/div&gt;
&lt;/div&gt;</textarea>
        </div>
    </div>
    <div class="latest-list row">
        <div class='col-sm-12 col-md-6'>
            <?php echo latest('theme/basic-simple', 'demo_card', 5, 33); ?>
        </div>
        <div class='col-sm-12 col-md-6'>
            <?php echo latest('theme/basic-simple', 'demo_webzine', 5, 33); ?>
        </div>
    </div>
</section>

<section class='latest-sample-section mb-5'>
    <div class='alert alert-info position-relative'>
        <i class="fa fa-info" aria-hidden="true"></i> 탭형식으로 여러 최신글 출력
        <div class='code-view-button position-absolute'>
            <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#ex-4code" aria-expanded="true" aria-controls="ex-4code">
                <i class="fa fa-code" aria-hidden="true"></i> code
            </button>
        </div>
        <div class="collapse" id="ex-4code">
            <div class='btn-navbar'>
                <button type='button' data-target='ex-4' class='copy-code btn btn-link pull-right btn-sm'><i class="fa fa-clipboard" aria-hidden="true"></i></button>
            </div>
            <textarea class='code-view alert alert-secondary w-100 ex-4' readonly>&lt;div class=&quot;latest-list row&quot;&gt;
    &lt;div class='col-sm-12 col-md-6'&gt;
        &lt;div class='tab-skin-wrap latst-no-title'&gt;
            &lt;?php echo bp_tab_latest('theme/basic-simple', 'bo_table1,bo_table2,bo_table3', 5, 33); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class='col-sm-12 col-md-6'&gt;
        &lt;div class='tab-skin-wrap latst-no-title latest-simple'&gt;
            &lt;?php echo bp_tab_latest('theme/basic', 'bo_table1,bo_table2,bo_table3,bo_table4', 5, 33); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</textarea>
        </div>
    </div>
    <div class="latest-list row">
        <div class='col-sm-12 col-md-6'>
            <div class='tab-skin-wrap latst-no-title'>
                <?php echo bp_tab_latest('theme/basic-simple', 'demo_board,demo_webzine,demo_card', 5, 33); ?>
            </div>
        </div>
        <div class='col-sm-12 col-md-6'>
            <div class='tab-skin-wrap latst-no-title latest-simple'>
                <?php echo bp_tab_latest('theme/basic', 'demo_gallery,gnuboard,etc,qna', 5, 33); ?>
            </div>
        </div>
    </div>
</section>
<?php
include_once(G5_THEME_PATH . '/tail.php');
