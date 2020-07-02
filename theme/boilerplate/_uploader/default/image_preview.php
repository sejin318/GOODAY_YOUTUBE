<?php
include_once "./_common.php";
if (!$is_member) {
    exit;
}
require G5_PATH . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

Image::configure(array('driver' => 'gd'));
//원본
$img_path = G5_DATA_PATH . "/file/{$bo_table}/{$filename}";
//썸네일
$save_file_name = G5_DATA_PATH . "/file/{$bo_table}/thumb-bp-{$filename}";

if (file_exists($img_path) && !file_exists($save_file_name)) {
    //생성
    $img = Image::make($img_path)->resize(300, null, function ($constraint) {
        $constraint->aspectRatio();
    })->orientate()->encode('jpg', 75)->save($save_file_name);
} else {
    //썸네일 로딩
    $img = Image::make($save_file_name);
}
echo $img->response();
