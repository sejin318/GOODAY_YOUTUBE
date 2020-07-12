<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

/**
 * Boilerplate 테마 라이브러리 로딩
 */
//composer vendor
include_once BP_VENDOR_PATH . DIRECTORY_SEPARATOR . "autoload.php";
require_once G5_PLUGIN_PATH . "/ask-cache/autoload.php";

use phpFastCache\CacheManager;
//캐시설정
CacheManager::setup(array(
    "path" => G5_DATA_PATH . '/tmp', //저장위치
));
CacheManager::CachingMethod("phpfastcache");
$InstanceCache = CacheManager::Files();

//sns data
use Embera\Embera;
use Embera\ProviderCollection\DefaultProviderCollection;

$config_embera = [
    'https_only' => false,
    'responsive' => true,
    //'fake_responses' => Embera::ONLY_FAKE_RESPONSES
];

$collection = new DefaultProviderCollection($config_embera);
$embera = new Embera($config_embera);

####################################################################
# 그누보드 기본 변수와 통합용.
# 라이브러리보다 먼저 선언해야함
####################################################################
if (!function_exists('add_boilerplate_config')) {
    /**
     * 테마 설정을 $config 변수와 통합
     *
     * @param [type] $args
     * @return void
     */
    function add_boilerplate_config($args)
    {
        $_boilerplate = sql_fetch("SELECT * from `" . BP_CONFIG_TABLE . "`", false);
        if (is_array($_boilerplate)) {
            return array_merge((array) $args, $_boilerplate);
        } else {
            //환경설정을 불러오지 못하면 설치로 이동
            if (!stristr($_SERVER['PHP_SELF'], '_install'))
                header("location:" . G5_THEME_URL . "/_install.php");
            return $args;
        }
    }
}

if (!function_exists('add_boilerplate_member')) {
    /**
     * 테마용 회원확장 필드를 $member 변수와 통합
     *
     * @param [type] $args
     * @return void
     */
    function add_boilerplate_member($args, $mb_id)
    {
        $sql = "SELECT count(*) as cnt from `" . BP_MEMBER_TABLE . "` where `bm_mb_id` = '{$mb_id}'";
        $_ext_field = sql_fetch($sql, false);
        //row값이 없으면 무조건 추가한다.
        if ($_ext_field['cnt'] == 0) {
            $sql = "INSERT into `" . BP_MEMBER_TABLE . "` set `bm_mb_id`='{$mb_id}'";
            sql_query($sql);
        }

        $sql = "SELECT * from `" . BP_MEMBER_TABLE . "` where bm_mb_id = '{$mb_id}'";
        $_boilerplate_member = sql_fetch($sql, false);
        unset($_boilerplate_member['bm_idx']);
        if (is_array($_boilerplate_member)) {
            return array_merge((array) $args, $_boilerplate_member);
        } else {
            return $args;
        }
    }
}

if (!function_exists('add_boilerplate_board')) {
    /**
     * 테마 설정을 $board 변수와 통합
     *
     * @param [type] $args
     * @return void
     */
    function add_boilerplate_board()
    {
        global $board, $bo_table;
        $_boilerplate = sql_fetch("SELECT * from `" . BP_BOARD_TABLE . "` where `bb_bo_table` = '{$bo_table}'", false);
        if ($bo_table && $_boilerplate) {
            return array_merge((array) $board, $_boilerplate);
        } else {
            return $board;
        }
    }
}

//config 에 설정값을 추가
$config = add_boilerplate_config($config);
//member에 추가필드 테이블을 적용
$member = add_boilerplate_member($member, $member['mb_id']);
//board 변수에 게시판 추가설정 적용
$board = add_boilerplate_board();


#####################################################
# 테마 함수 모음
#####################################################

if (!function_exists('bp_main_menu')) {
    /**
     * 메인메뉴
     * /themo/테마명/_menu/pc 폴더
     * @param [type] $config
     * @return void
     */
    function bp_main_menu()
    {
        global $config, $is_member, $is_admin, $_head_file, $member;
        // $pc_menu = BP_PC_MENU . DIRECTORY_SEPARATOR . $config['bp_pc_menu'] . DIRECTORY_SEPARATOR . '_menu.php';
        $pc_menu = BP_PC_MENU . DIRECTORY_SEPARATOR . 'community' . DIRECTORY_SEPARATOR . '_menu.php';
        // $pc_menu = BP_PC_MENU . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . '_menu.php';
        // $pc_menu = BP_PC_MENU . DIRECTORY_SEPARATOR . 'simple-with-hero' . DIRECTORY_SEPARATOR . '_menu.php';
        if ($config['bp_pc_menu'] && file_exists($pc_menu)) {
            include_once $pc_menu;
        } else {
            // include_once $pc_menu;
            echo "<div class='alert alert-danger'>메뉴 파일이 없습니다.</div>";
            echo $config . "\n";
            // echo $pc_menu . "\n";
        }
    }
}

if (!function_exists('bp_mobile_menu')) {

    /**
     * 모바일메뉴
     * /themo/테마명/_menu/mobile 폴더
     *
     * @param [type] $config
     * @return void
     */
    function bp_mobile_menu($config)
    {
        global $config, $is_member, $is_admin, $_head_file, $member;
        $mobile_menu = BP_MOBILE_MENU . DIRECTORY_SEPARATOR . $config['bp_mobile_menu'] . DIRECTORY_SEPARATOR . '_mobile-menu.php';
        if ($config['bp_mobile_menu'] && file_exists($mobile_menu)) {
            include_once $mobile_menu;
        } else {
            echo "<div class='alert alert-danger'> 모바일 메뉴 파일이 없습니다.</div>";
        }
    }
}

