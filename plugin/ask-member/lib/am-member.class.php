<?php

/*  ASKTOOLS DB Class
 *  Copyright (c) AskCafe <www.asktheme.net>
 *  @author Asktheme.net (baegjins@gmail.com)
 */

/**
 * Description of DB
 *
 * @author myaskpc
 */
class DB
{

    /**
     * 회원비교
     * @param type $array
     * @return type
     */
    public static function member_diff($array)
    {
        $array = array_filter($array);
        $sql = "select * from " . AT_MEMBER_TABLE . " where ";
        $count = count($array);
        for ($i = 0; $i < $count; $i++) {
            $sql .= "mb_id ='{$array[$i]}' ";
            if ($i < $count - 1) {
                $sql .= " or ";
            }
        }
        $result = sql_query($sql);
        for ($i = 0; $rows = sql_fetch_array($result); $i++) {
            $data[] = $rows;
        }
        return $data;
    }

    /**
     * 회원정보 가져오기
     * @param type $mb_id
     * @return type
     */
    public static function get_member($mb_id)
    {
        $sql = "select * from " . AT_MEMBER_TABLE . " where `mb_id` = '{$mb_id}'";
        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 회원 메모 가져오기
     *
     * @param [type] $member
     * @param [type] $mb_id
     * @return void
     */
    public static function get_member_memo($member, $mb_id)
    {
        $sql = "SELECT * from " . BP_MEMBER_MEMO_TABLE . " where `bm_mb_id` = '{$member}' and `bm_memo_mb_id`='{$mb_id}'";
        $result = sql_fetch($sql);
        return $result;
    }
    /**
     * 회원별명 가져오기
     * @param type $mb_id
     * @return type
     */
    public static function get_member_nick($mb_id)
    {
        $sql = "select mb_nick from " . AT_MEMBER_TABLE . " where `mb_id` = '{$mb_id}'";
        $result = sql_fetch($sql);
        return $result['mb_nick'];
    }

    /**
     * 회원 삭제
     * @param type $mb_id
     * @return type
     */
    public static function delete_member($mb_id)
    {
        $sql = "delete from " . AT_MEMBER_TABLE . " where `mb_id` = '{$mb_id}' limit 1";
        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 신고 저장
     * @param type $array
     * @return type
     */
    public static function report_save($array)
    {

        $sql = "insert into `" . AT_REPORT_TABLE . "` set "
            . "`ar_reporter_id` = '{$array['reporter_id']}', "
            . "`ar_mb_id`= '{$array['mb_id']}', "
            . "`ar_type`= '{$array['type']}', "
            . "`ar_memo`= '{$array['memo']}', "
            . "`ar_me_id`= '{$array['me_id']}', "
            . "`ar_bo_table`= '{$array['bo_table']}', "
            . "`ar_wr_id`= '{$array['wr_id']}', "
            . "`ar_reason`= '{$array['reason']}', "
            . "`ar_datetime`= '" . G5_TIME_YMDHIS . "', "
            . "`ar_ip`= INET_ATON('{$array['ip']}') ";

        return sql_query($sql);
    }

    /**
     * 신고목록
     * @param type $from_record
     * @param type $page_rows
     * @return type
     */
    public static function report_list($from_record, $page_rows, $search_text = false, $reporter_id = '')
    {
        $add_where = '';
        if ($search_text) {
            $search_text = Asktools::xss_clean($search_text);
            $add_where = " where ar_mb_id = '{$search_text}' or ar_reporter_id = '{$search_text}'";
        }
        //신고자목록
        if ($reporter_id) {
            $search_text = Asktools::xss_clean($reporter_id);
            $add_where = " where  lists.ar_reporter_id = '{$search_text}'";
        }
        $sql = "select * from `" . AT_REPORT_TABLE . "` {$add_where} order by ar_idx desc limit {$from_record}, {$page_rows} ";
        $result = sql_query($sql);
        $data = array();
        while ($rows = sql_fetch_array($result)) {
            $data[] = $rows;
        }

        return $data;
    }

    /**
     * 신고목록 통합
     * @param type $from_record
     * @param type $page_rows
     * @return type
     */
    public static function report_total_list($from_record, $page_rows, $search_text = false, $reporter_id = '')
    {
        $add_where = '';
        if ($search_text) {
            $search_text = Asktools::xss_clean($search_text);
            $add_where = " where lists.ar_mb_id = '{$search_text}' or lists.ar_reporter_id = '{$search_text}'";
        }
        //신고자목록
        if ($reporter_id) {
            $search_text = Asktools::xss_clean($reporter_id);
            $add_where = " where  lists.ar_reporter_id = '{$search_text}'";
        }
        $sql = "SELECT * FROM `" . AT_REPORT_TABLE . "` as lists left join `" . AT_REPORT_SANCTION_TABLE . "` as results on lists.ar_sanction_idx = results.as_idx
         {$add_where} order by lists.ar_idx desc limit {$from_record}, {$page_rows}  ";
        $result = sql_query($sql);
        $data = array();
        while ($rows = sql_fetch_array($result)) {
            $data[] = $rows;
        }

        return $data;
    }

    /**
     * 신고목록 Total
     * @return type
     */
    public static function report_count($search_text = false, $reporter_id = '')
    {
        $add_where = '';
        if ($search_text) {
            $search_text = Asktools::xss_clean($search_text);
            $add_where = " where ar_mb_id = '{$search_text}' or ar_reporter_id = '{$search_text}'";
        }

        //신고자목록
        if ($reporter_id) {
            $search_text = Asktools::xss_clean($reporter_id);
            $add_where = " where ar_reporter_id = '{$search_text}'";
        }

        $sql = "select count(*) as total from `" . AT_REPORT_TABLE . "` {$add_where}";
        $result = sql_fetch($sql);
        return $result['total'];
    }

    /**
     * 회원메모 목록
     *
     * @param [type] $mb_id
     * @return void
     */
    public static function member_memo_total_list($from_record, $page_rows, $member_id)
    {
        $member_id = Asktools::xss_clean($member_id);

        $sql = "SELECT * from `" . BP_MEMBER_MEMO_TABLE . "` where `bm_mb_id` = '{$member_id}' limit {$from_record}, {$page_rows}";
        $result = sql_query($sql);
        $data = array();
        while ($rows = sql_fetch_array($result)) {
            $data[] = $rows;
        }

        return $data;
    }


    /**
     * 회원메모 카운트
     *
     * @param [type] $mb_id
     * @return void
     */
    public static function member_memo_count($member_id)
    {
        $member_id = Asktools::xss_clean($member_id);

        $sql = "SELECT count(*) as total from `" . BP_MEMBER_MEMO_TABLE . "` where `bm_mb_id` = '{$member_id}'";
        $result = sql_fetch($sql);
        return $result['total'];
    }


    /**
     * 신고데이터
     * @param type $ar_idx
     * @return type
     */
    public static function get_report($ar_idx, $result_idx = '')
    {
        if ($result_idx) {
            $where = "ar_sanction_idx";
        } else {
            $where = "ar_idx";
        }
        $sql = "select *, INET_NTOA(ar_ip) as ipaddress from `" . AT_REPORT_TABLE . "` where `{$where}` = '{$ar_idx}' ";
        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 신고내역 처리
     * @param type $array
     * @return type
     */
    public static function report_sanction_save($array, $update = false)
    {
        if ($update === true) {
            //수정
            $sql = "update `" . AT_REPORT_SANCTION_TABLE . "` set "
                . " `as_mb_id`='{$array['as_mb_id']}', "
                . " `as_type`='{$array['as_type']}', "
                . " `as_start_day`='{$array['as_start_day']}', "
                . " `as_end_day`='{$array['as_end_day']}', "
                . " `as_reason`='{$array['as_reason']}', "
                . " `as_memo`='{$array['as_memo']}', "
                . " `as_datetime`='" . G5_TIME_YMDHIS . "' "
                . " where  `as_idx` = '{$array['as_idx']}'";
            sql_query($sql, false);
        } else {
            //저장
            $sql = "insert into `" . AT_REPORT_SANCTION_TABLE . "` set "
                . " `as_mb_id`='{$array['as_mb_id']}', "
                . " `as_type`='{$array['as_type']}', "
                . " `as_start_day`='{$array['as_start_day']}', "
                . " `as_end_day`='{$array['as_end_day']}', "
                . " `as_reason`='{$array['as_reason']}', "
                . " `as_memo`='{$array['as_memo']}', "
                . " `as_datetime`='" . G5_TIME_YMDHIS . "' ";
            sql_query($sql, false);
            $last_id = sql_insert_id();
            //신고테이블에 키 입력.
            if ($array['ar_idx']) {
                $sql = "update `" . AT_REPORT_TABLE . "` set `ar_sanction_idx` = '{$last_id}' where `ar_idx` = '{$array['ar_idx']}'";
                sql_query($sql, true);
            }
        }
    }

    /**
     * 쪽지 발송
     * @param type $recv_mb_id
     * @param type $send_mb_id
     * @param type $contents
     */
    public static function memo_send($recv_mb_id, $send_mb_id, $contents)
    {

        $tmp_row = sql_fetch(" select max(me_id) as max_me_id from `" . AT_MEMO_TABLE . "` ");
        $me_id = $tmp_row['max_me_id'] + 1;

        // 쪽지 INSERT
        $sql = " insert into `" . AT_MEMO_TABLE . "` ( me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo ) values ( '{$me_id}', '{$recv_mb_id}', '{$send_mb_id}', '" . G5_TIME_YMDHIS . "', '{$contents}' ) ";
        sql_query($sql);

        // 실시간 쪽지 알림 기능
        $sql = " update `" . AT_MEMBER_TABLE . "` set mb_memo_call = '{$send_mb_id}', mb_memo_cnt = '" . get_memo_not_read($recv_mb_id) . "' where mb_id = '{$recv_mb_id}' ";
        sql_query($sql);
    }

    /**
     * 신고처리결과 가져오기
     * @param type $as_idx
     * @return type
     */
    public static function get_report_sanction($as_idx)
    {
        $where = 'as_idx';
        $sql = "select * from `" . AT_REPORT_SANCTION_TABLE . "` where `{$where}` = '{$as_idx}' ";
        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 신고처리목록
     * @param type $from_record
     * @param type $page_rows
     * @return type
     */
    public static function report_result_list($from_record, $page_rows)
    {
        //$sql = "select * from `" . AT_REPORT_SANCTION_TABLE . "` order by as_idx desc limit {$from_record}, {$page_rows} ";
        $sql = "SELECT * FROM `" . AT_REPORT_SANCTION_TABLE . "` as snt left join `" . AT_REPORT_TABLE . "` as rt on snt.as_idx = rt.ar_sanction_idx order by snt.as_idx desc limit {$from_record}, {$page_rows}";
        $result = sql_query($sql, false);
        $data = array();
        while ($rows = sql_fetch_array($result)) {
            $data[] = $rows;
        }

        return $data;
    }

    /**
     * 신고처리합계
     * @return type
     */
    public static function report_result_count()
    {
        $sql = "select count(*) as total from `" . AT_REPORT_SANCTION_TABLE . "`";
        $result = sql_fetch($sql);
        return $result['total'];
    }

    /**
     * 게시판 설정
     * @param type $bo_table
     * @return type
     */
    public static function get_board_inf($bo_table)
    {
        $sql = "select * from `" . AT_BOARD_TABLE . "` where `bo_table` = '{$bo_table}'";
        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 예약게시물 합계
     * @return type
     */
    public static function reserve_count()
    {
        $sql = "select count(*) as cnt from `" . AT_RESERVE_TABLE . "`";
        $result = sql_fetch($sql);
        return $result['cnt'];
    }

    /**
     * 게시판예약등록 목록
     * @param type $from_record
     * @param type $page_rows
     * @return type
     */
    public static function get_reserve_list($from_record, $page_rows)
    {
        $sql = "select *  from `" . AT_RESERVE_TABLE . "` order by ar_idx desc limit {$from_record}, {$page_rows}";
        $result = sql_query($sql, false);
        $data = array();
        while ($rows = sql_fetch_array($result)) {
            $article = ASKDB::get_article_info($rows['ar_bo_table'], $rows['ar_wr_id']);
            if (!$article) {
                $board_data = array();
            } else {
                $board_data = $article;
            }
            $data[] = array_merge(array_merge($rows, ASKDB::get_board_info($rows['ar_board'])), $board_data);
        }

        return $data;
    }

    /**
     * 게시판예약등록삭제
     * @param type $ar_idx
     */
    public static function remove_reserve($ar_idx)
    {
        $sql = "delete from `" . AT_RESERVE_TABLE . "` where `ar_idx` = '{$ar_idx}' limit 1";
        sql_query($sql);
    }

    /**
     * 메모 목록
     * @param type $from_record
     * @param type $page_rows
     * @param type $search_text
     * @return type
     */
    public static function get_memo_list($from_record, $page_rows, $search_text = false)
    {
        $add_where = '';
        if ($search_text) {
            $search_text = Asktools::xss_clean($search_text);
            $add_where = " where `me_recv_mb_id` = '$search_text' or `me_send_mb_id` = '{$search_text}' or `me_memo` like '%{$search_text}%'";
        }
        $sql = "select * from `" . AT_MEMO_TABLE . "` {$add_where} order by me_id desc limit {$from_record}, {$page_rows}";
        $result = sql_query($sql);
        $data = array();
        while ($rows = sql_fetch_array($result)) {
            $data[] = $rows;
        }

        return $data;
    }

    /**
     * 메모 합계
     * @return type
     */
    public static function memo_count($search_text = false)
    {
        $add_where = '';
        if ($search_text) {
            $search_text = Asktools::xss_clean($search_text);
            $add_where = " where `me_recv_mb_id` = '$search_text' or `me_send_mb_id` = '{$search_text}' or `me_memo` like '%{$search_text}%'";
        }
        $sql = "select count(*) as total from `" . AT_MEMO_TABLE . "` {$add_where}";
        $result = sql_fetch($sql);
        return $result['total'];
    }

    /**
     * 메모뷰 합계
     * @param type $mb_id
     * @param type $mode
     * @return type
     */
    public static function memo_view_count($mb_id, $mode = "")
    {
        $mb_id = Asktools::xss_clean($mb_id);

        if ($mode == 'send') {
            $add_where = " where `me_send_mb_id` = '{$mb_id}' or ";
        } else {
            $add_where = " where `me_recv_mb_id` = '{$mb_id}' or ";
        }

        $sql = "select count(*) as total from `" . AT_MEMO_TABLE . "` {$add_where}";
        $result = sql_fetch($sql);
        return $result['total'];
    }

    /**
     * 쪽지 가져오기
     * @param type $idx
     * @return type
     */
    public static function get_memo_view($idx)
    {
        $me_idx = Asktools::xss_clean($idx);

        $sql = "select * from `" . AT_MEMO_TABLE . "` where `me_id` = '{$me_idx}'";

        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 전체회원정보
     * @param type $field
     * @return type
     */
    public static function get_member_all($field = 'mb_id')
    {
        $sql = "select * from " . AT_MEMBER_TABLE;
        $result = sql_query($sql);
        while ($rows = sql_fetch_array($result)) {
            $data[] = $rows;
        }

        return $data;
    }

    /**
     * 회원수
     * @return type
     */
    public static function count_member()
    {
        $sql = "select count(*) as cnt from " . AT_MEMBER_TABLE;
        $result = sql_fetch($sql);
        return $result['cnt'];
    }
}
