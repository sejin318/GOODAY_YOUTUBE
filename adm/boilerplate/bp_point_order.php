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

$g5['title'] = 'Boilerplate  포인트 주문 상세보기';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');

if ($idx && $w == 'u') {
    $idx = Asktools::clean($idx);
    $sql = "SELECT * from  `" . BP_POINT_CHARGE_TABLE . "` where `bo_idx` = '{$idx}'";
    $_point = sql_fetch($sql);
}
if (!$_point) {
    alert('데이터가 없습니다.');
    exit;
}
?>
<div class="jumbotron p-5">
    <h1>포인트 주문 상세보기</h1>
    <p class="lead">
        포인트 주문 처리 페이지입니다.
    </p>
</div>
<?php echo bp_display_message(); ?>
<div class="point-order-wrap row frm-wrap justify-content-center">
    <div class='col-sm-12 col-md-8 col-lg-6'>
        <div class='alert alert-info'>
            현재 포인트 주문상태는 <span class='badge badge-success'><?php echo $_point['bo_order_state'] ?></span> 입니다.
        </div>
        <table class='table table-bordered'>
            <tbody>
                <tr>
                    <th class='bg-dark w-25'>아이디</th>
                    <td><?php echo $_point['bo_mb_id'] ?></td>
                </tr>
                <tr>
                    <th class='bg-dark'>포인트</th>
                    <td><?php echo number_format($_point['bo_point']) ?></td>
                </tr>
                <tr>
                    <th class='bg-dark'>입금은행</th>
                    <td><?php echo $_point['bo_bank'] ?></td>
                </tr>
                <tr>
                    <th class='bg-dark'>입금인</th>
                    <td><?php echo $_point['bo_name'] ?></td>
                </tr>
                <tr>
                    <th class='bg-dark'>이메일</th>
                    <td><?php echo $_point['bo_email'] ?></td>
                </tr>
                <tr>
                    <th class='bg-dark'>구매일</th>
                    <td><?php echo $_point['bo_datetime'] ?></td>
                </tr>
                <tr>
                    <th class='bg-dark'>IP</th>
                    <td><?php echo $_point['bo_ip'] ?></td>
                </tr>
                <?php if ($_point['bo_order_state'] == '완료') { ?>
                    <tr>
                        <th class='bg-primary'>완료일자</th>
                        <td><?php echo $_point['bo_deposit_datetime'] ?></td>
                    </tr>
                <?php } ?>
                <?php if ($_point['bo_order_state'] == '취소') { ?>
                    <tr>
                        <th class='bg-danger'>취소일자</th>
                        <td><?php echo $_point['bo_cancel_datetime'] ?></td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
        <form name="pb_point_charge" id="pb_point_charge" method="post" enctype="multipart/form-data" onsubmit="return bp_submit(this);">
            <input type="hidden" name="token" value="" id="token">
            <input type="hidden" name='w' value="<?php echo $w ?>" />
            <input type="hidden" name='bo_idx' value="<?php echo $_point['bo_idx'] ?>" />
            <input type="hidden" name='bo_point' value="<?php echo $_point['bo_point'] ?>" />
            <input type="hidden" name='bo_mb_id' value="<?php echo $_point['bo_mb_id'] ?>" />
            <input type="hidden" name='bo_datetime' value="<?php echo $_point['bo_datetime'] ?>" />
            <input type="hidden" name='bo_name' value="<?php echo $_point['bo_name'] ?>" />
            <input type="hidden" name='bo_order_state_org' value="<?php echo $_point['bo_order_state'] ?>" />
            <input type="hidden" name="page" value="<?php echo $page ?>">

            <div class='frm-group border-top-1'>
                <label class='frm-label'><span>주문 처리</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <?php if ($_point['bo_order_state'] == '주문') { ?>
                            <div class='p-1'>
                                <label><input type="radio" name="bo_order_state" value='완료'> 완료 - 결제가 되면 완료서 설정하세요. 포인트가 지급됩니다.</label>
                            </div>
                            <div class='p-1'>
                                <label><input type="radio" name="bo_order_state" value='취소'> 취소 - 주문을 취소합니다.</label>
                            </div>
                        <?php } ?>
                        <?php if ($_point['bo_order_state'] == '취소') { ?>
                            <div class='p-1'>
                                <label><input type="radio" name="bo_order_state" value='주문'> 주문 - 취소된 주문을 주문상태로 바꿉니다.</label>
                            </div>
                        <?php } ?>

                        <?php if ($_point['bo_order_state'] == '완료') { ?>
                            <div class='p-1'>
                                <div class="alert alert-info w-50">
                                    <input type="hidden" name="bo_order_state" value='<?php echo $_point['bo_order_state'] ?>'>
                                    주문이 완료 처리되면 환불요청에 대해서만 처리 가능합니다. 환불요청 목록에서 처리합니다.
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="btn_fixed_top btn_confirm">
                <a href='./bp_point_order_list.php?page=<?php echo $page ?>' class='btn btn-secondary'>목록</a>
                <input type="submit" value="확인" class="btn_submit btn btn-primary" accesskey="s">
            </div>
        </form>
    </div>
</div>
<script>
    function bp_submit(f) {
        
        if (f.bo_order_state.length > 1) {
            if (f.bo_order_state.value == '') {
                alert('주문 처리를 선택하세요.');
                return false;
            }
        } else {
            if (f.bo_order_state.checked == false || f.bo_order_state.checked == undefined) {
                alert('주문 처리를 선택하세요.');
                return false;
            }
        }

        <?php if ($_point['bo_order_state'] == '완료') { ?>
            if (f.bo_order_state.value == '완료') {
                alert('완료건은 처리할 내역이 없습니다.');
                return false;
            }
        <?php } ?>

        f.action = "./bp_point_order.update.php";
        if (confirm('주문을 [' + f.bo_order_state.value + '] 처리 하시겠습니까?')) {
            return true;
        } else {
            return false;
        }

    }
</script>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
