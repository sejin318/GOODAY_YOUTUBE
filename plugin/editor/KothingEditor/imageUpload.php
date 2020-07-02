<?php 
include "_common.php";
$bo_table = $_POST['bo_table'];
$g5['board_table'] = G5_TABLE_PREFIX.'board'; // 게시판 설정 테이블
$sql = "SELECT * FROM {$g5['board_table']} WHERE bo_table = '{$bo_table}'";
$cf = sql_fetch($sql);
$ym = date('ym', G5_SERVER_TIME);

$data_dir = G5_DATA_PATH.'/editor/'.$ym;
$data_url = G5_DATA_URL.'/editor/'.$ym;

@mkdir($data_dir, G5_DIR_PERMISSION);
@chmod($data_dir, G5_DIR_PERMISSION);

$target_dir = G5_DATA_PATH.'/editor/';
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($_FILES["editor_file"]['name'][0],PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
$check = getimagesize($_FILES["editor_file"]["tmp_name"]);
if($check !== false) {
    //echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
} else {
    echo json_encode(array('msg'=> '이미지 파일이 아닙니다'));
    $uploadOk = 0;
    exit;
}
// Check file size
if ($_FILES["editor_file"]["size"][0] > $cf['bo_upload_size']) {
    echo json_encode(array('msg'=> '파일의 용량이 '.$cf['bo_upload_size'].'byte 보다 큽니다'));
    $uploadOk = 0;
    exit;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo json_encode(array('msg'=> '이미지 파일이 아닙니다'));
    $uploadOk = 0;
    exit;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo json_encode(array('msg'=> '정상적으로 파일이 업로드 되지 않았습니다'));
// if everything is ok, try to upload file
} else {
    $filename = time().".".$imageFileType;
    $save_dir = sprintf('%s/%s', $data_dir, $filename);
    if (move_uploaded_file($_FILES["editor_file"]["tmp_name"][0], $save_dir)) {
        $save_url = sprintf('%s/%s', $data_url, $filename);
        echo json_encode(array('src'=> $save_url));
    } else {
        echo json_encode(array('msg'=> '이미지 저장에 실패하였습니다'));
    }
}
?>