<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
//board uploader 환경설정
include_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'config.inc.php';

//board uploader 댓글 처리
include_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'write_comment_update.inc.php';