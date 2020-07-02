<?php
$sub_menu = "800221";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

if (ASKDB::exsit_table(AT_REPORT_TABLE) == false) {
    //테마 설치 후 이용하세요.
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}
$g5['title'] = 'Boilerplate - 회원신고 모록';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');

if ($page < 1) {
    $page = 1;
}

$page_rows = PAGING_ROWS;

$total_count = DB::report_count($search_text);
$_data['total_count'] = $total_count;
$total_page = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
$_data['paging'] = Asktools::paging(5, $page, $total_page, './mb_report_list.php?search_text=' . $search_text);

$_data['report_list'] = DB::report_total_list($from_record, $page_rows, $search_text);
?>
<script type="text/javascript">
    $(function() {
        $('.go-list').click(function() {
            location.replace('./mb_report_list.php');
        });
    });
</script>
<div class='report-list-wrap' id="report_list">
    <div class="jumbotron p-5">
        <h1>회원 신고 목록</h1>
        <p class="lead">
            회원이 신고한 목록입니다.
        </p>
    </div>
    <?php echo bp_display_message() ?>

    <div class='contents-box'>
        <h2 class="frm-head"><?php echo $g5['title'] ?></h2>
        <div class="report_list">
            <div class="list-search mb-2">
                <form action="./mb_report_list.php" method="get" class="form">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search_text" value="<?php echo $search_text ?>" required placeholder="회원아이디 입력">
                        <span class="input-group-append">
                            <?php if ($search_text) { ?>
                                <button class="btn btn-secondary go-list" type="reset"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                            <?php } ?>
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </span>
                    </div><!-- /input-group -->
                </form>
            </div>
            <span class="badge badge-info badge-lg">신고 수 : <?php echo $_data['total_count'] ?></span>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>신고자</th>
                        <th>피신고자</th>
                        <th>신고사유</th>
                        <th>신고시간</th>
                        <th>처리시간</th>
                        <th>처리내역</th>
                        <th>보기</th>
                        <th>관리</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_data['report_list'] as $list) { ?>
                        <tr>
                            <td>
                                <?php echo $list['ar_idx'] ?>
                            </td>
                            <td>
                                <a href="<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&mb_id=<?php echo $list['ar_reporter_id'] ?>" target="_blank"><?php echo $list['ar_reporter_id'] ?> <i class="fa fa-external-link" aria-hidden="true"></i></a>
                            </td>
                            <td>
                                <a href="<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&mb_id=<?php echo $list['ar_mb_id'] ?>" target="_blank"><?php echo $list['ar_mb_id'] ?> <i class="fa fa-external-link" aria-hidden="true"></i></a>
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
                            <td>
                                <?php if ($list['ar_sanction_idx'] == 0) { ?>
                                    <a href='./mb_report_sanction.php?idx=<?php echo $list['ar_idx'] ?>&amp;page=<?php echo $page ?>&amp;list=report' class='btn btn-danger btn-sm'>미처리</a>
                                <?php } else { ?>
                                    <a href='./mb_report_sanction.php?idx=<?php echo $list['ar_idx'] ?>&amp;w=u&amp;page=<?php echo $page ?>&amp;list=report' class='btn btn-warning btn-sm'>수정</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (!$_data['report_list']) { ?>
                        <tr>
                            <td colspan='8'>
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
include_once G5_ADMIN_PATH . '/admin.tail.php';
