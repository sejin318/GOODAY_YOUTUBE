<?php
$sub_menu = "800501";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

//테이블 체크
if (ASKDB::exsit_table(BP_SLIDER_TABLE) == false) {
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}

$g5['title'] = 'Boilerplate  포인트 환불 상세보기';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');

if ($idx && $w == 'u') {
    $idx = Asktools::clean($idx);
    $sql = "SELECT * from  `" . BP_POINT_REFUND_TABLE . "` where `br_idx` = '{$idx}'";
    $_point = sql_fetch($sql);
}
if (!$_point) {
    alert('데이터가 없습니다.');
    exit;
}
?>

<div class="point-order-wrap frm-wrap">
    <div class="jumbotron p-4">
        <h1 class="display-5">포인트 환불</h1>
        <p class="lead">충전한 포인트 잔액을 환불할 수 있습니다.</p>
    </div>
    <?php echo bp_display_message(); ?>
    <div class='point-refund-wrap row justify-content-center'>
        <div class='col-sm-12 col-md-8 col-lg-6'>
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
                            <th class='bg-danger'>처리결과</th>
                            <td><?php echo $_point['br_refund_state'] ?></td>
                        </tr>
                        <tr>
                            <th class='bg-danger'>거부일자</th>
                            <td><?php echo $_point['br_refund_datetime'] ?></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <?php if (!$_point['br_refund_state']) { ?>
                <form name="bp_point_charge_form" method="post" enctype="multipart/form-data" onsubmit="return bp_point_refund_submit(this);">
                    <input type="hidden" name="token" value="" id="token">
                    <input type="hidden" name='idx' value="<?php echo $_point['br_idx'] ?>" />
                    <input type="hidden" name='br_mb_id' value="<?php echo $_point['br_mb_id'] ?>" />
                    <input type="hidden" name='br_point' value="<?php echo $_point['br_point'] ?>" />
                    <input type="hidden" name='br_email' value="<?php echo $_point['br_email'] ?>" />
                    <input type="hidden" name='page' value="<?php echo $_point['page'] ?>" />
                    <input type="hidden" name='w' value="<?php echo $w ?>" />

                    <div class="form-group">
                        <label><input type='radio' name='br_refund_state' value='환불완료' />포인트 환불 완료처리</label>
                        <div class='help-text text-muted text-left'><small>포인트 환불 완료 및 포인트 차감 처리</small></div>
                    </div>
                    <div class="form-group">
                        <label><input type='radio' name='br_refund_state' value='환불거부' />포인트 환불 거부처리</label>
                        <input type='text' name='br_refuse_memo' value="" class='form-control' placeholder="환불거부 사유">
                        <div class='help-text text-muted text-left'><small>거부 사유를 입력하세요.</small></div>
                    </div>

                    <div class='form-action justify-content-between d-flex'>
                        <a href="./bp_point_refund_list.php" class="btn btn-danger"><i class="fa fa-list" aria-hidden="true"></i> 포인트환불 내역</a>
                        <button type="submit" class='btn btn-primary'>확인</button>
                    </div>
                </form>
            <?php } else { ?>
                <a href="./bp_point_refund_list.php" class="btn btn-danger"><i class="fa fa-list" aria-hidden="true"></i> 포인트환불 내역</a>
            <?php } ?>

        </div>
    </div>
</div>

<script>
    //전송
    function bp_point_refund_submit(f) {

        <?php if ($_point['br_refund_state']) { ?>
            return false;
        <?php } ?>
        if (f.br_refund_state.value == '') {
            alert('환불 처리를 선택하세요.');
            return false;
        }
        if (f.br_refund_state.value == '환불거부') {
            if (f.br_refuse_memo.value == '') {
                alert('환불 거부 사유를 입력하세요.');
                return false;
            }
        }
        if (confirm(f.br_refund_state.value + ' 처리를 진행하시겠습니까?')) {
            f.action = "./bp_point_refund.update.php";
            return true;
        }else{
            return false;
        }
    }
</script>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
