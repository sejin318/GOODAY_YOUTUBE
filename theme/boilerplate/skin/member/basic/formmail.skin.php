<?php

/**
 * formmail.skin.php
 * 폼메일
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
include_once G5_THEME_PATH . "/head.sub.php";
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

?>

<!-- 폼메일 시작 { -->
<div class="formmail-wrap container-fluid">
    <h2 class="page-title p-2"><?php echo $name ?>님께 메일보내기</h2>

    <form name="fformmail" action="./formmail_send.php" onsubmit="return fformmail_submit(this);" method="post" enctype="multipart/form-data" style="margin:0px;">
        <input type="hidden" name="to" value="<?php echo $email ?>">
        <input type="hidden" name="attach" value="2">
        <?php if ($is_member) { // 회원이면  
            ?>
            <input type="hidden" name="fnick" value="<?php echo get_text($member['mb_nick']) ?>">
            <input type="hidden" name="fmail" value="<?php echo $member['mb_email'] ?>">
        <?php }  ?>

        <div class="form_01 new_win_con">
            <h2 class="sr-only">메일쓰기</h2>
            <?php if (!$is_member) {  ?>
                <div class="form-group">
                    <label for="fnick" class="sr-only">이름<strong>필수</strong></label>
                    <input type="text" name="fnick" id="fnick" required class="form-control required" placeholder="이름">
                </div>
                <div class="form-group">
                    <label for="fmail" class="sr-only">E-mail<strong>필수</strong></label>
                    <input type="text" name="fmail" id="fmail" required class="form-control required" placeholder="E-mail">
                </div>
            <?php }  ?>
            <div class="form-group">
                <label for="subject" class="sr-only">제목<strong>필수</strong></label>
                <input type="text" name="subject" id="subject" required class="form-control required" placeholder="제목">
            </div>
            <div class="form-group">
                <span class="sr-only">형식</span>
                <input type="radio" name="type" value="0" id="type_text" checked>
                <label for="type_text"><span></span>TEXT</label>

                <input type="radio" name="type" value="1" id="type_html">
                <label for="type_html"><span></span>HTML</label>

                <input type="radio" name="type" value="2" id="type_both">
                <label for="type_both"><span></span>TEXT+HTML</label>
            </div>
            <div class="form-group">
                <label for="content" class="sr-only">내용<strong>필수</strong></label>
                <textarea name="content" id="content" required class="form-control required"></textarea>
            </div>
            <div class="alert alert-info alert-sm">첨부 파일은 누락될 수 있으므로 메일을 보낸 후 파일이 첨부 되었는지 반드시 확인해 주시기 바랍니다.</div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-download" aria-hidden="true"></i><span class="sr-only"> 첨부 파일 1</span></span>
                    </div>
                    <input type="file" name="file1" id="file1" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-download" aria-hidden="true"></i><span class="sr-only"> 첨부 파일 2</span></span>
                    </div>
                    <input type="file" name="file2" id="file2" class="form-control">
                </div>
            </div>

            <span class="sr-only">자동등록방지</span>
            <?php echo captcha_html(); ?>

            <div class="form-action d-flex">
                <button type="submit" id="btn_submit" class="btn btn-primary mr-auto">메일발송</button>
                <button type="button" onclick="window.close();" class="btn btn-danger">창닫기</button>
            </div>
        </div>


    </form>
</div>

<script>
    with(document.fformmail) {
        if (typeof fname != "undefined")
            fname.focus();
        else if (typeof subject != "undefined")
            subject.focus();
    }

    function fformmail_submit(f) {
        <?php echo chk_captcha_js();  ?>

        if (f.file1.value || f.file2.value) {
            // 4.00.11
            if (!confirm("첨부파일의 용량이 큰경우 전송시간이 오래 걸립니다.\n\n메일보내기가 완료되기 전에 창을 닫거나 새로고침 하지 마십시오."))
                return false;
        }

        document.getElementById('btn_submit').disabled = true;

        return true;
    }
</script>
<!-- } 폼메일 끝 -->
<?php
include_once G5_THEME_PATH . "/tail.sub.php";