if (!function_exists('bp_logo_view')) {

    /**
     * 로고 이미지 출력
     *
     * @param [type] $config
     * @return void
     */
    function bp_logo_view($config, $random = false)
    {
        //테마 기본설정에 로고 이미지가 있다면 출력
        $default_logo = "<a href='/' class='site-logo-link navbar-brand'><img src='" . BP_ASSETS_URL . "/img/logo4.png' class='Boilerplate.kr site-logo'></a>";
        if ($config['bp_logo']) {
            $default_logo = "<a href='/' class='site-logo-link navbar-brand'><img src='" . BP_FILE_URL . "/{$config['bp_logo']}' class='site-logo the-logo' ></a>";
        }

        //기간 중복 랜덤일 경우 처리

        //기간 지정 로고 있을 경우
//        $sql = "SELECT * from `" . BP_LOGO_TABLE . "` where  (date_format(now(), '%Y-%m-%d') BETWEEN `lm_startday` and `lm_endday`) order by lm_order limit 1";
//        $logo = sql_fetch($sql);
//        if ($logo) {
//            $default_logo = "<a href='{$logo['lm_link']}' class='site-logo-link navbar-brand'><img src='" . BP_FILE_URL . "/{$logo['lm_file']}' class='site-logo' alt='{$logo['lm_alt']}'></a>";
//        }
        return $default_logo;
    }
}


if (!function_exists('bp_board_favorite')) {
    /**
     * 게시판 즐겨찾기
     *
     * @param [type] $bo_table
     * @return void
     */
    function bp_board_favorite($bo_table)
    {
        global $is_member, $board, $member, $config;
        if (!$config['bp_use_favorite']) {
            return false;
        }
        $str = '';
        if ($is_member) {
            $sql = "SELECT count(*) as cnt from `" . BP_FAVORITE_TABLE . "` where bf_bo_table = '{$bo_table}' and bf_mb_id = '{$member['mb_id']}'";
            $count = sql_fetch($sql);
            $star = "fa-star-o";
            $aria_pressed = "false";
            $active = "";
            if ($count['cnt'] > 0) {
                $star = "fa-star";
                $aria_pressed = "true";
                $active = "active";
            }
            $str = "<script>
                $(function() {
                    $('#add-favorite').click(function() {
                        var thisState = $(this).attr('aria-pressed');
                        //처리 스크립트
                        $.ajax({
                            url: '" . G5_PLUGIN_URL . DS . "ask-favorite" . DS . "toggle_favorite.php',
                            dataType: 'json',
                            method: 'POST',
                            data: {
                                subject: '{$board['bo_subject']}',
                                bo_table: '{$bo_table}',
                                mb_id: '{$member['mb_id']}',
                                status: thisState
                            }
                        }).done(function(xhr) {
                            //console.log(xhr.result);
                            //즐겨찾기상태
                            if (xhr.result == 'add') {
                                $('#favorite-state').removeClass('fa-star-o').addClass('fa-star');
                            }
                            //해제상태
                            if (xhr.result === 'delete') {
                                $('#favorite-state').removeClass('fa-star').addClass('fa-star-o');
                            }
                        });
                    });
                });
            </script>
            <!-- 즐겨찾기 -->
            <button type='button' class='btn btn-success mr-1 {$active}' data-toggle='button' aria-pressed='{$aria_pressed}' id='add-favorite'>
                <i class='fa {$star}' id='favorite-state' aria-hidden='true'></i> <span class='hide-sm'> 즐겨찾기</span>
            </button>";
        }
        return $str;
    }
}

if (!function_exists('bp_favorite_list')) {
    /**
     * 즐겨찾기 출력
     *
     * @return void
     */
    function bp_favorite_list()
    {
        global $is_member, $member, $config;
        if (!$config['bp_use_favorite']) {
            return false;
        }
        $str = '';
        if ($is_member) {
            $sql = "SELECT * from `" . BP_FAVORITE_TABLE . "` where bf_mb_id = '{$member['mb_id']}'";
            $result = sql_query($sql);
            $str = "<div class='input-group pl-2 pr-2 mt-1 mb-1'><div class='input-group-prepend'><span class='input-group-text'><i class='fa fa-star' aria-hidden='true'></i></span></div><select name='favorite' class='form-control'>";
            $str .= '<option>- 즐겨찾기 -</option>';
            while ($row = sql_fetch_array($result)) {
                $change_url = get_pretty_url($row['bf_bo_table']);
                $str .= "<option value='{$change_url}'>{$row['bf_subject']}</option>";
            }
            $str .= "</select></div>";
            $str .= "<script>
            $(function(){
                $('select[name=favorite]').change(function(){
                    location.href=$(this).val();
                });
            });
            </script>";
            return $str;
        }
    }
}

//style selector
if (!function_exists('live_settings')) {

    /**
     * 테마 셀렉터
     */
    function live_settings()
    {
        //미리보기 페이지 패스~
        if (stristr($_SERVER['HTTP_REFERER'], 'preview')) {
            return false;
        }

        //데모서버에서만 동작
        if ($_SERVER['SERVER_ADDR'] == '172.16.0.4') {
            include_once G5_PATH . DIRECTORY_SEPARATOR . 'demo' . DIRECTORY_SEPARATOR . 'live_settings.php';
        } else {
            return false;
        }
    }
}


