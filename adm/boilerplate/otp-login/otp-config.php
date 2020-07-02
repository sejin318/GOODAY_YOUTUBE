<?php

/**
 * ASK-ADMIN-OTP
 * 관리자 Two Factor 인증
 * otp-config.php
 */
$sub_menu = "800120";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

/**
 * OTP 관련 필드 추가.
 */
if (!isset($config['ask_otp_use'])) {
    sql_query("ALTER TABLE `{$g5['config_table']}` ADD `ask_otp_use` varchar(1) NOT NULL DEFAULT '', ADD `ask_otp_secret_key` varchar(16) NOT NULL DEFAULT '' ", true);
}

$g5['title'] = 'Boilerplate OTP 설정';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/otp-login/style.css">');
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');


//키가 없으면 생성 및 QR코드 출력
if ($config['ask_otp_secret_key'] && strlen($config['ask_otp_secret_key']) == 16) {
    $secret_key = $config['ask_otp_secret_key'];
} else {
    $secret_key = $_ga->createSecret();
}

$qrCodeUrl = $_ga->getQRCodeGoogleUrl($config['cf_title'], $secret_key);

$timestamp = time();
$date_time = date("Y-m-d H:i:s", $timestamp);

?>
<div class="jumbotron p-5">
    <h1>관리자 OTP 설정</h1>
    <p class="lead">
        아래 설명을 참고하여 설정하세요.
    </p>
</div>
<?php echo bp_display_message();?>
<form name="askconfigform" id="askconfigform" method="post" enctype="multipart/form-data" onsubmit="return otp_submit(this);">
    <input type="hidden" name="token" value="" id="token">
    <h2 class="frm-head">관리자 로그인 OTP 설정</h2>
    <div class='alert-info'>
        <i class="fa fa-info-circle" aria-hidden="true"></i>
        관리자 로그인시 OTP를 입력하도록 설정합니다. <br />
        <i class="fa fa-info-circle" aria-hidden="true"></i> 안드로이드(<a href='https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ko' target='_blank'>Google OTP</a>,
        <a href='https://play.google.com/store/apps/details?id=com.authy.authy' target='_blank'>Authy 2</a> )
        또는 iOS(<a href='https://apps.apple.com/kr/app/google-authenticator/id388497605' target='_blank'>Google Authenticator</a>,
        <a href='https://apps.apple.com/us/app/authy/id494168017' target='_blank'>Authy</a>) OTP 프로그램으로 QR코드를 스캔하세요<br />
        <i class="fa fa-info-circle" aria-hidden="true"></i> 주의) 웹사이트가 운영되는 서버의 시간이 맞지 않으면 인증이 안됩니다. <?php echo  "현재 서버시간 : $date_time"; ?><br />
        <i class="fa fa-info-circle" aria-hidden="true"></i> 인증 후 서버시간이 안맞아서 인증이 안될 경우 관리자에 접속이 안됩니다. <br />
        phpmyadmin에서 UPDATE `g5_config` SET ask_otp_use =''; 쿼리를 실행해서 사용을 해제하세요.<br /><br />
        <img src='<?php echo $qrCodeUrl; ?>' />


    </div>
    <div class='frm-wrap'>
        <div class='frm-group border-top-1'>
            <label class='frm-label'><span>OTP 사용여부</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <?php
                    $disabled = 'disabled';
                    if ($_SESSION['ask_otp_tested'] == true || $config['ask_otp_use']) {
                        $disabled = '';
                    }
                    ?>
                    <label><input type="checkbox" name="ask_otp_use" value="1" id="ask_otp_use" class="frm-check" <?php echo $config['ask_otp_use'] ? 'checked' : '';
                                                                                                                    echo $disabled ?>> 사용</label>
                    <?php echo help('사용에 체크해야 OTP 설정이 사이트에 적용됩니다. 테스트를 완료해야 선택할 수 있습니다. OTP Secret Key를 저장 후 테스트 하세요.'); ?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='ask_otp_secret_key'><span>OTP Secret Key</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <?php
                    if ($config['ask_otp_use']) {
                        $readonly = 'readonly';
                    }
                    ?>
                    <input type="text" name="ask_otp_secret_key" value="<?php echo $secret_key ?>" maxlength='16' id="ask_otp_secret_key" class="frm-input required" required placeholder="16자리 보안키 입력" <?php echo $readonly ?>>
                    <?php echo help('설정된 비밀키를 운영도중에 변경하면 OTP 사용이 중지됩니다. 변경시 OTP앱에 재등록해야 합니다. '); ?>
                </div>
            </div>
        </div>
        <?php if ($config['ask_otp_secret_key']) { ?>
            <!-- OTP 재발급 -->
            <div class='frm-group'>
                <label class='frm-label'><span>OTP Secret Key 재발급</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="reissued" value="1" id="reissued" class="frm-check"> OTP 비밀키 재발급</label>
                        <?php echo help('체크 후 저장하면 재발급 됩니다. 재발급 후 TEST를 및 OTP앱에 재등록 해야합니다.'); ?>
                    </div>
                </div>
            </div>
            <!-- OTP 테스트 -->
            <div class='frm-group'>
                <label class='frm-label' for='ask_otp_secret_key'><span>OTP TEST</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <input type="text" name="otp_test" value="" maxlength="6" id="otp_test" class="frm-input" placeholder="otp 6자리 입력">
                        <?php echo help('Secret Key 16자리를 저장하였다면 OTP앱을 등록 후 6자리 OTP 숫자를 입력해서 테스트 할 수 있습니다.'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>


    <div class="btn_fixed_top btn_confirm">
        <input type="submit" value="확인" class="btn btn-primary" accesskey="s">
    </div>

</form>

<script>
    function otp_submit(f) {
        f.action = "./otp-config.update.php";
        if ($('#reissued').is(':checked') == true) {
            if (confirm("OTP Secret Key 재발급 받으면 OTP앱에 재등록해야 합니다. \n자동 사이트에 사용해지 됩니다. \nOTP Secret Key 재발급 하시겠습니까?")) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
</script>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
