<?php

/**
 * memo_form.skin.php
 * 쪽지쓰기
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

include_once G5_THEME_PATH . "/head.php";
run_event('마이페이지메뉴', '마이페이지메뉴');

?>

<!-- 쪽지 보내기 시작 { -->
<div class="memo-wrap">
    <h2 class='page-title p-2 mb-3'>
        <?php echo $g5['title'] ?>
    </h2>
    <div class="memo">
        <ul class="nav nav-tabs mb-2">
            <li class="nav-item"><a href="./memo.php?kind=recv" class='nav-link'>받은쪽지</a></li>
            <li class="nav-item"><a href="./memo.php?kind=send" class='nav-link'>보낸쪽지</a></li>
            <li class="nav-item"><a href="./memo_form.php" class='nav-link active'>쪽지쓰기</a></li>
        </ul>
        <form name="fmemoform" action="<?php echo $memo_action_url; ?>" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
            <div class="memo-form">
                <h2 class="sr-only">쪽지쓰기</h2>

                <div class="form-group">
                  <?php
                  echo $member['mb_id'] != "admin" ?
                  "<input type='text' name='null_name' value='최고관리자에게 발송됩니다.' id='null_id' required class='form-control required' disabled >
                  <input type='text' name='me_recv_mb_id' value='admin' id='me_recv_mb_id' required class='form-control required' hidden >" :
                  "<input type='text' name='me_recv_mb_id' value='{$me_recv_mb_id}' id='me_recv_mb_id' required class='form-control required' placeholder='받는 회원아이디' >"
                   ?>
                  <!-- <input type="text" name="null_name" value="최고관리자에게 발송됩니다." id="null_id" required class="form-control required" disabled >
                  <input type="text" name="me_recv_mb_id" value="admin" id="me_recv_mb_id" required class="form-control required" hidden > -->
                  <?php
                  // print_r($g5);
                  // print_r($member['mb_id']);
                  ?>

                  <!-- <input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id; ?>" id="me_recv_mb_id" required class="form-control required" placeholder="받는 회원아이디" > -->
                </div>
                <!-- <input type="text" name="me_recv_mb_id" value="admin" id="me_recv_mb_id" required class="form-control required" placeholder="쪽지는 관리자에게 발송됩니다." readonly> -->

                <div class="alert alert-info alert-sm">여러 회원에게 보낼때는 컴마(,)로 구분하세요.
                    <?php if ($config['cf_memo_send_point']) { ?>
                        <br />쪽지 보낼때 회원당 <?php echo number_format($config['cf_memo_send_point']); ?>점의 포인트를 차감합니다.
                    <?php } ?>
                </div>
                <div class="form-group">
                    <textarea name="me_memo" id="me_memo" required rows="10" class="form-control required" placeholder="내용입력"><?php echo $content ?></textarea>
                </div>
                <div class="form-group">
                    <span class="sr-only">자동등록방지</span>
                    <?php echo captcha_html(); ?>
                </div>
            </div>

            <div class="form-action d-flex">
                <button type="submit" id="btn_submit" class="btn btn-primary mr-auto">보내기</button>
                <a href='./memo.php' class="btn btn-danger">취소</a>
            </div>
    </div>
    </form>
</div>

<script>
    function fmemoform_submit(f) {
        <?php echo chk_captcha_js();  ?>

        return true;
    }
</script>
<!-- } 쪽지 보내기 끝 -->

<?php
include_once G5_THEME_PATH . "/tail.php";