if (!function_exists('bp_tab_latest')) {
    /**
     * 탭형식으로 최신글 출력
     *
     * @param [type] $skindir
     * @param [type] $array_table
     * @param integer $rows
     * @param integer $lens
     * @return void
     */
    function bp_tab_latest($skindir, $array_table, $rows = 5, $lens = 33)
    {
        $uniqid = get_uniqid();
        $bo_tables = explode(',', $array_table);
        if (!is_array($bo_tables) || count($bo_tables) < 2) {
            echo "<div class='alert alert-danger'> 게시판 테이블 'bo_table1,bo_table2,bo_table3' 같이 입력하세요. 2개 이상의 게시판 테이블을 입력하세요.</div>";
            return false;
        }
        //탭출력
        $tab = '<ul class="nav nav-tabs nav-justified" id="pills-tab' . $uniqid . '" role="tablist">';
        $i = 0;
        foreach ($bo_tables as $bo_table) {
            $board = ASKDB::get_board_info(trim($bo_table));
            $active = '';
            if ($i == 0) {
                $active = "active";
            }
            $tab .=  "<li class='nav-item'><a class='nav-link " 
                . $active 
                . "' id='pills-" 
                . $bo_table 
                . $uniqid 
                . "-tab' data-toggle='pill' href='#pills-" 
                . $bo_table 
                . $uniqid 
                . "' subref='http://www.goodayoutube.com/bbs/board.php?bo_table=$bo_table"
                . "' role='tab' aria-controls='pills-" 
                . $bo_table 
                . $uniqid 
                . "' aria-selected='true'>" 
                . "<div class='inner-atag' clicked='$active' href='http://www.goodayoutube.com/bbs/board.php?bo_table=$bo_table'>"
                . $board["bo_subject"] 
                . "</div>"
                . "</a></li>";
            $i++;
        }
        $tab .= '</ul>';
        unset($i);
        //탭컨텐츠
        $tab .= '<div class="tab-content" id="pills-tabContent' . $uniqid . '" class="p-2">';
        $i = 0;
        foreach ($bo_tables as $bo_table) {
            $active = '';
            if ($i == 0) {
                $active = "active";
            }
            $tab .= ' <div class="tab-pane fade show ' . $active . '" id="pills-' . $bo_table . $uniqid . '" role="tabpanel" aria-labelledby="pills-' . $bo_table . $uniqid . '-tab">';
            $tab .= latest($skindir, $bo_table, $rows, $lens);
            $tab .= '</div>';
            $i++;
        }
        $tab .= "</div>";
        return $tab;
    }
}



if (!function_exists('bp_bbcode_image_tag')) {
    /**
     * 댓글 BBcode image
     * [img]이미지주소[/img] 형식을 이미지 태그로 변환
     *
     * @param [type] $str
     * @return void
     */
    function bp_bbcode_image_tag($str)
    {
        if (!is_array($str)) {
            $str = strip_tags($str);
            $str = nl2br($str);
        }
        $regex = "/\[img\](.*?)\[\/img\]/is";
        if (is_array($str)) {
            $str = "<div style='padding:.5rem 0'><img src=\"{$str[1]}\" style='max-width:100%;'/></div>";
        }
        return preg_replace_callback($regex, 'bp_bbcode_image_tag', $str);
    }
}

if (!function_exists('bp_image_orientation_fix')) {
    /**
     * 이미지 방향 오류수정
     * JPG만 처리
     *
     * @param [type] $filename
     * @return void
     */
    function bp_image_orientation_fix($filename, $quility)
    {
        if (function_exists('exif_read_data')) {
            $file_parts = pathinfo($filename);
            //jpg 아니면
            if (strtolower($file_parts['extension']) != 'jpg') {
                return false;
            }
            $exif = exif_read_data($filename);
            if ($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if ($orientation != 1) {
                    $img = imagecreatefromjpeg($filename);
                    $deg = 0;
                    switch ($orientation) {
                        case 3:
                            $deg = 180;
                            break;
                        case 6:
                            $deg = 270;
                            break;
                        case 8:
                            $deg = 90;
                            break;
                    }
                    if ($deg) {
                        $img = imagerotate($img, $deg, 0);
                    }
                    // then rewrite the rotated image back to the disk as $filename
                    imagejpeg($img, $filename, $quility);
                } // if there is some rotation necessary
            } // if have the exif orientation info
        } // if function exists
    }
}


if (!function_exists('bp_slider_event')) {
    /**
     * Slider Event
     *
     * @param [type] $slider_name
     * @param string $skin
     * @return void
     */
    function bp_slider_event($slider_name, $skin = '')
    {
        //스킨 설정
        $sql = "SELECT * from `" . BP_SLIDER_TABLE . "` where `bs_name` = '{$slider_name}'";
        $_cfg = sql_fetch($sql, true);
        //스킨경로
        if ($skin) {
            $skin_path = $skin;
        } else {
            $skin_path = $_cfg['bs_skin'];
        }
        if ($_cfg['bs_page_count'] > 0) {
            //페이지 불러오기
            $sql = "SELECT * from `" . BP_SLIDER_LIST_TABLE . "` where `bss_parent` = '{$_cfg['bs_idx']}' and  ((date_format(now(), '%Y-%m-%d') BETWEEN `bss_startday` and `bss_endday`) or (`bss_startday` = '0000-00-00' and `bss_endday` = '0000-00-00')) order by bss_order";
            $result = sql_query($sql, true);
            $item = array();
            for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                $item[$i] = $rows;
            }

            include_once BP_SLIDER_SKIN_PATH . DIRECTORY_SEPARATOR . $skin_path . DIRECTORY_SEPARATOR . 'slider.skin.php';
        }
    }
}

if (!function_exists('bp_slider')) {
    /**
     * BP Slider
     *
     * @param [type] $idx
     * @param string $skin
     * @return void
     */
    function bp_slider($idx, $skin = '')
    {
        //스킨 설정
        $sql = "SELECT * from `" . BP_SLIDER_TABLE . "` where `bs_idx` = '{$idx}'";
        $_cfg = sql_fetch($sql);

        //스킨경로
        if ($skin) {
            $skin_path = $skin;
        } else {
            $skin_path = $_cfg['bs_skin'];
        }
        if ($_cfg['bs_page_count'] > 0) {
            //페이지 불러오기
            $sql = "SELECT * from `" . BP_SLIDER_LIST_TABLE . "` where `bss_parent` = '{$idx}' and  ((date_format(now(), '%Y-%m-%d') BETWEEN `bss_startday` and `bss_endday`) or (`bss_startday` = '0000-00-00' and `bss_endday` = '0000-00-00')) order by bss_order";
            $result = sql_query($sql, true);
            $item = array();
            for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                $item[$i] = $rows;
            }

            include_once BP_SLIDER_SKIN_PATH . DIRECTORY_SEPARATOR . $skin_path . DIRECTORY_SEPARATOR . 'slider.skin.php';
        }
    }
}

if (!function_exists('bp_mypage_menu')) {
    /**
     * 마이페이지 메뉴
     *
     * @return void
     */
    function bp_mypage_menu()
    {
        global $config;
        include_once BP_MYPAGE_PATH . DIRECTORY_SEPARATOR . 'my_menu.inc.php';
    }
}

