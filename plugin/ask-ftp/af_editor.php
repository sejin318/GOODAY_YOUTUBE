<?php
include_once './_common.php';
$login_error = null;
include_once './php-ftp-client/src/FtpClient/FtpClient.php';
include_once './php-ftp-client/src/FtpClient/FtpException.php';
include_once './php-ftp-client/src/FtpClient/FtpWrapper.php';
include_once './ask_ftp.const.php';
include_once './ask_ftp.lib.php';
include_once './ask_ftp.auth.php';

$g5['title'] = 'ASK-FTP';
include_once G5_PLUGIN_PATH . '/ask-ftp/head.sub.php';
if (!$config['bp_ftp_modify']) {
    alert('파일을 편집 할 수 없습니다. 테마 기본설정에서 FTP 편집을 활성화 하세요.');
    exit;
}
if (!$edit_file && $dir) {
    alert('File이 없습니다.');
    exit;
}
//파일 읽기
$h = fopen('php://temp', 'r+');
$ftp->fget($h, $edit_file, FTP_ASCII, 0);
$fstats = fstat($h);
fseek($h, 0);
$contents = @fread($h, $fstats['size']);
$edit_contents = htmlspecialchars($contents);
fclose($h);

$host = af_Decrypt($_SESSION['SS_FTP_HOST']);
?>

<div class="alert alert-info">
    <h3 class="display-6">Editor</h3>
    <hr class="my-4">
    <p>FTP로 업로드된 파일만 수정이 됩니다. 테마-기본설정에 백업설정을 하였다면 <?php echo $config['bp_ftp_root'] . DIRECTORY_SEPARATOR . $config['bp_ftp_backup'] ?> 디렉토리에 백업됩니다.</p>
</div>

<div class='row'>
    <div class='col-sm-12'>
        <div class='edit-file input-group mb-1'>
            <div class='input-group-prepend'><span class='input-group-text'>편집파일 <span class='host-pwd'>&nbsp;<?php echo $host ?>@</span></span></div>
            <input class='form-control' type='text' value='<?php echo $edit_file ?>' readonly>
        </div>
        <div id="code_editor"><?php echo $edit_contents ?></div>
        <script>
            var editor = ace.edit("code_editor");
            editor.session.setMode("ace/mode/php");
            editor.setReadOnly(false); //읽기전용
            editor.resize(true);
            //editor.getValue(); 데이터 가져오기
        </script>
        <form id='editform' action="./af_editor_save.php" method="post">
            <div class='d-flex'>
                <input type="hidden" name='edit_file' value='<?php echo $edit_file; ?>'>
                <input type='hidden' name='contents_org' class='contents_org' value="<?php echo $edit_contents ?>">
                <input type='hidden' name='contents' class='contents'>
                <button type='button' id='cancel' class='btn btn-secondary'>취소</button>
                &nbsp;
                <button type='button' id='golist' class='btn btn-secondary '>목록</button>
                <button type='submit' class='btn btn-primary ml-auto'>저장</button>
            </div>
        </form>
        <br /><br /><br />
        <script>
            $(function() {
                $('#editform').submit(function(data) {
                    var string = editor.getValue();
                    $('.contents').val(string);
                    return true;
                });
                $('#golist').click(function() {
                    <?php
                    if ($edit_file) {
                        $up_dir_link = str_replace('/' . array_pop(explode('/', $edit_file)), '', $edit_file);
                    }
                    ?>
                    location.href = './ask_ftp.php?dir=<?php echo $up_dir_link ?>';
                });
                $('#cancel').click(function() {
                    location.href = './ask_ftp.php';

                    <?php if ($_SESSION['ask_message']) { ?>
                        //history.go(-2);
                    <?php } else { ?>
                        //history.go(-1);
                    <?php } ?>
                });
            });
        </script>
    </div>
</div>
<?php
include_once G5_PLUGIN_PATH . '/ask-ftp/tail.sub.php';
