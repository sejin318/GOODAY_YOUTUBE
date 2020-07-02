<?php

//ASKUPLOAD 환경설정
inc_auconfig($bo_table);

/**
 *  ASK-UPLOADER
 */
//쓰기 완료시 임시세션 값을 $wr_id로 변경하기.
if (get_session('wr_id_tmp') && $wr_id_tmp) {
    //wr_id 업데이트
    $sql = "update {$g5['board_file_table']} set wr_id = '{$wr_id}' where bo_table = '{$bo_table}' and wr_id = '{$wr_id_tmp}'";
    sql_query($sql);

    // 파일의 개수를 게시물에 업데이트 한다.
    au_file_total($bo_table, $wr_id);
}

//임시 세션 지우기
set_session('wr_id_tmp', false);

if (AU_YOUTUBE_THUMB == true) {
    //유튜브 링크가 있다면 썸네일용 유튜브 이미지 등록.
    if ($wr_link1) {
        youtube_link_upload($wr_link1);
    }
    if ($wr_link2) {
        youtube_link_upload($wr_link2);
    }
}

//일반동영상 처리
if (AU_FFMPEG_THUMB == true) {
    $vidoe = au_get_file($bo_table, $wr_id);
    foreach ($vidoe as $key => $val) {
        //동영상 확장자 체크
        $ext = au_get_ext($val['file']);
        if (stristr(AU_FILE_VIDEO, $ext)) {
            //서버에 FFMPEG 사용해서 썸네일 생성
            $server_path = G5_DATA_PATH . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR . $bo_table . DIRECTORY_SEPARATOR . $val['file'];
            $vthumb = new ffmpeg();
            $vthumb->ffmpeg_screens($server_path, $server_path);
        }
    }
}