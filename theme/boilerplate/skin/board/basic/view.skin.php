<?php

/**
 * Boilerplate.kr
 * Basic 게시판 보기
 */
if (!defined("_GNUBOARD_")) {
    exit; // 개별 페이지 접근 불가
}
//board uploader 환경설정
include_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'config.inc.php';
include_once G5_LIB_PATH . '/thumbnail.lib.php';
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/boards/board.basic.css">', 30);
if ($board['bb_use_font']) {
    add_stylesheet('<link href="https://fonts.googleapis.com/css?family=Black+And+White+Picture|Black+Han+Sans|Cute+Font|Do+Hyeon|Dokdo|East+Sea+Dokdo|Gaegu|Gamja+Flower|Gugi|Hi+Melody|Jua|Kirang+Haerang|Nanum+Gothic|Nanum+Myeongjo|Nanum+Pen+Script|Noto+Sans+KR:400,700|Poor+Story|Single+Day|Song+Myung|Stylish|Sunflower:300|Yeon+Sung&display=swap&subset=korean" rel="stylesheet">', 200);
}
?>

<?php run_event('게시판내용상단', '게시판내용상단'); ?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->
<article class='board-view-wrap'>
    <h1 class='board-title'><?php echo $board['bo_subject']; ?></h1>
    <header class='bv-header mb-3'>
        <h6 class='bv-title'>
            <?php if ($category_name) { ?>
                <span class="bv-category">
                    <?php echo $view['ca_name']; ?>
                </span>
            <?php } ?>
            <?php
            if ($view['wr_1'] && $board['bb_use_font']) {
                $use_font = $view['wr_1'];
            }
            ?>

            <span class="bv-subject <?php echo $use_font ?>">
                <?php echo get_text($view['wr_subject']); ?>
            </span>
        </h6>
    </header>

    <section class='bv-info mb-5'>
        <h2 class='sr-only'>페이지 정보</h2>
        <div class="profile-info d-flex mb-2">
            <!-- <div class="profile-img mr-1"><?php echo get_member_profile_img($view['mb_id']) ?></div> -->
            <div class="profile-comment text-break">
                <span class="sr-only">작성자</span>
                <?php echo $view['name'] ?>
                <?php
                if ($is_ip_view) {
                    echo "<span class='d-none d-md-inline'> ($ip)</span>";
                } ?>
                <div class='d-block d-sm-none'></div>
                <span class="sr-only">댓글</span><a href="#bo_vc"> <i class="fa fa-commenting-o" aria-hidden="true"></i> <?php echo number_format($view['wr_comment']) ?>건</a>
                <span class="sr-only">조회</span><i class="fa fa-eye" aria-hidden="true"></i> <?php echo number_format($view['wr_hit']) ?>회
                <span class="sr-only">작성일</span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?>
            </div>
        </div>
        <!--//.profile-info -->

        <!-- 회원메모 -->
        <?php include_once G5_PLUGIN_PATH . '/ask-member/user_memo.inc.php'; ?>


        <!-- 게시물 상단 버튼 시작 { -->
        <div class='bv-buttons btn-toolbar' role="toolbar" aria-label="Board View Buttons">
            <div class='sns-share btn-group btn-group-sm mr-1'>
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sns-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-share-alt" aria-hidden="true"></i> <span class='hide-sm'>공유</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="sns-dropdown">
                    <?php include_once G5_SNS_PATH . "/view.sns.skin.php"; ?>
                    <?php if ($scrap_href) { ?>
                        <a href="<?php echo $scrap_href;  ?>" target="_blank" class="dropdown-item" onclick="win_scrap(this.href); return false;"><i class="fa fa-bookmark" aria-hidden="true"></i> 스크랩</a>
                    <?php } ?>
                </div>
            </div>
            <?php ob_start(); ?>
            <div class='btn-group btn-group-sm ml-auto d-none d-md-flex'>

                <?php if ($prev_href) { ?>
                    <a href="<?php echo $prev_href ?>" class='btn btn-outline-info'><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                <?php } ?>
                <?php if ($next_href) { ?>
                    <a href="<?php echo $next_href ?>" class='btn btn-outline-info'><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                <?php } ?>
                <a href="<?php echo $list_href ?>" class="btn btn-outline-secondary mr-1" title="목록"><i class="fa fa-list" aria-hidden="true"></i><span class='hide-sm'> 목록</span></a>
                <?php if ($reply_href) { ?>
                    <a href="<?php echo $reply_href ?>" class="btn btn-outline-secondary mr-1" title="답변"><i class="fa fa-reply" aria-hidden="true"></i><span class='hide-sm'> 답변</span></a>
                <?php } ?>
                <?php if ($write_href) { ?>
                    <a href="<?php echo $write_href ?>" class="btn btn-outline-primary mr-1" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class='hide-sm'> 글쓰기</span></a>
                <?php } ?>

                <?php if ($update_href) { ?>
                    <a href="<?php echo $update_href ?>" class='btn btn-outline-secondary mr-1'><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span class='hide-sm'> 수정</span></a>
                <?php } ?>
                <?php if ($delete_href) { ?>
                    <a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;" class='btn btn-outline-danger mr-1'><i class="fa fa-trash-o" aria-hidden="true"></i><span class='hide-sm'> 삭제</span></a>
                <?php } ?>
                <?php if ($copy_href) { ?>
                    <a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;" class='btn btn-outline-warning mr-1'><i class="fa fa-files-o" aria-hidden="true"></i><span class='hide-sm'> 복사</span></a>
                <?php } ?>
                <?php if ($move_href) { ?>
                    <a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;" class='btn btn-outline-warning mr-1'><i class="fa fa-arrows" aria-hidden="true"></i><span class='hide-sm'> 이동</span></a>
                <?php } ?>
                <?php if ($search_href) { ?>
                    <a href="<?php echo $search_href ?>" class='btn btn-outline-secondary'><i class="fa fa-search" aria-hidden="true"></i> <span class='hide-sm'>검색</span></a>
                <?php } ?>
            </div>
            <?php
            $link_buttons = ob_get_contents();
            ob_end_flush();
            ?>

            <!-- 모바일용 버튼 -->
            <div class='mobile-view-buttons ml-auto d-sm-flex d-md-none'>
                <a href="<?php echo $list_href ?>" class="btn btn-secondary btn-sm mr-1" title="목록"><i class="fa fa-list" aria-hidden="true"></i><span class='hide-sm'> 목록</span></a>
                <?php if ($write_href) { ?>
                    <a href="<?php echo $write_href ?>" class="btn btn-primary btn-sm mr-1" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class='hide-sm'> 글쓰기</span></a>
                <?php } ?>
                <?php if ($write_href || $reply_href || $update_href || $search_href || $delete_href || $move_href) { ?>
                    <button id="mobile-view-menu" type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="mobile-view-menu">
                        <?php if ($reply_href) { ?>
                            <a href="<?php echo $reply_href ?>" class="dropdown-item" title="답변"><i class="fa fa-reply" aria-hidden="true"></i><span class='hide-sm'> 답변</span></a>
                        <?php } ?>

                        <?php if ($update_href) { ?>
                            <a href="<?php echo $update_href ?>" class='dropdown-item'><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span class='hide-sm'> 수정</span></a>
                        <?php } ?>
                        <?php if ($delete_href) { ?>
                            <a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;" class='dropdown-item'><i class="fa fa-trash-o" aria-hidden="true"></i><span class='hide-sm'> 삭제</span></a>
                        <?php } ?>
                        <?php if ($copy_href) { ?>
                            <a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;" class='dropdown-item'><i class="fa fa-files-o" aria-hidden="true"></i><span class='hide-sm'> 복사</span></a>
                        <?php } ?>
                        <?php if ($move_href) { ?>
                            <a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;" class='dropdown-item'><i class="fa fa-arrows" aria-hidden="true"></i><span class='hide-sm'> 이동</span></a>
                        <?php } ?>
                        <?php if ($search_href) { ?>
                            <a href="<?php echo $search_href ?>" class='dropdown-item'><i class="fa fa-search" aria-hidden="true"></i> <span class='hide-sm'>검색</span></a>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
        </div>

        <!-- } 게시물 상단 버튼 끝 -->
    </section>

    <section class='board-contents-wrap mb-5'>
        <h2 class="sr-only">본문</h2>

        <?php
        //기본 업로더 및 gps 미사용
        if ($config['bp_board_uploader'] && $_use_gps === false) {
            // 파일 출력 - 이미지는 태그로 직접 입력된다.
            $v_img_count = count($view['file']);
            if ($v_img_count) {
                echo "<div class='board-image'>\n";

                for ($i = 0; $i <= count($view['file']); $i++) {
                    if ($view['file'][$i]['view']) {
                        //echo $view['file'][$i]['view'];
                        echo get_file_thumbnail($view['file'][$i]);
                    }
                }

                echo "</div>\n";
            }
        } else if ($config['bp_board_uploader'] && $_use_gps === true) {
            include_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'image_gps_view.inc.php';
        }

        ?>

        <!-- 본문 내용 시작 { -->
        <div class='board-contents'>
            <?php

            if ($config['bp_board_uploader'] == 'ask-uploader') {
                $video_viewer_path = G5_PLUGIN_PATH . DIRECTORY_SEPARATOR . "ask-uploader" . DIRECTORY_SEPARATOR . "askupload-video.php";
                if (file_exists($video_viewer_path)) {
                    include_once $video_viewer_path;
                }
            }
            //본문 출력
            echo bp_get_view_thumbnail($view['content']);
            ?>
        </div>
        <?php
        if ($board['bb_list_skin'] == '_list.youtube.inc.php' && $view['link'][2]) {
            //유튜브 플레이어
            include_once $board_skin_path . DIRECTORY_SEPARATOR . '_youtube_view.inc.php';
        }
        ?>

        <?php if ($view['link']) { ?>
            <div class='mt-2 mb-2 link-contents-wrap'>
                <?php
                //느림 캐싱할것
                if ($view['link'][1]) {
                    echo "<div class='pt-2 pb-2'> " . $embera->autoEmbed($view['link'][1]) . " </div>";
                }
                //youtube 스킨은 링크2번을 사용
                if ($board['bb_list_skin'] != '_list.youtube.inc.php') {
                    if ($view['link'][2]) {
                        echo "<div class='pt-2 pb-2'> " . $embera->autoEmbed($view['link'][2]) . " </div>";
                    }
                }

                ?>
            </div>
        <?php } ?>
        <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우
        ?>
        <!-- } 본문 내용 끝 -->

        <?php if ($is_signature) { ?><p class='alert alert-success mt-5'><i class="fa fa-pencil" aria-hidden="true"></i> <?php echo $signature ?></p><?php } ?>


        <!--  추천 비추천 시작 { -->
        <?php if ($good_href || $nogood_href) { ?>
            <div class='board-action mt-5 mb-5 btn-toolbar justify-content-center'>
                <?php if ($good_href) { ?>
                    <div class='btn-group mr-1'>
                        <a href="<?php echo $good_href . '&amp;' . $qstr ?>" id="good_button" class="btn btn-outline-primary">
                           <?php echo 
                            "<script>
                           $('#good_button').click( function(){window.location.reload();} );
                           $('#nogood_button').click( function(){window.location.reload();} ); 
                           </script>" ?>
                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i><span class='d-none d-md-inline'> 추천</span><?php echo number_format($view['wr_good']) ?>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($nogood_href) { ?>
                    <div class='btn-group'>
                        <a href="<?php echo $nogood_href . '&amp;' . $qstr ?>" id="nogood_button" class="btn btn-outline-danger">
                            <i class="fa fa-thumbs-o-down" aria-hidden="true"></i><span class='d-none d-md-inline'> 비추천</span> <?php echo number_format($view['wr_nogood']) ?>
                        </a>
                    </div>
                <?php } ?>
                <?php echo Asktools::button_board_report($bo_table, $wr_id); ?>
            </div>
            <?php } else {
            if ($board['bo_use_good'] || $board['bo_use_nogood']) { ?>
                <div class='board-action mt-5 mb-5 btn-toolbar justify-content-center'>

                    <?php if ($board['bo_use_good']) { ?>
                        <div class='btn-group mr-1'>
                            <span class="btn btn-secondary"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <span class="sr-only"> 추천</span> <?php echo number_format($view['wr_good']) ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($board['bo_use_nogood']) { ?>
                        <div class='btn-group'>
                            <span class="btn btn-secondary"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> <span class="sr-only"> 비추천</span> <?php echo number_format($view['wr_nogood']) ?></span>
                        </div>
                    <?php } ?>

                </div>
        <?php
            }
        }
        ?>
        <!-- }  추천 비추천 끝 -->
    </section>

    <?php
    $cnt = 0;
    if ($view['file']['count']) {
        for ($i = 0; $i < count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
    ?>

    <?php if ($cnt && !$board['bb_use_download_point']) { ?>
        <!-- 첨부파일 시작 { -->
        <section class='board-attach mb-2'>
            <h2>첨부파일</h2>
            <ul>
                <?php
                // 가변 파일
                for ($i = 0; $i < count($view['file']); $i++) {
                    if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
                ?>
                        <li>
                            <i class="fa fa-folder-open" aria-hidden="true"></i>
                            <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                                <?php echo $view['file'][$i]['source'] ?> <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                            </a>
                            <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드 | DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
                        </li>
                <?php
                    }
                }
                ?>
            </ul>
        </section>
        <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php
    ################################################
    # 첨부파일 개별 포인트 설정 목록 -기본업로더만 지원
    ################################################
    if ($config['bp_board_uploader'] == 'default') {
        include_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'view_point_file.inc.php';
    }
    ?>

    <?php if (isset($view['link'][1]) && $view['link'][1]) { ?>
        <!-- 관련링크 시작 { -->
        <section class='board-links mb-2 text-cut'>
            <h2>관련링크</h2>
            <ul>
                <?php
                // 링크
                $cnt = 0;
                for ($i = 1; $i <= count($view['link']); $i++) {
                    //유튜브 스킨은 #2 패스
                    if ($board['bb_list_skin'] == 'youtube') {
                        if ($i == 2) {
                            continue;
                        }
                    }
                    if ($view['link'][$i]) {
                        $cnt++;
                        $link = cut_str($view['link'][$i], 70);
                ?>
                        <li>
                            <i class="fa fa-link" aria-hidden="true"></i>
                            <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                                <?php echo $link ?>
                            </a>
                            <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
                        </li>
                <?php
                    }
                }
                ?>
            </ul>
        </section>
        <!-- } 관련링크 끝 -->
    <?php } ?>
    <hr />
    <?php if ($prev_href || $next_href) { ?>
        <div class="befor-next-buttons btn-toolbar mb-5">
            <?php if ($prev_href) { ?>
                <div class='btn-group mb-1'>
                    <a href="<?php echo $prev_href ?>" class='btn btn-outline-info'>
                        <i class="fa fa-chevron-up" aria-hidden="true"></i> 이전글
                        <span class="nb_date">(<?php echo str_replace('-', '.', substr($prev_wr_date, '2', '8')); ?>)</span>
                        <?php echo $prev_wr_subject; ?>
                    </a>

                </div>
            <?php } ?>
            <?php if ($next_href) { ?>
                <div class='btn-group mb-1'>
                    <a href="<?php echo $next_href ?>" class='btn btn-outline-info'>
                        <i class="fa fa-chevron-down" aria-hidden="true"></i> 다음글
                        <span class="nb_date">(<?php echo str_replace('-', '.', substr($next_wr_date, '2', '8')); ?>)</span>
                        <?php echo $next_wr_subject; ?>
                    </a>
                </div>

            <?php } ?>
        </div>
    <?php } ?>

    <?php
    // 코멘트 입출력
    include_once G5_BBS_PATH . '/view_comment.php';
    echo "<br>"; 
    echo "<br>"; 
    echo "<br>"; 
    include_once (G5_BBS_PATH.'/list2.php');
    ?>
</article>
<!-- } 게시판 읽기 끝 -->

<script>
    <?php if ($board['bo_download_point'] < 0) { ?>
        $(function() {
            $("a.view_file_download").click(function() {
                if (!g5_is_member) {
                    alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
                    return false;
                }

                var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

                if (confirm(msg)) {
                    var href = $(this).attr("href") + "&js=on";
                    $(this).attr("href", href);

                    return true;
                } else {
                    return false;
                }
            });
        });
    <?php } ?>

    function board_move(href) {
        window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
    }
</script>

<script>
    $(function() {
        $("a.view_image").click(function() {
            window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
            return false;
        });

        // 추천, 비추천
        $("#good_button, #nogood_button").click(function() {
            var $tx;
            if (this.id == "good_button")
                $tx = $("#bo_v_act_good");
            else
                $tx = $("#bo_v_act_nogood");

            excute_good(this.href, $(this), $tx);
            return false;
        });

        // 이미지 리사이즈
        $("#bo_v_atc").viewimageresize();
    });

    function excute_good(href, $el, $tx) {
        $.post(
            href, {
                js: "on"
            },
            function(data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                }

                if (data.count) {
                    $el.find("strong").text(number_format(String(data.count)));
                    if ($tx.attr("id").search("nogood") > -1) {
                        $tx.text("이 글을 비추천하셨습니다.");
                        $tx.fadeIn(200).delay(2500).fadeOut(200);
                    } else {
                        $tx.text("이 글을 추천하셨습니다.");
                        $tx.fadeIn(200).delay(2500).fadeOut(200);
                    }
                }
            }, "json"
        );
    }
</script>
<!-- } 게시글 읽기 끝 -->
<?php run_event('게시판내용하단', '게시판내용하단'); ?>
<hr />
