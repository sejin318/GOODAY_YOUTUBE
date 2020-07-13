<?php

/**
 * register_result.skin.php
 * 회원 가입 완료 스킨
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

?>

<!-- 회원가입결과 시작 { -->
<div id="reg_result" class="register-result-wrap">
    <div class="jumbotron">
        <h1 class="display-5">회원가입완료</h1>
        <p class="lead">
            <i class="fa fa-gift" aria-hidden="true"></i> <strong><?php echo get_text($mb['mb_nick']); ?></strong>님의 회원가입을 진심으로 축하합니다.
            <?php if (is_use_email_certify()) {  ?>
                <p class="result_txt">
                    회원 가입 시 입력하신 이메일 주소로 인증메일이 발송되었습니다.<br>
                    메일이 안올시 스펨메일함을 확인해주세요. <br>
                    발송된 인증메일을 확인하신 후 인증처리를 하시면 사이트를 원활하게 이용하실 수 있습니다.
                </p>
                <div id="result_email">
                    <span>아이디</span>
                    <strong><?php echo $mb['mb_id'] ?></strong><br>
                    <span>이메일 주소</span>
                    <strong><?php echo $mb['mb_email'] ?></strong>
                </div>
                <p>
                    이메일 주소를 잘못 입력하셨다면, 사이트 관리자에게 문의해주시기 바랍니다.
                </p>
            <?php }  ?>
        </p>
        <hr class="my-2">
        <p class="result_txt">
            회원님의 비밀번호는 아무도 알 수 없는 암호화 코드로 저장되므로 안심하셔도 좋습니다.<br>
            아이디, 비밀번호 분실시에는 회원가입시 입력하신 이메일 주소를 이용하여 찾을 수 있습니다.
        </p>

        <p class="result_txt">
            회원 탈퇴는 언제든지 가능하며 일정기간이 지난 후, 회원님의 정보는 삭제하고 있습니다.<br>
            감사합니다.
        </p>

        <p class="lead">
            <a class="btn btn-primary btn-lg" href="/" role="button">홈으로 이동</a>
        </p>
    </div>
</div>