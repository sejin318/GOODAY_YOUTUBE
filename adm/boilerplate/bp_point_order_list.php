<?php
$sub_menu = "800500";
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

$g5['title'] = 'Boilerplate  포인트 주문 목록';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');

$sql_common = " from  `" . BP_POINT_CHARGE_TABLE . "` ";
$sql_order = " order by bo_idx desc ";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and (bo_mb_id like '%{$stx}%' or bo_name like '%{$stx}%') ";
}


$sql = " SELECT count(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " SELECT * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql, true);
?>
<div class='mypage-wrap'>
    <div class="jumbotron p-4">
        <h1 class="display-5">포인트 주문 목록</h1>
        <hr />
        <p class="lead">회원이 주문한 포인트 목록.</p>
    </div>
    <?php echo bp_display_message(); ?>
    <div class="table-responsive table-wrap">
        <div class="search-wrap">
            <form action="./bp_point_order_list.php" method="get">
                <div class="ml-auto mr-auto w-100 mb-2">
                    <div class="input-group">
                        <input type="text" name="stx" value="<?php echo $stx ?>" class="form-control" placeholder="아이디, 입금인 검색" />
                        <?php if ($stx) {
                            echo '<button type="button" class="btn btn-danger" onclick="location.href=\'./bp_point_order_list.php\'"><i class="fa fa-close" aria-hidden="true"></i></button>';
                        } ?>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>아이디</th>
                    <th>포인트</th>
                    <th>은행</th>
                    <th>입금인</th>
                    <th>주문날짜</th>
                    <th>상태</th>
                    <th>관리</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                    $bg = '';
                    if ($rows['bo_order_state'] == '취소') {
                        $bg = 'bg-secondary text-white';
                    }
                    if ($rows['bo_order_state'] == '완료') {
                        $bg = 'bg-success text-white';
                    }
                    if ($rows['bo_order_state'] == '주문') {
                        $bg = 'font-weight-bolder';
                    }
                ?>
                    <tr class="text-center <?php echo $bg ?>">
                        <td>
                            <?php echo $rows['bo_mb_id'] ?>
                        </td>
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
                            <a href='./bp_point_order.php?idx=<?php echo $rows['bo_idx'] ?>&w=u&page=<?php echo $page ?>' class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php
                } //for
                ?>
            </tbody>
        </table>
        <?php if ($stx) { ?>
            <div class='text-right'>
                <a href='./bp_point_order_list.php' class="btn btn-primary"><i class="fa fa-list" aria-hidden="true"></i> 목록</a>
            </div>
        <?php } ?>
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
include_once G5_ADMIN_PATH . '/admin.tail.php';
