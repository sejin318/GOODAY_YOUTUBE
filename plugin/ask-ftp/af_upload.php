<?php
include_once './_common.php';
$login_error = null;
include_once './php-ftp-client/src/FtpClient/FtpClient.php';
include_once './php-ftp-client/src/FtpClient/FtpException.php';
include_once './php-ftp-client/src/FtpClient/FtpWrapper.php';
include_once './ask_ftp.const.php';
include_once './ask_ftp.lib.php';
include_once './ask_ftp.auth.php';

###########
# 삭제
###########
if ($type == 'delete' && $dir && $target_name) {
    if (!$config['bp_ftp_modify']) {
        alert('파일을 편집 할 수 없습니다. 테마 기본설정에서 FTP 편집을 활성화 하세요.');
        exit;
    }
    if ($file_directory == 'file') {
        //파일삭제
        $result = $ftp->delete($dir . '/' . $target_name);
    } elseif ($file_directory == 'directory') {
        //삭제금지 폴더 처리
        if (in_array($target_name, explode(',', AF_EXCLUDE_DELETE_DIR))) {
            $_SESSION['ask_message'] = $target_name . ' 삭제가 금지된 디렉토리 입니다.';
            goto_url("./ask_ftp.php?dir={$dir}");
            exit;
        }

        //디렉토리 삭제
        $result = $ftp->rmdir($dir . '/' . $target_name, true);
    }

    if ($result) {
        $_SESSION['ask_message'] = $target_name . ' 삭제 되었습니다.';
        goto_url("./ask_ftp.php?dir={$dir}");
    } else {
        alert('삭제 오류가 발생되었습니다.');
    }
}

############
# 권한 변경
############
if ($type == 'fileperm' && $dir && $target_name && $perm_number) {
    if (!$config['bp_ftp_modify']) {
        alert('파일을 편집 할 수 없습니다. 테마 기본설정에서 FTP 편집을 활성화 하세요.');
        exit;
    }
    //숫자만
    if (!preg_match('/^[0-9]*$/', $dest_name)) {
        alert($perm_number . '숫자만 사용가능합니다.');
        exit;
    }
    $mode = octdec(str_pad($perm_number, 4, '0', STR_PAD_LEFT));
    if ($dir == '/') {
        $target_path = $dir . $target_name;
    } else {
        $target_path = $dir . '/' . $target_name;
    }

    $result = $ftp->chmod($mode, $target_path);
    if ($result) {
        $_SESSION['ask_message'] = $perm_number . '로 권한이 변경 되었습니다.';
        goto_url("./ask_ftp.php?dir={$dir}");
    } else {
        alert($target_path . ' 권한 변경 오류가 발생되었습니다.');
    }
}

############
# 이름 변경
############
if ($type == 'filerename' && $dir && $org_name && $dest_name) {

    if (!$config['bp_ftp_modify']) {
        alert('파일을 편집 할 수 없습니다. 테마 기본설정에서 FTP 편집을 활성화 하세요.');
        exit;
    }

    //폴더, 파일이름 체크
    if (!preg_match('/^[_\.\-A-Za-z0-9+]*$/', $dest_name)) {
        alert($dest_name . ' 영문, 숫자, -, _ . 만 사용가능합니다.');
        exit;
    }
    if ($dir == '/') {
        $old_name = $dir . $org_name;
        $new_name = $dir . $dest_name;
    } else {
        $old_name = $dir . '/' . $org_name;
        $new_name = $dir . '/' . $dest_name;
    }

    if ($ftp->isDir($new_name)) {
        alert($new_name . ' 디렉토리 또는 파일이 이미 존재합니다.');
        exit;
    }

    //삭제금지 폴더 처리
    if (in_array($org_name, explode(',', AF_EXCLUDE_DELETE_DIR))) {
        $_SESSION['ask_message'] = $org_name . ' 이름변경이 금지된 디렉토리 입니다.';
        goto_url("./ask_ftp.php?dir={$dir}");
        exit;
    }

    $result = $ftp->rename($old_name, $new_name);
    if ($result) {
        $_SESSION['ask_message'] = $new_name . '로 변경 되었습니다.';
        goto_url("./ask_ftp.php?dir={$dir}");
    } else {
        alert('이름 변경 오류가 발생되었습니다.');
    }
}

