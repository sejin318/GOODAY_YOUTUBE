<?php
/**
 * password.skin.php
 * 비밀번호입력
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

$delete_str = "";
if ($w == 'x') $delete_str = "댓";
if ($w == 'u') $g5['title'] = $delete_str . "글 수정";
else if ($w == 'd' || $w == 'x') $g5['title'] = $delete_str . "글 삭제";
else $g5['title'] = $g5['title'];
?>
<!-- 비밀번호 확인 시작 { -->
<div class="password-form container">
    <h1>비밀번호입력</h1>
    <div class='row'>
        <div class="col-sm-12 col-md-12">
            <div class="border-dark p-3 shadow-lg">
                <h2><?php echo $g5['title'] ?></h2>
                <div class='alert alert-info'>
                    <?php if ($w == 'u') { ?>
                        <strong>작성자만 글을 수정할 수 있습니다.</strong>
                        작성자 본인이라면, 글 작성시 입력한 비밀번호를 입력하여 글을 수정할 수 있습니다.
                    <?php } else if ($w == 'd' || $w == 'x') {  ?>
                        <strong>작성자만 글을 삭제할 수 있습니다.</strong>
                        작성자 본인이라면, 글 작성시 입력한 비밀번호를 입력하여 글을 삭제할 수 있습니다.
                    <?php } else {  ?>
                        <strong>비밀글 기능으로 보호된 글입니다.</strong>
                        작성자와 관리자만 열람하실 수 있습니다.<br> 본인이라면 비밀번호를 입력하세요.
                    <?php }  ?>
                </div>

                <form name="fboardpassword" action="<?php echo $action;  ?>" method="post">
                    <input type="hidden" name="w" value="<?php echo $w ?>">
                    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
                    <input type="hidden" name="comment_id" value="<?php echo $comment_id ?>">
                    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                    <input type="hidden" name="stx" value="<?php echo $stx ?>">
                    <input type="hidden" name="page" value="<?php echo $page ?>">

                    <fieldset>
                        <div class="input-group">
                            <input type="password" name="wr_password" id="password_wr_password" required class="form-control required" size="15" maxLength="20" placeholder="비밀번호">
                            <div class="input-group-append">
                                <input type="submit" value="확인" class="btn btn-primary">
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- } 비밀번호 확인 끝 -->