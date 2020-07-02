<?php
include_once('./_common.php');

if (!$is_member) {
    alert('회원전용 페이지 입니다.');
    exit;
}
$g5['title'] = 'Mypage - 포인트 충전내역';
include_once(G5_THEME_PATH . '/head.php');
$list = array();

$sql_common = " from  `" . BP_POINT_CHARGE_TABLE . "` where bo_mb_id = '" . escape_trim($member['mb_id']) . "' ";
$sql_order = " order by bo_idx desc ";

$sql = " SELECT count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " SELECT * {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql, true);
?>
<div class='mypage-wrap'>
    <?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>
    <div class="jumbotron p-4">
        <h1 class="display-5">포인트 충전 목록</h1>
        <hr />
        <p class="lead">충전한 포인트 목록입니다. 취소는 상세보기에서 가능하며 입금 확인 및 완료 전에 취소해야 합니다. 입금완료 후에는 포인트환불을 이용하세요.</p>
    </div>
    <?php echo bp_display_message(); ?>
    <div class="table-responsive table-wrap">
        <div class='text-right mb-2'>
            <?php if ($total_count > 0) { ?>
                <a href="<?php echo G5_PLUGIN_URL ?>/ask-point-charge/bp_point_refund.php" class="btn btn-danger btn-sm mr-1"> 포인트환불</a>
            <?php } ?>
            <a href="<?php echo G5_PLUGIN_URL ?>/ask-point-charge/bp_point_refund_list.php" class="btn btn-danger btn-sm mr-1"> 포인트환불 목록</a>
            <?php if ($config['bp_point_charge']) { ?>
                <a href="<?php echo G5_PLUGIN_URL ?>/ask-point-charge/bp_point_charge.php" class="btn btn-primary btn-sm">포인트충전</a>
            <?php } ?>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>포인트</th>
                    <th>은행</th>
                    <th>입금인</th>
                    <th>날짜</th>
                    <th>상태</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                ?>
                    <tr class="even">
                        <td>
                            <?php echo number_format($rows['bo_point']) ?>
                        </td>
                        <td>
                            <?php echo $rows['bo_bank'] ?>
                        </td>
                        <td>
                            <?php echo $rows['bo_name'] ?>
                        </td>
                        <td>
                            <?php echo $rows['bo_datetime'] ?>
                        </td>
                        <td>
                            <?php echo $rows['bo_order_state'] ?>
                        </td>
                        <td>
                            <a href='./bp_point_charge.php?idx=<?php echo $rows['bo_idx'] ?>&w=u' class="btn btn-secondary btn-sm">상세보기</a>
                        </td>
                    </tr>
                <?php
                } //for
                if ($i == 0) {
                    echo "<tr><td colspan='6' class='p-4'>포인트 충전 내역이 없습니다.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- 페이지 -->
    <div class="paging mb-3 pt-3 pb-3">
        <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='); ?>
    </div>
    <script>
        $(function() {
            //삭제 처리, 토큰 넘기기
            $(document).on("click", ".delete-item", function() {
                if (confirm('삭제하시겠습니까?')) {
                    var token = _get_delete_token();

                    if (!token) {
                        alert("토큰 정보가 올바르지 않습니다.");
                        return false;
                    }
                    var href = $(this).attr('href');
                    $(this).attr('href', href + '&token=' + token);
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>
</div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
