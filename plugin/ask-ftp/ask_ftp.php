<?php
include_once './_common.php';
include_once './php-ftp-client/src/FtpClient/FtpClient.php';
include_once './php-ftp-client/src/FtpClient/FtpException.php';
include_once './php-ftp-client/src/FtpClient/FtpWrapper.php';
include_once './ask_ftp.const.php';
include_once './ask_ftp.lib.php';
include_once './ask_ftp.auth.php';

$g5['title'] = 'ASK-FTP';
include_once G5_PLUGIN_PATH . '/ask-ftp/head.sub.php';

//경로가 없으면
if (!$dir) {
    # Root 이동
    $ftp->chdir('/');
    if ((isset($config['bp_ftp_backup']) && $config['bp_ftp_backup']) && $_SESSION['SS_FTP_LOGIN'] == true) {
        //백업용 폴더 없으면 생성.
        $server_backup_path = $config['bp_ftp_root'] . '/' . $config['bp_ftp_backup'];
        if ($ftp->isDir($server_backup_path) == false) {
            if ($ftp->mkdir($server_backup_path)) {
                $ftp->chmod(octdec(str_pad('0700', 4, '0', STR_PAD_LEFT)), $server_backup_path);
            }
        }
    }
    $dir = $ftp->pwd();
}
if(!$config['bp_ftp_modify']){
    echo "<div class='alert alert-info'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> FTP 수정, 삭제, 편집 기능이 사용중지되어 있습니다. 테마 설정에서 변경 가능합니다.</div>";
}
?>
<div class='function-list'>
    <div class='row'>
        <div class='col-sm-12 col-md-6'>
            <div class='mkdir-wrap'>
                <div class='alert alert-info'>
                    <h3>폴더, 파일생성</h3>
                    - 현재 폴더아래에 생성 됩니다.<br />
                    - 영문, 숫자, -, _만 입력 가능합니다.<br />
                    - 동일 폴더가 있다 생성하지 않습니다.
                    <hr>
                    <form action='./af_upload.php' method="post" enctype="multipart/form-data">
                        <input type='hidden' name='dir' value="<?php echo $dir ?>" />
                        <input type='hidden' name='type' value="makedir" />
                        <div class="input-group">
                            <input type='text' name='dirname' required class='form-control' multiple placeholder="Directory or file name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <input type="checkbox" value='is_file' name='is_file'>파일
                                </div>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="makedir">생성</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class='col-sm-12 col-md-6'>
            <div class='upload-wrap'>
                <div class='alert alert-info'>
                    <h3>파일 업로드</h3>
                    - 동일한 파일명이 있으면 덮어쓰게 됩니다.<br />
                    - 현재 폴더에 업로드 됩니다.<br />
                    - 파일 최대 업로드 크기 : <?php echo ini_get('upload_max_filesize'); ?>
                    <hr />
                    <form action='./af_upload.php' method="post" enctype="multipart/form-data">
                        <input type='hidden' name='dir' value="<?php echo $dir ?>" />
                        <input type='hidden' name='type' value="fileupload" />
                        <div class="input-group">
                            <input type='file' name='askfile[]' required class='form-control' multiple placeholder="File upload">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="fileupload"><i class="fa fa-upload" aria-hidden="true"></i> 업로드</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class='file-list table-responsive'>
        <?php af_list(); ?>
    </div>
</div>
<?php
include_once G5_PLUGIN_PATH . '/ask-ftp/tail.sub.php';
