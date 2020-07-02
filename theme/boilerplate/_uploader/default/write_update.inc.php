<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * 
 *  게시물 업로드 처리용
 */

######################################
# 개별파일 다운로드 포인트 저장
######################################
if ($board['bb_use_download_point']) {
    if ($board['bb_use_download_point']) {

        if ($upload) {
            //포인트를 파일첨부 DB에 저장
            for ($i = 0; $i < count($upload); $i++) {
                //파일이 있으면 포인트 설정하기
                $row = sql_fetch(" SELECT count(*) as cnt from {$g5['board_file_table']} where `bo_table` = '{$bo_table}' and `wr_id` = '{$wr_id}' and `bf_no` = '{$i}' ");
                if ($row['cnt']) {
                    $bf_download_point[$i] = Asktools::clean($bf_download_point[$i]);
                    $bf_content[$i] = Asktools::clean($bf_content[$i]);
                    //삭제
                    if ($upload[$i]['del_check'] || $upload[$i]['file']) {
                        $sql = " UPDATE `{$g5['board_file_table']}` set `bf_content` = '{$bf_content[$i]}', `bf_download_point` = '{$bf_download_point[$i]}' where `bo_table` = '{$bo_table}' and `wr_id` = '{$wr_id}' and `bf_no` = '{$i}' limit 1";
                        sql_query($sql);
                    } else {
                        //수정
                        $sql = " UPDATE `{$g5['board_file_table']}` set `bf_content` = '{$bf_content[$i]}', `bf_download_point` = '{$bf_download_point[$i]}' where `bo_table` = '{$bo_table}' and `wr_id` = '{$wr_id}' and `bf_no` = '{$i}' limit 1 ";
                        sql_query($sql);
                    }
                }
            }
        }
    }
}