if (!function_exists('bp_display_message')) {

    /**
     * 처리결과 메세지 출력용
     *
     * @return void
     */
    function bp_display_message()
    {
        if (!$_SESSION['message']) {
            return false;
        }

        $str = "
    <div class='alert-message alert alert-info alert-dismissible fade show' role='alert'>
    <h3><i class='fa fa-info-circle' aria-hidden='true'></i></strong> Message </h3>
    {$_SESSION['message']}
    <button type='button' class='message-close close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button>
    </div>
    <script>
        $('.message-close').click(function() {
            $('.alert-message').hide();
        });
    </script>";
        unset($_SESSION['message']);
        return $str;
    }
}

if (!function_exists('comment_file_no_sort')) {
    /**
     * 첨부파일 순서 재설정
     * @global type $g5
     * @param type $bo_table
     * @param type $wr_id
     */
    function comment_file_no_sort($bo_table, $wr_id)
    {
        global $g5;
        //파일순서 리빌드
        $sql = "select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' order by bf_datetime";
        $res = sql_query($sql);
        for ($i = 0; $rows = sql_fetch_array($res); $i++) {
            $sql = "update {$g5['board_file_table']} set bf_no = '{$i}' where bo_table = '{$rows['bo_table']}' and wr_id = '{$rows['wr_id']}' and bf_no = '{$rows['bf_no']}' limit 1";
            sql_query($sql);
        }
    }
}

if (!class_exists('BBCode')) {
    /**
     * BBCODE class
     */
    class BBCode
    {

        protected $bbcode_table = array();


        public function __construct()
        {

            // Replace [b]...[/b] with <strong>...</strong>
            $this->bbcode_table["/\[b\](.*?)\[\/b\]/is"] = function ($match) {
                return "<strong>$match[1]</strong>";
            };


            // Replace [i]...[/i] with <em>...</em>
            $this->bbcode_table["/\[i\](.*?)\[\/i\]/is"] = function ($match) {
                return "<em>$match[1]</em>";
            };


            // Replace [code]...[/code] with <pre><code>...</code></pre>
            $this->bbcode_table["/\[code\](.*?)\[\/code\]/is"] = function ($match) {
                return "<pre><code>$match[1]</code></pre>";
            };


            // Replace [quote]...[/quote] with <blockquote><p>...</p></blockquote>
            $this->bbcode_table["/\[quote\](.*?)\[\/quote\]/is"] = function ($match) {
                return "<blockquote><p>$match[1]</p></blockquote>";
            };


            // Replace [quote="person"]...[/quote] with <blockquote><p>...</p></blockquote>
            $this->bbcode_table["/\[quote=\"([^\"]+)\"\](.*?)\[\/quote\]/is"] = function ($match) {
                return "$match[1] wrote: <blockquote><p>$match[2]</p></blockquote>";
            };


            // Replace [size=30]...[/size] with <span style="font-size:30%">...</span>
            $this->bbcode_table["/\[size=(\d+)\](.*?)\[\/size\]/is"] = function ($match) {
                return "<span style=\"font-size:$match[1]%\">$match[2]</span>";
            };


            // Replace [s] with <del>
            $this->bbcode_table["/\[s\](.*?)\[\/s\]/is"] = function ($match) {
                return "<del>$match[1]</del>";
            };


            // Replace [u]...[/u] with <span style="text-decoration:underline;">...</span>
            $this->bbcode_table["/\[u\](.*?)\[\/u\]/is"] = function ($match) {
                return '<span style="text-decoration:underline;">' . $match[1] . '</span>';
            };


            // Replace [center]...[/center] with <div style="text-align:center;">...</div>
            $this->bbcode_table["/\[center\](.*?)\[\/center\]/is"] = function ($match) {
                return '<div style="text-align:center;">' . $match[1] . '</div>';
            };


            // Replace [color=somecolor]...[/color] with <span style="color:somecolor">...</span>
            $this->bbcode_table["/\[color=([#a-z0-9]+)\](.*?)\[\/color\]/is"] = function ($match) {
                return '<span style="color:' . $match[1] . ';">' . $match[2] . '</span>';
            };


            // Replace [email]...[/email] with <a href="mailto:...">...</a>
            $this->bbcode_table["/\[email\](.*?)\[\/email\]/is"] = function ($match) {
                return "<a href=\"mailto:$match[1]\">$match[1]</a>";
            };


            // Replace [email=someone@somewhere.com]An e-mail link[/email] with <a href="mailto:someone@somewhere.com">An e-mail link</a>
            $this->bbcode_table["/\[email=(.*?)\](.*?)\[\/email\]/is"] = function ($match) {
                return "<a href=\"mailto:$match[1]\">$match[2]</a>";
            };


            // Replace [url]...[/url] with <a href="...">...</a>
            $this->bbcode_table["/\[url\](.*?)\[\/url\]/is"] = function ($match) {
                return "<a href=\"$match[1]\">$match[1]</a>";
            };


            // Replace [url=http://www.google.com/]A link to google[/url] with <a href="http://www.google.com/">A link to google</a>
            $this->bbcode_table["/\[url=(.*?)\](.*?)\[\/url\]/is"] = function ($match) {
                return "<a href=\"$match[1]\">$match[2]</a>";
            };


            // Replace [img]...[/img] with <img src="..."/>
            $this->bbcode_table["/\[img\](.*?)\[\/img\]/is"] = function ($match) {
                $match[1] = strip_tags($match[1]);
                return "<div style='padding:.5rem 0'><img src=\"$match[1]\" style='max-width:98%;'/></div>";
            };


            // Replace [list]...[/list] with <ul><li>...</li></ul>
            $this->bbcode_table["/\[list\](.*?)\[\/list\]/is"] = function ($match) {
                $match[1] = preg_replace_callback("/\[\*\]([^\[\*\]]*)/is", function ($submatch) {
                    return "<li>" . preg_replace("/[\n\r?]$/", "", $submatch[1]) . "</li>";
                }, $match[1]);

                return "<ul>" . preg_replace("/[\n\r?]/", "", $match[1]) . "</ul>";
            };


            // Replace [list=1|a]...[/list] with <ul|ol><li>...</li></ul|ol>
            $this->bbcode_table["/\[list=(1|a)\](.*?)\[\/list\]/is"] = function ($match) {
                if ($match[1] == '1') {
                    $list_type = '<ol>';
                } else if ($match[1] == 'a') {
                    $list_type = '<ol style="list-style-type: lower-alpha">';
                } else {
                    $list_type = '<ol>';
                }

                $match[2] = preg_replace_callback("/\[\*\]([^\[\*\]]*)/is", function ($submatch) {
                    return "<li>" . preg_replace("/[\n\r?]$/", "", $submatch[1]) . "</li>";
                }, $match[2]);

                return $list_type . preg_replace("/[\n\r?]/", "", $match[2]) . "</ol>";
            };


            // Replace [youtube]...[/youtube] with <iframe src="..."></iframe>
            $this->bbcode_table["/\[youtube\](?:http?:\/\/)?(?:www\.)?youtu(?:\.be\/|be\.com\/watch\?v=)([A-Z0-9\-_]+)(?:&(.*?))?\[\/youtube\]/i"] = function ($match) {
                return "<iframe class=\"youtube-player\" type=\"text/html\" width=\"640\" height=\"385\" src=\"http://www.youtube.com/embed/$match[1]\" frameborder=\"0\"></iframe>";
            };
        }
        public function toHTML($str, $escapeHTML = false, $nr2br = false)
        {
            if (!$str) {
                return "";
            }

            if ($escapeHTML) {
                $str = htmlspecialchars($str);
            }

            foreach ($this->bbcode_table as $key => $val) {
                $str = preg_replace_callback($key, $val, $str);
            }

            if ($nr2br) {
                $str = preg_replace_callback("/\n\r?/", function ($match) {
                    return "<br/>";
                }, $str);
            }

            return $str;
        }
    }
}

