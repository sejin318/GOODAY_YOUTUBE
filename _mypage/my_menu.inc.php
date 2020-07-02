<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
//dark 테마일 경우 메뉴 배경
$navbar = 'navbar-light bg-light';
if($config['bp_colorset'] =='colorset.dark.css'){
    $navbar = 'navbar-dark bg-dark';
}

?>
<div class='mypage-menu-wrap mb-2'>
    <nav class="navbar navbar-expand-lg <?php echo $navbar;?> ">
        <a class="navbar-brand" href="<?php echo BP_MYPAGE_URL ?>"><i class="fa fa-home" aria-hidden="true"></i> <span class="d-sm-inline d-lg-none">Mypage</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mypage-navbar" aria-controls="mypage-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mypage-navbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href='<?php echo G5_BBS_URL ?>/memo.php' class='nav-link mr-1'> <i class="fa fa-envelope" aria-hidden="true"></i> <span class="mypage-links">쪽지</span></a>
                </li>
                <li class="nav-item <?php echo strstr($_SERVER['PHP_SELF'], 'my_article') ? "active" : ""; ?>">
                    <a href='<?php echo BP_MYPAGE_URL ?>/my_article.php' class='nav-link mr-1'> <i class="fa fa-list" aria-hidden="true"></i> <span class="mypage-links">내글</span></a>
                </li>
                <li class="nav-item">
                    <a href='<?php echo BP_MYPAGE_URL ?>/my_point.php' class='nav-link mr-1'> <i class="fa fa-money" aria-hidden="true"></i> <span class="mypage-links">포인트</span></a>
                </li>
                <li class="nav-item">
                    <a href='<?php echo BP_MYPAGE_URL ?>/my_point_rank.php' class='nav-link mr-1'> <i class="fa fa-trophy" aria-hidden="true"></i> <span class="mypage-links">포인트순위</span></a>
                </li>
                <li class="nav-item">
                    <a href='<?php echo G5_BBS_URL ?>/scrap.php' class='nav-link mr-1'> <i class="fa fa-bookmark" aria-hidden="true"></i> <span class="mypage-links">스크랩</span></a>
                </li>
                <li class="nav-item">
                    <a href='<?php echo BP_MYPAGE_URL ?>/my_download.php' class='nav-link mr-1'> <i class="fa fa-download" aria-hidden="true"></i> <span class="mypage-links">다운로드</span></a>
                </li>
                <?php if ($config['bp_use_favorite']) { ?>
                    <li class="nav-item">
                        <a href='<?php echo BP_MYPAGE_URL ?>/my_favorite.php' class='nav-link mr-1'> <i class="fa fa-star" aria-hidden="true"></i> <span class="mypage-links">즐겨찾기</span></a>
                    </li>
                <?php } ?>
                <?php if ($config['bp_use_alarm']) { ?>
                    <li class="nav-item">
                        <a href='<?php echo BP_MYPAGE_URL ?>/my_alarm.php' class='nav-link mr-1'> <i class="fa fa-bell" aria-hidden="true"></i> <span class="mypage-links">알람</span></a>
                    </li>
                <?php } ?>
                <?php if ($config['bp_use_report']) { ?>
                    <li class="nav-item">
                        <a href='<?php echo BP_MYPAGE_URL ?>/my_report.php' class='nav-link'> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="mypage-links">신고내역</span></a>
                    </li>
                <?php } ?>
                <?php if ($config['bp_member_memo']) { ?>
                    <li class="nav-item">
                        <a href='<?php echo BP_MYPAGE_URL ?>/my_memo.php' class='nav-link'> <i class="fa fa-envelope-open" aria-hidden="true"></i> <span class="mypage-links">회원메모</span></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</div>