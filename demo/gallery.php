<?php
include_once "./_common.php";

/**
 * DEMO Page
 */
$g5['title'] = "최신글 갤러리 데모";
include_once(G5_THEME_PATH . '/head.php');
?>
<div class="jumbotron p-4">
    <h1 class="display-5">Boilerplate Theme DEMO</h1>
    <p class="lead">Gallery 최신글 데모 페이지</p>
    <hr class="my-4">
    <p>궁금한 사항은 질문답변 게시판을 이용해 주세요.</p>
</div>
<div class="latest-list row">
    <div class='col-sm-12 '>
        <section class='latest-sample-section mb-5'>
            <div class='alert alert-info position-relative'>
                <i class="fa fa-info" aria-hidden="true"></i> 기본 갤러리 최신글 - 기본 6개 출력
                <div class='code-view-button position-absolute'>
                    <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#ex-1code" aria-expanded="true" aria-controls="ex-1code">
                        <i class="fa fa-code" aria-hidden="true"></i> code
                    </button>
                </div>
                <div class="collapse" id="ex-1code">
                    <div class='btn-navbar'>
                        <button type='button' data-target='ex-1' class='copy-code btn btn-link pull-right btn-sm'><i class="fa fa-clipboard" aria-hidden="true"></i></button>
                    </div>
                    <textarea class='code-view alert alert-secondary w-100 ex-1' readonly>&lt;div class=&quot;sample-wrap&quot;&gt;
    &lt;h2&gt;기본 갤러리 최신글&lt;/h2&gt;
    &lt;?php echo latest('theme/gallery', 'bo_table_name', 6, 30); ?&gt;
&lt;/div&gt;</textarea>
                </div>
            </div>
            <!-- 기본 -->
            <div class="sample-wrap">
                <?php echo latest('theme/gallery', 'demo_gallery', 6, 30); ?>
            </div>
        </section>
        <section class='latest-sample-section mb-5'>
            <div class='alert alert-info'>
                <i class="fa fa-info" aria-hidden="true"></i> 작성자 숨기기
                <div class='code-view-button position-absolute'>
                    <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#ex-2code" aria-expanded="true" aria-controls="ex-2code">
                        <i class="fa fa-code" aria-hidden="true"></i> code
                    </button>
                </div>
                <div class="collapse" id="ex-2code">
                    <div class='btn-navbar'>
                        <button type='button' data-target='ex-2' class='copy-code btn btn-link pull-right btn-sm'><i class="fa fa-clipboard" aria-hidden="true"></i></button>
                    </div>
                    <textarea class='code-view alert alert-secondary w-100 ex-2' readonly>&lt;div class=&quot;sample-wrap mb-4 latest-no-writer&quot;&gt;
    &lt;?php echo latest('theme/gallery', 'bo_table_name', 6, 30); ?&gt;
&lt;/div&gt;</textarea>
                </div>
            </div>
            <!-- 작성자 지우기 -->
            <div class="sample-wrap latest-no-writer">
                <?php echo latest('theme/gallery', 'demo_gallery', 6, 30); ?>
            </div>
        </section>

        <section class='latest-sample-section mb-5'>
            <div class='alert alert-info'>
                <i class="fa fa-info" aria-hidden="true"></i> 간격 없애기, 제목, 작성자 숨기기
                <div class='code-view-button position-absolute'>
                    <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#ex-3code" aria-expanded="true" aria-controls="ex-3code">
                        <i class="fa fa-code" aria-hidden="true"></i> code
                    </button>
                </div>
                <div class="collapse" id="ex-3code">
                    <div class='btn-navbar'>
                        <button type='button' data-target='ex-3' class='copy-code btn btn-link pull-right btn-sm'><i class="fa fa-clipboard" aria-hidden="true"></i></button>
                    </div>
                    <textarea class='code-view alert alert-secondary w-100 ex-3' readonly>&lt;div class=&quot;latest-no-gutters latest-no-writer latest-no-subject&quot;&gt;
    &lt;?php echo latest('theme/gallery', 'bo_table_name', 6, 30); ?&gt;