if (!function_exists('board_youtube_convert')) {
    /**
     * 유튜브 URL to Embed Tag
     *
     * @param [type] $wr_content
     * @return void
     */
    function board_youtube_convert($wr_content)
    {
        $wr_content = strip_tags($wr_content);

        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "<h5 class='mt-5 text-cut font-size'><i class='fa fa-youtube' aria-hidden='true'></i> https://www.youtube.com/embed/$2 </h5>
            <div class='embed-responsive embed-responsive-4by3'><iframe class='embed-responsive-item' src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe></div>",
            $wr_content
        );
    }
}


###############
# Gallery 기능
###############
if (!function_exists('bp_get_exif')) {
    /**
     * @param $image
     * @return mixed
     */
    function bp_get_exif($image)
    {
        global $bo_table;
        if (!function_exists('exif_read_data')) {
            return "exif_read_data Function Not Declared";
        }
        $image_path = G5_DATA_PATH . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR . $bo_table . DIRECTORY_SEPARATOR . $image;
        if (!file_exists($image_path)) {
            return "Image file Not Found";
        }
        $exif = exif_read_data($image_path, 'IFD0');
        return $exif;
    }
}

if (!function_exists('bp_get_image_location')) {

    /**
     * 이미지 GPS
     *
     * @param [type] $exif_info
     * @return void
     */
    function bp_get_image_location($exif_info)
    {
        $info = $exif_info;

        $direction = array('N', 'S', 'E', 'W');
        if (
            isset($info['GPSLatitude'], $info['GPSLongitude'], $info['GPSLatitudeRef'], $info['GPSLongitudeRef']) &&
            in_array($info['GPSLatitudeRef'], $direction) && in_array($info['GPSLongitudeRef'], $direction)
        ) {

            $lat_degrees_a = explode('/', $info['GPSLatitude'][0]);
            $lat_minutes_a = explode('/', $info['GPSLatitude'][1]);
            $lat_seconds_a = explode('/', $info['GPSLatitude'][2]);
            $lng_degrees_a = explode('/', $info['GPSLongitude'][0]);
            $lng_minutes_a = explode('/', $info['GPSLongitude'][1]);
            $lng_seconds_a = explode('/', $info['GPSLongitude'][2]);

            $lat_degrees = $lat_degrees_a[0] / $lat_degrees_a[1];
            $lat_minutes = $lat_minutes_a[0] / $lat_minutes_a[1];
            $lat_seconds = $lat_seconds_a[0] / $lat_seconds_a[1];
            $lng_degrees = $lng_degrees_a[0] / $lng_degrees_a[1];
            $lng_minutes = $lng_minutes_a[0] / $lng_minutes_a[1];
            $lng_seconds = $lng_seconds_a[0] / $lng_seconds_a[1];

            $lat = (float) $lat_degrees + ((($lat_minutes * 60) + ($lat_seconds)) / 3600);
            $lng = (float) $lng_degrees + ((($lng_minutes * 60) + ($lng_seconds)) / 3600);
            $lat = number_format($lat, 7);
            $lng = number_format($lng, 7);

            //If the latitude is South, make it negative.
            //If the longitude is west, make it negative
            $lat = $info['GPSLatitudeRef'] == 'S' ? $lat * -1 : $lat;
            $lng = $info['GPSLongitudeRef'] == 'W' ? $lng * -1 : $lng;

            return array(
                'Latitude'  => $lat,
                'Longitude' => $lng,
            );
        }

        return false;
    }
}
if (!function_exists('bp_get_view_thumbnail')) {

    /**
     * ! 게시글보기 썸네일 생성
     * @param $contents
     * @param $thumb_width
     * @return mixed
     */
    function bp_get_view_thumbnail($contents, $thumb_width = 0, $url = false)
    {
        global $board, $config, $bo_table;

        if (!$thumb_width) {
            $thumb_width = $board['bo_image_width'];
        }

        // $contents 중 img 태그 추출
        $matches = get_editor_image($contents, true);

        if (empty($matches)) {
            return $contents;
        }

        for ($i = 0; $i < count($matches[1]); $i++) {

            $img = $matches[1][$i];
            preg_match("/src=[\'\"]?([^>\'\"]+[^>\'\"]+)/i", $img, $m);
            $src = $m[1];
            preg_match("/style=[\"\']?([^\"\'>]+)/i", $img, $m);
            $style = $m[1];
            preg_match("/width:\s*(\d+)px/", $style, $m);
            $width = $m[1];
            preg_match("/height:\s*(\d+)px/", $style, $m);
            $height = $m[1];
            preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $img, $m);
            $alt = get_text($m[1]);

            // 이미지 path 구함
            $p = parse_url($src);
            if (strpos($p['path'], '/' . G5_DATA_DIR . '/') != 0) {
                $data_path = preg_replace('/^\/.*\/' . G5_DATA_DIR . '/', '/' . G5_DATA_DIR, $p['path']);
            } else {
                $data_path = $p['path'];
            }

            $srcfile = G5_PATH . $data_path;
            if (is_file($srcfile)) {
                $size = @getimagesize($srcfile);
                if (empty($size)) {
                    continue;
                }

                // jpg 이면 exif 체크
                if ($size[2] == 2 && function_exists('exif_read_data')) {
                    $degree = 0;
                    $exif   = @exif_read_data($srcfile);
                    if (!empty($exif['Orientation'])) {
                        switch ($exif['Orientation']) {
                            case 8:
                                $degree = 90;
                                break;
                            case 3:
                                $degree = 180;
                                break;
                            case 6:
                                $degree = -90;
                                break;
                        }

                        // 세로사진의 경우 가로, 세로 값 바꿈
                        if ($degree == 90 || $degree == -90) {
                            $tmp     = $size;
                            $size[0] = $tmp[1];
                            $size[1] = $tmp[0];
                        }
                    }
                }

                // 원본 width가 thumb_width보다 작다면
                if ($size[0] <= $thumb_width) {
                    continue;
                }

                // Animated GIF 체크
                $is_animated = false;
                if ($size[2] == 1) {
                    $is_animated = is_animated_gif($srcfile);
                }

                // 썸네일 높이
                $thumb_height = round(($thumb_width * $size[1]) / $size[0]);
                $filename     = basename($srcfile);
                $filepath     = dirname($srcfile);

                // 썸네일 생성
                if (!$is_animated) {
                    $thumb_file = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, false);
                } else {
                    $thumb_file = $filename;
                }

                if (!$thumb_file) {
                    continue;
                }

                //Exif info
                $str = '';
                $exif['gps_info'] = bp_get_image_location($exif);
                $flashfired       = 'No';
                $CameraMaker      = strtoupper($exif['Make'] . ' ' . $exif['Model']);
                if ($exif['Flash'] == 1) {
                    $flashfired = 'Yes';
                }
                if ($exif['Flash'] == 2) {
                    $flashfired = 'Strobe Return Light Detected';
                }
                if ($exif['Flash'] == 4) {
                    $flashfired = 'Strobe Return Light Not Detected';
                }
                if ($exif['Flash'] == 8) {
                    $flashfired = 'Compulsory Flash Mode';
                }
                if ($exif['Flash'] == 16) {
                    $flashfired = '자동';
                }
                if ($exif['Flash'] == 32) {
                    $flashfired = '없음';
                }
                if ($exif['Flash'] == 64) {
                    $flashfired = 'Red Eye Reduction Mode';
                }

                if ($exif['WhiteBalance'] == 0) {
                    $WhiteBalance = '자동';
                }
                if ($exif['WhiteBalance'] == 1) {
                    $WhiteBalance = '수동';
                }

                $thumb_tag = "<!--IMG GPS --><div class='image-exif'>" . PHP_EOL;
                if ($width) {
                    $thumb_tag .= '<img src="' . G5_URL . str_replace($filename, $thumb_file, $data_path) . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '"/>';
                } else {
                    $thumb_tag .= '<img src="' . G5_URL . str_replace($filename, $thumb_file, $data_path) . '" alt="' . $alt . '"/>';
                }
                $addres_info     = '';
                $map             = "";
                $map_view        = "";
                $photo_menu_icon = '<i class="fa fa-info-circle" aria-hidden="true"></i>';

                if (($exif['gps_info']['Latitude'] && $exif['gps_info']['Longitude'])) {
                    //bf_address 주소정보 입력
                    $gps_to_address = bp_get_address($filename);

                    # 주소가 없으면 카카오 API로 주소 가져와서 입력
                    if ($gps_to_address == '') {
                        $photo_address = bp_kakao_request('/v2/local/geo/coord2regioncode', "x=" . $exif['gps_info']['Longitude'] . "&y=" . $exif['gps_info']['Latitude'] . "&input_coord=WGS84", $filename);
                    }
                    $photo_address = $gps_to_address;
                    $addres_info     = "<li><span>위치</span> <a href='http://map.daum.net/link/map/{$photo_address},{$exif['gps_info']['Latitude']},{$exif['gps_info']['Longitude']}' target='_blank'>{$photo_address} <i class='fa fa-map' aria-hidden='true'></i></a></li>";
                    $photo_menu_icon = '<i class="fa fa-map-marker" aria-hidden="true"></i>';
                    $map             = "<div id='map-list_{$i}' class='kakao-map'></div>";
                    $map_view        = "data-mapid='map-list_{$i}' data-lat='{$exif['gps_info']['Latitude']}' data-long='{$exif['gps_info']['Longitude']}'";
                }

                $thumb_tag .= '<button class="view-exif-info" ' . $map_view . '>' . $photo_menu_icon . '</i></button>';
                $thumb_tag .= "<div class='exif-info'>" . PHP_EOL;

                $thumb_tag .= "<div class='map-wrap'>{$map}</div>";
                $thumb_tag .= "<ul class='ex-list'>" . PHP_EOL;
                if ($exif['Make']) {
                    $thumb_tag .= "<li><span>카메라</span> {$CameraMaker}</li>";
                }
                if ($exif['FileSize']) {
                    $thumb_tag .= "<li><span>크기</span> " . number_format($exif['FileSize'] / 1024 / 1024, 2) . "MB </li>";
                }
                if ($exif['DateTime']) {
                    $thumb_tag .= "<li><span>날짜</span> " . date("Y-m-d H:i:s", strtotime($exif['DateTime'])) . "</li>";
                }
                if ($exif['COMPUTED']['Width'] && $exif['COMPUTED']['Height']) {
                    $thumb_tag .= "<li><span>해상도</span> {$exif['COMPUTED']['Width']} x {$exif['COMPUTED']['Height']}</li>";
                }
                if ($exif['COMPUTED']['ApertureFNumber']) {
                    $thumb_tag .= "<li><span>조리개</span> {$exif['COMPUTED']['ApertureFNumber']}</li>";
                }
                if (isset($exif['Flash'])) {
                    $thumb_tag .= "<li><span>플래시</span> {$flashfired}</li>";
                }
                if (isset($exif['WhiteBalance'])) {
                    $thumb_tag .= "<li><span>화이트밸런스</span> {$WhiteBalance}</li>";
                }
                if ($exif['ISOSpeedRatings']) {
                    $thumb_tag .= "<li><span>ISO</span> {$exif['ISOSpeedRatings']}</li>";
                }
                if ($exif['FocalLength']) {
                    $thumb_tag .= "<li><span>초점거리</span> {$exif['FocalLength']} mm</li>";
                }
                if ($exif['ExposureTime']) {
                    $thumb_tag .= "<li><span>노출시간</span> {$exif['ExposureTime']} s</li>";
                }
                $thumb_tag .= $addres_info;



                $img_tag = $matches[0][$i];

                // $img_tag에 editor 경로가 있으면 원본보기 링크 추가
                if (strpos($img_tag, G5_DATA_DIR . '/' . G5_EDITOR_DIR) && preg_match("/\.({$config['cf_image_extension']})$/i", $filename)) {
                    $imgurl    = str_replace(G5_URL, "", $src);
                    //$thumb_tag = '<a href="' . G5_BBS_URL . '/view_image.php?fn=' . urlencode($imgurl) . '" target="_blank" class="view_image">' . $thumb_tag . '</a>';
                    $org_image_view = "<li><span>원본보기</span> <a href='{$imgurl}' target='_blank'>{$filename} <i class='fa fa-link' aria-hidden='true'></i></a></li>";
                } else {
                    $org_image_view = "<li><span>원본보기</span> <a href='" . G5_DATA_URL . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR . $bo_table . DIRECTORY_SEPARATOR . $filename . "' target='_blank'>{$filename} <i class='fa fa-link' aria-hidden='true'></i></a></li>";
                }

                $thumb_tag .= $org_image_view . "</ul></div></div>" . PHP_EOL; //.image-exif
                if ($url == true) {
                    $imgurl = G5_URL . str_replace($filename, $thumb_file, $data_path);
                    return $imgurl;
                }
                $contents = str_replace($img_tag, $thumb_tag, $contents);
            }
        } //for

        return $contents;
    }
}


