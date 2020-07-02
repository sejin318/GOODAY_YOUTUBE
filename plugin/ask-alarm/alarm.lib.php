<?php

/**
 * ask alarm plugin
 * 
 */

/**
 * 
 * 댓글 알람 write_comment_update.php 
 * run_event('comment_update_after', $board, $wr_id, $w, $qstr, $redirect_url);
 * 
 * 답글 알람 write_update.php
 * run_event('write_update_after', $board, $wr_id, $w, $qstr, $redirect_url);
 * 
 * 메모 알람 memo_form_update.php
 * run_event('memo_form_update_after', $member_list, $str_nick_list, $redirect_url);
 * 
 * QA 알람 qawrite_update.php
 * run_event('qawrite_update', $qa_id, $write, $w, $qaconfig);
 */
if (!function_exists('bp_alarm_comments')) {
    /**
     * 댓글 알람 등록
     *
     * @param [type] $board
     * @param [type] $wr_id
     * @param [type] $w
     * @param [type] $qstr
     * @param [type] $redirect_url
     * @return void
     */
    function bp_alarm_comments($board, $wr_id, $w, $qstr, $redirect_url)
    {
        global $g5, $is_member, $member, $comment_id, $config;

        if (!$config['bp_use_alarm']) {
            return false;
        }

        if ($w == 'cu') {
            return false;
        }
        if ($w == 'c') {
            //원글
            $write = ASKDB::get_article_info($board['bo_table'], $wr_id);

            $comments_parent = false;
            //댓글의 댓글
            if (isset($_POST['comment_id']) && $_POST['comment_id']) {
                //부모 wr_id
                $insert_comment_id = Asktools::xss_clean($_POST['comment_id']);
                $comments_parent =  ASKDB::get_article_info($board['bo_table'], $insert_comment_id);
            }
            //작성된 댓글
            $comments = ASKDB::get_article_info($board['bo_table'], $comment_id);

            if ($is_member) {
                $writer_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
            } else {
                $writer_name = addslashes($comments['wr_name']);
            }

            //원글과 다른 회원 댓글 알람
            if ($write['mb_id'] != $comments['mb_id'] && !$comments_parent) {
                //알람 등록
                $contents = sql_real_escape_string(cut_str(strip_tags($comments['wr_content']), 40)) . " ";
                bp_alarm_insert('comment', $board['bo_table'], $comment_id, $board['bo_subject'], $contents, $writer_name, $write['mb_id']);
            }

            //원글과 다른 회원 댓글 알람 - 본인 댓글에 본인이 답댓글
            if ($write['mb_id'] != $comments['mb_id'] && $comments_parent['mb_id'] == $comments['mb_id']) {
                //알람 등록
                $contents = sql_real_escape_string(cut_str(strip_tags($comments['wr_content']), 40)) . " ";
                bp_alarm_insert('comment', $board['bo_table'], $comment_id, $board['bo_subject'], $contents, $writer_name, $write['mb_id']);
            }

            //원댓글과 다른 회원의 대댓글
            if ($comments_parent && $comments_parent['mb_id'] != $comments['mb_id']) {
                //부모댓글에 알람 등록
                $contents = sql_real_escape_string(cut_str(strip_tags($comments['wr_content']), 40)) . " ";
                bp_alarm_insert('comment', $board['bo_table'], $comment_id, $board['bo_subject'], $contents, $writer_name, $comments_parent['mb_id']);
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('bp_alarm_insert')) {
    /**
     * 게시물 알람을 DB에 등록
     * @param [type] $type
     * @param [type] $bo_table
     * @param [type] $wr_id
     * @param [type] $bo_subject
     * @param [type] $parent_subject
     * @param [type] $writer_name
     * @param [type] $parent_mb_id
     * @param string $me_id
     * @return void
     */
    function bp_alarm_insert($type, $bo_table, $wr_id, $bo_subject, $parent_subject, $writer_name, $parent_mb_id, $me_id = '')
    {
        //DB 등록
        $sql = "INSERT into `" . BP_ALARM_TABLE . "` set `ba_type` = '{$type}',
                                                            `ba_bo_table` = '{$bo_table}',
                                                            `ba_wr_id` = '{$wr_id}',
                                                            `ba_me_id` = '{$me_id}',
                                                            `ba_bo_subject` = '{$bo_subject}',
                                                            `ba_wr_subject` = '{$parent_subject}',
                                                            `ba_datetime` = '" . G5_TIME_YMDHIS . "',
                                                            `ba_name` = '{$writer_name}',
                                                            `ba_mb_id` = '{$parent_mb_id}',
                                                            `ba_read` = '0'";
        sql_query($sql, true);
        //알람 개수 업데이트
        bp_alarm_count($parent_mb_id, 'add');
        return true;
    }
}

if (!function_exists('bp_alarm_reply')) {
    /**
     * 답글 알람 
     *
     * @param [type] $board
     * @param [type] $wr_id
     * @param [type] $w
     * @param [type] $qstr
     * @param [type] $redirect_url
     * @return void
     */
    function bp_alarm_reply($board, $wr_id, $w, $qstr, $redirect_url)
    {
        global $g5, $is_member, $member, $comment_id, $config;

        if (!$config['bp_use_alarm']) {
            return false;
        }

        if ($w != 'r') {
            return false;
        }

        $parent_wr_id = isset($_POST['wr_id']) &&  $_POST['wr_id'] ? Asktools::xss_clean($_POST['wr_id']) : 0;

        //원글 가져오기
        $parent_contents = ASKDB::get_article_info($board['bo_table'], $parent_wr_id);

        if ($is_member) {
            $writer_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
        } else {
            $writer_name = addslashes($parent_contents['wr_name']);
        }

        //원글작성자와 동일 작성자는 패스~
        if ($parent_contents['mb_id'] == $member['mb_id']) {
            return false;
        }

        if ($parent_wr_id) {
            $contents = sql_real_escape_string(cut_str(strip_tags($parent_contents['wr_content']), 40));
            bp_alarm_insert('reply', $board['bo_table'], $parent_wr_id, $board['bo_subject'], $contents, $writer_name, $parent_contents['mb_id']);
        }
    }
}

if (!function_exists('bp_alarm_memo')) {

    /**
     * 메모 알람 등록
     *
     * @param [type] $member_list
     * @param [type] $str_nick_list
     * @param [type] $redirect_url
     * @return void
     */
    function bp_alarm_memo($member_list, $str_nick_list, $redirect_url)
    {
        global $g5, $is_member, $member, $config, $me_id;

        if (!$config['bp_use_alarm']) {
            return false;
        }
        if (!$is_member) {
            return false;
        };

        if (isset($_POST['me_memo'])) {
            $memo = $_POST['me_memo'];
        }

        if (isset($member_list['id']) && $member_list['id']) {
            $id_count = count($member_list['id']);
            for ($i = 0; $i < $id_count; $i++) {

                $mb_id = $member_list['id'][$i];

                if (($mb_id === $member['mb_id']) || !$me_id) {
                    return false;
                }
                $wr_name = clean_xss_tags($member['mb_nick']);

                //알람등록
                bp_alarm_insert('memo', '', '', '', $memo, $wr_name, $mb_id, $me_id);
            }
        }
    }
}

if (!function_exists('bp_alarm_qa')) {
    /**
     * 1:1문의 알람
     *
     * @param [type] $qa_id
     * @param [type] $write
     * @param [type] $w
     * @param [type] $qaconfig
     * @return void
     */
    function bp_alarm_qa($qa_id, $write, $w, $qaconfig)
    {
        global $g5, $is_member, $member, $is_admin;

        //답변시 알람 등록
        if ($is_admin && $qa_id && $w == 'a') {
            $qa_id = (int) $qa_id;

            $sql = " select * from {$g5['qa_content_table']} where qa_id = '{$qa_id}' ";
            $write_item = sql_fetch($sql);

            $contents = sql_real_escape_string(cut_str(strip_tags($write_item['qa_content']), 40));
            $writer_name = addslashes(clean_xss_tags($member['mb_nick']));

            //다른 회원일 경우
            if ($write_item['mb_id'] != $member['mb_id']) {
                bp_alarm_insert('qna', '', $qa_id, '1:1문의', $contents, $writer_name, $write_item['mb_id']);
            }
            return true;
        }
    }
}


if (!function_exists('bp_alarm_count')) {
    /**
     * 회원 알람 카운터 저장
     *
     * @param [type] $mb_id
     * @param [type] $type
     * @return void
     */
    function bp_alarm_count($mb_id, $type)
    {
        $sql = "SELECT count(*) as cnt from `" . BP_MEMBER_TABLE . "` where `bm_mb_id` = '{$mb_id}'";
        $_ext_field = sql_fetch($sql, true);
        //row값이 없으면 무조건 추가한다.
        if ($_ext_field['cnt'] == 0) {
            $sql = "INSERT into `" . BP_MEMBER_TABLE . "` set `bm_mb_id`='{$mb_id}'";
            sql_query($sql);
        }
        //타입, 더하기, 빼기
        if ($type == 'add') {
            $num = " `bm_alarm_count` + 1 ";
        }
        if ($type == 'remove') {
            $num = " `bm_alarm_count` - 1 ";
        }

        //update
        $sql = "UPDATE `" . BP_MEMBER_TABLE . "` set `bm_alarm_count` = {$num} where `bm_mb_id` = '{$mb_id}'";
        sql_query($sql, true);
    }
}
//메모 알람 이벤트 등록
add_event('memo_form_update_after', 'bp_alarm_memo', 10, 5);

//답글 알람 이벤트 등록
add_event('write_update_after', 'bp_alarm_reply', 10, 5);

//댓글 알람 이벤트 등록
add_event('comment_update_after', 'bp_alarm_comments', 10, 5);

//1:1문의 알람 이벤트 등록
add_event('qawrite_update', 'bp_alarm_qa', 10, 8);
