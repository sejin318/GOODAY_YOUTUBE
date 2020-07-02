<?php
include_once('./_common.php');

if (!$is_member) {
    alert('회원전용 페이지 입니다.');
    exit;
}
$g5['title'] = 'Mypage - 포인트순위';
include_once(G5_THEME_PATH . '/head.php');
$pr = ASKDB::point_rank(50);
$rank = "SELECT COUNT(*) + 1 as cnt FROM {$g5['member_table']} WHERE mb_point > ( SELECT `mb_point` FROM {$g5['member_table']} WHERE mb_id =  '" . escape_trim($member['mb_id']) . "' );";
$my_rank = sql_fetch($rank, true);
?>
<div class='mypage-wrap'>
    <?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>
    <div class="jumbotron p-4">
        <h1 class="display-5">포인트 순위</h1>
        <hr />
        <p class="lead">포인트 순위를 출력합니다. 나의 순위는 <?php echo $my_rank['cnt'] ?>등 입니다.</p>
    </div>
    <div class="table-responsive table-wrap">
        <table class="table table-bordered">
            <caption>
                보유포인트
                <span><?php echo number_format($member['mb_point']); ?></span>
            </caption>
            <thead class="thead-dark">
                <tr>
                    <th>순위</th>
                    <th>회원</th>
                    <th>포인트</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($pr as $point_rank) {
                ?>
                    <tr class="">
                        <td><?php echo $i ?>위</td>
                        <td>
                            <?php echo $point_rank['mb_nick']; ?>
                        </td>
                        <td>
                            <?php echo number_format($point_rank['mb_point']); ?>
                        </td>
                    </tr>
                <?php
                    $i++;
                } //for
                ?>
            </tbody>
        </table>
    </div>

</div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
