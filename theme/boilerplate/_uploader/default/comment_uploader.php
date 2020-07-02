<?php
include_once "./_common.php";
include_once G5_LIB_PATH . '/thumbnail.lib.php';

/**
 * 댓글 이미지 첨부 업로더
 */
header('Content-type: application/json');

if (!$is_member) {
    echo json_encode(array('error' => '회원전용입니다. 올바른 방법으로 이용해 주세요.#0'), JSON_PRETTY_PRINT);
}
$chars_array = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

// 토큰체크
$upload_token = trim(get_session('ss_comment_token'));
set_session('ss_comment_token', '');
if (!trim($_POST['comment_image_token']) || !$upload_token || $upload_token != $_POST['comment_image_token']) {

    echo json_encode(array("request" => $_POST, 'error' => '올바른 방법으로 이용해 주세요.#1' . $_POST['comment_image_token'] . '=' . $upload_token), JSON_PRETTY_PRINT);
    exit;
}
$upload_max_filesize = ini_get('upload_max_filesize');
$file_upload_msg = false;

if ($_POST && $_FILES) {
    $board = ASKDB::get_board_info($bo_table);

    //업로드
    $tmp_file  = $_FILES['bf_file']['tmp_name'];
    $filesize  = $_FILES['bf_file']['size'];
    $filename  = $_FILES['bf_file']['name'];
    $filename  = get_safe_filename($filename);

    // 서버에 설정된 값보다 큰파일을 업로드 한다면
    if ($filename) {
        if ($_FILES['bf_file']['error'] == 1) {
            $file_upload_msg .= '\"' . $filename . '\" 파일의 용량이 서버에 설정(' . $upload_max_filesize . ')된 값보다 크므로 업로드 할 수 없습니다.\\n';
        } else if ($_FILES['bf_file']['error'] != 0) {
            $file_upload_msg .= '\"' . $filename . '\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
        }
        if ($file_upload_msg) {
            echo json_encode(array('error' => $file_upload_msg), JSON_PRETTY_PRINT);
        }
    }

    if (is_uploaded_file($tmp_file)) {

        $file_upload_msg = false;
        // 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
        if (!$is_admin && $filesize > $board['bo_upload_size']) {
            $file_upload_msg .= '\"' . $filename . '\" 파일의 용량(' . number_format($filesize) . ' 바이트)이 게시판에 설정(' . number_format($board['bo_upload_size']) . ' 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n';
            if ($file_upload_msg) {
                echo json_encode(array('error' => $file_upload_msg), JSON_PRETTY_PRINT);
            }
        }
        $timg = @getimagesize($tmp_file);
        // image type
        if (preg_match("/\.({$config['cf_image_extension']})$/i", $filename) || preg_match("/\.({$config['cf_flash_extension']})$/i", $filename)) {
            if ($timg['2'] < 1 || $timg['2'] > 16) {
                echo json_encode(array('error' => '이미지만 등록 가능합니다.'), JSON_PRETTY_PRINT);
            }
        }
        //=================================================================

        $upload['image'] = $timg;

        // 프로그램 원래 파일명
        $upload['source'] = $filename;
        $upload['filesize'] = $filesize;

        // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
        $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

        shuffle($chars_array);
        $shuffle = implode('', $chars_array);

        $upload['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])) . '_' . substr($shuffle, 0, 8) . '_' . replace_filename($filename);

        $dest_file = G5_DATA_PATH . '/file/' . $bo_table . '/' . $upload['file'];

        //업로드
        if (move_uploaded_file($tmp_file, $dest_file)) {
            $key = rand(10000000, 99999999);

            //썸네일 생성
            $thumb = get_list_thumbnail($bo_table, $key, $board['bo_mobile_gallery_width'], $board['bo_mobile_gallery_height']);

            //DB입력
            $sql = " INSERT into `{$g5['board_file_table']}` set bo_table = '{$bo_table}',
                                                                wr_id = '{$key}',
                                                                bf_no = '{$key}',
                                                                bf_source = '{$upload['source']}',
                                                                bf_file = '{$upload['file']}',
                                                                bf_content = 'boilerplate-comment-image',
                                                                bf_fileurl = '{$upload['fileurl']}',
                                                                bf_thumburl = '{$thumb['src']}',
                                                                bf_storage = '{$upload['storage']}',
                                                                bf_download = 0,
                                                                bf_filesize = '{$upload['filesize']}',
                                                                bf_width = '{$upload['image']['0']}',
                                                                bf_height = '{$upload['image']['1']}',
                                                                bf_type = '{$upload['image']['2']}',
                                                                bf_datetime = '" . G5_TIME_YMDHIS . "' ";
            sql_query($sql, true);
            $upload['key'] = $key;
            echo json_encode($upload, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(array('error' => 'UPLOAD ERROR'), JSON_PRETTY_PRINT);
        }

        // 올라간 파일의 퍼미션을 변경합니다.
        chmod($dest_file, G5_FILE_PERMISSION);
    }
} else {
    echo json_encode(array('error' => 'error'), JSON_PRETTY_PRINT);
}
