<?php
include_once('./_common.php');

if (!$is_member) {
    alert('회원전용 페이지 입니다.');
    exit;
}
$g5['title'] = 'Mypage - 다운로드 목록';
include_once(G5_THEME_PATH . '/head.php');

$list = array();

$sql_common = " from `" . BP_DOWNLOAD_TABLE . "` where bd_mb_id = '" . escape_trim($member['mb_id']) . "' ";
$sql_order = " order by bd_idx desc ";

$sql = " SELECT count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$list = array();
$sql = " SELECT * {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
?>
<div class='mypage-wrap'>
    <?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>
    <div class="jumbotron p-4">
        <h1 class="display-5">다운로드 목록</h1>
        <hr />
        <p class="lead">포인트로 콘텐츠를 다운로드 한 목록입니다. 다시 다운받으려면 다운로드 버튼을 클릭하세요. <br />이 페이지에서 다운받면 다시 포인트가 차감되지 않습니다.</p>
    </div>
    <div class="table-responsive table-wrap">
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>컨텐츠명</th>
                    <th>포인트</th>
                    <th>다운로드 횟수</th>
                    <th>날짜</th>
                    <th>다운로드</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $row = sql_fetch_array($result); $i++) { ?>
                    <tr>
                        <td>
                            <a href='<?php echo get_pretty_url($row['bd_bo_table'], $row['bd_wr_id']) ?>'><?php echo $row['bd_content'] ?></a>
                        </td>
                        <td>
                            -<?php echo number_format($row['bd_point']) ?>
                        </td>
                        <td>
                            <?php echo $row['bd_down_count'] ?>
                        </td>
                        <td>
                            <?php echo $row['bd_datetime'] ?>
                        </td>
                        <td>
                            <a href='./my_content_download.php?idx=<?php echo $row['bd_idx'] ?>' class='btn btn-secondary btn-sm download-item'><i class="fa fa-download" aria-hidden="true"></i> 다운로드</a>
                        </td>
                    </tr>
                <?php
                } //for

                if ($i == 0) {
                    echo '<td colspan="5" class="empty_li">자료가 없습니다.</td>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        $(function() {
            //토큰 넘기기
            $(document).on("click", ".download-item", function() {
                if (confirm('다운받으시겠습니까? 콘텐츠 구매 목록에서 다운로드시 포인트를 차감하지 않습니다.')) {
                    var href = $(this).attr("href") + "&js=on";
                    $(this).attr("href", href);

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

    <!-- 페이지 -->
    <div class="paging mb-3 pt-3 pb-3">
        <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='); ?>
    </div>
</div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
