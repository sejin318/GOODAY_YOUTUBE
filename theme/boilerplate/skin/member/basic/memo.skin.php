<?php

/**
 * memo.skin.php
 * 쪽지목록
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

include_once G5_THEME_PATH . "/head.php";
run_event('마이페이지메뉴', '마이페이지메뉴');
?>

<!-- 쪽지 목록 시작 { -->
<div class="memo-wrap">
    <h2 class='page-title p-2 mb-3'>
        <?php echo $g5['title'] ?>
        <div class="page-count-info">전체 <?php echo $kind_title ?>쪽지 <?php echo $total_count ?>통<br></div>
    </h2>
    <div class="memo">
        <ul class="nav nav-tabs mb-2">
            <li class="nav-item"><a href="./memo.php?kind=recv" class='nav-link <?php if ($kind == 'recv') {  ?>active<?php } ?>'>받은쪽지</a></li>
            <li class="nav-item"><a href="./memo.php?kind=send" class='nav-link <?php if ($kind == 'send') {  ?>active<?php } ?>'>보낸쪽지</a></li>
            <li class="nav-item"><a href="./memo_form.php" class='nav-link'>쪽지쓰기</a></li>
        </ul>
        <table class="memo-list table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>보낸이</th>
                    <th>시간</th>
                    <th>내용</th>
                    <th>관리</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($list); $i++) {
                    $readed = '';
                    $readed = (substr($list[$i]['me_read_datetime'], 0, 1) == 0) ? '<i class="fa fa-envelope" aria-hidden="true"></i><span class="sr-only">읽지않은 메세지</span>' : '<i class="fa fa-envelope-open-o" aria-hidden="true"></i>';
                    $memo_preview = utf8_strcut(strip_tags($list[$i]['me_memo']), 36, '..');

                    echo "<tr>";
                    echo "<td> <!-- " . get_member_profile_img($list[$i]['mb_id']) . " --> {$list[$i]['name']} </td>";
                    echo "<td class=''><span class='memo_datetime'><i class='fa fa-clock-o' aria-hidden='true'></i> {$list[$i]['send_datetime']}</span></td>";
                    echo "<td class=''>{$readed} <a href='{$list[$i]['view_href']}' class=''>{$memo_preview}</a></td>";
                    echo "<td><a href='{$list[$i]['del_href']}' onclick='del(this.href); return false;' class='btn btn-danger'><i class='fa fa-trash-o' aria-hidden='true'></i> <i class='sr-only'>삭제</i></a></td>";
                    echo "</tr>";
                } ?>
                <?php if ($i == 0) {
                    echo "<tr>";
                    echo '<td colspan="4" class="empty_table">자료가 없습니다.</td>';
                    echo "</tr>";
                }  ?>
            </tbody>
        </table>

        <!-- 페이지 -->
        <div class="paging mb-3 pt-3 pb-3">
            <?php echo $write_pages; ?>
        </div>

        <p class="alert alert-info"><i class="fa fa-info-circle" aria-hidden="true"></i> 쪽지 보관일수는 최장 <strong><?php echo $config['cf_memo_del'] ?></strong>일 입니다.</p>
    </div>
</div>
<!-- } 쪽지 목록 끝 -->

<?php
include_once G5_THEME_PATH . "/tail.php";
