<?php

/**
 * profile.skin.php
 * 프로필
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

include_once G5_THEME_PATH . "/head.sub.php";
?>

<!-- 자기소개 시작 { -->
<div class="profile-wrap container-fluid">
    <h3 class='page-title p-2 mb-3'><?php echo $mb_nick ?>님의 프로필</h3>
    <div class="profile_name">
        <span class="my_profile_img">
            <?php echo get_member_profile_img($mb['mb_id']); ?>
        </span>
        <?php echo $mb_nick ?>
    </div>
    <div class="table-responsive">
        <table class='table table-bordered'>
            <tbody>
                <tr>
                    <th scope="row"><i class="fa fa-star-o" aria-hidden="true"></i> 회원권한</th>
                    <td><?php echo $mb['mb_level'] ?></td>
                    <th scope="row"><i class="fa fa-database" aria-hidden="true"></i> 포인트</th>
                    <td><?php echo number_format($mb['mb_point']) ?></td>
                </tr>
                <tr>
                    <th scope="row"><i class="fa fa-clock-o" aria-hidden="true"></i> 회원가입일</th>
                    <td><?php echo ($member['mb_level'] >= $mb['mb_level']) ?  substr($mb['mb_datetime'], 0, 10) . " (" . number_format($mb_reg_after) . " 일)" : "알 수 없음";  ?></td>
                    <th scope="row"><i class="fa fa-clock-o" aria-hidden="true"></i> 최종접속일</th>
                    <td><?php echo ($member['mb_level'] >= $mb['mb_level']) ? $mb['mb_today_login'] : "알 수 없음"; ?></td>
                </tr>
                <?php if ($mb_homepage) {  ?>
                    <tr>
                        <th scope="row"><i class="fa fa-home" aria-hidden="true"></i> 홈페이지</th>
                        <td colspan="3"><a href="<?php echo $mb_homepage ?>" target="_blank"><?php echo $mb_homepage ?></a></td>
                    </tr>
                <?php }  ?>

            </tbody>
        </table>
    </div>

    <section class='border mt-2 mb-2 d-block p-2'>
        <h3 class="title border-bottom d-block p-2">인사말</h3>
        <p class="p-2"><?php echo $mb_profile ?></p>
    </section>
    <div class="form-action d-flex">
        <button type="button" class="btn btn-danger ml-auto mr-auto" onclick="window.close();">닫기</button>
    </div>
</div>
<!-- } 자기소개 끝 -->
<?php
include_once G5_THEME_PATH . "/tail.sub.php";
