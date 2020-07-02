<?php
include_once('./_common.php');

if (!$is_member) {
    alert('회원전용 페이지 입니다.');
    exit;
}
$g5['title'] = 'Mypage - 내최신글';
include_once(G5_THEME_PATH . '/head.php');

$sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id and b.bo_use_search = 1 ";
$gr_id = isset($_GET['gr_id']) ? substr(preg_replace('#[^a-z0-9_]#i', '', $_GET['gr_id']), 0, 10) : '';
if ($gr_id) {
    $sql_common .= " and b.gr_id = '$gr_id' ";
}

$mb_id = escape_trim($member['mb_id']);

if ($mb_id) {
    $sql_common .= " and a.mb_id = '{$mb_id}' ";
}
$sql_order = " order by a.bn_id desc ";
$sql = " SELECT count(*) as cnt {$sql_common} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_new_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$list = array();
$sql = " SELECT a.*, b.bo_subject, b.bo_mobile_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

    if ($row['wr_id'] == $row['wr_parent']) {

        // 원글
        $comment = "";
        $comment_link = "";
        $row2 = sql_fetch(" SELECT * from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");
        $list[$i] = $row2;

        $name = get_sideview($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);
        // 당일인 경우 시간으로 표시함
        $datetime = substr($row2['wr_datetime'], 0, 10);
        $datetime2 = $row2['wr_datetime'];
        if ($datetime == G5_TIME_YMD) {
            $datetime2 = substr($datetime2, 11, 5);
        } else {
            $datetime2 = substr($datetime2, 5, 5);
        }
    } else {

        // 코멘트
        $comment = '[코] ';
        $comment_link = '#c_' . $row['wr_id'];
        $row2 = sql_fetch(" SELECT * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
        $row3 = sql_fetch(" SELECT mb_id, wr_name, wr_email, wr_homepage, wr_datetime from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");
        $list[$i] = $row2;
        $list[$i]['wr_id'] = $row['wr_id'];
        $list[$i]['mb_id'] = $row3['mb_id'];
        $list[$i]['wr_name'] = $row3['wr_name'];
        $list[$i]['wr_email'] = $row3['wr_email'];
        $list[$i]['wr_homepage'] = $row3['wr_homepage'];

        $name = get_sideview($row3['mb_id'], get_text(cut_str($row3['wr_name'], $config['cf_cut_name'])), $row3['wr_email'], $row3['wr_homepage']);
        // 당일인 경우 시간으로 표시함
        $datetime = substr($row3['wr_datetime'], 0, 10);
        $datetime2 = $row3['wr_datetime'];
        if ($datetime == G5_TIME_YMD) {
            $datetime2 = substr($datetime2, 11, 5);
        } else {
            $datetime2 = substr($datetime2, 5, 5);
        }
    }

    $list[$i]['gr_id'] = $row['gr_id'];
    $list[$i]['bo_table'] = $row['bo_table'];
    $list[$i]['name'] = $name;
    $list[$i]['comment'] = $comment;
    $list[$i]['href'] = get_pretty_url($row['bo_table'], $row2['wr_id'], $comment_link);
    $list[$i]['datetime'] = $datetime;
    $list[$i]['datetime2'] = $datetime2;

    $list[$i]['gr_subject'] = $row['gr_subject'];
    $list[$i]['bo_subject'] = ((G5_IS_MOBILE && $row['bo_mobile_subject']) ? $row['bo_mobile_subject'] : $row['bo_subject']);
    $list[$i]['wr_subject'] = $row2['wr_subject'];
}

$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?gr_id={$gr_id}&amp;page=");

?>
<div class='mypage-wrap'>
    <?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>
    <div class="jumbotron p-4">
        <h1 class="display-5">내최신글</h1>
        <hr />
        <p class="lead">내가 작성한 최신글 목록, 작성 후 <?php echo $config['cf_new_del'] ?>일이 지나면 목록은 삭제됩니다.</p>
    </div>
    <div class="new-board-list">
        <div class="table-wrap">
            <?php if ($gr_id) { ?>
                <div class='btn-group mb-1'>
                    <a href="./my_article.php" class='btn btn-primary'>전체목록</a>
                </div>
            <?php } ?>
            <table class='table table-striped'>
                <thead class='thead-dark'>
                    <tr>
                        <th class='new-group'>그룹</th>
                        <th class='new-board'>게시판</th>
                        <th class='new-subject'>제목</th>
                        <th class='new-name'>이름</th>
                        <th class="new-date">일시</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($list); $i++) {
                        $num = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
                        $gr_subject = cut_str($list[$i]['gr_subject'], 20);
                        $bo_subject = cut_str($list[$i]['bo_subject'], 20);
                        $wr_subject = get_text(cut_str($list[$i]['wr_subject'], 40));
                    ?>
                        <tr>
                            <td class="new-group"><a href="./my_article.php?gr_id=<?php echo $list[$i]['gr_id'] ?>"><?php echo $gr_subject ?></a></td>
                            <td class="new-board"><a href="<?php echo get_pretty_url($list[$i]['bo_table']); ?>"><?php echo $bo_subject ?></a></td>
                            <td class="new-subject">
                                <a href="<?php echo $list[$i]['href'] ?>" class="new_tit"><?php echo $list[$i]['comment'] ?><?php echo $wr_subject ?></a>
                                <div class="write-info">
                                    <a href="./new.php?gr_id=<?php echo $list[$i]['gr_id'] ?>"><?php echo $gr_subject ?></a> /
                                    <a href="<?php echo G5_URL . DIRECTORY_SEPARATOR . $list[$i]['bo_table'] ?>"><?php echo $bo_subject ?></a> /
                                    <?php echo $list[$i]['name'] ?> /
                                    <?php echo $list[$i]['datetime2'] ?>
                                </div>
                            </td>
                            <td class="new-name"><?php echo $list[$i]['name'] ?></td>
                            <td class="new-date"><?php echo $list[$i]['datetime2'] ?></td>
                        </tr>
                    <?php }  ?>

                    <?php if ($i == 0)
                        echo '<tr><td colspan="' . $colspan . '" class="empty_table">게시물이 없습니다.</td></tr>';
                    ?>
                </tbody>
            </table>
        </div>

        <div class='paging mb-3 pt-3 pb-3'>
            <!-- 페이지 -->
            <?php echo $write_pages; ?>
            <!-- 페이지 -->
        </div>

        <!-- } 전체게시물 목록 끝 -->
    </div>
</div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
