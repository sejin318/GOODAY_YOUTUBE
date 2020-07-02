<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * 댓글 입력시 첨부파일 처리
 */
//임시키에 wr_id 넣기
if ($board['bb_comment_image'] && $is_member) {
    include_once G5_LIB_PATH . '/thumbnail.lib.php';

    if ($comment_image_key) {
        $tmp_key = trim($comment_image_key);
        $tmp_key = explode(',', $comment_image_key);
        foreach ($tmp_key as $wr_id_key) {
            if ($wr_id_key) {
                $sql = "UPDATE `{$g5['board_file_table']}` set `wr_id` = '{$comment_id}' where `wr_id` = '{$wr_id_key}' limit 1";
                sql_query($sql, true);
            }
        }
    }
    //댓글 첨부 순서 정렬
    comment_file_no_sort($bo_table, $comment_id);
    // 파일의 개수를 댓글에 업데이트 한다.
    $row = sql_fetch(" SELECT count(*) as cnt from `{$g5['board_file_table']}` where `bo_table` = '{$bo_table}' and `wr_id` = '{$comment_id}' ");
    sql_query(" UPDATE {$g5['write_prefix']}{$bo_table} set `wr_file` = '{$row['cnt']}' where wr_id = '{$comment_id}' ", true);
}
