<?php
include_once('./_common.php');

if (!$is_member) {
    alert('회원전용 페이지 입니다.');
    exit;
}
$g5['title'] = 'Mypage';
include_once(G5_THEME_PATH . '/head.php');
?>
<?php include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . "./my_menu.inc.php"; ?>

<div class="jumbotron p-4">
    <h1 class="display-5">MYPAGE</h1>
    <p class="lead">개인화 페이지 입니다. 사이트 활동 내역을 확인 할 수 있습니다.</p>
</div>
<div class="mypage-wrap">
    <div class='table-responsive'>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th class='text-right'>아이디</th>
                    <td><?php echo $member['mb_id'] ?></td>
                    <th class='text-right'>별명</th>
                    <td><?php echo $member['mb_nick'] ?></td>
                </tr>
                <tr>
                    <th class='text-right'>포인트</th>
                    <td><?php echo number_format($member['mb_point']) ?>Point</td>
                    <th class='text-right'>포인트순위</th>
                    <td>
                        <?php
                        $rank = "SELECT COUNT(*) + 1 as cnt FROM {$g5['member_table']} WHERE mb_point > ( SELECT `mb_point` FROM {$g5['member_table']} WHERE mb_id =  '" . escape_trim($member['mb_id']) . "' );";
                        $my_rank = sql_fetch($rank, true);
                        echo $my_rank['cnt'] . '위';
                        ?>
                    </td>
                </tr>
                <tr>
                    <th class='text-right'>최근 로그인 IP</th>
                    <td><?php echo $member['mb_login_ip'] ?></td>
                    <th class='text-right'>최근 로그인 날짜</th>
                    <td><?php echo $member['mb_today_login'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <?php $my_latest = ASKDB::get_mylatest(5); ?>
            <div class="card mb-2">
                <div class="card-header">
                    <a href='<?php echo BP_MYPAGE_URL ?>/my_article.php'>내 최신글</a>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    if ($my_latest) {
                        foreach ($my_latest as $list) {
                            echo "<li class='list-group-item text-cut'><a href='" . get_pretty_url($list['bo_table']) . "'>" . get_text(cut_str($list['wr_subject'], 30)) . "</a></li>";
                        }
                        unset($list);
                    } else {
                        echo '<li class="list-group-item text-center p-4">내 최신글이 없습니다.</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="col-sm-12 col-lg-4">
            <?php $my_memo = ASKDB::get_mymemo(5); ?>
            <div class="card mb-2">
                <div class="card-header">
                    <a href='<?php echo G5_BBS_URL ?>/memo.php'>받은쪽지</a>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    if ($my_memo) {
                        foreach ($my_memo as $list) {
                            echo "<li class='list-group-item text-cut'>{$list['is_read']} [" . DB::get_member_nick($list['me_send_mb_id']) . "] <a href='" . $list['view_href'] . "'>" . get_text(cut_str($list['me_memo'], 30)) . "</a></li>";
                        }
                        unset($list);
                    } else {
                        echo '<li class="list-group-item text-center p-4">쪽지가 없습니다.</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4">
            <?php $my_point = ASKDB::get_mypoint(5); ?>
            <div class="card mb-2">
                <div class="card-header">
                    <a href='<?php echo BP_MYPAGE_URL ?>/my_point.php'>내포인트</a>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    if ($my_point) {
                        foreach ($my_point as $list) {
                            if ($list['point1']) {
                                $point = $list['point1'];
                            } else {
                                $point = $list['point2'];
                            }
                            echo "<li class='list-group-item text-cut {$list['expired_class']}'>{$point} : {$list['po_content']} {$list['po_expire_date']}</li>";
                        }
                        unset($list);
                    } else {
                        echo '<li class="list-group-item text-center p-4">포인트 내역이 없습니다.</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <div class="card mb-2">
                <div class="card-header">
                    <a href='<?php echo G5_BBS_URL ?>/scrap.php'>스크랩</a>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    $my_scrap = ASKDB::get_myscrap(5);
                    if ($my_scrap) {
                        foreach ($my_scrap as $list) {
                            echo "<li class='list-group-item text-cut'><a href='{$list['opener_href_wr_id']}'>{$list['bo_subject']} {$list['subject']}</a></li>";
                        }
                        unset($list);
                    } else {
                        echo '<li class="list-group-item text-center p-4">스크랩이 없습니다.</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4">
            <div class="card mb-2">
                <div class="card-header">
                    <a href='<?php echo BP_MYPAGE_URL ?>/my_favorite.php'>즐겨찾기</a>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    $my_favorite = ASKDB::get_myfavorite(5);
                    if ($my_favorite) {
                        foreach ($my_favorite as $list) {
                            echo "<li class='list-group-item text-cut'><a href='" . get_pretty_url($list['bo_table']) . "'>{$list['bo_subject']}</a> <i class='fa fa-link' aria-hidden='true'></i></li>";
                        }
                        unset($list);
                    } else {
                        echo '<li class="list-group-item text-center p-4">스크랩이 없습니다.</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4">
            <div class="card mb-2">
                <div class="card-header">
                    <a href='<?php echo BP_MYPAGE_URL ?>/my_alarm.php'>알람</a>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    $my_alarm = ASKDB::get_myalarm(5);
                    if ($my_alarm) {
                        echo $my_alarm;
                    } else {
                        echo '<li class="list-group-item text-center p-4">스크랩이 없습니다.</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

    </div>

</div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