if (!function_exists('bp_kakao_request')) {
    /**
     * 카카오 API
     * @param $path
     * @param $query
     * @param $content_type
     * @return mixed
     * curl -v -X GET "https://dapi.kakao.com/v2/local/geo/coord2address.json?x=127.423084873712&y=37.0789561558879&input_coord=WGS84" -H "Authorization: KakaoAK kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk"
     */
    function bp_kakao_request($path, $query, $img_name, $content_type = 'json')
    {
        global $g5, $board, $bo_table, $wr_id, $config;
        $api_server = 'https://dapi.kakao.com';
        $headers    = array("Authorization: KakaoAK " . $config['cf_kakao_rest_key']);
        $opts       = array(
            CURLOPT_URL            => $api_server . $path . '.' . $content_type . '?' . $query,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSLVERSION     => 1,
            CURLOPT_HEADER         => false,
            CURLOPT_POST           => false,
            CURLOPT_HTTPHEADER     => $headers,
        );
        $curl_session = curl_init();
        curl_setopt_array($curl_session, $opts);
        $return_data = curl_exec($curl_session);

        if (curl_errno($curl_session)) {
            throw new Exception(curl_error($curl_session));
        } else {

            curl_close($curl_session);
            $addr    = json_decode($return_data, true);
            $address = $addr['documents']['0']['address_name'];
            //Field 추가
            sql_query("ALTER TABLE `{$g5['board_file_table']}` ADD `bf_address` VARCHAR(255) NOT NULL AFTER `bf_datetime`");
            //주소 정보를 DB에 저장한다.
            $sql = "UPDATE {$g5['board_file_table']} set bf_address='{$address}' where bo_table='{$bo_table}' and wr_id= '{$wr_id}' and bf_file = '{$img_name}' limit 1";
            sql_query($sql, true);
            return $address;
        }
    }
}

