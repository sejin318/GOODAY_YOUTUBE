<?php
include_once "./_common.php";
$_data['title'] = "ERROR";

if ($_SESSION['error_message']) {
    $_data['error_message'] = $_SESSION['error_message'];
} else {
    $_data['error_message'] = "ERROR PAGE";
}
include_once G5_THEME_PATH . '/head.sub.php';

?>
<div class='row' id='g5_error'>
    <div class='col-sm-12 col-md-12'>
        <div class='contents-box'>
            <h2>회원 오류</h2>
            <?php if ($_SESSION['error_message']) { ?>
                <div class='error_message'>
                    <div class="error">
                        <?php echo $_data['error_message'] ?>
                    </div>
                </div>
            <?php } ?>
            <div class="popup-action">
                <button type="button" class="close_btn btn btn-danger">뒤로가기</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.close_btn').click(function() {
            history.go(-1);
        });
        <?php if ($_SESSION['error_message'] == 'ERROR PAGE') { ?>
            history.go(-1);
        <?php } ?>
    });
</script>

<?php
//세선 삭제
unset($_SESSION['error_message']);
include_once G5_THEME_PATH . '/tail.sub.php';
