<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * Community Tools 
 */

//기본 상수 정의
define('DS', DIRECTORY_SEPARATOR);
define('AT_ROOT', G5_PATH . DS . "_ask_tools");
define('AT_URL', G5_PLUGIN_URL . DS . "ask-member");

define('AT_ASSETS', '_assets');
define('AT_CACHE', '_cache');
define('AT_LIB', '_lib');
define('AT_FILES', '_files');
define('AT_CONFIG', '_config');
define('AT_TEMPLATES', '_templates');
define('AT_CSS_URL', AT_URL . DS . AT_ASSETS . DS . 'css');
define('AT_JS_URL', AT_URL . DS . AT_ASSETS . DS . 'js');
define('AT_CACHE_PATH', AT_ROOT . DS . AT_CACHE);
define('AT_FILES_PATH', AT_ROOT . DS . AT_FILES);
define('AT_TEMPLATES_PATH', AT_ROOT . DS . AT_TEMPLATES);

//테이블 정의
define('AT_WRITE', $g5['write_prefix']); //보드 Prefix
define('AT_REPORT_TABLE', 'boilerplate_user_report'); //신고
define('AT_REPORT_SANCTION_TABLE', 'boilerplate_user_report_sanction'); //신고처리
define('AT_ISSUE_TABLE', 'boilerplate_issue'); //게시판 이슈
define('AT_RESERVE_TABLE', 'boilerplate_reserve'); //게시판 예약등록


define("AT_MYSQL_HOST", G5_MYSQL_HOST);
define('AT_MYSQL_USER', G5_MYSQL_USER);
define('AT_MYSQL_PASSWORD', G5_MYSQL_PASSWORD);
define('AT_MYSQL_DB', G5_MYSQL_DB);
define('G5_MYSQL_SET_MODE', false);

define('AT_CONFIG_TABLE', $g5['config_table']);
define('AT_BOARD_TABLE', $g5['board_table']);
define('AT_BOARD_NEW', $g5['board_new_table']);
define('AT_LOGIN_TABLE', $g5['login_table']);
define('AT_MEMBER_TABLE', $g5['member_table']);
define('AT_MEMO_TABLE', $g5['memo_table']);


/*
 * 회원신고 환경설정
 */
//신고처리시 포인트
define('REPORT_REWARD_POINT', 0);
define('PAGING_ROWS', 15);

//휴지통 게시판 지정 - 테이블명, 읽기, 쓰기, 목록 권한을 10으로 설정해야 합니다.
define('AT_TRASHCAN_BOARD', 'trashcan');

//최근 인기게시물 날짜 지정 - 지정한 날짜 내의 게시물 뽑기.
define('AT_POPULAR_DAY', 7);

//인기게시물 제외할 게시판 테이블 'notice,qna' 와 같이 쉼표로 구분해서 입력.
define('AT_POPULAR_EXCLUDE', 'notice,qa');

//게시물 예약등록용 게시판 지정 - 테이블명, 읽기, 쓰기, 목록 권한을 10으로 설정해야 합니다.
define('AT_RESERVE_BOARD', 'reserve');


//자동등업 사용 여부 - 사용시 true
define('AT_AUTO_LEVELUP', false);
//3레벨업에 필요한 포인트 
define('AT_LV_UP3', 1000);
//4레벨업에 필요한 포인트 
define('AT_LV_UP4', 2000);
//5레벨업에 필요한 포인트 
define('AT_LV_UP5', 3000);
//6레벨업에 필요한포인트 
define('AT_LV_UP6', 4000);
//7레벨업에 필요한 포인트 
define('AT_LV_UP7', 5000);
//8레벨업에 필요한 포인트 
define('AT_LV_UP8', 6000);
//9레벨업에 필요한 포인트 
define('AT_LV_UP9', 7000);