&lt;/div&gt;</textarea>
                </div>
            </div>
            <!-- 간격, 작성자, 제목 없애기 -->
            <div class="sample-wrap latest-no-gutters latest-no-writer latest-no-subject">
                <?php echo latest('theme/gallery', 'demo_gallery', 6, 30); ?>
            </div>
        </section>

        <section class='latest-sample-section mb-5'>
            <div class='alert alert-info pr-5'>
                <i class="fa fa-info" aria-hidden="true"></i> 간격 없애기, 제목, 작성자 숨기기 및 테두리 사용, 모바일도 목록으로만 출력
                <div class='code-view-button position-absolute'>
                    <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#ex-4code" aria-expanded="true" aria-controls="ex-4code">
                        <i class="fa fa-code" aria-hidden="true"></i> code
                    </button>
                </div>
                <div class="collapse" id="ex-4code">
                    <div class='btn-navbar'>
                        <button type='button' data-target='ex-4' class='copy-code btn btn-link pull-right btn-sm'><i class="fa fa-clipboard" aria-hidden="true"></i></button>
                    </div>
                    <textarea class='code-view alert alert-secondary w-100 ex-4' readonly>&lt;div class=&quot;border pt-0 pl-2 pr-2 pb-2 latest-no-gutters latest-no-writer latest-no-subject list-view-only&quot;&gt;
    &lt;?php echo latest('theme/gallery', 'bo_table_name', 6, 30); ?&gt;
&lt;/div&gt;</textarea>
                </div>
            </div>
            <!-- 간격, 작성자, 제목 없애기, 태두리 넣기 -->
            <div class="border pt-0 pl-2 pr-2 pb-2 latest-no-gutters latest-no-writer latest-no-subject list-view-only">
                <?php echo latest('theme/gallery', 'demo_card', 6, 30); ?>
            </div>
        </section>


        <section class='latest-sample-section mb-5'>
            <div class='alert alert-info pr-5'>
                <i class="fa fa-info" aria-hidden="true"></i> 2열 배치, 게시물 수는 2, 4 등 2의 배수로 사용
                <div class='code-view-button position-absolute'>
                    <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#ex-5code" aria-expanded="true" aria-controls="ex-5code">
                        <i class="fa fa-code" aria-hidden="true"></i> code
                    </button>
                </div>
                <div class="collapse" id="ex-5code">
                    <div class='btn-navbar'>
                        <button type='button' data-target='ex-5' class='copy-code btn btn-link pull-right btn-sm'><i class="fa fa-clipboard" aria-hidden="true"></i></button>
                    </div>
                    <textarea class='code-view alert alert-secondary w-100 ex-5' readonly>&lt;div class=&quot;row row-2&quot;&gt;
    &lt;div class='col-sm-12 col-md-6'&gt;
        &lt;div class=&quot;pt-0 pl-2 pr-2 pb-2 latest-no-writer&quot;&gt;
            &lt;?php echo latest('theme/gallery', '게시판테이블명', 4, 30); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
    &lt;div class='col-sm-12 col-md-6'&gt;
        &lt;div class=&quot;pt-0 pl-2 pr-2 pb-2 latest-no-writer&quot;&gt;
            &lt;?php echo latest('theme/gallery', '게시판테이블명', 4, 30); ?&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</textarea>
                </div>
            </div>
            <div class="row row-2">
                <div class='col-sm-12 col-md-6'>
                    <div class="pt-0 pl-2 pr-2 pb-2 latest-no-writer">
                        <?php echo latest('theme/gallery', 'demo_webzine', 4, 30); ?>
                    </div>
                </div>
                <div class='col-sm-12 col-md-6'>
                    <div class="pt-0 pl-2 pr-2 pb-2 latest-no-writer">
                        <?php echo latest('theme/gallery', 'demo_card', 4, 30); ?>
                    </div>
                </div>
            </div>
        </section>


    </div>
</div>

<?php
include_once(G5_THEME_PATH . '/tail.php');
