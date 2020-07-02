<?php

/**
 * outlogin.skin.1.php
 * 소셜 로그인 스킨
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 * 
 * 아웃로그인 - 로그인
 */

if (!defined("_GNUBOARD_")) {
    exit; // 개별 페이지 접근 불가
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/outlogin/outlogin.basic.css\">", 50);

?>

<!-- 로그인 전 아웃로그인 시작 { -->
<section class='outlogin-mobile-basic-wrap border shadow-sm background-9'>
    <h2 class="sr-only">회원 로그인</h2>
    <div class="p-2">
        <form name="foutlogin" action="<?php echo $outlogin_action_url ?>" onsubmit="return fhead_submit(this);" method="post" autocomplete="off">
            <input type="hidden" name="url" value="<?php echo $outlogin_url ?>">
            <div class="form-group form-subject">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">ID</span>
                    </div>
                    <input type="text" class='form-control' name="mb_id" required maxlength="20" placeholder="아이디">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">PW</span>
                    </div>
                    <input type="password" name="mb_password" class='form-control' required maxlength="20" placeholder="비밀번호">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <input type="checkbox" name="auto_login" value="1" id="auto_login-mobile" class="fomr-check-input">
                            <label class="form-check-label" for="auto_login-mobile"> Auto</label>
                        </span>
                    </div>
                    <input type="submit" value="로그인" class="form-control btn btn-info">
                </div>
            </div>
            <div class="outlogin-menu btn-navbar mt-2 mb-2 text-center">
                <a href="<?php echo G5_BBS_URL ?>/password_lost.php" id="ol_password_lost" class="btn btn-sm"><i class="fa fa-user-circle" aria-hidden="true"></i> 정보찾기</a>
                <a href="<?php echo G5_BBS_URL ?>/register.php" class="btn btn-sm"><i class="fa fa-sign-in" aria-hidden="true"></i> 회원가입</a>
            </div>
            <?php
            // 소셜로그인 사용시 소셜로그인 버튼
            include get_social_skin_path() . '/social_outlogin.skin.1.php';
            ?>
        </form>
    </div>
</section>
<script>
    jQuery(function($) {
        $("#auto_login-mobile").click(function() {
            if ($(this).is(":checked")) {
                if (!confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?"))
                    return false;
            }
        });
    });

    function fhead_submit(f) {
        if ($(document.body).triggerHandler('outlogin1', [f, 'foutlogin']) !== false) {
            return true;
        }
        return false;
    }
</script>
<!-- } 로그인 전 아웃로그인 끝 -->