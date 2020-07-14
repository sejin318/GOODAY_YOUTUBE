<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
?>

<script>
    // 글자수 제한
    var char_min = parseInt(<?php echo $comment_min ?>); // 최소
    var char_max = parseInt(<?php echo $comment_max ?>); // 최대
</script>
<button type="button" class="btn btn-outline-secondary">댓글 <?php echo $view['wr_comment']; ?></button>
<!-- 댓글 시작 { -->
<section class='comment-wrap mt-2'>
    <h2>댓글목록</h2>
    <?php
    $cmt_amt = count($list);
    for ($i = 0; $i < $cmt_amt; $i++) {
        $comment_id = $list[$i]['wr_id'];
        $cmt_depth = strlen($list[$i]['wr_comment_reply']) * 20;
        $comment = $list[$i]['content'];
        /*
        if (strstr($list[$i]['wr_option'], "secret")) {
            $str = $str;
        }
        */
        $comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);
        $cmt_sv = $cmt_amt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
        $c_reply_href = $comment_common_url . '&amp;c_id=' . $comment_id . '&amp;w=c#bo_vc_w';
        $c_edit_href = $comment_common_url . '&amp;c_id=' . $comment_id . '&amp;w=cu#bo_vc_w';
    ?>

        <article class='comment-box mb-2' id="c_<?php echo $comment_id ?>" <?php if ($cmt_depth) { ?> style="margin-left:<?php echo $cmt_depth ?>px;border-top-color:#e0e0e0" <?php } ?>>
            <div class="profile-wrap">
                <!-- <div class="profile-img pull-left d-none d-md-block">
                    <?php echo get_member_profile_img($list[$i]['mb_id']); ?>
                </div> -->
                <header class='comments-header pull-left' style="z-index:<?php echo $cmt_sv; ?>">
                    <h2><?php echo get_text($list[$i]['wr_name']); ?>님의 <?php if ($cmt_depth) { ?><span class="sr-only">댓글의</span><?php } ?> 댓글</h2>
                    <div class='wr-info'>
<!--                       edit-->
                        <?php include_once G5_LIB_PATH."/level_icon.lib.php"; echo get_level_icon($list[$i]['mb_id'], 20); ?> <?php echo $list[$i]['name'] ?>                        
                        <?php if ($is_ip_view) { ?>
                            <span class="sr-only">아이피</span>
                            <span>(<?php echo $list[$i]['ip']; ?>)</span>
                        <?php } ?>
                        <span class="sr-only">작성일</span>
                        <span class="bo_vc_hdinfo"><i class="fa fa-clock-o" aria-hidden="true"></i> <time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', strtotime($list[$i]['datetime'])) ?>"><?php echo $list[$i]['datetime'] ?></time></span>
                        <?php include G5_SNS_PATH . '/view_comment_list.sns.skin.php'; ?>
                    </div>
                </header>
                <div class="btn-toolbar pull-right">
                    <div class="btn-group btn-group-sm">
                        <?php if ($config['bp_member_memo'] && $member['mb_id'] && ($list[$i]['mb_id'] != $member['mb_id'])) { ?>
                            <a href="#member-memo" class="btn btn-info btn-sm" onclick="window.open('<?php echo G5_PLUGIN_URL . "/ask-member/user_memo.php?mb_id={$list[$i]['mb_id']}"; ?>','user_memo', 'width=600, height=300');"><i class="fa fa-envelope-open" aria-hidden="true"></i> <span class="d-none d-md-inline">회원메모</span> </a>
                        <?php } ?>
                        <?php echo Asktools::button_board_report($bo_table, $comment_id, true); ?>
                        <?php if ($list[$i]['is_reply']) { ?>
                            <a href="<?php echo $c_reply_href; ?>" onclick="comment_box('<?php echo $comment_id ?>', 'c'); return false;" class='btn btn-outline-secondary'><i class="fa fa-reply" aria-hidden="true"></i> <span class='d-none d-md-inline'>답변</span></a>
                        <?php } ?>
                        <?php if ($list[$i]['is_edit']) { ?>
                            <a href="<?php echo $c_edit_href; ?>" onclick="comment_box('<?php echo $comment_id ?>', 'cu'); return false;" class='btn btn-outline-secondary'><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span class='d-none d-md-inline'>수정</span></a>
                        <?php } ?>
                        <?php if ($list[$i]['is_del']) { ?>
                            <a href="<?php echo $list[$i]['del_link']; ?>" onclick="return comment_delete();" class='btn btn-outline-danger'><i class="fa fa-trash" aria-hidden="true"></i> <span class='d-none d-md-inline'>삭제</span></a>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="cm_wrap">
                <!-- 댓글 출력 -->
                <div class="cmt_contents">
                    <?php if ($config['bp_member_memo'] && $member['mb_id'] && ($list[$i]['mb_id'] != $member['mb_id'])) { ?>
                        <!-- 회원 메모 -->
                        <div class='member-memo-comment-wrap ml-auto text-right'>
                            <?php
                            $comment_memo = DB::get_member_memo($member['mb_id'], Asktools::xss_clean($list[$i]['mb_id']));
                            echo "<span class='badge badge-info member-memo-comment'><i class='fa fa-envelope-open' aria-hidden='true'></i> {$comment_memo['bm_memo']}</span>";
                            ?>
                        </div>
                    <?php } ?>
                    <?php if (strstr($list[$i]['wr_option'], "secret")) { ?><img src="<?php echo $board_skin_url; ?>/img/icon_secret.gif" alt="비밀글"><?php } ?>
                    <?php
                    //board uploader - comment 출력 부분
                    include BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'comment.inc.php';
                    ?>
                    <?php if ($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del']) {

                        if ($w == 'cu') {
                            $sql = " select wr_id, wr_content, mb_id from $write_table where wr_id = '$c_id' and wr_is_comment = '1' ";
                            $cmt = sql_fetch($sql);
                            if (!($is_admin || ($member['mb_id'] == $cmt['mb_id'] && $cmt['mb_id'])))
                                $cmt['wr_content'] = '';
                            $c_wr_content = $cmt['wr_content'];
                        }
                    ?>
                    <?php } ?>
                </div>
                <div id="edit_<?php echo $comment_id ?>" class="bo_vc_w form-wrap"></div><!-- 수정 -->
                <div id="reply_<?php echo $comment_id ?>" class="bo_vc_w form-wrap"></div><!-- 답변 -->

                <input type="hidden" value="<?php echo strstr($list[$i]['wr_option'], "secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
                <textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
            </div>


        </article>
    <?php } ?>
    <?php if ($i == 0) { //댓글이 없다면
    ?><div class='comment-empty'>등록된 댓글이 없습니다.</div><?php } ?>

</section>
<!-- } 댓글 끝 -->