if (!function_exists('bp_get_address')) {
    /**
     * 파일 테이블에서 저장된 주소 가져오기
     *
     * @param [type] $filename
     * @return void
     */
    function bp_get_address($filename)
    {
        global $g5, $bo_table, $wr_id;
        $sql = "SELECT bf_address from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_file = '{$filename}' ";
        $result = sql_fetch($sql);
        return $result['bf_address'];
    }
}

if (!function_exists('bp_unread_alarm')) {
    /**
     *  읽지않은 알람 수
     *
     * @param [type] $mb_id
     * @return void
     */
    function bp_unread_alarm($mb_id)
    {
        $sql = "SELECT count(*) as cnt from `" . BP_ALARM_TABLE . "` where ba_mb_id = '{$mb_id}' and `ba_read` = 0";
        $result = sql_fetch($sql);
        return $result['cnt'];
    }
}
if (!function_exists('print_t')) {
    function print_t($str)
    {
        echo "<textarea class='form-control' rows='8'>";
        print_r($str);
        echo "</textarea>";
    }
}
if (!function_exists('is_ie11')) {
    /**
     * IE 11 검사
     *
     * @return boolean
     */
    function is_ie11()
    {
        if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) {
            return true;
        } else {
            return false;
        }
    }
}


if (!class_exists('VideoUrlParser')) {
    /**
     * https://github.com/sampotts/plyr
     * Youtube, Vimeo url parser
     */
    class VideoUrlParser
    {
        /**
         * Determines which cloud video provider is being used based on the passed url.
         *
         * @param string $url The url
         * @return null|string Null on failure to match, the service's name on success
         */
        public static function identify_service($url)
        {
            if (preg_match('%youtube|youtu\.be%i', $url)) {
                return 'youtube';
            } elseif (preg_match('%vimeo%i', $url)) {
                return 'vimeo';
            }
            return null;
        }

        /**
         * Determines which cloud video provider is being used based on the passed url,
         * and extracts the video id from the url.
         *
         * @param string $url The url
         * @return null|string Null on failure, the video's id on success
         */
        public static function get_url_id($url)
        {
            $service = self::identify_service($url);

            if ($service == 'youtube') {
                return self::get_youtube_id($url);
            } elseif ($service == 'vimeo') {
                return self::get_vimeo_id($url);
            }
            return null;
        }

        /**
         * Determines which cloud video provider is being used based on the passed url,
         * extracts the video id from the url, and builds an embed url.
         *
         * @param string $url The url
         * @return null|string Null on failure, the video's embed url on success
         */
        public static function get_url_embed($url)
        {
            $service = self::identify_service($url);

            $id = self::get_url_id($url);

            if ($service == 'youtube') {
                return self::get_youtube_embed($id);
            } elseif ($service == 'vimeo') {
                return self::get_vimeo_embed($id);
            }
            return null;
        }

        /**
         * Parses various youtube urls and returns video identifier.
         *
         * @param string $url The url
         * @return string the url's id
         */
        public static function get_youtube_id($url)
        {
            $youtube_url_keys = array('v', 'vi');

            // Try to get ID from url parameters
            $key_from_params = self::parse_url_for_params($url, $youtube_url_keys);
            if ($key_from_params) return $key_from_params;

            // Try to get ID from last portion of url
            return self::parse_url_for_last_element($url);
        }

        /**
         * Builds a Youtube embed url from a video id.
         *
         * @param string $youtube_video_id The video's id
         * @return string the embed url
         */
        public static function get_youtube_embed($youtube_video_id, $autoplay = 1)
        {
            $embed = "http://youtube.com/embed/$youtube_video_id?autoplay=$autoplay";

            return $embed;
        }

        /**
         * Parses various vimeo urls and returns video identifier.
         *
         * @param string $url The url
         * @return string The url's id
         */
        public static function get_vimeo_id($url)
        {
            // Try to get ID from last portion of url
            return self::parse_url_for_last_element($url);
        }

        /**
         * Builds a Vimeo embed url from a video id.
         *
         * @param string $vimeo_video_id The video's id
         * @return string the embed url
         */
        public static function get_vimeo_embed($vimeo_video_id, $autoplay = 1)
        {
            $embed = "http://player.vimeo.com/video/$vimeo_video_id?byline=0&amp;portrait=0&amp;autoplay=$autoplay";

            return $embed;
        }

        /**
         * Find the first matching parameter value in a url from the passed params array.
         *
         * @access private
         *
         * @param string $url The url
         * @param array $target_params Any parameter keys that may contain the id
         * @return null|string Null on failure to match a target param, the url's id on success
         */
        private static function parse_url_for_params($url, $target_params)
        {
            parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_params);
            foreach ($target_params as $target) {
                if (array_key_exists($target, $my_array_of_params)) {
                    return $my_array_of_params[$target];
                }
            }
            return null;
        }

        /**
         * Find the last element in a url, without any trailing parameters
         *
         * @access private
         *
         * @param string $url The url
         * @return string The last element of the url
         */
        private static function parse_url_for_last_element($url)
        {
            $url_parts = explode("/", $url);
            $prospect = end($url_parts);
            $prospect_and_params = preg_split("/(\?|\=|\&)/", $prospect);
            if ($prospect_and_params) {
                return $prospect_and_params[0];
            } else {
                return $prospect;
            }
            return $url;
        }
    }
}

