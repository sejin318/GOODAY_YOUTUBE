<?php
include_once('./_common.php');

if (!$is_member) {
    alert('회원전용 페이지 입니다.');
    exit;
}
$g5['title'] = 'Mypage - 즐겨찾기';
include_once(G5_THEME_PATH . '/head.php');
$sql = "SELECT * from `" . BP_FAVORITE_TABLE . "` where `bf_mb_id` = '" . escape_trim($member['mb_id']) . "'";
$result = sql_query($sql);
?>
<div class='mypage-wrap'>
    <?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>
    <div class="jumbotron p-4">
        <h1 class="display-5">게시판 즐겨찾기</h1>
        <hr />
        <p class="lead">즐겨찾기 추가/삭제는 게시판 목록 상단에서 가능합니다.</p>
    </div>
    <?php echo bp_display_message(); ?>
    <div class="table-responsive table-wrap">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>게시판</th>
                    <th>관리</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                ?>
                    <tr class="">
                        <td>
                            <a href='<?php echo  get_pretty_url($rows['bf_bo_table']); ?>'><?php echo $rows['bf_subject']; ?></a> <i class="fa fa-link" aria-hidden="true"></i>
                        </td>
                        <td>
                            <a href='<?php echo G5_PLUGIN_URL . DIRECTORY_SEPARATOR . 'ask-favorite/favorite_delete.php' ?>?idx=<?php echo $rows['bf_idx'] ?>' class='btn btn-danger delete-item'><i class="fa fa-trash" aria-hidden="true"></i> 삭제</a>
                        </td>
                    </tr>
                <?php
                } //for
                ?>
            </tbody>
        </table>
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
