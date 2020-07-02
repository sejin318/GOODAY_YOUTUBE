<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

Asktools::init();
/**
 * ASK Member tools
 */
class Asktools
{

    /**
     * G5 기본설정
     * @var type 
     */
    static $g5;

    /**
     * 기본환경설정
     * @var type 
     */
    static $config;

    /**
     * 회원정보
     * @var type 
     */
    static $member;

    /**
     * 게시판
     * @var type 
     */
    static $board;

    /**
     * 그룹
     * @var type 
     */
    static $group;

    /**
     * bo_table
     * @var type 
     */
    static $bo_table;

    /**
     * wr_id
     * @var type 
     */
    static $wr_id;

    /**
     * 현재페이지
     * @var type 
     */
    private static $currentPage;

    /**
     * 관리자
     * @var type 
     */
    private static $is_admin;

    /**
     * 초기화
     * @global type $member
     */
    public static function init()
    {
        global $g5, $config, $member, $board, $group, $bo_table, $wr_id, $is_admin;
        //초기화
        self::$g5 = $g5;
        self::$config = $config;
        self::$member = $member;
        self::$board = $board;
        self::$group = $group;
        self::$bo_table = $bo_table;
        self::$wr_id = $wr_id;
        self::$is_admin = $is_admin;
        //현재 페이지 구분
        self::page_check();
        self::current_page();

        //포인트로 등업
        self::auto_levelup();
    }

