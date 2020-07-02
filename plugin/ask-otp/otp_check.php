<?php

/**
 * ASK OTP
 * 관리자 OTP 인증 입력
 * otp_check.php
 */
include_once './_common.php';
include_once G5_PATH . '/head.sub.php';
if ($is_admin != 'super') {
    echo "Access Denied.";
    exit;
}
?>
<div class='otp-wrap container'>
    <div class="border border-color-6 p-3 shadow">
        <form name="askconfigform" id="askconfigform" method="post" enctype="multipart/form-data" onsubmit="return otp_submit(this);" autocomplete="off">
            <h2 class="page-title">관리자 로그인 OTP 인증</h2>
            <div class='alert alert-info'>
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                OTP 6자리를 입력하세요.
            </div>
            <div class='input-group'>
                <input type="text" name="ask_otp_key" value="" maxlength='6' id="ask_otp_key" class="form-control required" required placeholder="6자리 OTP 입력">
                <button type="submit" class="btn btn-primary">확인</button>
            </div>
        </form>
        <script>
            function otp_submit(f) {
                f.action = "./otp_check.update.php";
                return true;
            }
        </script>
    </div>
</div>
<?php
include_once G5_PATH . '/tail.sub.php';
