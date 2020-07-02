<?php

//ASKUPLOAD 환경설정
inc_auconfig($bo_table);


if (AU_COMMENT == true) {
//쓰기 완료시 임시세션 값을 $wr_id로 변경하기.
    if (get_session('comment_wr_id_tmp') && $comment_wr_id_tmp) {

        //임시첨부파일을 해당 댓글 첨부로 업데이트
        $sql = "select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_wr_id_tmp}'";
        $result = sql_query($sql);
        for ($i = 0; $rows = sql_fetch_array($result); $i++) {
            //첨부파일 마지막 번호 
            $sql = "select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' order by bf_no desc";

            $last_bf_no = sql_fetch($sql);
            if ($last_bf_no) {
                $bf_no = $last_bf_no['bf_no'] + 1;
            } else {
                $bf_no = 0;
            }
            //wr_id 업데이트
            $sql = "update {$g5['board_file_table']} set wr_id = '{$comment_id}', bf_no = '{$bf_no}' where bo_table = '{$bo_table}' and wr_id = '{$comment_wr_id_tmp}' and bf_no ='{$i}'";
            sql_query($sql);
        }

        // 파일의 개수를 게시물에 업데이트 한다.
        au_file_total($bo_table, $comment_id);
    }
}
//임시 세션 지우기
set_session('comment_wr_id_tmp', false);
