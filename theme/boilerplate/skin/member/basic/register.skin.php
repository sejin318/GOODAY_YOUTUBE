<?php

/**
 * register.skin.php
 * 회원 가입 스킨
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

?>

<!-- 회원가입약관 동의 시작 { -->
<div class="register-wrap">
    <h1 class='title'>회원가입</h1>
    <form name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

        <div class='alert alert-info'><i class="fa fa-check-circle" aria-hidden="true"></i> 회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</div>

        <?php
        // 소셜로그인 사용시 소셜로그인 버튼
        @include_once(get_social_skin_path() . '/social_register.skin.php');
        ?>
        <section id="fregister_term">
            <h2 class="title">회원가입약관</h2>
            <textarea class='form-control term-text' readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
            <fieldset class="fregister_agree">
                <input type="checkbox" name="agree" value="1" id="agree11" class="selec_chk">
                <label for="agree11"><span class="text">회원가입약관의 내용에 동의합니다.</span></label>
            </fieldset>
        </section>

        <section id="fregister_private">
            <h2 class="title">개인정보처리방침안내</h2>
            <div class='table-responsive'>
                <table class="table table-bordered">
                    <caption class="sr-only">개인정보처리방침안내</caption>
                    <thead class="thead-dark">
                        <tr>
                            <th>목적</th>
                            <th>항목</th>
                            <th>보유기간</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>이용자 식별 및 본인여부 확인</td>
                            <td>아이디, 이름, 비밀번호</td>
                            <td>회원 탈퇴 시까지</td>
                        </tr>
                        <tr>
                            <td>고객서비스 이용에 관한 통지,<br>CS대응을 위한 이용자 식별</td>
                            <td>연락처 (이메일, 휴대전화번호)</td>
                            <td>회원 탈퇴 시까지</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <fieldset class="fregister_agree">
                <input type="checkbox" name="agree2" value="1" id="agree21" class="selec_chk">
                <label for="agree21"><span class="text">개인정보처리방침안내의 내용에 동의합니다.</span></label>
            </fieldset>
        </section>

        <div id="fregister_chkall" class="chk_all fregister_agree">
            <input type="checkbox" name="chk_all" id="chk_all" class="selec_chk">
            <label for="chk_all">회원가입 약관에 모두 동의합니다</label>
        </div>

        <div class="form-action d-flex justify-content-center">
            <a href="<?php echo G5_URL ?>" class="btn btn-danger btn-lg mr-2">취소</a>
            <button type="submit" class="btn btn-primary btn-lg">회원가입</button>
        </div>

    </form>

    <script>
        function fregister_submit(f) {
            if (!f.agree.checked) {
                alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
                f.agree.focus();
                return false;
            }

            if (!f.agree2.checked) {
                alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
                f.agree2.focus();
                return false;
            }

            return true;
        }

        jQuery(function($) {
            // 모두선택
            $("input[name=chk_all]").click(function() {
                if ($(this).prop('checked')) {
                    $("input[name^=agree]").prop('checked', true);
                } else {
                    $("input[name^=agree]").prop("checked", false);
                }
            });
        });
    </script>
</div>
<!-- } 회원가입 약관 동의 끝 -->