<?php
include_once('./_common.php');

if (!$is_member) {
    alert('회원전용 페이지 입니다.');
    exit;
}
$g5['title'] = 'Mypage - 내알람';
include_once(G5_THEME_PATH . '/head.php');

$list = array();

$sql_common = " from  `" . BP_ALARM_TABLE . "` where ba_mb_id = '" . escape_trim($member['mb_id']) . "' ";
$sql_order = " order by ba_idx desc ";

$sql = " SELECT count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$rows =  G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];
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
        <h1 class="display-5">내 알람</h1>
        <hr />
        <p class="lead">게시판 댓글, 쪽지 등에 관한 알람 목록입니다. 현재 총 알람(<?php echo $total_count ?>)개</p>
    </div>
    <?php echo bp_display_message(); ?>
    <div class="table-responsive table-wrap">
        <div class='btn-navbar mb-1 d-flex justify-content-between'>
            <div class="btn-group mr-auto">
                <a href='<?php echo G5_PLUGIN_URL . "/ask-alarm/alarm_read_all.php?type=alldelete" ?>' class='btn btn-secondary alarm-alldelete' data-message='모두삭제'><i class="fa fa-trash-o" aria-hidden="true"></i> 모두삭제</a>
            </div>
            <div class="btn-group ml-auto">
                <a href='<?php echo G5_PLUGIN_URL . "/ask-alarm/alarm_read_all.php?type=allread" ?>' class='btn btn-primary alarm-allread' data-message='모두읽기'><i class="fa fa-eye" aria-hidden="true"></i> 모두읽기</a>
            </div>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>알람</th>
                    <th>내용</th>
                    <th>상태</th>
                    <th>관리</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                ?>
                    <tr>
                        <td class="text-center">
                            <?php echo $rows['ba_type'] == 'comment' ? '<i class="fa fa-comment" aria-hidden="true"></i> 댓글' : ""; ?>
                            <?php echo $rows['ba_type'] == 'reply' ? '<i class="fa fa-reply" aria-hidden="true"></i> 답글' : ""; ?>
                            <?php echo $rows['ba_type'] == 'memo' ? '<i class="fa fa-envelope-open-o" aria-hidden="true"></i> 쪽지' : ""; ?>
                            <?php echo $rows['ba_type'] == 'qna' ? '<i class="fa fa-question" aria-hidden="true"></i> 1:1문의' : ""; ?>
                        </td>
                        <td>
                            <strong><?php echo $rows['ba_name'] ?></strong>님이
                            <?php if (($rows['ba_type'] == 'comment' || $rows['ba_type'] == 'reply') && $rows['ba_bo_table'] && $rows['ba_wr_id']) { ?>
                                <!-- 댓글 -->
                                <?php echo $rows['ba_bo_subject'] != '' ? "<a href='" . G5_PLUGIN_URL . DIRECTORY_SEPARATOR . "ask-alarm/alarm_link.php?ba_idx={$rows['ba_idx']}'  class='text-link'>[" . $rows['ba_bo_subject'] . "] " : ""; ?>
                                <?php echo $rows['ba_wr_subject'] != '' ? cut_str($rows['ba_wr_subject'], 20) . ' </a> 게시물에 댓글을 남겼습니다.' : ""; ?>
                            <?php } ?>
                            <?php if ($rows['ba_type'] == 'qna') { ?>
                                <!-- 1:1문의-->
                                <?php echo $rows['ba_bo_subject'] != '' ? "<a href='" . G5_PLUGIN_URL . DIRECTORY_SEPARATOR . "ask-alarm/alarm_link.php?ba_idx={$rows['ba_idx']}'  class='text-link'>[" . $rows['ba_bo_subject'] . "] " : ""; ?>
                                <?php echo $rows['ba_wr_subject'] != '' ? cut_str($rows['ba_wr_subject'], 20) . ' </a> 에 답변을 남겼습니다.' : ""; ?>
                            <?php } ?>

                            <?php if ($rows['ba_type'] == 'memo') { ?>
                                <!-- 쪽지 -->
                                <?php echo $rows['ba_wr_subject'] != '' ? "<a href='" . G5_PLUGIN_URL . DIRECTORY_SEPARATOR . "ask-alarm/alarm_link.php?ba_idx={$rows['ba_idx']}'  class='text-link'>[" . cut_str($rows['ba_wr_subject'], 20) . "]</a> 쪽지를 발송하였습니다. " : ""; ?>
                            <?php } ?>

                        </td>
                        <td class="text-center">
                            <?php echo $rows['ba_read'] ? "<span class=''><i class='fa fa-folder-open-o' aria-hidden='true'></i> <span class='d-none d-lg-inline'>읽음</span></span>" : "<span class=''><i class='fa fa-folder' aria-hidden='true'></i></span>"; ?>
                        </td>
                        <td class="text-center">
                            <a href='<?php echo G5_PLUGIN_URL . "/ask-alarm/alarm_read_all.php?type=delete&ba_idx={$rows['ba_idx']}&page={$page}" ?>' class='btn btn-danger delete-item' data-message='삭제'> <i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php
                } //for
                if($total_count == 0){
                    echo "<tr><td colspan='5' class='text-center p-4'>알람이 없습니다.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        $(function() {
            //삭제 처리, 토큰 넘기기
            $(document).on("click", ".delete-item, .alarm-allread, .alarm-alldelete", function() {
                var jobMessage = $(this).data('message');
                if (confirm(jobMessage + ' 하시겠습니까?')) {
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
