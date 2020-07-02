<?php
$sub_menu = "800100";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

$g5['title'] = 'Boilerplate  테마 설치';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');
//Boilerplate 테마 사용 체크
?>

<section>
    <h2 class="frm-head">테마 설치 </h2>
    <hr />
    <div class="config-install">
        <h3>환경설정 테이블</h3>
        <?php echo DBInstall::db_config(BP_CONFIG_TABLE); ?>
        <h3>로고 테이블</h3>
        <?php echo DBInstall::db_logo(BP_LOGO_TABLE); ?>
        <h3>게시판즐겨찾기 테이블</h3>
        <?php echo DBInstall::db_favorite(BP_FAVORITE_TABLE); ?>
        <h3>슬라이더 테이블</h3>
        <?php echo DBInstall::db_slider(BP_SLIDER_TABLE); ?>
        <h3>슬라이더 목록 테이블</h3>
        <?php echo DBInstall::db_slider_list(BP_SLIDER_LIST_TABLE); ?>
        <h3>배너 테이블</h3>
        <?php echo DBInstall::db_banner(BP_BANNER_TABLE); ?>
        <h3>알람 테이블</h3>
        <?php echo DBInstall::db_alarm(BP_ALARM_TABLE); ?>
        <h3>회원메모 테이블</h3>
        <?php echo DBInstall::db_member_memo(BP_MEMBER_MEMO_TABLE); ?>
        <h3>회원신고 테이블</h3>
        <?php echo DBInstall::db_report(AT_REPORT_TABLE); ?>
        <h3>회원신고 처리 테이블</h3>
        <?php echo DBInstall::db_report_sanction(AT_REPORT_SANCTION_TABLE); ?>
        <h3>회원확장필드 테이블</h3>
        <?php echo DBInstall::db_member(BP_MEMBER_TABLE); ?>
        <h3>포인트구매 테이블</h3>
        <?php echo DBInstall::db_point_charge(BP_POINT_CHARGE_TABLE); ?>
        <h3>포인트환불 테이블</h3>
        <?php echo DBInstall::db_point_refund(BP_POINT_REFUND_TABLE); ?>
        <h3>다운로드목록 테이블</h3>
        <?php echo DBInstall::db_download_log(BP_DOWNLOAD_TABLE); ?>

        <h3>각종 필드확장</h3>
        <?php echo DBInstall::db_field(); ?>

        <h3>Dummy 게시물 log</h3>
        <?php echo DBInstall::db_dummy(BP_DUMMY_TABLE); ?>
        <h3>게시판 확장 설정</h3>
        <?php echo DBInstall::db_board(BP_BOARD_TABLE); ?>
        <?php
        echo '<h3>슬라이더 이미지 폴더 생성</h3>';
        $image_dir_path = BP_SLIDERSAVE_DIR;
        if (!is_dir($image_dir_path)) {
            @mkdir($image_dir_path, G5_DIR_PERMISSION);
            echo "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> {$image_dir_path} 디렉토리가 생성되었습니다.</div>";
        } else {
            echo "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> {$image_dir_path} 디렉토리가 이미 생성되었습니다.</div>";
        }

        echo '<h3>보일러플레이트 이미지 폴더 생성</h3>';
        $image_dir_path = BP_FILE_DIR;
        if (!is_dir($image_dir_path)) {
            @mkdir($image_dir_path, G5_DIR_PERMISSION);
            echo "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> {$image_dir_path} 디렉토리가 생성되었습니다.</div>";
        } else {
            echo "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> {$image_dir_path} 디렉토리가 이미 생성되었습니다.</div>";
        }
        ?>

    </div>
</section>

<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
