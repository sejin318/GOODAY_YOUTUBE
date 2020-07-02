<?php
if (!defined("_GNUBOARD_")) {
    exit; // 개별 페이지 접근 불가
}
include_once(G5_LIB_PATH . '/thumbnail.lib.php');
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/qna/qna.basic.css">', 50);

?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->

<article id="bo_v" class='qa-view-wrap'>
    <header>
        <h2 id="bo_v_title" class='page-title p-2 mb-2 border-color-6 border-bottom'>
            <?php
            echo '<span class="bo_v_cate">' . $view['category'] . '</span> '; // 분류 출력 끝

            echo $view['subject']; // 글제목 출력
            ?>
        </h2>
    </header>

    <section id="bo_v_info">
        <h2 class="sr-only">페이지 정보</h2>
        <span class="sr-only">작성자</span><span><?php echo $view['name'] ?></span>
        <span class="sr-only">작성일</span><span class="bo_date"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $view['datetime']; ?></span>
        <?php if ($view['email'] || $view['hp']) { ?>
            <?php if ($view['email']) { ?>
                <span class="sr-only">이메일</span>
                <span><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $view['email']; ?></span>
            <?php } ?>
            <?php if ($view['hp']) { ?>
                <span class="sr-only">휴대폰</span>
                <span><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $view['hp']; ?></span>
            <?php } ?>
        <?php } ?>

        <!-- 게시물 상단 버튼 시작 { -->
        <div id="bo_v_top" class='btn-navbar text-right'>
            <?php ob_start(); ?>

            <div class="btn-group">
                <a href="<?php echo $list_href ?>" class="btn btn-secondary mr-1" title="목록"><i class="fa fa-list" aria-hidden="true"></i><span class="sr-only">목록</span></a>
                <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn btn-primary mr-1" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a><?php } ?>
                <?php if ($update_href || $delete_href) { ?>
                    <?php if ($update_href) { ?><a href="<?php echo $update_href ?>" class="btn btn-info mr-1" title="수정"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 수정</a><?php } ?>
                    <?php if ($delete_href) { ?><a href="<?php echo $delete_href ?>" class="btn btn-danger" onclick="del(this.href); return false;" title="삭제"> <i class="fa fa-trash-o" aria-hidden="true"></i> 삭제</a><?php } ?>
                <?php } ?>
            </div>
            <script>
                // 게시판 리스트 옵션
                $(".btn_more_opt").on("click", function() {
                    $(".more_opt").toggle();
                })
            </script>
            <?php
            $link_buttons = ob_get_contents();
            ob_end_flush();
            ?>
        </div>
        <!-- } 게시물 상단 버튼 끝 -->
    </section>

    <section id="bo_v_atc" class="qa-content-wrap mt-3 mb-3 ">
        <h2 id="bo_v_atc_title" class='sr-only'>본문</h2>

        <?php
        // 파일 출력
        if ($view['img_count']) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i = 0; $i < $view['img_count']; $i++) {
                //echo $view['img_file'][$i];
                echo get_view_thumbnail($view['img_file'][$i], $qaconfig['qa_image_width']);
            }

            echo "</div>\n";
        }
        ?>

        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con" class='qa-content border border-color-6 pt-4 p-3 background-7'><?php echo get_view_thumbnail($view['content'], $qaconfig['qa_image_width']); ?></div>
        <hr />
        <!-- } 본문 내용 끝 -->

        <?php if ($view['qa_type']) { ?>
            <div id="bo_v_addq"><a href="<?php echo $rewrite_href; ?>" class="btn_b01">추가질문</a></div>
        <?php } ?>

        <?php if ($view['download_count']) { ?>

            <!-- 첨부파일 시작 { -->
            <section id="bo_v_file">
                <h2>첨부파일</h2>
                <ul>
                    <?php
                    // 가변 파일
                    for ($i = 0; $i < $view['download_count']; $i++) {
                    ?>
                        <li>
                            <i class="fa fa-download" aria-hidden="true"></i>
                            <a href="<?php echo $view['download_href'][$i];  ?>" class="view_file_download">
                                <strong><?php echo $view['download_source'][$i] ?></strong>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </section>
            <!-- } 첨부파일 끝 -->
        <?php } ?>
    </section>

    <?php if ($prev_href || $next_href) { ?>
        <div class="btn-navbar pt-2 pb-2 text-right">
            <?php if ($prev_href) { ?><a href="<?php echo $prev_href ?>" class="btn btn-secondary"><i class="fa fa-chevron-left" aria-hidden="true"></i> 이전글</a><?php } ?>
            <?php if ($next_href) { ?><a href="<?php echo $next_href ?>" class="btn btn-secondary">다음글 <i class="fa fa-chevron-right" aria-hidden="true"></i></i></a><?php } ?>
        </div>
    <?php } ?>

    <?php
    // 질문글에서 답변이 있으면 답변 출력, 답변이 없고 관리자이면 답변등록폼 출력
    if (!$view['qa_type']) {
        if ($view['qa_status'] && $answer['qa_id'])
            include_once($qa_skin_path . '/view.answer.skin.php');
        else
            include_once($qa_skin_path . '/view.answerform.skin.php');
    }
    ?>

    <?php if ($view['rel_count']) { ?>
        <section id="bo_v_rel">
            <h2 class="sr-only">연관질문</h2>

            <div class="table-wrap">
                <table class='table'>
                    <thead class="table-dark">
                        <tr>
                            <th>제목</th>
                            <th>등록일</th>
                            <th>상태</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < $view['rel_count']; $i++) {
                        ?>
                            <tr>
                                <td>
                                    <span class="bo_cate_link"><?php echo get_text($rel_list[$i]['category']); ?></span>
                                    <a href="<?php echo $rel_list[$i]['view_href']; ?>" class="bo_tit">
                                        <?php echo $rel_list[$i]['subject']; ?>
                                    </a>
                                </td>
                                <td class="td_date"><?php echo $rel_list[$i]['date']; ?></td>
                                <td class="td_stat"><span class="<?php echo ($rel_list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($rel_list[$i]['qa_status'] ? '<i class="fa fa-check-circle" aria-hidden="true"></i> 답변완료' : '<i class="fa fa-times-circle" aria-hidden="true"></i> 답변대기'); ?></span></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php } ?>



</article>
<!-- } 게시판 읽기 끝 -->

<script>
    $(function() {
        $("a.view_image").click(function() {
            window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
            return false;
        });

        // 이미지 리사이즈
        $("#bo_v_atc").viewimageresize();
    });
</script>