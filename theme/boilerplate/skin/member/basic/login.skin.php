<?php

/**
 * login.skin.php
 * 회원 로그인 스킨
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit; // 개별 페이지 접근 불가
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

?>

<div class='container'>
    <!-- 로그인 시작 { -->
    <div id="mb_login" class="login-wrap row">
        <h1 class="sr-only"><?php echo $g5['title'] ?></h1>
        <div class="member-login-box shadow p-3">
            <div class="login-header">
                <h2 class="login-title"><span class="sr-only">회원</span>로그인</h2>
            </div>
            <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
                <input type="hidden" name="url" value="<?php echo $login_url ?>">

                <fieldset class='login-form'>
                    <legend class="sr-only">회원로그인</legend>
                    <div class='form-group'>
                        <label for="login_id" class="sr-only">회원아이디<strong class="sr-only"> 필수</strong></label>
                        <input type="text" name="mb_id" id="login_id" required class="form-control required" size="20" maxLength="20" placeholder="아이디">
                    </div>
                    <div class='form-group'>
                        <label for="login_pw" class="sr-only">비밀번호<strong class="sr-only"> 필수</strong></label>
                        <input type="password" name="mb_password" id="login_pw" required class="form-control required" size="20" maxLength="20" placeholder="비밀번호">
                    </div>
                    <div class='form-group'>
                        <button type="submit" class="btn btn-primary btn-block">로그인</button>
                    </div>
                    <div class='form-group'>
                        <input type="checkbox" name="auto_login" id="login_auto_login" class="selec_chk">
                        <label for="login_auto_login"><span></span> 자동로그인</label> /
                        <a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost">정보찾기</a> /
                        <a href="<?php echo G5_BBS_URL ?>/register.php" class="join">회원가입</a>
                    </div>
                </fieldset>
            </form>
            <?php @include_once(get_social_skin_path() . '/social_login.skin.php'); // 소셜로그인 사용시 소셜로그인 버튼 
            ?>
        </div>
    </div>

    <script>
        jQuery(function($) {
            $("#login_auto_login").click(function() {
                if (this.checked) {
                    this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
                }
            });
        });

        function flogin_submit(f) {
            if ($(document.body).triggerHandler('login_sumit', [f, 'flogin']) !== false) {
                return true;
            }
            return false;
        }
    </script>
    <!-- } 로그인 끝 -->
</div>