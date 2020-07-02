<?php

//ASKUPLOAD 환경설정
inc_auconfig($bo_table);

//댓글 첨부파일이 있다면 삭제
$sql = " select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    @unlink(G5_DATA_PATH . '/file/' . $bo_table . '/' . str_replace('../', '', $row['bf_file']));
    // 썸네일삭제
    if (preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
        delete_board_thumbnail($bo_table, $row['bf_file']);
    }
}
//DB에서도 삭제한다.
$sql = "delete from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}'";
sql_query($sql);
