<?php

/** 
 * Boilerplate Theme 설치하기
 */
include_once './_common.php';

//관리자만 설치 가능
if ($is_admin != 'super') {
    alert('이용권한이 없습니다.');
    exit;
}
include_once G5_THEME_PATH . '/head.sub.php';
if (isset($config['bp_colorset'])) {
    alert('Boilerplate 테마가 이미 설치되었습니다.');
    exit;
}
?>
<div class='container'>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">Install</a>
    </nav>
    <div class='row'>
        <div class='col-sm-12'>
            <div class="jumbotron p-4 mb-3 mt-3">
                <h1 class="display-5">Boilerplate Theme 설치</h1>
                <hr />
                아래 안내에 따라 테마를 설치하세요.
            </div>
        </div>
        <div class='col-sm-12'>
            <h2 class="page-title mt-5">라이선스 안내</h2>
            <div class="form-group">
                <textarea name="license" id="" class="form-control" placeholder="" aria-describedby="helpId" rows="10">Boilerplate Theme 라이선스
-------------------------------------------
- Boilerplate Theme(이하 테마)의 저작권은 제작자인 boilerplate.kr에 있습니다.
- 테마 전체 또는 일부를 재배포(유,무료)를 할 수 없습니다.
- 테마에 사용된 외부 소스는 해당 소스의 라이선스를 따릅니다.
- 테마 사용으로 어떠한 손해가 발생하더라도 제작자는 책임을 부담하지 않습니다.
- 누구나 사이트 제작, 납품등을 위해 테마를 사용할 수 있습니다.
- 프리렌서, 회사에서 제작하여 납품이 가능합니다.
- 판매용 솔루션, 개인, 자사 또는 타사의 컨텐츠판매몰에 테마 전체 또는 일부를 포함해서 판매할 수 없습니다.</textarea>
                <small id="helpId" class="text-muted">위 라이선스 내용을 읽고 동의해야 사용가능합니다.</small>
            </div>
            <form action="<?php echo G5_ADMIN_URL ?>/boilerplate/bp_install.php">
                <label><input type="checkbox" name='agree' value="1"> 위 라이선스에 동의하며 설치를 진행합니다.</label>
                <div class="form-action text-center">
                    <button type="submit" class='btn btn-primary btn-lg submit'>설치하기</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.submit').on('click', function() {
            var agreeCheck = $('input[name=agree').is(":checked");
            if (agreeCheck == false) {
                alert('라이선스에 동의해야 설치가 진행됩니다.');
                return false;
            }
            return true;
        });
    });
</script>
<?php
include_once G5_THEME_PATH . '/tail.sub.php';
