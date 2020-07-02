<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH . '/group.php');
    return;
}

if (!$is_admin && $group['gr_device'] == 'mobile')
    alert($group['gr_subject'] . ' 그룹은 모바일에서만 접근할 수 있습니다.');

$g5['title'] = $group['gr_subject'];
include_once(G5_THEME_PATH . '/head.php');
// run_event("{$gr_id}", "{$gr_id}");
echo "<div class='group_slider'>";
run_event("{$group['gr_subject']}", "{$group['gr_subject']}");
echo "</div>";
include_once(G5_LIB_PATH . '/latest.lib.php');
?>

<div class="jumbotron p-4 mb-3">
    <h1 class="display-5"><?php echo $group['gr_subject'] ?></h1>
    <hr />
    <p class="lead">
      그룹 최신글 목록
      <?php
      ?>
    </p>
</div>
<?php
    ####################################################################################################
    # 슬라이더를 이벤트로 호출할 수 있습니다.
    # run_event('슬라이더위치', '슬라이더위치','슬라이더스킨');
    # 슬라이더 위치는 등록한 슬라이더 이름을 입력해야 합니다.
    # 슬라이더 스킨은 theme/boilerplate/_slider/폴더명 입니다.
    # 생략하면 슬라이더 관리자에서 지정한 스킨이 사용됩니다.
    ####################################################################################################
    // run_event('그룹슬라이더', '그룹슬라이더');
    run_event($gr_id, $$gr_id);
    ?>
<div class="row latest-simple ">
    <!-- 메인화면 최신글 시작 -->
    <?php
    //  최신글
    $sql = " SELECT bo_table, bo_subject from {$g5['board_table']} where gr_id = '{$gr_id}' and bo_list_level <= '{$member['mb_level']}' and bo_device <> 'mobile' ";
    if (!$is_admin) {
        $sql .= " and bo_use_cert = '' ";
    }
    $sql .= " order by bo_order ";
    $result = sql_query($sql);
    for ($i = 0; $row = sql_fetch_array($result); $i++) {
    ?>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <?php
            // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
            // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
            echo latest('theme/basic', $row['bo_table'], 5, 25);
            ?>
        </div>
    <?php } ?>
    <!-- 메인화면 최신글 끝 -->
</div>
<?php
include_once(G5_THEME_PATH . '/tail.php');
?>