    /**
     * 리다이렉트
     * @param type $uri
     * @param string $method
     * @param type $code
     */
    public static function redirect($uri = '', $method = 'auto', $code = NULL)
    {
        // IIS environment likely? Use 'refresh' for better compatibility
        if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE) {
            $method = 'refresh';
        } elseif ($method !== 'refresh' && (empty($code) or !is_numeric($code))) {
            if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1') {
                $code = ($_SERVER['REQUEST_METHOD'] !== 'GET') ? 303 // reference: http://en.wikipedia.org/wiki/Post/Redirect/Get
                    : 307;
            } else {
                $code = 302;
            }
        }

        switch ($method) {
            case 'refresh':
                header('Refresh:0;url=' . $uri);
                break;
            default:
                header('Location: ' . $uri, TRUE, $code);
                break;
        }
        exit;
    }

    /**
     * 게시물, 댓글 신고 버튼
     * @param type $bo_table
     * @param type $wr_id
     * @param type $li
     * @return type
     */
    public static function button_board_report($bo_table, $wr_id, $comments = false)
    {
        //예약게시판에는 출력하지 않음.
        if ($_GET['bo_table'] == AT_RESERVE_BOARD) {
            return false;
        }
        $bo_table = Asktools::xss_clean($bo_table);
        $wr_id = Asktools::xss_clean($wr_id);
        if ($comments === false) {
            //본문
            $tag = "div";
            $class = 'user_report_button_wrap ask-buttons-wrap btn-group ml-1';
        } else {
            //댓글
            $tag = "div";
            $class = 'comment_user_report_button_wrap ask-buttons-wrap';
        }

        //신고내역 
        $count = ASKDB::check_board_report($bo_table, $wr_id);
        $count_view = "";
        if ($count > 0) {
            $count_view = "<span class='report_count'>{$count}</span>";
        }
        $return_tags = "<{$tag} class='{$class}'>"
            . "<a href='#report' class='btn btn-outline-danger' onclick='window.open(\"" . AT_URL . '/' . "user_report.php?bo_table={$bo_table}&wr_id={$wr_id}\" , \"user_report\", \"width=600, height=800\")'> "
            . "<i class='fa fa-exclamation-circle' aria-hidden='true'></i>"
            . " <span class='d-none d-md-inline'>신고</span> {$count_view}</a>"
            . "</{$tag}>";
        //댓글 신고하기용
        if ($comments == true) {
            $return_tags = "<{$tag} class='{$class}'>"
                . "<a href='#report' class='btn btn-outline-danger btn-sm' onclick='window.open(\"" . AT_URL . '/' . "user_report.php?bo_table={$bo_table}&wr_id={$wr_id}\" , \"user_report\", \"width=600, height=800\")'> "
                . "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> <span class='d-none d-md-inline'>신고</span> {$count_view}</a>"
                . "</{$tag}>";
        }
        //테마 기본설정에 신고사용이면 출력
        if (self::$config['bp_use_report'] == true) {
            return $return_tags;
        } else {
            return false;
        }
    }

    /**
     * 쪽지 신고
     * @param type $me_id
     * @param type $kind
     * @return boolean
     */
    public static function button_memo_report($me_id, $kind)
    {
        if ($kind != 'recv') {
            return false;
        }
        $me_id = Asktools::xss_clean($me_id);
        $kind = Asktools::xss_clean($kind);
        $class = "user_report_button_wrap";
        //신고내역 
        $check = ASKDB::check_memo_report($me_id);
        $text = "";
        $script = "";
        if ($check) {
            $text = "<span class='sr-only'>{$check['ar_datetime']}에 신고하였습니다.</span>신고됨";
            $class = 'user_report_button_wrap2';
            $script = 'alert("' . $check['ar_datetime'] . '에 신고하였습니다.");return false;';
        } else {
            $text = "신고";
        }

        return "<div class='{$class} ml-1'>"
            . "<a href='#report' class='btn btn-danger' onclick='{$script}window.open(\"" . AT_URL . '/' . "user_report.php?me_id={$me_id}\" , \"user_report\", \"width=600, height=800\")'>{$text}</a>"
            . "</div>";
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    public static function xss_clean($data)
    {
        return filter_var($data, FILTER_SANITIZE_STRING);
    }

    /**
     * 
     * @param type $valor
     * @return type
     */
    public function htmlFilter($valor)
    {
        $resultado = htmlentities($valor, ENT_QUOTES, 'UTF-8');
        return $resultado;
    }

    /**
     * 
     * @param type $valor
     * @return type
     */
    public function SQLfilter($valor)
    {
        $valor = str_ireplace("SELECT", "", $valor);
        $valor = str_ireplace("COPY", "", $valor);
        $valor = str_ireplace("DELETE", "", $valor);
        $valor = str_ireplace("DROP", "", $valor);
        $valor = str_ireplace("DUMP", "", $valor);
        $valor = str_ireplace(" OR ", "", $valor);
        $valor = str_ireplace("%", "", $valor);
        $valor = str_ireplace("LIKE", "", $valor);
        $valor = str_ireplace("--", "", $valor);
        $valor = str_ireplace("^", "", $valor);
        $valor = str_ireplace("[", "", $valor);
        $valor = str_ireplace("]", "", $valor);
        $valor = str_ireplace("\\", "", $valor);
        $valor = str_ireplace("!", "", $valor);
        $valor = str_ireplace("¡", "", $valor);
        $valor = str_ireplace("?", "", $valor);
        $valor = str_ireplace("=", "", $valor);
        $valor = str_ireplace("&", "", $valor);
        return $valor;
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    public function xssFilter($data)
    {
        // Fix &entity\n;
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);
        // we are done...
        return $data;
    }

    /**
     * 
     * @param type $data
     * @return type
     */
    public static function filter($data)
    {
        Asktools::SQLfilter($data);
        Asktools::xssFilter($data);
        Asktools::htmlFilter($data);

        return $data;
    }

    /**
     * 필터링
     * @param type $data
     * @return type
     */
    public static function clean($data)
    {
        Asktools::SQLfilter($data);
        Asktools::xssFilter($data);
        Asktools::htmlFilter($data);
        Asktools::filter($data);

        return $data;
    }

    /**
     * 페이징
     * @param type $write_pages
     * @param type $cur_page
     * @param type $total_page
     * @param string $url
     * @param type $add
     * @return string
     */
    public static function paging($write_pages, $cur_page, $total_page, $url, $add = "")
    {
        $url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';

        $str = '<ul class="pagination">';
        if ($cur_page > 1) {
            $str .= '<li class="page-item"><a href="' . $url . '1' . $add . '" class="page-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i><span class="sr-only">처음</span></a></li>' . PHP_EOL;
        }

        $start_page = (((int) (($cur_page - 1) / $write_pages)) * $write_pages) + 1;
        $end_page = $start_page + $write_pages - 1;

        if ($end_page >= $total_page) {
            $end_page = $total_page;
        }

        if ($start_page > 1) {
            $str .= '<li class="page-item"><a href="' . $url . ($start_page - 1) . $add . '" class="page-link"><i class="fa fa-angle-left" aria-hidden="true"></i><span class="sr-only">이전</span></a></li>' . PHP_EOL;
        }

        if ($total_page > 1) {
            for ($k = $start_page; $k <= $end_page; $k++) {
                if ($cur_page != $k) {
                    $str .= '<li class="page-item"><a href="' . $url . $k . $add . '" class="page-link">' . $k . '<span class="sr-only">페이지</span></a></li>' . PHP_EOL;
                } else {
                    $str .= '<li class="page-item active"><a href="#" class="page-link">' . $k . '<span class="sr-only">현재페이지</span></a></li>' . PHP_EOL;
                }
            }
        }

        if ($total_page > $end_page) {
            $str .= '<li class="page-item"><a href="' . $url . ($end_page + 1) . $add . '" class="page-link"><i class="fa fa-angle-right" aria-hidden="true"></i><span class="sr-only">다음</span></a></li>' . PHP_EOL;
        }

        if ($cur_page < $total_page) {
            $str .= '<li class="page-item"><a href="' . $url . $total_page . $add . '" class="page-link"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span class="sr-only">맨끝</span></a></li>' . PHP_EOL;
        }

        $str .= "</ul>";
        if ($str) {
            return "<nav aria-label='Page navigation' class='page_navi'>{$str}</nav>";
        } else {
            return "";
        }
    }

    private function page_check()
    {
        //상태 체크
        $board = self::$board;
        $member = self::$member;
        $group = self::$group;
        $bo_table = self::$bo_table;
        $wr_id = self::$wr_id;
        //글쓰기 페이지, 댓글 쓰기

        if ($board && strstr($_SERVER['PHP_SELF'], 'write') && $bo_table) {
            return self::$currentPage = 'board_write';
        }

        //게시판 리스트
        if ($board && strstr($_SERVER['PHP_SELF'], 'board') && $bo_table && !$wr_id) {
            return self::$currentPage = 'board_list';
        }

        if ($board && strstr($_SERVER['PHP_SELF'], 'board') && $bo_table && $wr_id) {
            return self::$currentPage = 'board_view';
        }

        if (strstr($_SERVER['PHP_SELF'], 'memo_form')) {
            return self::$currentPage = 'memo_write';
        }
    }

    /**
     * 현재 페이지
     * @return type
     */
    public static function current_page()
    {
        //테이블 체크
        if (ASKDB::exsit_table(AT_REPORT_SANCTION_TABLE) != 1) {
            return false;
        }

        $check = ASKDB::check_sangction(self::$member['mb_id']);
        $type = "";
        //php 7.2 
        if ($check == 0 || is_null($check)) {
            return false;
        }
        for ($i = 0; count($check) > $i; $i++) {
            //정지 종류
            if ($check[$i]['as_type'] === 'all') {
                $type = "게시판(댓글포함) 쓰기 및 쪽지 쓰기 금지";
            }
            if ($check[$i]['as_type'] === 'write') {
                $type = "게시판(댓글포함) 쓰기 금지";
            }
            if ($check[$i]['as_type'] === 'memo') {
                $type = "쪽지 쓰기 금지";
            }
            $msg['error_message'] = "<h3>이용정지안내</h3>";
            $msg['error_message'] .= "<table class='table table-bordered g5_error_table'>";
            $msg['error_message'] .= "<thead><tr>";
            $msg['error_message'] .= "<th colspan='2'>";
            $msg['error_message'] .= "<h3>{$check[$i]['as_reason']}</h3>";
            $msg['error_message'] .= "</th></tr>";
            $msg['error_message'] .= "<tbody>";
            $msg['error_message'] .= "</tr>";
            $msg['error_message'] .= "<td>시작일</td>";
            $msg['error_message'] .= "<td>{$check[$i]['as_start_day']} 부터</td>";
            $msg['error_message'] .= "</tr>";
            $msg['error_message'] .= "</tr>";
            $msg['error_message'] .= "<td>종료일</td>";
            $msg['error_message'] .= "<td>{$check[$i]['as_end_day']} 까지</td>";
            $msg['error_message'] .= "</tr>";
            $msg['error_message'] .= "<td>정지내역</td>";
            $msg['error_message'] .= "<td> {$type}  </td>";
            $msg['error_message'] .= "<tr>";
            $msg['error_message'] .= "<td>문의</td>";
            $msg['error_message'] .= "<td> 1:1 게시판에 문의사항이 있다면 남겨주세요. </td>";
            $msg['error_message'] .= "</tr>";
            $msg['error_message'] .= "</tbody>";
            $msg['error_message'] .= "</table>";
            //전체 차단
            if ($check[$i]['as_type'] === 'all' && (self::$currentPage === 'board_write' || self::$currentPage === 'memo_write')) {
                $_SESSION['error_message'] = $msg['error_message'];
                if (self::$currentPage === 'memo_write') {
                    $url = "error.php";
                } else {
                    $url = "g5_error.php";
                }
                self::redirect(G5_PLUGIN_URL . DS . "ask-member" . DS . $url);
                exit;
            }

            //글쓰기 차단
            if ($check[$i]['as_type'] === 'write' && self::$currentPage === 'board_write') {
                $_SESSION['error_message'] = $msg['error_message'];
                self::redirect(G5_PLUGIN_URL . DS . "ask-member" . DS . "g5_error.php");
                exit;
            }

            //글쓰기 차단
            if ($check[$i]['as_type'] === 'memo' && self::$currentPage === 'memo_write') {
                $_SESSION['error_message'] = $msg['error_message'];
                self::redirect(G5_PLUGIN_URL . DS . "ask-member" . DS . "error.php");
                exit;
            }
        }
    }

    /**
     * 게시물 삭제시 휴지통으로 이동.
     * @global type $g5
     * @global type $config
     * @param type $bo_table
     * @param type $article_id
     */
    public static function save_trashcan($bo_table, $article_id)
    {

        //휴지통 게시판 설정하지 않으면 중단.
        if (AT_TRASHCAN_BOARD == '') {
            return false;
        }

        //휴지통에서 삭제시 중단
        if (AT_TRASHCAN_BOARD == $bo_table) {
            return false;
        }

        //$bo_table = 원본게시물
        $write_table = self::$g5['write_prefix'] . $bo_table;

        $sw = 'copy';
        // 원본 파일 디렉토리
        $src_dir = G5_DATA_PATH . '/file/' . $bo_table;

        $save_count_write = 0;
        $save_count_comment = 0;
        $cnt = 0;

        $wr_id_list = preg_replace('/[^0-9\,]/', '', $article_id);

        //원본 게시물
        $sql = " select distinct wr_num from {$write_table} where wr_id in ({$wr_id_list}) order by wr_id ";

        $result = sql_query($sql);
        while ($row = sql_fetch_array($result)) {
            $wr_num = $row['wr_num'];

            //휴지통 테이블명
            $move_bo_table = AT_TRASHCAN_BOARD;
            $move_write_table = self::$g5['write_prefix'] . $move_bo_table;

            $src_dir = G5_DATA_PATH . '/file/' . $bo_table; // 원본 디렉토리
            $dst_dir = G5_DATA_PATH . '/file/' . $move_bo_table; // 복사본 디렉토리

            $count_write = 0;
            $count_comment = 0;

            $next_wr_num = get_next_num($move_write_table);

            //원본게시물 정보
            $sql2 = " select * from {$write_table} where wr_num = '{$wr_num}' order by wr_parent, wr_is_comment, wr_comment desc, wr_id ";
            $result2 = sql_query($sql2);
            while ($row2 = sql_fetch_array($result2)) {
                $nick = cut_str(self::$member['mb_nick'], self::$config['cf_cut_name']);
                if (!$row2['wr_is_comment'] && self::$config['cf_use_copy_log']) {
                    if (strstr($row2['wr_option'], 'html')) {
                        $log_tag1 = '<div class="contents_delete_log">';
                        $log_tag2 = '</div>';
                    } else {
                        $log_tag1 = "\n";
                        $log_tag2 = '';
                    }

                    $row2['wr_content'] .= "\n" . $log_tag1 . '[이 게시물은 ' . $nick . '님에 의해 ' . G5_TIME_YMDHIS . ' ' . self::$board['bo_subject'] . '에서 삭제됨]' . $log_tag2;
                }

                // 게시글 추천, 비추천수
                $wr_good = $wr_nogood = 0;

                $sql = " insert into {$move_write_table}
                        set wr_num = '{$next_wr_num}',
                             wr_reply = '{$row2['wr_reply']}',
                             wr_is_comment = '{$row2['wr_is_comment']}',
                             wr_comment = '{$row2['wr_comment']}',
                             wr_comment_reply = '{$row2['wr_comment_reply']}',
                             ca_name = '" . addslashes($row2['ca_name']) . "',
                             wr_option = '{$row2['wr_option']}',
                             wr_subject = '" . addslashes($row2['wr_subject']) . "',
                             wr_content = '" . addslashes($row2['wr_content']) . "',
                             wr_link1 = '" . addslashes($row2['wr_link1']) . "',
                             wr_link2 = '" . addslashes($row2['wr_link2']) . "',
                             wr_link1_hit = '{$row2['wr_link1_hit']}',
                             wr_link2_hit = '{$row2['wr_link2_hit']}',
                             wr_hit = '{$row2['wr_hit']}',
                             wr_good = '{$wr_good}',
                             wr_nogood = '{$wr_nogood}',
                             mb_id = '{$row2['mb_id']}',
                             wr_password = '{$row2['wr_password']}',
                             wr_name = '" . addslashes($row2['wr_name']) . "',
                             wr_email = '" . addslashes($row2['wr_email']) . "',
                             wr_homepage = '" . addslashes($row2['wr_homepage']) . "',
                             wr_datetime = '{$row2['wr_datetime']}',
                             wr_file = '{$row2['wr_file']}',
                             wr_last = '{$row2['wr_last']}',
                             wr_ip = '{$row2['wr_ip']}',
                             wr_1 = '" . addslashes($row2['wr_1']) . "',
                             wr_2 = '" . addslashes($row2['wr_2']) . "',
                             wr_3 = '" . addslashes($row2['wr_3']) . "',
                             wr_4 = '" . addslashes($row2['wr_4']) . "',
                             wr_5 = '" . addslashes($row2['wr_5']) . "',
                             wr_6 = '" . addslashes($row2['wr_6']) . "',
                             wr_7 = '" . addslashes($row2['wr_7']) . "',
                             wr_8 = '" . addslashes($row2['wr_8']) . "',
                             wr_9 = '" . addslashes($row2['wr_9']) . "',
                             wr_10 = '" . addslashes($row2['wr_10']) . "' ";
                sql_query($sql);

                $insert_id = sql_insert_id();

                // 코멘트가 아니라면
                if (!$row2['wr_is_comment']) {
                    $save_parent = $insert_id;

                    //첨부파일 처리
                    $sql3 = " select * from  " . self::$g5['board_file_table'] . " where bo_table = '{$bo_table}' and wr_id = '{$row2['wr_id']}' order by bf_no ";
                    $result3 = sql_query($sql3);
                    for ($k = 0; $row3 = sql_fetch_array($result3); $k++) {
                        if ($row3['bf_file']) {
                            // 원본파일을 복사하고 퍼미션을 변경
                            @copy($src_dir . '/' . $row3['bf_file'], $dst_dir . '/' . $row3['bf_file']);
                            @chmod($dst_dir / $row3['bf_file'], G5_FILE_PERMISSION);
                        }

                        $sql = " insert into  " . self::$g5['board_file_table'] . " 
                                    set bo_table = '{$move_bo_table}',
                                     wr_id = '{$insert_id}',
                                     bf_no = '{$row3['bf_no']}',
                                     bf_source = '" . addslashes($row3['bf_source']) . "',
                                     bf_file = '{$row3['bf_file']}',
                                     bf_download = '{$row3['bf_download']}',
                                     bf_content = '" . addslashes($row3['bf_content']) . "',
                                     bf_filesize = '{$row3['bf_filesize']}',
                                     bf_width = '{$row3['bf_width']}',
                                     bf_height = '{$row3['bf_height']}',
                                     bf_type = '{$row3['bf_type']}',
                                     bf_datetime = '{$row3['bf_datetime']}' ";
                        sql_query($sql);
                    }

                    $count_write++;
                } else {
                    $count_comment++;
                }

                sql_query(" update {$move_write_table} set wr_parent = '{$save_parent}' where wr_id = '{$insert_id}' ");

                $cnt++;
            }

            sql_query(" update " . self::$g5['board_table'] . " set bo_count_write = bo_count_write + '{$count_write}' where bo_table = '{$move_bo_table}' ");
            sql_query(" update " . self::$g5['board_table'] . " set bo_count_comment = bo_count_comment + '{$count_comment}' where bo_table = '{$move_bo_table}' ");

            delete_cache_latest($bo_table);

            $save_count_write += $count_write;
            $save_count_comment += $count_comment;
        }
    }

    /**
     * 휴지통 비우기
     * @param type $trash_board
     */
    public static function empty_trash($trash_board)
    {

        // 파일 삭제
        sql_query(" delete from `" . self::$g5['board_file_table'] . "` where bo_table = '{$trash_board}' ");
        // 최신글 삭제
        sql_query(" delete from `" . self::$g5['board_new_table'] . "` where bo_table = '{$trash_board}' ");
        // 스크랩 삭제
        sql_query(" delete from `" . self::$g5['scrap_table'] . "` where bo_table = '{$trash_board}' ");
        //휴지통 테이블 비우기
        sql_query(" truncate " . self::$g5['write_prefix'] . $trash_board);
    }

    /**
     * 인기게시물 출력
     * @param type $bo_table
     * @return string
     */
    public static function display_popularity($bo_table = false)
    {
        $bo_table = Asktools::xss_clean($bo_table);
        //테이블이 없을경우
        if ($bo_table === false) {
            return false;
        }
        $pop = ASKDB::get_popular_item($bo_table, AT_POPULAR_DAY);

        //결과값이 없을경우
        if (!$pop) {
            return false;
        }

        $exclude = explode(',', AT_POPULAR_EXCLUDE);

        //제외 설정
        if (in_array($bo_table, $exclude)) {
            return false;
        }

        $str = "<section class='at_popular'>"
            . "<h3>인기게시물</h3>"
            . "<ul>";
        foreach ($pop as $key => $value) {
            $str .= "<li><a href='" . G5_BBS_URL . "/board.php?bo_table={$value['bo_table']}&amp;wr_id={$value['wr_id']}'><span class='at_comment_count'>({$value['wr_comment']})</span> {$value['wr_subject']}</a></li>";
        }
        $str .= "</ul></section>";
        return $str;
    }

    /**
     * 이슈등록 해제 버튼
     * @global type $view
     * @param type $bo_table
     * @param type $wr_id
     * @return boolean|string
     */
    public static function button_board_issue($bo_table, $wr_id)
    {
        global $view;

        //예약게시판에는 출력하지 않음.
        if ($_GET['bo_table'] == AT_RESERVE_BOARD) {
            return false;
        }
        //이슈설정 체크
        $bo_table = Asktools::xss_clean($bo_table);
        $wr_id = Asktools::xss_clean($wr_id);
        $check = ASKDB::get_issue_info($bo_table, $wr_id);
        $str = "<script type='text/javascript'>$(function(){ $('#make_issue, #unmake_issue').click(function () {
            var url;
            if ($(this).attr('id') == 'make_issue') {
                url = '" . G5_URL . "/_ask_tools/set_issue.php?check_wr_id={$wr_id}&bo_table={$bo_table}&mb_id={$view['mb_id']}';
            } else {
                url = '" . G5_URL . "/_ask_tools/set_issue.php?check_wr_id={$wr_id}&bo_table={$bo_table}&cancel=1';
            }

            $.ajax({
                url: url,
                type: 'get',
                success: function (data) {
                    //이슈로지정
                    if (data == 'make issue') {
                        $('#make_issue').css('display','none');
                        $('#unmake_issue').css('display','block');
                        show_noty('이슈로 지정되었습니다.');
                    }
                    //이슈취소
                    if (data == 'unmake issue') {
                        $('#unmake_issue').css('display','none');
                        $('#make_issue').css('display','block');
                        show_noty('이슈지정이 취소되었습니다.');
                    }
                }
            });
        });
        });
        
        </script>";
        if ($check) {
            $str .= "<div class='issue_button_wrap ask-buttons-wrap'><a href='#unmake-issue' id='unmake_issue' class='btn btn_b03'><i class='fa fa-comments-o' aria-hidden='true'></i>이슈해제</a></div>";
            $str .= "<div class='issue_button_wrap ask-buttons-wrap'><a href='#make-issue' id='make_issue' class='btn btn_b03' style='display:none'><i class='fa fa-comments' aria-hidden='true'></i>이슈지정</a></div>";
        } else {
            $str .= "<div class='issue_button_wrap ask-buttons-wrap'><a href='#unmake-issue' id='unmake_issue' class='btn btn_b03' style='display:none'><i class='fa fa-comments-o' aria-hidden='true'></i>이슈해제</a></div>";
            $str .= "<div class='issue_button_wrap ask-buttons-wrap'><a href='#make-issue' id='make_issue' class='btn btn_b03'><i class='fa fa-comments' aria-hidden='true'></i>이슈지정</a></div>";
        }

        //관리자만 보이게
        if (self::$is_admin == 'super') {
            return $str;
        } else {
            return false;
        }
    }

    /**
     * 예약게시물 등록 설정버튼
     * @param type $bo_table
     * @param type $wr_id
     * @return boolean|string
     */
    public static function button_board_reserve($bo_table, $wr_id)
    {
        //예약등록용 게시판에만 출력
        if ($bo_table != AT_RESERVE_BOARD) {
            return false;
        }

        $count = ASKDB::get_reserve_info($wr_id, 'count');
        if ($count > 0) {
            $addcount = "<span style='font-weight:600; color:#333;'>" . $count . "</span>";
        }
        $link = "<a href='#addreserve' class='btn btn_b03' onclick='window.open(\"" . AT_URL . DS . "add_reserve.php?bo_table={$bo_table}&wr_id={$wr_id}\" , \"addreserve\", \"width=500, height=800\")'>"
            . "<i class='fa fa-clock-o' aria-hidden='true'></i>"
            . "예약등록설정 {$addcount}</a>";
        $str = "<div class='reserve_button_wrap ask-buttons-wrap'>{$link}</div>";
        return $str;
    }

    /**
     * 게시물 자동등록 처리
     * @param type $bo_table
     * @param type $article_id
     * @param type $target_bo_table
     * @param type $datetime
     * @return boolean
     */
    public static function write_reserve($article_id, $target_bo_table)
    {

        //예약게시판을 설정하지 않으면 중단.
        if (AT_RESERVE_BOARD == '') {
            return false;
        }

        $bo_table = AT_RESERVE_BOARD; //예약동록 게시판

        $reserve_board = self::$g5['write_prefix'] . $bo_table;

        // 원본 파일 디렉토리
        $src_dir = G5_DATA_PATH . '/file/' . $bo_table;

        $save_count_write = 0;
        $save_count_comment = 0;
        $cnt = 0;

        $reserve_wr_id = preg_replace('/[^0-9\,]/', '', $article_id);

        //원본 게시물
        $sql = " select distinct wr_num from {$reserve_board} where wr_id in ({$reserve_wr_id}) order by wr_id ";

        $result = sql_query($sql);
        while ($row = sql_fetch_array($result)) {
            $wr_num = $row['wr_num'];

            //등록될 테이블명
            $write_bo_table = $target_bo_table;
            $write_board_table = self::$g5['write_prefix'] . $write_bo_table;

            $src_dir = G5_DATA_PATH . '/file/' . $bo_table; // 원본 디렉토리
            $dst_dir = G5_DATA_PATH . '/file/' . $write_bo_table; // 복사본 디렉토리

            $count_write = 0;
            $count_comment = 0;

            $next_wr_num = get_next_num($write_board_table);

            //원본게시물 정보
            $sql2 = " select * from {$reserve_board} where wr_num = '{$wr_num}' order by wr_parent, wr_is_comment, wr_comment desc, wr_id ";

            $result2 = sql_query($sql2);
            while ($row2 = sql_fetch_array($result2)) {
                $nick = cut_str(self::$member['mb_nick'], self::$config['cf_cut_name']);
                if (!$row2['wr_is_comment'] && self::$config['cf_use_copy_log']) {
                    if (strstr($row2['wr_option'], 'html')) {
                        $log_tag1 = '<div class="contents_delete_log">';
                        $log_tag2 = '</div>';
                    } else {
                        $log_tag1 = "\n";
                        $log_tag2 = '';
                    }
                }

                // 게시글 추천, 비추천수
                $wr_good = $wr_nogood = 0;

                $sql = " insert into {$write_board_table}
                        set wr_num = '{$next_wr_num}',
                             wr_reply = '{$row2['wr_reply']}',
                             wr_is_comment = '{$row2['wr_is_comment']}',
                             wr_comment = '{$row2['wr_comment']}',
                             wr_comment_reply = '{$row2['wr_comment_reply']}',
                             ca_name = '" . addslashes($row2['ca_name']) . "',
                             wr_option = '{$row2['wr_option']}',
                             wr_subject = '" . addslashes($row2['wr_subject']) . "',
                             wr_content = '" . addslashes($row2['wr_content']) . "',
                             wr_link1 = '" . addslashes($row2['wr_link1']) . "',
                             wr_link2 = '" . addslashes($row2['wr_link2']) . "',
                             wr_link1_hit = '{$row2['wr_link1_hit']}',
                             wr_link2_hit = '{$row2['wr_link2_hit']}',
                             wr_hit = '{$row2['wr_hit']}',
                             wr_good = '{$wr_good}',
                             wr_nogood = '{$wr_nogood}',
                             mb_id = '{$row2['mb_id']}',
                             wr_password = '{$row2['wr_password']}',
                             wr_name = '" . addslashes($row2['wr_name']) . "',
                             wr_email = '" . addslashes($row2['wr_email']) . "',
                             wr_homepage = '" . addslashes($row2['wr_homepage']) . "',
                             wr_datetime = '" . G5_TIME_YMDHIS . "',
                             wr_file = '{$row2['wr_file']}',
                             wr_last = '{$row2['wr_last']}',
                             wr_ip = '{$row2['wr_ip']}',
                             wr_1 = '" . addslashes($row2['wr_1']) . "',
                             wr_2 = '" . addslashes($row2['wr_2']) . "',
                             wr_3 = '" . addslashes($row2['wr_3']) . "',
                             wr_4 = '" . addslashes($row2['wr_4']) . "',
                             wr_5 = '" . addslashes($row2['wr_5']) . "',
                             wr_6 = '" . addslashes($row2['wr_6']) . "',
                             wr_7 = '" . addslashes($row2['wr_7']) . "',
                             wr_8 = '" . addslashes($row2['wr_8']) . "',
                             wr_9 = '" . addslashes($row2['wr_9']) . "',
                             wr_10 = '" . addslashes($row2['wr_10']) . "' ";
                sql_query($sql);

                $insert_id = sql_insert_id();

                // 새글 INSERT
                sql_query(" insert into " . self::$g5['board_new_table'] . " ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$target_bo_table}', '{$insert_id}', '{$insert_id}', '" . G5_TIME_YMDHIS . "', '{$row2['mb_id']}' ) ", true);

                // 코멘트가 아니라면
                if (!$row2['wr_is_comment']) {
                    $save_parent = $insert_id;

                    //첨부파일 처리
                    $sql3 = " select * from  " . self::$g5['board_file_table'] . " where bo_table = '{$bo_table}' and wr_id = '{$row2['wr_id']}' order by bf_no ";
                    $result3 = sql_query($sql3);
                    for ($k = 0; $row3 = sql_fetch_array($result3); $k++) {
                        if ($row3['bf_file']) {
                            // 원본파일을 복사하고 퍼미션을 변경
                            @copy($src_dir . '/' . $row3['bf_file'], $dst_dir . '/' . $row3['bf_file']);
                            @chmod($dst_dir / $row3['bf_file'], G5_FILE_PERMISSION);
                        }

                        $sql = " insert into  " . self::$g5['board_file_table'] . " 
                                    set bo_table = '{$write_bo_table}',
                                     wr_id = '{$insert_id}',
                                     bf_no = '{$row3['bf_no']}',
                                     bf_source = '" . addslashes($row3['bf_source']) . "',
                                     bf_file = '{$row3['bf_file']}',
                                     bf_download = '{$row3['bf_download']}',
                                     bf_content = '" . addslashes($row3['bf_content']) . "',
                                     bf_filesize = '{$row3['bf_filesize']}',
                                     bf_width = '{$row3['bf_width']}',
                                     bf_height = '{$row3['bf_height']}',
                                     bf_type = '{$row3['bf_type']}',
                                     bf_datetime = '" . G5_TIME_YMDHIS . "' ";
                        sql_query($sql);
                    }

                    $count_write++;
                } else {
                    $count_comment++;
                }

                sql_query(" update {$write_board_table} set wr_parent = '{$save_parent}' where wr_id = '{$insert_id}' ");

                $cnt++;
            }

            sql_query(" update " . self::$g5['board_table'] . " set bo_count_write = bo_count_write + '{$count_write}' where bo_table = '{$write_bo_table}' ");
            sql_query(" update " . self::$g5['board_table'] . " set bo_count_comment = bo_count_comment + '{$count_comment}' where bo_table = '{$write_bo_table}' ");

            delete_cache_latest($article_id);

            $save_count_write += $count_write;
            $save_count_comment += $count_comment;
            return $insert_id;
        }
    }

    /**
     * 예약게시물 등록 스케쥴러
     * 크론 또는 웹크론에 등록
     */
    public static function job_write_reserve()
    {
        $sql = "select * from `" . AT_RESERVE_TABLE . "` where `ar_datetime` < '" . G5_TIME_YMDHIS . "' and `ar_result_id` = 0 ";
        $result = sql_query($sql);
        for ($i = 0; $rows = sql_fetch_array($result); $i++) {
            //예약된 게시물 등록
            $last_id = self::write_reserve($rows['ar_wr_id'], $rows['ar_board']);
            sql_query("update `" . AT_RESERVE_TABLE . "` set `ar_result_id` = '{$last_id}' where `ar_idx` = '{$rows['ar_idx']}'");
            delete_cache_latest($rows['ar_board']);
        }
    }

    /**
     * 쪽지 통보 삭제
     * @param type $bo_table
     * @param type $wr_id
     * @param type $token
     * @return boolean
     */
    public static function button_board_delete($bo_table, $wr_id, $token)
    {

        //예약게시판에는 출력하지 않음.
        if ($_GET['bo_table'] == AT_RESERVE_BOARD) {
            return false;
        }
        if (!self::$is_admin) {
            return false;
        }

        $bo_table = Asktools::xss_clean($bo_table);
        $wr_id = Asktools::xss_clean($wr_id);

        $tag = "div";
        $class = 'board_delete_button_wrap';

        return "<{$tag} class='{$class} ask-buttons-wrap'>"
            . "<a href='#report' class='btn btn_b03' onclick='window.open(\"" . AT_URL . DS . "delete_send_memo.php?bo_table={$bo_table}&wr_id={$wr_id}&token={$token}\" , \"board_delete\", \"width=600, height=800\")'>"
            . "<i class='fa fa-trash' aria-hidden='true'></i>"
            . "삭제&amp;통보</a>"
            . "</{$tag}>";
    }

    /**
     * 회원 자동 등업
     * @return boolean
     */
    public static function auto_levelup()
    {
        $member = self::$member;
        $is_admin = self::$is_admin;
        $config = self::$config;

        //사용여부
        if (AT_AUTO_LEVELUP !== true) {
            return false;
        }
        //관리자는 제외
        if ($is_admin === 'super') {
            return false;
        }

        //3랩업
        if ($member['mb_level'] == '2' && $member['mb_point'] >= AT_LV_UP3) {
            //레벨업
            ASKDB::member_levelup($member['mb_id'], $member['mb_level'], 3);
            //쪽지
            self::lvup_memo($member['mb_nick'], 3, AT_LV_UP4);
            return true;
        }
        //4랩업
        if ($member['mb_level'] == '3' && $member['mb_point'] >= AT_LV_UP4) {
            //레벨업
            ASKDB::member_levelup($member['mb_id'], $member['mb_level'], 4);
            //쪽지
            self::lvup_memo($member['mb_nick'], 4, AT_LV_UP5);
            return true;
        }
        //5랩업
        if ($member['mb_level'] == '4' && $member['mb_point'] >= AT_LV_UP5) {
            //레벨업
            ASKDB::member_levelup($member['mb_id'], $member['mb_level'], 5);
            //쪽지
            self::lvup_memo($member['mb_nick'], 5, AT_LV_UP6);
            return true;
        }
        //6랩업
        if ($member['mb_level'] == '5' && $member['mb_point'] >= AT_LV_UP6) {
            //레벨업
            ASKDB::member_levelup($member['mb_id'], $member['mb_level'], 6);
            //쪽지
            self::lvup_memo($member['mb_nick'], 6, AT_LV_UP7);
            return true;
        }
        //7랩업
        if ($member['mb_level'] == '6' && $member['mb_point'] >= AT_LV_UP7) {
            //레벨업
            ASKDB::member_levelup($member['mb_id'], $member['mb_level'], 7);
            //쪽지
            self::lvup_memo($member['mb_nick'], 7, AT_LV_UP8);
            return true;
        }
        //8랩업
        if ($member['mb_level'] == '7' && $member['mb_point'] >= AT_LV_UP8) {
            //레벨업
            ASKDB::member_levelup($member['mb_id'], $member['mb_level'], 8);
            //쪽지
            self::lvup_memo($member['mb_nick'], 8, AT_LV_UP9);
            return true;
        }
        //9랩업
        if ($member['mb_level'] == '8' && $member['mb_point'] >= AT_LV_UP9) {
            //레벨업
            ASKDB::member_levelup($member['mb_id'], $member['mb_level'], 9);
            //쪽지
            self::lvup_memo($member['mb_nick'], 9, 0);
            return true;
        }
    }

    /**
     * 자동등업 쪽지 보내기
     * @param type $name
     * @param type $level
     * @param type $point
     * @return string
     */
    private static function lvup_memo($name, $level, $point)
    {
        $next = $level + 1;
        //쪽지발송
        $contents = "자동등급업" . PHP_EOL;
        $contents .= "-----------" . PHP_EOL . PHP_EOL;
        $contents .= "{$name} 회원님은 포인트 조건이 충족되어 Level{$level}로 회원 등급이 상승되었습니다." . PHP_EOL . PHP_EOL;
        if ($point != 0) {
            $contents .= "Level{$next}로 등급업 되기 위한 포인트는 {$point} 입니다." . PHP_EOL . PHP_EOL;
        }
        if ($point == 0) {
            $contents .= "최고 레벨에 도달하였습니다." . PHP_EOL . PHP_EOL;
        }
        $contents .= "많은 활동 부탁드립니다. 감사합니다.";
        ASKDB::memo_send(self::$member['mb_id'], self::$config['cf_admin'], $contents);
    }
}
