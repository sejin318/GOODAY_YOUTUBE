<?php

/**
 * 댓글에 첨부파일을 삭제한다.
 */
//ASKUPLOAD 환경설정
inc_auconfig($bo_table);


for ($i = $chk_count - 1; $i >= 0; $i--) {
    $write = sql_fetch(" select * from $write_table where wr_id = '$tmp_array[$i]' ");

    $len = strlen($write['wr_reply']);
    if ($len < 0) {
        $len = 0;
    }
    $reply = substr($write['wr_reply'], 0, $len);

    // 원글만 구한다.
    $sql = " select count(*) as cnt from $write_table
                where wr_reply like '$reply%'
                and wr_id <> '{$write['wr_id']}'
                and wr_num = '{$write['wr_num']}'
                and wr_is_comment = 0 ";
    $row = sql_fetch($sql);
    if ($row['cnt']) {
        continue;
    }

    //삭제하려는 게시물의 댓글
    $sql = " select wr_id, mb_id, wr_is_comment, wr_content from $write_table where wr_parent = '{$write['wr_id']}' and wr_is_comment = 1 order by wr_id ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result)) {
        //댓글에 업로드된 파일이 있다면 파일삭제
        $sql2 = " select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$row['wr_id']}' ";
        $result2 = sql_query($sql2);
        while ($row2 = sql_fetch_array($result2)) {
            @unlink(G5_DATA_PATH . '/file/' . $bo_table . '/' . str_replace('../', '', $row2['bf_file']));
            // 썸네일삭제
            if (preg_match("/\.({$config['cf_image_extension']})$/i", $row2['bf_file'])) {
                delete_board_thumbnail($bo_table, $row2['bf_file']);
            }
        }

        // 파일테이블 행 삭제
        sql_query(" delete from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$row['wr_id']}' ");
    }
}