<?php
if($config['cf_theme'] != 'boilerplate'){
    return false;
}
$menu['menu800'] = array(
    array('800000', '<strong>보일러플레이트</strong>', '#', 'boilerplate'),
    array('800100', '<i class="fa fa-caret-right" aria-hidden="true"></i> 테마-기본설정', G5_ADMIN_URL . '/boilerplate/bp_config.php', 'boilerplate'),
    array('800101', '<i class="fa fa-caret-right" aria-hidden="true"></i> 테마-로고설정', G5_ADMIN_URL . '/boilerplate/bp_logo.php', 'boilerplate'),
    array('800110', '<i class="fa fa-caret-right" aria-hidden="true"></i> 테마-슬라이더', G5_ADMIN_URL . '/boilerplate/bp_slider_list.php', 'boilerplate'),
    array('800115', '<i class="fa fa-caret-right" aria-hidden="true"></i> 테마-배너목록', G5_ADMIN_URL . '/boilerplate/bp_banner_list.php', 'boilerplate'),
    array('800120', '<i class="fa fa-caret-right" aria-hidden="true"></i> 관리자 OTP 설정', G5_ADMIN_URL . '/boilerplate/otp-login/otp-config.php', 'cf_otp'),
    array('800150', '<i class="fa fa-caret-right" aria-hidden="true"></i> Dummy 생성', G5_ADMIN_URL . '/boilerplate/bp_dummy.php', 'boilerplate'),
    array('800200', '<hr/>', '#', 'ask-tools'),
    array('800210', '<i class="fa fa-caret-right" aria-hidden="true"></i> 회원비교', G5_ADMIN_URL . '/boilerplate/mb_diff.php', 'boilerplate'),
    array('800221', '<i class="fa fa-caret-right" aria-hidden="true"></i> 회원신고목록', G5_ADMIN_URL . '/boilerplate/mb_report_list.php', 'boilerplate'),
    array('800299', '<hr/>', '#', 'ask-tools'),
    array('800300', '<i class="fa fa-caret-right" aria-hidden="true"></i> DB 백업', G5_ADMIN_URL . '/boilerplate/ask-backup/askbackup.php', 'boilerplate'),
    array('800310', '<i class="fa fa-caret-right" aria-hidden="true"></i> ASK-FTP', G5_PLUGIN_URL . '/ask-ftp/ask_ftp.php', 'cf_ftp'),
    array('800399', '<hr/>', '#', 'ask-tools'),
    array('800400', '<i class="fa fa-caret-right" aria-hidden="true"></i> 게시판확장설정', G5_ADMIN_URL . '/boilerplate/bp_board_list.php', 'boilerplate'),
    array('800399', '<hr/>', '#', 'ask-tools'),
    array('800500', '<i class="fa fa-caret-right" aria-hidden="true"></i> 포인트주문목록', G5_ADMIN_URL . '/boilerplate/bp_point_order_list.php', 'boilerplate'),
    array('800510', '<i class="fa fa-caret-right" aria-hidden="true"></i> 포인트환불목록', G5_ADMIN_URL . '/boilerplate/bp_point_refund_list.php', 'boilerplate'),
    array('800399', '<hr/>', '#', 'ask-tools'),
    array('800999', '<i class="fa fa-caret-right" aria-hidden="true"></i> Upgrade', G5_ADMIN_URL . '/boilerplate/bp_install.php', 'boilerplate'),
    array('800999', '<i class="fa fa-caret-right" aria-hidden="true"></i> PMA', G5_URL . '/_pma', 'boilerplate')
);
