<?php

/**
 * 포인트 충전
 */
include_once "./_common.php";
if (!$is_member) {
    alert_close('로그인 후 이용하세요.');
}
if ($idx && $w == 'u') {
    $idx = Asktools::clean($idx);
    $sql = "SELECT * from  `" . BP_POINT_CHARGE_TABLE . "` where bo_mb_id = '" . escape_trim($member['mb_id']) . "' and `bo_idx` = '{$idx}'";
    $_point = sql_fetch($sql);
}
include_once(G5_THEME_PATH . '/head.php');
?>
<?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>
<div class='mypage-wrap'>

    <div class="jumbotron p-4">
        <h1 class="display-5">포인트 충전</h1>
        <p class="lead">사이트 이용에 필요한 포인트를 충전할 수 있습니다.</p>
        <hr class="my-4">
        <p>포인트 충전 관련 문의는 1:1 문의란을 이용해 주세요.</p>
    </div>
    <div class='point-charge-wrap row justify-content-center'>
        <div class='col-sm-12 col-md-8 col-lg-6'>
            <form name="bp_point_charge_form" method="post" enctype="multipart/form-data" onsubmit="return bp_point_charge_submit(this);">
                <input type="hidden" name="token" value="" id="token">
                <input type="hidden" name='idx' value="<?php echo $_point['bo_idx'] ?>" />
                <input type="hidden" name='w' value="<?php echo $w ?>" />
                <div class="form-group">
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text'>포인트</span>
                        </div>
                        <?php
                        if (!$idx && !$w) {
                            $point_tmp = explode('|', $config['bp_point_list']);
                            echo "<select name='bo_point' class='form-control select-point'>";
                            echo "<option value=''>-- 충전할 포인트 선택 --</option>";
                            foreach ($point_tmp as $point) {
                                $point = trim($point);
                                echo "<option value='{$point}'>" . number_format($point) . "</option>";
                            }
                            echo "<option value='customer'>포인트직접입력</option>";
                            echo "</select>";
                            echo "<input type='text' name='bo_point_customer' value='' class='form-control bp_customer_point d-none' placeholder='포인트입력' />";
                        }
                        if ($_point) {
                            $_point['bo_point'] = number_format($_point['bo_point']);
                            echo "<input type='text' value='{$_point['bo_point']}' class='form-control' disabled>";;
                        }
                        ?>
                    </div>
                    <script>
                        $(function() {
                            $('.select-point').change(function() {
                                if ($(this).val() == 'customer') {
                                    $('.bp_customer_point').removeClass('d-none');

                                }
                            });
                        });
                    </script>
                </div>
                <div class="form-group">
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text'>입금은행</span>
                        </div>
                        <?php
                        if (!$idx && !$w) {
                            $bank_tmp = explode('|', $config['bp_bank_list']);
                            echo "<select name='bo_bank' class='form-control'>";
                            echo "<option value=''>-- 입금은행 선택 --</option>";
                            foreach ($bank_tmp as $bank) {
                                $bank = trim($bank);
                                echo "<option vlaue='{$bank}'>{$bank}</option>";
                            }
                            echo "</select>";
                        }
                        if ($_point) {
                            echo "<input type='text' value='{$_point['bo_bank']}' class='form-control' disabled>";;
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text'>입금인</span>
                        </div>
                        <input type='text' name='bo_name' class='form-control' value='<?php echo $_point['bo_name'] ?>' placeholder="입금인 이름" <?php echo $_point['bo_order_state'] == '완료' ? "disabled" : "" ?> />
                    </div>
                    <div class='help-text text-muted text-right'><small>필히 입금인을 정확히 입력하세요.</small></div>
                </div>
                <div class="form-group">
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text'>Email</span>
                        </div>
                        <input type='email' name='bo_email' class='form-control' value='<?php echo $_point['bo_email'] ?>' placeholder="이메일 주소 입력" <?php echo $_point['bo_order_state'] == '완료' ? "disabled" : "" ?> />
                    </div>
                    <div class='help-text text-muted text-right'><small>이메일 주소를 입력하세요.</small></div>
                </div>
                <?php if ($_point['bo_order_state'] == '주문') { ?>
                    <div class="form-group">
                        <label><input type='checkbox' name='bo_cancel' value='1' />포인트 충전 취소하기</label>
                        <div class='help-text text-muted text-left'><small>미입금 상태에서는 포인트 충전을 취소 할 수 있습니다. </small></div>
                    </div>
                <?php } ?>




                <?php if (!$idx && !$w) { ?>
                    <div class='form-group'>
                        <textarea name='point-term' rows="6" readonly class="form-control point-term" aria-label="With textarea">### 포인트구매약관 ###

- 포인트를 구매하시려면 사이트 회원이어야 합니다.
- 포인트는 입금을 통해 구매할 수 있습니다. 
- 포인트는 타인에게 양도할 수 없습니다.
- 포인트는 구매 후 언제든지 환불 가능하며 환불 요청 후 영업일 기준 3일 이내에 환불됩니다.
- 이미 사용한 포인트는 환불할 수 없습니다.
- 포인트 구매를 통한 포인트만 환불이 가능합니다.
- 사용하지 않은 포인트의 유효기간은 2년입니다.
- 유료구매 포인트는 서비스가 유지될때까지 유효하며 서비스 중단시 별도의 공지를 통해 환불을 진행합니다.</textarea>
                        <div class='p-1 text-right'>
                            <label><input type='checkbox' name='agree' value="1"> 약관 동의</label>
                        </div>
                    </div>
                <?php } ?>
                <div class="alert alert-info">
                    <?php if ($_point['bo_order_state'] == '주문') { ?>
                        <i class="fa fa-info" aria-hidden="true"></i> 포인트 주문 후 48시간 이내에 입금하지 않으면 취소 처리 됩니다.
                    <?php } ?>
                    <?php if ($_point['bo_order_state'] == '취소') { ?>
                        <i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $_point['bo_cancel_datetime'] ?>에 포인트 주문을 취소하였습니다.
                    <?php } ?>
                    <?php if ($_point['bo_order_state'] == '완료') { ?>
                        <i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $_point['bo_deposit_datetime'] ?>에 포인트 주문이 완료되었습니다.
                        <br />
                        <i class="fa fa-money" aria-hidden="true"></i> <?php echo $_point['bo_point'] ?> 포인트가 지급되었습니다.
                    <?php } ?>
                </div>
                <div class='form-action justify-content-between d-flex'>
                    <a href="<?php echo G5_PLUGIN_URL ?>/ask-point-charge/bp_point_charge_list.php" class="btn btn-success"><i class="fa fa-list" aria-hidden="true"></i> 포인트 충전 내역</a>
                    <?php if ($_point['bo_order_state'] == '주문' || !$w) { ?>
                        <button type="submit" class='btn btn-primary'>확인</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    //전송
    function bp_point_charge_submit(f) {

        var token = _get_delete_token();
        if (!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        } else {
            f.token.value = token;
        }

        <?php if (!$idx && !$w) { ?>
            if (f.bo_point.value == '') {
                alert('충전할 포인트를 선택하세요.');
                return false;
            }
            if (f.bo_point.value == 'customer') {
                if (f.bo_point_customer.value == '') {
                    alert('충전할 포인트를 입력하세요.');
                    return false;
                }
            }
            if (f.bo_bank.value == '') {
                alert('입금할 은행을 선택하세요.');
                return false;
            }
        <?php } ?>

        if (f.bo_name.value == '') {
            alert('입금자 명을 입력하세요.');
            return false;
        }
        if (f.bo_email.value == '') {
            alert('Email을 입력하세요.');
            return false;
        }

        <?php if (!$idx && !$w) { ?>
            if (f.agree.checked == false) {
                alert('포인트구매 약관에 동의하여야 구매가 가능합니다.');
                return false;
            }
        <?php } ?>

        f.action = "./bp_point_charge.update.php";
        return true;
    }
</script>
<?php
include_once(G5_THEME_PATH . '/tail.php');
