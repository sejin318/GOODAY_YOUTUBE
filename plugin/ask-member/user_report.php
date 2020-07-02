<?php
include_once "./_common.php";
if (!$is_member) {
    alert_close('로그인 후 이용하세요.');
}

//게시물 신고
if ($bo_table && $wr_id) {
    $write = ASKDB::get_article_info(Asktools::filter($bo_table), Asktools::filter($wr_id));
    $subject = cut_str(strip_tags($write['wr_subject']), 30);
    $dest_mb_id = $write['mb_id'];
    if ($member['mb_id'] == $write['mb_id']) {
        alert_close('본인의 게시물을 신고 할 수 없습니다.');
        exit;
    }
    //이미 신고했나?
    $check = ASKDB::check_board_report(Asktools::filter($bo_table), Asktools::filter($wr_id));
    if ($check) {
        alert_close('이미 신고한 게시물을 신고 할 수 없습니다.');
        exit;
    }
}
//쪽지 신고
if ($me_id) {
    $memo = ASKDB::get_memo_info(Asktools::filter($me_id));
    $dest_mb_id = $memo['me_send_mb_id'];
    $subject = cut_str(strip_tags($memo['me_memo']), 30);
    //이미 신고했나?
    $check = ASKDB::check_memo_report($me_id);
    if ($check) {
        alert_close('이 쪽지는 회원님이 이미 신고하였습니다');
        exit;
    }
}


$check_admin = is_admin($dest_mb_id);
if ($check_admin == 'super') {
    alert_close('관리자는 신고 할 수 없습니다.');
    exit;
}

include_once G5_THEME_PATH . '/head.sub.php';
?>
<script type="text/javascript">
    $(function() {
        $('.close_window').click(function() {
            window.close();
        });
        $('input[name=reason').click(function() {
            if ($('input[name=reason]').is(':checked') === true && $('input[name=reason]:checked').val() === '기타') {
                $('textarea[name=detail_reason]').prop('disabled', false);
            } else {
                $('textarea[name=detail_reason]').prop('disabled', true);
            }
        });
        $('.form_submit').click(function() {
            if ($('input[name=reason]').is(':checked') === false) {
                alert('신고사유를 선택하세요.');
                return false;
            }
            if ($('input[name=reason]:checked').val() === '기타') {
                if ($('textarea[name=detail_reason]').val() === '') {
                    alert('기타 사유를 입력하세요.');
                    return false;
                }
            }

            $('.form').submit();
        });
    });
</script>
<nav class="navbar navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">신고하기</a>
</nav>
<div class="container mt-5 pt-3">
    <div class='row' id='report'>
        <div class='col-sm-12 col-md-12'>
            <div class='contents-box'>
                <div class='alert alert-info'>
                    · 신고는 반대 의견을 표시하는 기능이 아닙니다. <br />
                    · 신고 대신 반대 의견을 적어 보시는 것은 어떨까요?<br />
                    · 다른 의견에 대한 경청과 예의를 갖춘 토론이 댓글을 더 가치있게 합니다.
                </div>
                <form action='./user_report.update.php' method="post" class="form">
                    <input type="hidden" name='reporter_id' value="<?php echo $member['mb_id'] ?>">
                    <input type="hidden" name='mb_id' value="<?php echo $dest_mb_id; ?>">
                    <?php if ($bo_table && $wr_id) { ?>
                        <input type="hidden" name='bo_table' value="<?php echo $bo_table ?>">
                        <input type="hidden" name='wr_id' value="<?php echo $wr_id ?>">
                    <?php } ?>
                    <?php if ($me_id) { ?>
                        <input type="hidden" name='me_id' value="<?php echo $me_id ?>">
                        <input type="hidden" name='memo' value="<?php echo $subject ?>">
                    <?php } ?>

                    <h4 class='page-title pb-3'>신고대상 : <?php echo $subject ?></h4>
                    <h5 class="border p-2 mt-3 border-color-6"><i class="fa fa-question-circle" aria-hidden="true"></i> 신고사유</h5>
                    <div class='form-group p-2'>
                        <div class="radio">
                            <label><input type="radio" name="reason" value="스팸">스팸</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="reason" value="홍보/영업">홍보/영업</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="reason" value="욕설/인신공격">욕설/인신공격</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="reason" value="개인정보보호">개인정보보호</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="reason" value="음란성/선정성">음란성/선정성</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="reason" value="명예회손/저작권">명예회손/저작권</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="reason" value="같은 내용의 반복 게시 (도배)">같은 내용의 반복 게시 (도배)</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="reason" value="기타">기타</label>
                        </div>
                        <textarea name='detail_reason' rows="5" class='form-control' placeholder="기타 사유를 입력하세요" disabled></textarea>
                    </div>

                    <div class='alert alert-danger'>
                        · 허위신고일 경우, 신고자의 <?php echo $config['cf_title'] ?> 이용이 제한될 수 있으니 신중하게 신고해 주세요.
                    </div>
                    <div class='form-action'>
                        <div class='pull-left'>
                            <button type="button" class='btn btn-danger close_window'>취소</button>
                        </div>
                        <div class='pull-right'>
                            <button type="submit" class='btn btn-primary form_submit'>신고하기</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<?php
include_once G5_THEME_PATH . '/tail.sub.php';
