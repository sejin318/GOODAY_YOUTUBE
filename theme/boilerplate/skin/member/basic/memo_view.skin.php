<?php

/**
 * memo_view.skin.php
 * 쪽지내용
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

include_once G5_THEME_PATH . "/head.php";

$nick = get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']);
if ($kind == "recv") {
    $kind_str = "보낸";
    $kind_date = "받은";
} else {
    $kind_str = "받는";
    $kind_date = "보낸";
}
run_event('마이페이지메뉴', '마이페이지메뉴');
?>

<!-- 쪽지보기 시작 { -->
<div class="memo-wrap">
    <h2 class='page-title p-2 mb-3'>
        <?php echo $g5['title'] ?>
        <div class="page-count-info">전체 <?php echo $kind_title ?>쪽지 <?php echo $total_count ?>통<br></div>
    </h2>

    <div class="memo">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a href="./memo.php?kind=recv" class='nav-link <?php if ($kind == 'recv') {  ?>active<?php } ?>'>받은쪽지</a></li>
            <li class="nav-item"><a href="./memo.php?kind=send" class='nav-link <?php if ($kind == 'send') {  ?>active<?php } ?>'>보낸쪽지</a></li>
            <li class="nav-item"><a href="./memo_form.php" class='nav-link'>쪽지쓰기</a></li>
        </ul>
        <div class='memo-send-info mt-2'>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><?php echo $nick ?></li>
                <li class="breadcrumb-item"><span class="sound_only"><?php echo $kind_date ?>시간</span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $memo['me_send_datetime'] ?></li>
            </ul>
        </div>
        <article class='memo-contents p-2'>
            <!-- 회원메모 -->
            <?php include_once G5_PLUGIN_PATH . '/ask-member/user_memo.inc.php'; ?>
            <?php echo conv_content($memo['me_memo'], 0) ?>
        </article>
        <div class="form-action d-flex">
            <?php if ($kind == 'recv') {  ?>
                <div class='btn-group mr-auto'>
                    <a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>" class="btn btn-primary">답장</a>
                </div>
            <?php }  ?>
            <div class='btn-group mr-1'>
                <a href="<?php echo $list_link ?>" class="btn btn-secondary"><i class="fa fa-list" aria-hidden="true"></i><span class="sound_only">목록</span></a>
                <!-- 신고 -->
                <?php echo Asktools::button_memo_report($me_id, $kind); ?>
            </div>
            <div class='btn-group'>
                <?php if ($prev_link) {  ?>
                    <a href="<?php echo $prev_link ?>" class="btn btn-secondary"><i class="fa fa-chevron-left" aria-hidden="true"></i> 이전<span>쪽지</span></a>
                <?php }  ?>
                <?php if ($next_link) {  ?>
                    <a href="<?php echo $next_link ?>" class="btn btn-secondary">다음<span>쪽지</span> <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                <?php }  ?>
            </div>
            <div class='btn-group ml-1'>
                <a href="<?php echo $del_link ?>" onclick="del(this.href); return false;" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> <span class="sound_only">삭제</span></a>
            </div>
        </div>
    </div>
</div>
<!-- } 쪽지보기 끝 -->
<?php
include_once G5_THEME_PATH . "/tail.php";