#################
# 파일, 폴더 생성
#################
if ($type == 'makedir') {
    //폴더이름 체크
    if (!preg_match('/^[_\.\-A-Za-z0-9+]*$/', $dirname)) {
        alert('영문, 숫자, -, _ . 만 사용가능합니다.');
        exit;
    }
    if ($dir == '/') {
        $makedir_path = $dir . $dirname;
    } else {
        $makedir_path = $dir . '/' . $dirname;
    }

    if (!$is_file) {
        //디렉토리 생성
        if ($ftp->isDir($makedir_path)) {
            alert($dirname . ' 디렉토리는 이미 존재합니다.');
            exit;
        }
        $result = $ftp->mkdir($makedir_path);
        if ($result) {
            $_SESSION['ask_message'] = $makedir_path . '디렉토리가 생성되었습니다.<br/> ' . $makedir_path . '로 이동되었습니다.';
            goto_url("./ask_ftp.php?dir={$makedir_path}");
        } else {
            alert('디렉토리 생성시 오류가 발생되었습니다.');
        }
    } else {
        //파일생성
        //$stream = fopen('data://text/plain;base64,' . base64_encode(''), 'rb');
        //$stream = fopen('data://text/plain;base64,' . base64_encode(''), 'rb');
        //$stream = fopen($makedir_path, 'r');
        $string = base64_encode('새파일입니다.');
        $stream = fopen('php://memory', 'rb');
        fwrite($stream, $string);
        rewind($stream);
        $result = $ftp->fput($makedir_path, $stream, FTP_ASCII);
        if ($result) {
            alert($makedir_path . '파일이 생성되었습니다. 편집화면으로 이동합니다.', "./af_editor.php?edit_file={$makedir_path}");
        } else {
            alert('파일 생성시 오류가 발생되었습니다. - ' . $makedir_path);
        }
    }
}

##############
# 파일 업로드
##############
if ($_FILES && $type == 'fileupload') {
    $filelist = '';
    for ($i = 0; count($_FILES['askfile']['name']) > $i; $i++) {
        //파일 확장자 체크
        $ascii_ext = explode(',', AF_ASCII);
        $this_ext = pathinfo($_FILES['askfile']['name'][$i]);
        if (in_array(strtolower($this_ext['extension']), $ascii_ext)) {
            //ascii file upload
            $mode = FTP_ASCII;
        } else {
            //binary file upload
            $mode = FTP_BINARY;
        }

        $tmp_file = G5_DATA_PATH . '/tmp/' . $_FILES['askfile']['name'][$i];
        //file을 그누보드 임시 폴더로 이동 후 FTP 명령어로 업로드한다.
        if (move_uploaded_file($_FILES['askfile']['tmp_name'][$i], $tmp_file)) {
            $result = $ftp->put($_POST['dir'] . '/' . $_FILES['askfile']['name'][$i], $tmp_file, $mode);
            if ($result) {
                $filelist .= $_FILES['askfile']['name'][$i] . '<br/>';
                //임시파일 삭제
                unlink($tmp_file);
            } else {
                unlink($tmp_file);
                alert('오류 : FTP 업로드 오류가 발생하였습니다. 쓰기 권한이 있는지 확인해보세요.');
                exit;
            }
        } else {
            alert('오류 : 그누보드 임시 폴더 data/tmp를 확인하세요.');
            exit;
        }
    }
    $_SESSION['ask_message'] = $filelist . ' 파일이 업로드되었습니다.';
    goto_url("./ask_ftp.php?dir={$dir}");
}
