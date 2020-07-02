<?php
include_once('./_common.php');

if (!$is_member) {
    alert('회원전용 페이지 입니다.');
    exit;
}
$g5['title'] = 'Mypage - 메모';
include_once(G5_THEME_PATH . '/head.php');


if ($page < 1) {
    $page = 1;
}

$page_rows =  G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];;
$list_page_rows =  G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];;
$total_count = DB::member_memo_count($member['mb_id']);
$_data['total_count'] = $total_count;
$total_page = ceil($total_count / $page_rows);  // 전체 페이지 계산
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
$_data['paging'] = Asktools::paging(5, $page, $total_page, './my_memo.php?');
$_data['memo_list'] = DB::member_memo_total_list($from_record, $page_rows, $member['mb_id']);
?>
<script type="text/javascript">
    $(function() {
        $('.go-list').click(function() {
            location.replace('./mb_memo_list.php');
        });
    });
</script>
<div class='mypage-wrap' id="memo_list">
    <?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>
    <div class="jumbotron p-4">
        <h1 class="display-5">메모내역</h1>
        <hr />
        <p class="lead">회원 메모 내역입니다.</p>
    </div>
    <?php echo bp_display_message() ?>

    <div class='contents-box'>
        <div class="memo_list table-responsive">

            <div class='btn-navbar mb-1 d-flex justify-content-between'>
                <div class="btn-group ml-auto">
                    <a href='<?php echo G5_PLUGIN_URL . "/ask-member/user_memo_man.php?type=alldelete" ?>' class='btn btn-danger alarm-alldelete' data-message='모두삭제'><i class="fa fa-trash-o" aria-hidden="true"></i> 모두삭제</a>
                </div>
            </div> <span class="badge badge-info badge-lg">회원메모 수 : <?php echo $_data['total_count'] ?></span>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>회원</th>
                        <th>메모내용</th>
                        <th>관리</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $k = 0;
                    foreach ($_data['memo_list'] as $list) { ?>
                        <tr>
                            <td>
                                <?php
                                $list_num = $total_count - ($page - 1) * $list_page_rows;
                                echo $list_num - $k;
                                ?>
                            </td>
                            <td>
                                <?php echo DB::get_member_nick($list['bm_memo_mb_id']) ?></a>
                            </td>
                            <td>
                                <?php echo $list['bm_memo'] ?>
                            </td>
                            <td>
                                <a href='<?php echo G5_PLUGIN_URL . "/ask-member/user_memo_man.php?type=delete&bm_idx={$list['bm_idx']}&page={$page}" ?>' class='btn btn-danger delete-item' data-message='삭제'> <i class="fa fa-trash" aria-hidden="true"></i></a>

                            </td>
                        </tr>
                    <?php
                        $k++;
                    } ?>
                    <?php if (!$_data['memo_list']) { ?>
                        <tr>
                            <td colspan='4' class="p-4 text-center">
                                메모내역이 없습니다.
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
</div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
