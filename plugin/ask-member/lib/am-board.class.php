<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * DB 쿼리
 */
class ASKDB
{

    /**
     * 게시물 본문 가져오기
     * @param type $bo_table
     * @param type $wr_id
     * @return string
     */
    public static function get_article_info($bo_table, $wr_id)
    {
        $bo_table = Asktools::xss_clean($bo_table);
        $wr_id = Asktools::xss_clean($wr_id);

        $sql = "select * from `" . AT_WRITE . $bo_table . "` where `wr_id` = '{$wr_id}'";
        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 게시판정보 가져오기
     * @param type $bo_table
     * @return type
     */
    public static function get_board_info($bo_table)
    {
        $bo_table = Asktools::xss_clean($bo_table);
        $sql = "select * from `" . AT_BOARD_TABLE . "` where `bo_table` = '{$bo_table}'";
        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 메모 정보 가져오기
     * @param type $me_id
     * @return type
     */
    public static function get_memo_info($me_id)
    {
        $me_id = Asktools::xss_clean($me_id);
        $sql = "select * from `" . AT_MEMO_TABLE . "` where `me_id` = '{$me_id}'";
        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 테이블 유무 검사
     * @param type $table_name
     * @return type
     */
    public static function exsit_table($table_name)
    {
        $sql = "SELECT EXISTS ( SELECT 1 FROM Information_schema.tables WHERE table_name = '" . $table_name . "' AND table_schema = '" . AT_MYSQL_DB . "' ) AS flag";
        $result = sql_fetch($sql);
        if ($result['flag'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 게시물신고 카운터
     * @param type $bo_table
     * @param type $wr_id
     * @param type $mb_id
     * @return type
     */
    public static function check_board_report($bo_table, $wr_id, $mb_id = false)
    {
        $addwhere = "";
        if ($mb_id) {
            $addwhere = " and `ar_reporter_id` = '{$mb_id}' ";
        }
        $sql = "select count(*) as cnt from `" . AT_REPORT_TABLE . "` where `ar_bo_table` = '{$bo_table}' and `ar_wr_id` = '{$wr_id}' {$addwhere}";
        $result = sql_fetch($sql);
        return $result['cnt'];
    }

    /**
     * 쪽지 신고했는지 검사
     * @param type $me_id
     * @return type
     */
    public static function check_memo_report($me_id)
    {
        $sql = "select * from `" . AT_REPORT_TABLE . "` where `ar_me_id` = '{$me_id}' order by ar_idx desc limit 1";
        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 제재 내역 체크
     * @param type $mb_id
     * @return type
     */
    public static function check_sangction($mb_id)
    {
        $sql = "select * from `" . AT_REPORT_SANCTION_TABLE . "` where `as_mb_id` = '{$mb_id}' and (`as_start_day` <= '" . G5_TIME_YMD . "' and `as_end_day` >= '" . G5_TIME_YMD . "' ) and as_type != 'reject' ";
        $result = sql_query($sql, false);
        while ($rows = sql_fetch_array($result)) {
            $data[] = $rows;
        }
        return $data;
    }

    /**
     * 인기게시물 뽑기 - board_new 테이블에서 뽑기.
     * @global type $g5
     * @param type $bo_table
     * @param type $days
     * @return type
     */
    public static function get_popular_item($bo_table, $days = 7)
    {
        global $g5;
        $date = date("Y-m-d", strtotime("-1 week"));
        $sql = " select a.*, b.bo_subject, c.wr_subject, c.wr_hit, c.wr_good, c.wr_comment from g5_board_new a left join  g5_board b  on a.bo_table = b.bo_table left join  {$g5['write_prefix']}{$bo_table} c
                on a.wr_id = c.wr_id where  a.bo_table = '{$bo_table}' and  b.bo_use_search = 1 and a.bn_datetime > '{$date}' and c.wr_is_comment = '0' order by c.wr_good desc, c.wr_hit desc, c.wr_comment desc limit 5";
        $result = sql_query($sql);
        while ($rows = sql_fetch_array($result)) {
            $data[] = $rows;
        }
        return $data;
    }

    /**
     * 이슈 게시물 정보
     * @param type $bo_table
     * @param type $wr_id
     */
    public static function get_issue_info($bo_table, $wr_id)
    {
        $sql = "select * from `" . AT_ISSUE_TABLE . "` where `ai_bo_table` = '{$bo_table}' and `ai_wr_id` = '{$wr_id}'";
        $result = sql_fetch($sql);
        return $result;
    }

    /**
     * 이슈 지정
     * @param type $bo_table
     * @param type $wr_id
     * @param type $make
     */
    public static function set_issue($bo_table, $wr_id, $mb_id, $make = true)
    {
        //이슈 지정일 경우
        if ($make === true) {
            $sql = "insert into `" . AT_ISSUE_TABLE . "` set `ai_bo_table` ='{$bo_table}', `ai_wr_id` = '{$wr_id}', `ai_datetime` ='" . G5_TIME_YMDHIS . "', `ai_mb_id` = '{$mb_id}'";
        } else {
            $sql = "delete from `" . AT_ISSUE_TABLE . "` where `ai_bo_table` ='{$bo_table}' and `ai_wr_id` = '{$wr_id}' limit 1";
        }
        sql_query($sql);
    }

    /**
     * 이슈설정 해제
     * @param type $ai_idx
     */
    public static function unset_issue($ai_idx)
    {
        $sql = "delete from `" . AT_ISSUE_TABLE . "` where `ai_idx` ='{$ai_idx}' limit 1";
        sql_query($sql);
    }

    /**
     * 게시판 목록
     * @global type $g5
     * @global type $is_admin
     * @global type $member
     * @return type
     */
    public static function get_board_list()
    {
        global $g5, $is_admin, $member;
        //대상 게시판 
        $sql = " select * from {$g5['board_table']} a, {$g5['group_table']} b where a.gr_id = b.gr_id ";
        if ($is_admin == 'group') {
            $sql .= " and b.gr_admin = '{$member['mb_id']}' ";
        } else if ($is_admin == 'board') {
            $sql .= " and a.bo_admin = '{$member['mb_id']}' ";
        }
        $sql .= " order by a.gr_id, a.bo_order, a.bo_table ";

        $result = sql_query($sql);
        for ($i = 0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = $row;
        }
        return $list;
    }

    /**
     * 첨부파일 정보
     *
     * @param [type] $bo_table
     * @param [type] $wr_id
     * @return void
     */
    public static  function get_file($bo_table, $wr_id, $bf_no)
    {
        global $g5, $qstr;

        $file['count'] = 0;
        $sql = " SELECT * from `{$g5['board_file_table']}` where `bo_table` = '{$bo_table}' and `wr_id` = '{$wr_id}' and `bf_no` = '{$bf_no}' ";
        $file = sql_fetch($sql);
        return $file;
    }

    /**
     * 게시판 예약등록
     * @param type $data
     */
    public static function add_reserve($data)
    {
        $sql = "insert into `" . AT_RESERVE_TABLE . "` set `ar_bo_table` = '{$data['bo_table']}', `ar_wr_id` = '{$data['wr_id']}', `ar_board` = '{$data['ar_board']}', `ar_datetime` = '{$data['ar_datetime']}'";
        sql_query($sql);
    }

    /**
     * 게시판 예약 정보
     * @param type $wr_id
     * @param type $mode
     * @return type
     */
    public static function get_reserve_info($wr_id, $mode = '')
    {
        $select = " * ";
        if ($mode == 'count') {
            $select = " count(*) as cnt ";
        }

        $sql = "select {$select} from `" . AT_RESERVE_TABLE . "` where `ar_wr_id` = '{$wr_id}'";

        if ($mode == 'count') {
            $result = sql_fetch($sql);
            return $result['cnt'];
        } else {
            $result = sql_query($sql);
            while ($row = sql_fetch_array($result)) {
                $data[] = array_merge($row, self::get_board_info($row['ar_board']));
            }
            return $data;
        }
    }

    /**
     * 회원 레벨 업
     * @param type $mb_id
     * @param type $lv1
     * @param type $lv2
     */
    public static function member_levelup($mb_id, $lv1, $lv2)
    {
        $sql = "update `" . AT_MEMBER_TABLE . "` set `mb_level` = '{$lv2}' where `mb_id` = '{$mb_id}' and `mb_level` = '{$lv1}' limit 1";
        sql_query($sql);
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
        $sql = " INSERT into `" . AT_MEMO_TABLE . "` ( me_id, me_recv_mb_id, me_send_mb_id, me_send_datetime, me_memo ) values ( '{$me_id}', '{$recv_mb_id}', '{$send_mb_id}', '" . G5_TIME_YMDHIS . "', '{$contents}' ) ";
        sql_query($sql, true);

        // 실시간 쪽지 알림 기능
        $sql = " UPDATE `" . AT_MEMBER_TABLE . "` set mb_memo_call = '{$send_mb_id}' where mb_id = '{$recv_mb_id}' ";
        sql_query($sql, true);

        $mb = DB::get_member($send_mb_id);
        //메모 알람 등록
        bp_alarm_insert('memo', '', '', '', $contents, $mb['mb_name'], $recv_mb_id, $me_id);
    }

    /**
     * 회원 포인트 순위
     * @param type $row
     * @return type
     */
    public function point_rank($row = 10)
    {
        global $g5;
        $sql = "SELECT mb_nick, mb_point from {$g5['member_table']} order by mb_point desc limit {$row}";
        $result = sql_query($sql);
        $point = array();
        while ($data = sql_fetch_array($result)) {
            $point[] = $data;
        }
        return $point;
    }

    /**
     * 내 즐겨찾기
     *
     * @param integer $limit
     * @return void
     */
    public static function  get_myfavorite($limit = 5)
    {
        global $member;
        $sql = "SELECT * from `" . BP_FAVORITE_TABLE . "` where `bf_mb_id` = '" . escape_trim($member['mb_id']) . "' limit {$limit}";
        $result = sql_query($sql);

        $list = array();
        for ($i = 0; $rows = sql_fetch_array($result); $i++) {
            $list[$i]['bo_table'] = $rows['bf_bo_table'];
            $list[$i]['bo_subject'] = $rows['bf_subject'];
        } //for

        return $list;
    }

    /**
     * 내 알람 목록
     *
     * @param integer $limit
     * @return void
     */
    public static function get_myalarm($limit = 5)
    {
        global $g5, $member;

        $list = array();

        $sql_common = " from  `" . BP_ALARM_TABLE . "` where ba_mb_id = '" . escape_trim($member['mb_id']) . "' ";
        $sql_order = " order by ba_idx asc ";
        $sql = " SELECT * {$sql_common} {$sql_order} limit {$limit} ";
        $result = sql_query($sql, true);
        $str = '';
        for ($i = 0; $rows = sql_fetch_array($result); $i++) {
            $str .= "<li class='list-group-item text-cut'>";
            $str .= $rows['ba_type'] == 'comment' ? '<i class="fa fa-comment" aria-hidden="true"></i> 댓글' : "";
            $str .= $rows['ba_type'] == 'reply' ? '<i class="fa fa-reply" aria-hidden="true"></i> 답글' : "";
            $str .= $rows['ba_type'] == 'memo' ? '<i class="fa fa-envelope-open-o" aria-hidden="true"></i> 쪽지' : "";
            $str .= $rows['ba_type'] == 'qna' ? '<i class="fa fa-question" aria-hidden="true"></i> 1:1문의' : "";
            $str .=  $rows['ba_name']  . "님이 ";
            if (($rows['ba_type'] == 'comment' || $rows['ba_type'] == 'reply') && $rows['ba_bo_table'] && $rows['ba_wr_id']) {
                $str .= $rows['ba_bo_subject'] != '' ? "<a href='" . G5_PLUGIN_URL . DIRECTORY_SEPARATOR . "ask-alarm/alarm_link.php?ba_idx={$rows['ba_idx']}'  class='text-link'>[" . $rows['ba_bo_subject'] . "] " : "";
                $str .= $rows['ba_wr_subject'] != '' ? cut_str($rows['ba_wr_subject'], 20) . ' </a> 게시물에 댓글을 남겼습니다.' : "";
            }
            if ($rows['ba_type'] == 'qna') {
                $str .= $rows['ba_bo_subject'] != '' ? "<a href='" . G5_PLUGIN_URL . DIRECTORY_SEPARATOR . "ask-alarm/alarm_link.php?ba_idx={$rows['ba_idx']}'  class='text-link'>[" . $rows['ba_bo_subject'] . "] " : "";
                $str .= $rows['ba_wr_subject'] != '' ? cut_str($rows['ba_wr_subject'], 20) . ' </a> 에 답변을 남겼습니다.' : "";
            }

            if ($rows['ba_type'] == 'memo') {
                $str .= $rows['ba_wr_subject'] != '' ? "<a href='" . G5_PLUGIN_URL . DIRECTORY_SEPARATOR . "ask-alarm/alarm_link.php?ba_idx={$rows['ba_idx']}'  class='text-link'>[" . cut_str($rows['ba_wr_subject'], 20) . "]</a> 쪽지를 발송하였습니다. " : "";
            }
            $str .= $rows['ba_read'] ? "<span class=''><i class='fa fa-folder-open-o' aria-hidden='true'></i> <span class='d-none d-lg-inline'>읽음</span></span>" : "<span class=''><i class='fa fa-folder' aria-hidden='true'></i></span>";
            $str .= "</li>";
        } //for
        return $str;
    }

    /**
     * 내 최신 스크랩
     *
     * @param integer $limit
     * @return void
     */
    public static function get_myscrap($limit = 5)
    {
        global $g5, $member;

        $sql_common = " from {$g5['scrap_table']} where mb_id = '{$member['mb_id']}' ";
        $sql_order = " order by ms_id desc ";
        $list = array();

        $sql = " select * $sql_common $sql_order  limit $limit ";
        $result = sql_query($sql);
        for ($i = 0; $row = sql_fetch_array($result); $i++) {

            $list[$i] = $row;

            // 게시판 제목
            $sql2 = " select bo_subject from {$g5['board_table']} where bo_table = '{$row['bo_table']}' ";
            $row2 = sql_fetch($sql2);
            if (!$row2['bo_subject']) $row2['bo_subject'] = '[게시판 없음]';

            // 게시물 제목
            $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];
            $sql3 = " select wr_subject from $tmp_write_table where wr_id = '{$row['wr_id']}' ";
            $row3 = sql_fetch($sql3, FALSE);
            $subject = get_text(cut_str($row3['wr_subject'], 30));
            if (!$row3['wr_subject'])
                $row3['wr_subject'] = '[글 없음]';

            $list[$i]['opener_href'] = get_pretty_url($row['bo_table']);
            $list[$i]['opener_href_wr_id'] = get_pretty_url($row['bo_table'], $row['wr_id']);
            $list[$i]['bo_subject'] = $row2['bo_subject'];
            $list[$i]['subject'] = $subject;
        }
        return $list;
    }
    /**
     * 내 포인트 내역
     *
     * @param integer $limit
     * @return void
     */
    public static function get_mypoint($limit = 5)
    {
        global $g5, $member;
        $sql_common = " from {$g5['point_table']} where mb_id = '" . escape_trim($member['mb_id']) . "' ";
        $sql_order = " order by po_id desc ";

        $sql = " SELECT * {$sql_common} {$sql_order} limit $limit ";
        $result = sql_query($sql);
        $list = array();
        for ($i = 0; $row = sql_fetch_array($result); $i++) {
            $point1 = $point2 = 0;
            $list[$i]['point_use_class'] = '';
            if ($row['po_point'] > 0) {
                $point1 = '+' . number_format($row['po_point']);
                $list[$i]['point1'] = $point1;
            } else {
                $point2 = number_format($row['po_point']);
                $list[$i]['point2'] = $point2;
                $list[$i]['point_use_class'] = 'point_use';
            }

            $list[$i]['po_content'] = $row['po_content'];

            $list[$i]['expired_class'] = '';
            if ($row['po_expired'] == 1) {
                $list[$i]['expired_class'] = ' disabled';
            }
            $list[$i]['po_expire_date'] = '';
            if ($row['po_expired'] == 1) {
                $list[$i]['po_expire_date'] = "만료 " . substr(str_replace('-', '', $row['po_expire_date']), 2);
            } else {
                $list[$i]['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date'];
            };
        } //for
        return $list;
    }

    /**
     * 받은 최신쪽지
     *
     * @param integer $limit
     * @return void
     */
    public static function get_mymemo($limit = 5)
    {
        global $g5, $member;

        $sql = " SELECT * from {$g5['memo_table']} where `me_type`='recv' and `me_recv_mb_id` = '" . escape_trim($member['mb_id']) . "' order by me_id desc limit {$limit}";
        $result = sql_query($sql);
        for ($i = 0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = $row;

            if (substr($row['me_read_datetime'], 0, 1) == 0) {
                $is_read = '<i class="fa fa-envelope" aria-hidden="true"></i>';
            } else {
                $is_read = '<i class="fa fa-envelope-open-o" aria-hidden="true"></i>';
            }
            $list[$i]['is_read'] = $is_read;
            $list[$i]['view_href'] = G5_BBS_URL . '/memo_view.php?me_id=' . $row['me_id'] . '&amp;kind=recv';
        }
        return $list;
    }
    /**
     * 회원 최근게시물
     *
     * @param [type] $limit
     * @return void
     */
    public static function get_mylatest($limit = 5)
    {
        global $g5, $member, $config;
        $sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id and b.bo_use_search = 1 ";
        $sql_common .= " and a.mb_id = '" . escape_trim($member['mb_id']) . "' ";
        $sql_order = " order by a.bn_id desc ";

        $list = array();
        $sql = " SELECT a.*, b.bo_subject, b.bo_mobile_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$limit} ";
        $result = sql_query($sql);
        for ($i = 0; $row = sql_fetch_array($result); $i++) {
            $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

            if ($row['wr_id'] == $row['wr_parent']) {

                // 원글
                $comment = "";
                $comment_link = "";
                $row2 = sql_fetch(" SELECT * from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");
                $list[$i] = $row2;

                $name = get_sideview($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);
                // 당일인 경우 시간으로 표시함
                $datetime = substr($row2['wr_datetime'], 0, 10);
                $datetime2 = $row2['wr_datetime'];
                if ($datetime == G5_TIME_YMD) {
                    $datetime2 = substr($datetime2, 11, 5);
                } else {
                    $datetime2 = substr($datetime2, 5, 5);
                }
            } else {

                // 코멘트
                $comment = '[코] ';
                $comment_link = '#c_' . $row['wr_id'];
                $row2 = sql_fetch(" SELECT * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
                $row3 = sql_fetch(" SELECT mb_id, wr_name, wr_email, wr_homepage, wr_datetime from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");
                $list[$i] = $row2;
                $list[$i]['wr_id'] = $row['wr_id'];
                $list[$i]['mb_id'] = $row3['mb_id'];
                $list[$i]['wr_name'] = $row3['wr_name'];
                $list[$i]['wr_email'] = $row3['wr_email'];
                $list[$i]['wr_homepage'] = $row3['wr_homepage'];

                $name = get_sideview($row3['mb_id'], get_text(cut_str($row3['wr_name'], $config['cf_cut_name'])), $row3['wr_email'], $row3['wr_homepage']);
                // 당일인 경우 시간으로 표시함
                $datetime = substr($row3['wr_datetime'], 0, 10);
                $datetime2 = $row3['wr_datetime'];
                if ($datetime == G5_TIME_YMD) {
                    $datetime2 = substr($datetime2, 11, 5);
                } else {
                    $datetime2 = substr($datetime2, 5, 5);
                }
            }

            $list[$i]['gr_id'] = $row['gr_id'];
            $list[$i]['bo_table'] = $row['bo_table'];
            $list[$i]['name'] = $name;
            $list[$i]['comment'] = $comment;
            $list[$i]['href'] = get_pretty_url($row['bo_table'], $row2['wr_id'], $comment_link);
            $list[$i]['datetime'] = $datetime;
            $list[$i]['datetime2'] = $datetime2;

            $list[$i]['gr_subject'] = $row['gr_subject'];
            $list[$i]['bo_subject'] = ((G5_IS_MOBILE && $row['bo_mobile_subject']) ? $row['bo_mobile_subject'] : $row['bo_subject']);
            $list[$i]['wr_subject'] = $row2['wr_subject'];
        }
        return $list;
    }
}
