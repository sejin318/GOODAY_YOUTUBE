<?php

/**
 * 포인트 환불
 */
include_once "./_common.php";
if (!$is_member) {
    alert_close('로그인 후 이용하세요.');
}
$my_point = $member['mb_point'];
if ($my_point <= 0 && !($idx && $w)) {
    alert('환불신청할 포인트가 없습니다.');
    exit;
}
//충전한 내역이 없다면 환불신청 차단
$sql =  "SELECT count(*) as cnt from  `" . BP_POINT_CHARGE_TABLE . "` where bo_mb_id = '" . escape_trim($member['mb_id']) . "'";
$charge_count = sql_fetch($sql);
if ($charge_count['cnt'] <= 0) {
    alert('충전한 내역이 없습니다.');
    exit;
}
//미승인된 환불신청이 있으면 환불 신청 불가
if (!$idx && !$w) {
    $sql = "SELECT count(*) as cnt from  `" . BP_POINT_REFUND_TABLE . "` where br_mb_id = '" . escape_trim($member['mb_id']) . "' and `br_refund_datetime` = '0000-00-00 00:00:00'";
    $refund_count = sql_fetch($sql, true);
    if ($refund_count['cnt'] > 0) {
        alert('환불 절차가 진행중인 건이 있습니다. 환불 완료 또는 취소처리 후 신청하세요.');
        exit;
    }
}
if ($idx && $w == 'u') {
    $idx = Asktools::clean($idx);
    $sql = "SELECT * from  `" . BP_POINT_REFUND_TABLE . "` where br_mb_id = '" . escape_trim($member['mb_id']) . "' and `br_idx` = '{$idx}'";
    $_point = sql_fetch($sql);
}
include_once(G5_THEME_PATH . '/head.php');
?>
<?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>
<div class='mypage-wrap'>

    <div class="jumbotron p-4">
        <h1 class="display-5">포인트 환불</h1>
        <p class="lead">충전한 포인트 잔액을 환불할 수 있습니다.</p>
        <hr class="my-4">
        <p>포인트 충전 관련 문의는 1:1 문의란을 이용해 주세요.</p>
    </div>
    <div class='point-refund-wrap row justify-content-center'>
        <div class='col-sm-12 col-md-8 col-lg-6'>
            <?php if ($_point['br_refund_state']) { ?>
                <table class='table table-bordered'>
                    <tbody>
                        <tr>
                            <th class='bg-dark w-25'>아이디</th>
                            <td><?php echo $_point['br_mb_id'] ?></td>
                        </tr>
                        <tr>
                            <th class='bg-dark'>포인트</th>
                            <td><?php echo number_format($_point['br_point']) ?></td>
                        </tr>
                        <tr>
                            <th class='bg-dark'>입금은행</th>
                            <td><?php echo $_point['br_bank_name'] . '' . $_point['br_bank_acount'] . ' ' . $_point['br_name'] ?></td>
                        </tr>
                        <tr>
                            <th class='bg-dark'>이메일</th>
                            <td><?php echo $_point['br_email'] ?></td>
                        </tr>
                        <tr>
                            <th class='bg-dark'>구매일</th>
                            <td><?php echo $_point['br_datetime'] ?></td>
                        </tr>
                        <tr>
                            <th class='bg-dark'>IP</th>
                            <td><?php echo $_point['br_ip'] ?></td>
                        </tr>
                        <?php if ($_point['br_refund_state'] == '환불완료') { ?>
                            <tr>
                                <th class='bg-primary'>처리결과</th>
                                <td><?php echo $_point['br_refund_state'] ?></td>
                            </tr>
                            <tr>
                                <th class='bg-primary'>완료일자</th>
                                <td><?php echo $_point['br_refund_datetime'] ?></td>
                            </tr>
                        <?php } ?>
                        <?php if ($_point['br_refund_state'] == '환불거부') { ?>
                            <tr>
                                <th class='bg-danger'>거부일자</th>
                                <td><?php echo $_point['br_refund_datetime'] ?></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
                <a href="<?php echo G5_PLUGIN_URL ?>/ask-point-charge/bp_point_refund_list.php" class="btn btn-danger"><i class="fa fa-list" aria-hidden="true"></i> 포인트환불 내역</a>

            <?php } else { ?>
                <form name="bp_point_charge_form" method="post" enctype="multipart/form-data" onsubmit="return bp_point_refund_submit(this);">
                    <input type="hidden" name="token" value="" id="token">
                    <input type="hidden" name='idx' value="<?php echo $_point['br_idx'] ?>" />
                    <input type="hidden" name='w' value="<?php echo $w ?>" />
                    <div class="form-group">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>포인트</span>
                                </div>
                                <input type='text' name='br_point' value="<?php echo $_point ? $_point['br_point'] : $member['mb_point']; ?>" class='form-control' readonly />
                            </div>
                            <div class='help-text text-muted text-right'><small>환불받을 포인트는 전체 잔액만 입력 가능합니다. 잔액 : <?php echo number_format($member['mb_point']) ?>P</small></div>
                        </div>
                        <script>
                            $(function() {
                                $("input[name=br_point").on("keyup", function() {
                                    $(this).val($(this).val().replace(/[^0-9]/g, ""));
                                    if ($(this).val() > <?php echo $member['mb_point'] ?>) {
                                        alert('보유한 포인트보다 큰 포인트를 입력할 수 없습니다.');
                                        $(this).val(<?php echo $member['mb_point'] ?>);
                                        return false;
                                    }
                                });
                                $("input[name=br_bank_acount").on("keyup", function() {
                                    $(this).val($(this).val().replace(/[^0-9]/g, ""));
                                });
                            });
                        </script>
                    </div>
                    <div class="form-group">
                        <div class='input-group'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text'>은행</span>
                            </div>
                            <input type='text' name="br_bank_name" value="<?php echo $_point['br_bank_name'] ?>" class="form-control">
                        </div>
                        <div class='help-text text-muted text-right'><small>환불받을 은행명</small></div>
                    </div>
                    <div class="form-group">
                        <div class='input-group'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text'>계좌번호</span>
                            </div>
                            <input type='text' name="br_bank_acount" value="<?php echo $_point['br_bank_acount'] ?>" class="form-control">
                        </div>
                        <div class='help-text text-muted text-right'><small>환불받을 계좌, 숫자만 입력</small></div>
                    </div>

                    <div class="form-group">
                        <div class='input-group'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text'>예금주</span>
                            </div>
                            <input type='text' name='br_name' class='form-control' value='<?php echo $_point['br_name'] ?>' placeholder="예금주 이름" />
                        </div>
                        <div class='help-text text-muted text-right'><small>필히 예금주를 정확히 입력하세요.</small></div>
                    </div>
                    <div class="form-group">
                        <div class='input-group'>
                            <div class='input-group-prepend'>
                                <span class='input-group-text'>Email</span>
                            </div>
                            <input type='email' name='br_email' class='form-control' value='<?php echo $_point['br_email'] ?>' placeholder="이메일 주소 입력" />
                        </div>
                        <div class='help-text text-muted text-right'><small>이메일 주소를 입력하세요.</small></div>
                    </div>
                    <?php if (!$idx && !$w) { ?>
                        <div class='form-group'>
                            <textarea name='point-term' rows="6" readonly class="form-control point-term" aria-label="With textarea">### 포인트환불약관 ###

- 포인트는 구매한 포인트만 환불 가능합니다.
- 포인트 환불 신청 후 48시간 이내에 환불 처리됩니다.
- 이미 사용한 포인트는 환불할 수 없습니다.</textarea>
                            <div class='p-1 text-right'>
                                <label><input type='checkbox' name='agree' value="1"> 약관 동의</label>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="alert alert-danger">
                        <i class="fa fa-info" aria-hidden="true"></i> 환불신청 후 포인트를 사용하면 포인트 잔액과 환불신청 포인트 차이로 인해 환불이 취소됩니다.
                    </div>
                    <?php if ($_point) { ?>
                        <div class="form-group">
                            <label><input type='checkbox' name='br_cancel' value='1' />포인트 환불 취소하기</label>
                            <div class='help-text text-muted text-left'><small>포인트 환불 신청을 취소합니다. </small></div>
                        </div>
                    <?php } ?>
                    <div class='form-action justify-content-between d-flex'>
                        <a href="<?php echo G5_PLUGIN_URL ?>/ask-point-charge/bp_point_refund_list.php" class="btn btn-danger"><i class="fa fa-list" aria-hidden="true"></i> 포인트환불 내역</a>
                        <button type="submit" class='btn btn-primary'>확인</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    //전송
    function bp_point_refund_submit(f) {

        var token = _get_delete_token();
        if (!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        } else {
            f.token.value = token;
        }

        <?php if (!$idx && !$w) { ?>
            if (f.br_point.value == '') {
                alert('환불할 포인트를 입력하세요.');
                return false;
            }
            if (f.br_bank_name.value == '') {
                alert('입금할 은행을 입력하세요.');
                return false;
            }
            if (f.br_bank_acount.value == '') {
                alert('입금할 계좌번호를 입력하세요.');
                return false;
            }
        <?php } ?>

        if (f.br_name.value == '') {
            alert('예금주 명을 입력하세요.');
            return false;
        }
        if (f.br_email.value == '') {
            alert('Email을 입력하세요.');
            return false;
        }

        <?php if (!$idx && !$w) { ?>
            if (f.agree.checked == false) {
                alert('포인트구매 약관에 동의하여야 구매가 가능합니다.');
                return false;
            }
        <?php } ?>

        f.action = "./bp_point_refund.update.php";
        return true;
    }
</script>
<?php
include_once(G5_THEME_PATH . '/tail.php');
