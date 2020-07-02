<?php

/**
 * member_confirm.skin.php
 * 비밀번호 확인
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

?>

<!-- 회원 비밀번호 확인 시작 { -->
<div id="mb_confirm" class="member-nohead-wrap">
    <div class="member-confirm-box p-3 shadow-lg">
        <h1 class="title"><?php echo $g5['title'] ?></h1>
        <hr />
        <div class="alert alert-info alert-sm">
            <span class="text">비밀번호를 한번 더 입력해주세요.</span>
            <?php if ($url == 'member_leave.php') { ?>
                비밀번호를 입력하시면 회원탈퇴가 완료됩니다.
            <?php } else { ?>
                회원님의 정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.
            <?php }  ?>
        </div>

        <form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
            <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
            <input type="hidden" name="w" value="u">

            <div class="form-group">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            회원아이디
                        </span>
                    </div>
                    <input class="form-control" value="<?php echo $member['mb_id'] ?>" readonly>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            비밀번호
                        </span>
                    </div>
                    <input type="password" name="mb_password" id="confirm_mb_password" required class="required form-control" size="15" maxLength="20" placeholder="비밀번호">
                </div>
            </div>

            <div class="btn-navbar text-center">
                <input type="submit" value="확인" id="btn_submit" class="btn btn-primary">
                <a href='#goback' class="btn btn-danger goback">취소</a>
            </div>
        </form>

    </div>
</div>
<script>
    function fmemberconfirm_submit(f) {
        document.getElementById("btn_submit").disabled = true;
        return true;
    }
    $(function() {
        $('.goback').click(function() {
            history.back();
        });
    });
</script>
<!-- } 회원 비밀번호 확인 끝 -->