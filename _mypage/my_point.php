<?php
include_once('./_common.php');

if (!$is_member) {
    alert('회원전용 페이지 입니다.');
    exit;
}
$g5['title'] = 'Mypage - 포인트내역';
include_once(G5_THEME_PATH . '/head.php');


$list = array();

$sql_common = " from {$g5['point_table']} where mb_id = '" . escape_trim($member['mb_id']) . "' ";
$sql_order = " order by po_id desc ";

$sql = " SELECT count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

?>
<div class='mypage-wrap'>
    <?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>
    <div class="jumbotron p-4">
        <h1 class="display-5">내포인트</h1>
        <hr />
        <p class="lead">내가 획득한 포인트 목록, 나의 포인트는 <?php echo number_format($member['mb_point']) ?> 포인트 입니다.</p>
    </div>
    <div class="table-responsive table-wrap">
        <?php if ($config['bp_point_charge']) { ?>
            <div class='text-right mb-2'>
                <a href="<?php echo G5_PLUGIN_URL ?>/ask-point-charge/bp_point_charge.php" class="btn btn-primary"><i class="fa fa-money" aria-hidden="true"></i> 포인트 충전</a>
                <a href="<?php echo G5_PLUGIN_URL ?>/ask-point-charge/bp_point_charge_list.php" class="btn btn-success"><i class="fa fa-list" aria-hidden="true"></i> 포인트 충전 내역</a>
            </div>
        <?php } ?>
        <table class="table table-bordered">
            <caption>
                보유포인트
                <span><?php echo number_format($member['mb_point']); ?></span>
            </caption>
            <thead class="thead-dark">
                <tr>
                    <th>내역</th>
                    <th>포인트</th>
                    <th>포인트</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sum_point1 = $sum_point2 = $sum_point3 = 0;

                $sql = " SELECT * {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
                $result = sql_query($sql);
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $point1 = $point2 = 0;
                    $point_use_class = '';
                    if ($row['po_point'] > 0) {
                        $point1 = '+' . number_format($row['po_point']);
                        $sum_point1 += $row['po_point'];
                    } else {
                        $point2 = number_format($row['po_point']);
                        $sum_point2 += $row['po_point'];
                        $point_use_class = 'point_use';
                    }

                    $po_content = $row['po_content'];

                    $expr = '';
                    if ($row['po_expired'] == 1)
                        $expr = ' txt_expired';
                ?>
                    <tr class="<?php echo $point_use_class; ?>">
                        <td>
                            <?php echo $po_content; ?>
                        </td>
                        <td>
                            <?php if ($point1) {
                                echo $point1;
                            } else {
                                echo $point2;
                            }  ?>
                        </td>
                        <td>
                            <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $row['po_datetime']; ?>
                            <span class="point_date<?php echo $expr; ?>">
                                <?php if ($row['po_expired'] == 1) { ?>
                                    만료 <?php echo substr(str_replace('-', '', $row['po_expire_date']), 2); ?>
                                <?php } else echo $row['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date']; ?>
                            </span>
                        </td>
                    </tr>
                <?php
                } //for

                if ($i == 0) {
                    echo '<td colspan="3" class="empty_li">자료가 없습니다.</td>';
                } else {
                    if ($sum_point1 > 0) {
                        $sum_point1 = "+" . number_format($sum_point1);
                    }
                    $sum_point2 = number_format($sum_point2);
                }
                ?>


            </tbody>
            <tfoot>
                <tr>
                    <td>
                        소계
                    </td>
                    <td>
                        <span><?php echo $sum_point1; ?> Point</span>
                    </td>
                    <td>
                        <span><?php echo $sum_point2; ?> Point</span>
                    </td>
                </tr>
            </tfoot>
        </table>
        </dv>

        <!-- 페이지 -->
        <div class="paging mb-3 pt-3 pb-3">
            <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='); ?>
        </div>
    </div>
    <?php
    include_once(G5_THEME_PATH . '/tail.php');
