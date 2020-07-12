<?php

/**
 * outlogin.skin.2.php
 * 소셜 로그인 스킨
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 *
 * 아웃로그인 - 로그아웃
 */

if (!defined("_GNUBOARD_")) {
    exit; // 개별 페이지 접근 불가
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/outlogin/outlogin.basic.css\">", 50);
?>
<!-- 로그인 후 아웃로그인 시작 { -->
<section class='outlogin-basic-wrap border background-9'>
    <h2 class="sr-only">나의 회원정보</h2>
    <div id="ol_after_hd" class='d-flex member-info p-2 border-color-7'>
        <!-- <div class="profile-image flex-shrink-1">
            <?php echo get_member_profile_img($member['mb_id']); ?>
        </div> -->
        <div class="w-100 align-self-center">
            <span class="nick-name"><?php echo $nick ?></span>님
            <div class='member-modify btn-navbar pt-1'>
                <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" id="ol_after_info" title="정보수정" class=''><i class="fa fa-pencil" aria-hidden="true"></i> <span class='sr-only'>정보</span> 수정 </a>
                <a href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout"><i class="fa fa-sign-out" aria-hidden="true"></i> 로그아웃</a>
                <?php if ($is_admin == 'super' || $is_auth) {  ?>
                    <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>" class="admin-link" title="관리자"><i class="fa fa-cog"></i> <span class='sr-only'>관리자</span></a>
                <?php }  ?>
            </div>
        </div>
    </div>
    <div id="ol_after_private" class="member-private-info d-flex justify-content-between m-2">
        <div class="mb-items flex-fill border-color-7">
            <a href="<?php echo G5_URL ?>/_mypage/"><i class="fa fa-user" aria-hidden="true"></i> Mypage</a>
        </div>
        <div class="mb-items flex-fill border-color-7">
            <a href="<?php echo G5_URL ?>/_mypage/my_point.php" id="ol_after_pt" class="">
                <i class="fa fa-database" aria-hidden="true"></i> <?php echo $point; ?>
            </a>
        </div>
        <div class="mb-items flex-fill border-color-7">
            <a href="<?php echo G5_BBS_URL ?>/memo.php" id="ol_after_memo" class="">
                <i class="fa fa-envelope-o" aria-hidden="true"></i><span class="sr-only"> 안 읽은 쪽지</span>
                <div class='badge badge-info'><?php echo $memo_not_read; ?></div>
            </a>

        </div>
        <div class="mb-items flex-fill border-color-7">
            <?php if ($config['bp_use_alarm']) { ?>
                <a href='<?php echo G5_URL ?>/_mypage/my_alarm.php'><i class="fa fa-bell" aria-hidden="true"></i>
                    <div class='badge badge-danger'><?php echo bp_unread_alarm($member['mb_id']); ?></div>
                </a>
            <?php } else { ?>
                <a href="<?php echo G5_BBS_URL ?>/scrap.php" id="ol_after_scrap" class="">
                    <i class="fa fa-thumb-tack" aria-hidden="true"></i> <span class="sr-only">스크랩</span> <?php echo $mb_scrap_cnt; ?>
                </a>
            <?php } ?>
        </div>
    </div>
    <?php
    //게시판 즐겨찾기 출력 - 테마 기본환경설정
    echo bp_favorite_list();
    ?>
</section>

<script>
    // 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
    function member_leave() {
        if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
            location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
    }
</script>
<!-- } 로그인 후 아웃로그인 끝 -->
