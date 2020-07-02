<?php
include_once('./_common.php');

if (!$is_member) {
    alert('회원전용 페이지 입니다.');
    exit;
}
$g5['title'] = 'Mypage - 신고내역';
include_once(G5_THEME_PATH . '/head.php');


if ($page < 1) {
    $page = 1;
}

$page_rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];

$list_page_rows = PAGING_ROWS;
$total_count = DB::report_count(false, $member['mb_id']);
$_data['total_count'] = $total_count;
$total_page = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
$_data['paging'] = Asktools::paging(5, $page, $total_page, './my_report.php?search_text=' . $search_text);
$_data['report_list'] = DB::report_total_list($from_record, $page_rows, false, $member['mb_id']);

?>
<script type="text/javascript">
    $(function() {
        $('.go-list').click(function() {
            location.replace('./mb_report_list.php');
        });
    });
</script>
<div class='mypage-wrap' id="report_list">
    <?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>
    <div class="jumbotron p-4">
        <h1 class="display-5">신고내역</h1>
        <hr />
        <p class="lead">신고한 내역 및 처리 결과입니다.</p>
    </div>
    <?php echo bp_display_message() ?>

    <div class='contents-box'>
        <div class="report_list table-responsive">
            <span class="badge badge-info badge-lg">신고 수 : <?php echo $_data['total_count'] ?></span>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>피신고자</th>
                        <th>신고사유</th>
                        <th>신고시간</th>
                        <th>처리시간</th>
                        <th>처리내역</th>
                        <th>보기</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $k = 0;
                    foreach ($_data['report_list'] as $list) { ?>
                        <tr>
                            <td>
                                <?php
                                $list_num = $total_count - ($page - 1) * $list_page_rows;
                                echo $list_num - $k;
                                ?>
                            </td>
                            <td>
                                <?php echo DB::get_member_nick($list['ar_mb_id']) ?></a>
                            </td>
                            <td>
                                <?php echo $list['ar_reason'] ?>
                            </td>
                            <td>
                                <?php echo $list['ar_datetime'] ?>
                            </td>
                            <td>
                                <?php echo $list['as_datetime'] ? $list['as_datetime'] : "<span class='badge badge-info'>미처리</span>"; ?>
                            </td>
                            <td>
                                <?php
                                if ($list['as_type'] == 'reject') {
                                    echo '사유 불충분';
                                } elseif ($list['as_type'] == 'all') {
                                    echo "글쓰기/쪽지 차단";
                                } elseif ($list['as_type'] == 'memo') {
                                    echo "쪽지차단";
                                } elseif ($list['as_type'] == 'write') {
                                    echo '글쓰기차단';
                                } else {
                                    echo "<span class='badge badge-info'>미처리</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($list['ar_type'] == 'board') { ?>
                                    <a href='<?php echo short_url_clean(G5_BBS_URL . "/board.php?bo_table={$list['ar_bo_table']}&amp;wr_id={$list['ar_wr_id']}"); ?>' target='_blank'>게시물<i class="fa fa-external-link" aria-hidden="true"></i></a>
                                <?php } else { ?>
                                    메모
                                <?php } ?>
                            </td>
                        </tr>
                    <?php
                        $k++;
                    } ?>
                    <?php if (!$_data['report_list']) { ?>
                        <tr>
                            <td colspan='7'>
                                신고목록이 없습니다.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class='paging d-flex justify-content-center'>
            <?php echo $_data['paging'] ?>
        </div>
    </div>
</div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
