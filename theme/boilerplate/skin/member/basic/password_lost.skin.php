<?php

/**
 * password_lost.skin.php
 * 비밀번호찾기
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

?>
<!-- As a heading -->
<nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand mb-0 h1"><?php echo $g5['title'] ?></span>
</nav>
<div class="container-fluid">
    <!-- 회원정보 찾기 시작 { -->
    <div class="popup-page-wrap row">
        <div class="col-sm-12">
            <div class="alert alert-info alert-sm mt-2">
                회원가입 시 등록하신 이메일 주소를 입력해 주세요.<br>
                해당 이메일로 아이디와 비밀번호 정보를 보내드립니다.
            </div>
            <form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="mb_email" class="sr-only">E-mail 주소<strong class="sound_only">필수</strong></label>
                    <input type="text" name="mb_email" id="mb_email" required class="required form-control email" placeholder="E-mail 주소">
                </div>
                <div class="form-group">
                    <?php echo captcha_html();  ?>
                </div>
                <div class="form-action">
                    <div class='btn-group d-flex'>
                        <button type="submit" class="btn btn-primary mr-1">확인</button>
                        <button type="button" onclick="window.close();" class="btn btn-danger">창닫기</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <script>
        function fpasswordlost_submit(f) {
            <?php echo chk_captcha_js();  ?>

            return true;
        }

        $(function() {
            var sw = screen.width;
            var sh = screen.height;
            var cw = document.body.clientWidth;
            var ch = document.body.clientHeight;
            var top = sh / 2 - ch / 2 - 100;
            var left = sw / 2 - cw / 2;
            moveTo(left, top);
        });
    </script>
    <!-- } 회원정보 찾기 끝 -->
</div>