if (!function_exists('bp_get_hostname')) {
    /**
     *  사이트 URL
     */
    function bp_get_hostname()
    {
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        //cloudflare 사용시 처리
        if ($_SERVER['HTTP_CF_VISITOR']) {
            if (json_decode($_SERVER['HTTP_CF_VISITOR'])->scheme == 'https') $_SERVER['HTTPS'] = 'on';
            $protocol = 'https://';
        }

        $domainName = $_SERVER['HTTP_HOST'];
        return $protocol . $domainName;
    }
}


//Tinymce 에디터용
define("BP_TINYMCE_DOMAIN", array(bp_get_hostname()));

if (!function_exists('_display_code_view')) {
    /**
     * Tag 출력
     *
     * @param [type] $id
     * @param [type] $code
     * @return void
     */
    function _display_code_view($id, $code)
    {
        $code = htmlspecialchars($code);
        return "<div class='code-view position-relative'>
            <div id='{$id}' class='code'>{$code}</div>
            <script>
                $(function() {
                    codeViewer('{$id}');
                })
            </script>
        </div>";
    }
}


if (!function_exists('bp_scrap_check')) {
    /**
     * 스크랩체크
     *
     * @param [type] $mb_id
     * @param [type] $bo_table
     * @param [type] $wr_id
     * @return void
     */
    function bp_scrap_check($bo_table, $wr_id)
    {
        global $g5, $member;
        if (!$member['mb_id']) {
            return false;
        }
        $sql = "SELECT count(*) cnt from `{$g5['scrap_table']}` where (`bo_table` = '{$bo_table}' and `wr_id`='{$wr_id}')and `mb_id` = '{$member['mb_id']}'";
        $result = sql_fetch($sql);
        if ($result['cnt'] > 0) {
            return 'scraped';
        } else {
            return false;
        }
    }
}