<?php if ($is_comment_write) {
    if ($w == '')
        $w = 'c';
?>
    <!-- 댓글 쓰기 시작 { -->
    <aside id="bo_vc_w" class="comment-form mt-2 mb-2">
        <h2>댓글쓰기</h2>
        <form name="fviewcomment" id="fviewcomment" action="<?php echo $comment_action_url; ?>" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
            <input type="hidden" name="w" value="<?php echo $w ?>" id="w">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
            <input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
            <input type="hidden" name="stx" value="<?php echo $stx ?>">
            <input type="hidden" name="spt" value="<?php echo $spt ?>">
            <input type="hidden" name="page" value="<?php echo $page ?>">
            <input type="hidden" name="is_good" value="">

            <span class="sr-only">내용</span>

            <?php if ($comment_min || $comment_max) { ?><strong id="char_cnt"><span id="char_count"></span>글자</strong><?php } ?>
            <!-- <input type="checkbox" name="wr_secret" value="secret" id="wr_secret" class="selec_chk">
            <label for="wr_secret"><span></span>비밀글</label> -->
            <div class="input-group">
                <textarea id="wr_content" name="wr_content" maxlength="10000" required class="required form-control" title="내용" placeholder="댓글내용을 입력해주세요" <?php if ($comment_min || $comment_max) { ?> onkeyup="check_byte('wr_content', 'char_count');" <?php } ?>><?php echo $c_wr_content; ?></textarea>
                <span class="input-group-append">
                    <button type="submit" id="btn_submit" class="btn btn-primary btn-comment-submit"><i class="fa fa-check-circle" aria-hidden="true"></i> <span>등록</span></button>
                </span>
            </div>

            <?php if ($comment_min || $comment_max) { ?>
                <script>
                    check_byte('wr_content', 'char_count');
                </script>
            <?php } ?>
            <script>
                $(document).on("keyup change", "textarea#wr_content[maxlength]", function() {
                    var str = $(this).val()
                    var mx = parseInt($(this).attr("maxlength"))
                    if (str.length > mx) {
                        $(this).val(str.substr(0, mx));
                        return false;
                    }
                });
            </script>
            <div class="guest-write-info">
                <div class="bo_vc_w_info">
                    <?php if ($is_guest) { ?>
                        <div class="input-group mt-1">
                            <span class='input-group-prepend'>
                                <label for="wr_name" class="sr-only">이름<strong> 필수</strong></label>
                            </span>
                            <input type="text" name="wr_name" value="<?php echo get_cookie("ck_sns_name"); ?>" id="wr_name" required class="form-control required" size="25" placeholder="이름">
                            <span class='input-group-append'>
                                <label for="wr_password" class="sr-only">비밀번호<strong> 필수</strong></label>
                            </span>
                            <input type="password" name="wr_password" id="wr_password" required class="form-control required" size="25" placeholder="비밀번호">
                        </div>
                    <?php } ?>
                    <?php if ($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>
                        <span class="sr-only">SNS 동시등록</span>
                        <span id="bo_vc_send_sns"></span>
                    <?php } ?>
                    <?php if ($is_guest) { ?>
                        <?php echo $captcha_html; ?>
                    <?php } ?>
                </div>
                <?php
                //board uploader - 업로더 출력
                include_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'comment_uploader.inc.php';
                ?>
            </div>
        </form>
    </aside>

    <?php
    //board uploader - 스크립트 출력
    include_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'comment_script.inc.php';
    ?>
<?php } ?>
<!-- } 댓글 쓰기 끝 -->
