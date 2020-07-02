<?php

/**
 * BoilerPlate 테마 DB 생성용.
 */
class DBInstall
{
    /**
     * Boilerplate config table
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_config($table_name)
    {
        //테이블 없으면 생성
        if (ASKDB::exsit_table($table_name) == false) {
            //신규설치시 테이블 생성
            $make_table_query = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
            `bp_logo` VARCHAR(100) NOT NULL DEFAULT 'default',
            `bp_colorset` VARCHAR(20) NOT NULL DEFAULT 'default',
            `bp_font_size` tinyint(1) NOT NULL,
            `bp_night_mode` tinyint(1) NOT NULL,
            `bp_browser_update` tinyint(1) NOT NULL,
            `bp_use_favorite` tinyint(1) NOT NULL,
            `bp_container` VARCHAR(50) NOT NULL DEFAULT 'container-xxl',
            `bp_header_footer` VARCHAR(50) NOT NULL DEFAULT 'left-aside',
            `bp_pc_menu` VARCHAR(50) NOT NULL DEFAULT 'simple-width-hero',
            `bp_pc_menu_container` tinyint(1) NOT NULL,
            `bp_pc_menu_color` VARCHAR(50) NOT NULL DEFAULT 'default',
            `bp_mobile_menu` VARCHAR(50) NOT NULL DEFAULT 'default',
            `bp_board_uploader` VARCHAR(50) NOT NULL DEFAULT 'default',
            `bp_use_report` tinyint(1) NOT NULL ,
            `bp_member_memo` tinyint(1) NOT NULL ,
            `bp_point_charge` tinyint(1) NOT NULL ,
            `bp_point_list` VARCHAR(255) NOT NULL DEFAULT '',
            `bp_bank_list` VARCHAR(50) NOT NULL DEFAULT '',
            `bp_use_alarm` tinyint(1) NOT NULL ,
            `bp_ftp_use` tinyint(1) NOT NULL,
            `bp_ftp_id` VARCHAR(50) NOT NULL DEFAULT '',
            `bp_ftp_password` VARCHAR(50) NOT NULL DEFAULT '',
            `bp_ftp_port` int(11) NOT NULL,
            `bp_ftp_root` VARCHAR(50) NOT NULL DEFAULT '',
            `bp_ftp_backup` VARCHAR(50) NOT NULL DEFAULT '',
            `bp_ftp_pasv` tinyint(1) NOT NULL,
            `bp_ftp_modify` tinyint(1) NOT NULL

        ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($make_table_query, true);

            //기본 데이터 입력
            $insert_default_data = "INSERT INTO `{$table_name}` set `bp_logo` = '',
                                                                `bp_colorset` = 'colorset.default.css',
                                                                `bp_font_size` = '1',
                                                                `bp_night_mode` = '0',
                                                                `bp_browser_update` = '1',
                                                                `bp_use_favorite` = '1',
                                                                `bp_container` = 'container-fluid',
                                                                `bp_header_footer` = 'left-aside',
                                                                `bp_pc_menu` = 'simple-width-hero',
                                                                `bp_pc_menu_container` = '0',
                                                                `bp_pc_menu_color` = 'dark',
                                                                `bp_mobile_menu` = 'default',
                                                                `bp_board_uploader` = 'default',
                                                                `bp_use_report` = '1',
                                                                `bp_member_memo` = '1',
                                                                `bp_point_list` = '5000|10000|20000|30000|40000|50000|100000|200000|500000',
                                                                `bp_use_alarm` = '1'";
            sql_query($insert_default_data, true);

            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 테마 환경설정 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미 설치 
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 테마 환경설정 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 로고 관리자
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_logo($table_name)
    {
        //테이블 체크   
        if (ASKDB::exsit_table($table_name) == false) {
            $_table_query = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
                `lm_idx` int(11) NOT NULL,
                `lm_alt` varchar(255) NOT NULL,
                `lm_link` varchar(255) NOT NULL,
                `lm_file` varchar(255) NOT NULL,
                `lm_startday` date NOT NULL,
                `lm_endday` date NOT NULL,
                `lm_order` int(11) NOT NULL
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($_table_query, true);
            sql_query("ALTER TABLE `{$table_name}` ADD PRIMARY KEY (`lm_idx`);", true);
            sql_query("ALTER TABLE `{$table_name}` MODIFY `lm_idx` int(11) NOT NULL AUTO_INCREMENT;", true);

            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> LOGO DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> LOGO DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 게시판 즐겨찾기 DB
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_favorite($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $_table_query = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
                `bf_idx` int(11) NOT NULL ,
                `bf_subject` varchar(255) NOT NULL,
                `bf_bo_table` varchar(50) NOT NULL,
                `bf_mb_id` varchar(100) NOT NULL
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($_table_query, true);
            sql_query("ALTER TABLE `{$table_name}` ADD PRIMARY KEY (`bf_idx`);", true);
            sql_query("ALTER TABLE `{$table_name}` MODIFY `bf_idx` int(11) NOT NULL AUTO_INCREMENT;", true);
            sql_query("ALTER TABLE `{$table_name}` ADD INDEX `myFavorite` (`bf_bo_table`, `bf_mb_id`)", true);

            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 게시판즐겨찾기 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 게시판즐겨찾기 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * dummy 게시물 로그
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_dummy($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $_table_query = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
                `dm_idx` int(11) NOT NULL ,
                `dm_bo_table` varchar(50) NOT NULL,
                `dm_wr_id` int(11) NOT NULL
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($_table_query, true);
            sql_query("ALTER TABLE `{$table_name}` ADD PRIMARY KEY (`dm_idx`);", true);
            sql_query("ALTER TABLE `{$table_name}` MODIFY `dm_idx` int(11) NOT NULL AUTO_INCREMENT;", true);
            sql_query("ALTER TABLE `{$table_name}` ADD INDEX `dummygroup` (`dm_bo_table`, `dm_wr_id`)", true);

            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> dummy 게시물 로그 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> dummy 게시물 로그 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 배너 설정 테이블
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_banner($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $_table_query = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
                `bb_idx` int(11) NOT NULL,
                `bb_name` varchar(200) NOT NULL,
                `bb_area` varchar(100) NOT NULL,
                `bb_image` varchar(200) NOT NULL,
                `bb_url` varchar(200) NOT NULL,
                `bb_html` text NOT NULL,
                `bb_type` varchar(10) NOT NULL,
                `bb_tag` varchar(200) NOT NULL,
                `bb_startday` date NOT NULL,
                `bb_endday` date NOT NULL
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($_table_query, true);
            sql_query("ALTER TABLE `{$table_name}` ADD PRIMARY KEY (`bb_idx`);", true);
            sql_query("ALTER TABLE `{$table_name}` MODIFY `bb_idx` int(11) NOT NULL AUTO_INCREMENT;", true);
            sql_query("ALTER TABLE `{$table_name}` ADD INDEX(`bb_area`)");
            sql_query("ALTER TABLE `{$table_name}` ADD INDEX(`bb_tag`)");
            sql_query("ALTER TABLE `{$table_name}` ADD INDEX `day_index` (`bb_startday`, `bb_endday`);");

            //배너위치 테이블 만들기

            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 배너 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 배너 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }


    /**
     * 게시판 확장 설정 테이블
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_board($table_name)
    {
        global $g5;
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $_table_query = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
                `bb_idx` int(11) NOT NULL,
                `bb_bo_table` varchar(200) NOT NULL,
                `bb_list_skin` varchar(100) NOT NULL,
                `bb_comment_image` tinyint(1) NOT NULL,
                `bb_use_font` tinyint(1) NOT NULL,
                `bb_gallery_col` tinyint(1) NOT NULL,
                `bb_webzine_col` tinyint(1) NOT NULL,
                `bb_exif_gps` tinyint(1) NOT NULL,
                `bb_use_download_point` tinyint(1) NOT NULL,
                `bb_use_download_level` tinyint(1) NOT NULL,
                `bb_use_download_save` tinyint(1) NOT NULL
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($_table_query, true);
            sql_query("ALTER TABLE `{$table_name}` ADD PRIMARY KEY (`bb_idx`);", true);
            sql_query("ALTER TABLE `{$table_name}` MODIFY `bb_idx` int(11) NOT NULL AUTO_INCREMENT;", true);
            sql_query("ALTER TABLE `{$table_name}` ADD INDEX(`bb_bo_table`)");

            //데이터 추가
            $board = ASKDB::get_board_list();
            foreach ($board as $_b) {
                $sql = "INSERT into `{$table_name}` set `bb_bo_table` = '{$_b['bo_table']}',
                                                             `bb_list_skin` = 'list',
                                                             `bb_comment_image` = '0',
                                                             `bb_use_font` = '0',
                                                             `bb_gallery_col` = '3',
                                                             `bb_webzine_col` = '1',
                                                             `bb_exif_gps` = '0',
                                                             `bb_use_download_point` = '0',
                                                             `bb_use_download_level` = '0',
                                                             `bb_use_download_save` = '0'";
                sql_query($sql, true);
            }

            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 게시판 확장 설정 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 게시판 확장 설정 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 슬라이더 설정 테이블
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_slider($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $slier_table_query = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
                `bs_idx` int(11) NOT NULL,
                `bs_name` varchar(255) NOT NULL,
                `bs_skin` varchar(255) NOT NULL,
                `bs_use` tinyint(1) NOT NULL,
                `bs_autoplay` tinyint(1) NOT NULL,
                `bs_control` tinyint(1) NOT NULL,
                `bs_indicator` tinyint(1) NOT NULL,
                `bs_crossfade` tinyint(1) NOT NULL,
                `bs_page_count` int(1) NOT NULL
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($slier_table_query, true);
            sql_query("ALTER TABLE `{$table_name}` ADD PRIMARY KEY (`bs_idx`);", true);
            sql_query("ALTER TABLE `{$table_name}` MODIFY `bs_idx` int(11) NOT NULL AUTO_INCREMENT;", true);
            sql_query("ALTER TABLE `{$table_name}` ADD UNIQUE(`bs_name`)", true);
            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 슬라이더 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 슬라이더 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 슬라이더 목록 테이블
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_slider_list($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $slierlist_table_query = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
                `bss_idx` int(11) NOT NULL,
                `bss_parent` int(11) NOT NULL,
                `bss_name` varchar(255) NOT NULL,
                `bss_subject` varchar(255) NOT NULL,
                `bss_content` varchar(255) NOT NULL,
                `bss_url` varchar(255) NOT NULL,
                `bss_class` varchar(50) NOT NULL,
                `bss_image` varchar(255) NOT NULL,
                `bss_order` int(11) NOT NULL,
                `bss_interval` int(11) NOT NULL,
                `bss_startday` date NOT NULL,
                `bss_endday` date NOT NULL
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($slierlist_table_query, true);
            sql_query("ALTER TABLE `" . $table_name . "` ADD PRIMARY KEY (`bss_idx`);", true);
            sql_query("ALTER TABLE `" . $table_name . "` MODIFY `bss_idx` int(11) NOT NULL AUTO_INCREMENT;", true);

            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 슬라이더 목록 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 슬라이더 목록 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 포인트 충전 테이블
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_point_charge($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $_table_query = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
                `bo_idx` int(11) NOT NULL,
                `bo_mb_id` varchar(50) NOT NULL,
                `bo_point` int(11) NOT NULL,
                `bo_datetime` datetime NOT NULL,
                `bo_bank` varchar(100) NOT NULL,
                `bo_name` varchar(255) NOT NULL,
                `bo_email` varchar(50) NOT NULL,
                `bo_order_state` varchar(50) NOT NULL,
                `bo_cancel_datetime` datetime NOT NULL,
                `bo_deposit_datetime` datetime NOT NULL,
                `bo_ip` varchar(50) NOT NULL
               
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($_table_query, true);
            sql_query("ALTER TABLE `" . $table_name . "` ADD PRIMARY KEY (`bo_idx`);", true);
            sql_query("ALTER TABLE `" . $table_name . "` MODIFY `bo_idx` int(11) NOT NULL AUTO_INCREMENT;", true);
            sql_query("ALTER TABLE `{$table_name}` ADD INDEX `search_index` (`bo_mb_id`, `bo_name`);");

            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 포인트구매목록 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 포인트구매목록 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 포인트 환불 테이블
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_point_refund($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $_table_query = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
                `br_idx` int(11) NOT NULL,
                `br_mb_id` varchar(50) NOT NULL,
                `br_point` int(11) NOT NULL,
                `br_datetime` datetime NOT NULL,
                `br_bank_name` varchar(100) NOT NULL,
                `br_bank_acount` varchar(50) NOT NULL,
                `br_name` varchar(255) NOT NULL,
                `br_email` varchar(50) NOT NULL,
                `br_refund_state` varchar(50) NOT NULL,
                `br_refuse_memo` varchar(255) NOT NULL,
                `br_refund_datetime` datetime NOT NULL,
                `br_ip` varchar(50) NOT NULL
               
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($_table_query, true);
            sql_query("ALTER TABLE `" . $table_name . "` ADD PRIMARY KEY (`br_idx`);", true);
            sql_query("ALTER TABLE `" . $table_name . "` MODIFY `br_idx` int(11) NOT NULL AUTO_INCREMENT;", true);
            sql_query("ALTER TABLE `{$table_name}` ADD INDEX `search_index` (`br_mb_id`, `br_name`);");

            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 포인트환불목록 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 포인트환불목록 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 다운로드 로그
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_download_log($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $_table_query = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
                `bd_idx` int(11) NOT NULL,
                `bd_mb_id` varchar(100) NOT NULL,
                `bd_bo_table` varchar(100) NOT NULL,
                `bd_wr_id` int(11) NOT NULL,
                `bd_bf_no` int(11) NOT NULL,
                `bd_content` varchar(255) NOT NULL,
                `bd_point` int(11) NOT NULL,
                `bd_down_count` int(11) NOT NULL,
                `bd_datetime` datetime NOT NULL,
                `bd_ip` varchar(50) NOT NULL               
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($_table_query, true);
            sql_query("ALTER TABLE `" . $table_name . "` ADD PRIMARY KEY (`bd_idx`);", true);
            sql_query("ALTER TABLE `" . $table_name . "` MODIFY `bd_idx` int(11) NOT NULL AUTO_INCREMENT;", true);
            sql_query("ALTER TABLE `{$table_name}` ADD INDEX `list_index` (`bd_mb_id`);");

            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 다운로드목록 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 다운로드목록 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 알람 테이블
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_alarm($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $_table_query = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
                `ba_idx` int(11) NOT NULL,
                `ba_type` varchar(10) NOT NULL,
                `ba_bo_table` varchar(50) NOT NULL,
                `ba_wr_id` int(11) NOT NULL,
                `ba_bo_subject` varchar(100) NOT NULL,
                `ba_wr_subject` varchar(255) NOT NULL,
                `ba_me_id` varchar(50) NOT NULL,
                `ba_datetime` datetime NOT NULL,
                `ba_name` varchar(100) NOT NULL,
                `ba_mb_id` varchar(100) NOT NULL,
                `ba_read` tinyint(1) NOT NULL
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($_table_query, true);
            sql_query("ALTER TABLE `" . $table_name . "` ADD PRIMARY KEY (`ba_idx`);", true);
            sql_query("ALTER TABLE `" . $table_name . "` MODIFY `ba_idx` int(11) NOT NULL AUTO_INCREMENT;", true);
            sql_query("ALTER TABLE `{$table_name}` ADD INDEX(`ba_mb_id`)");
            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> Alarm DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> Alarm DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 회원메모 테이블
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_member_memo($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $_table_query = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
                `bm_idx` int(11) NOT NULL,
                `bm_mb_id` varchar(10) NOT NULL,
                `bm_memo_mb_id` varchar(60) NOT NULL,
                `bm_memo` varchar(60) NOT NULL
              ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . ";";
            sql_query($_table_query, true);
            sql_query("ALTER TABLE `" . $table_name . "` ADD PRIMARY KEY (`bm_idx`);", true);
            sql_query("ALTER TABLE `" . $table_name . "` MODIFY `bm_idx` int(11) NOT NULL AUTO_INCREMENT;", true);
            sql_query("ALTER TABLE `{$table_name}` ADD UNIQUE `member_target` (`bm_mb_id`, `bm_memo_mb_id`)  USING BTREE;");
            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 회원메모 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 회원메모 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 회원확장 필드용 테이블
     *
     * @param [type] $table_name
     * @return void
     */
    public static function db_member($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $sql = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
            `bm_idx` int(11) NOT NULL AUTO_INCREMENT,
            `bm_mb_id` varchar(50) NOT NULL COMMENT '회원아이디',
            `bm_alarm_count` int(11) NOT NULL,
            PRIMARY KEY (`bm_idx`),
            KEY `member` (`bm_mb_id`)
          ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . " COMMENT='회원확장필드';";
            sql_query($sql, true);
            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 회원확장필드 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 회원확장필드 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 각종 확장 필드용
     *
     * @return void
     */
    public static function db_field()
    {
        global $g5;
        $result = '';
        $sql = " SHOW COLUMNS FROM `{$g5['board_file_table']}` LIKE 'bf_download_point' ";
        $row = sql_fetch($sql, true);
        if (!$row) {
            sql_query("ALTER TABLE `{$g5['board_file_table']}` ADD `bf_download_point` INT NOT NULL AFTER `bf_datetime`", true);
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 확장필드 업데이트 완료</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 확장필드가 이미 업데이트 되었습니다.</div>";
        }

        $sql = " SHOW COLUMNS FROM `" . BP_SLIDER_TABLE . "` LIKE 'bs_ratio' ";
        $row = sql_fetch($sql, true);
        if (!$row) {
            sql_query("ALTER TABLE `" . BP_SLIDER_TABLE . "` ADD `bs_ratio` VARCHAR(50) NOT NULL AFTER `bs_skin`;", true);
            $result .= "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> Slider 필드 업데이트 완료</div>";
        } else {
            //이미설치완료
            $result .= "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i>  Slider 필드 확장필드가 이미 업데이트 되었습니다.</div>";
        }

        return $result;
    }
    /**
     * 회원신고 관련 테이블 생성하기
     * @param type $table_name
     * @return type
     */
    public static function db_report($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $sql = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
            `ar_idx` int(11) NOT NULL AUTO_INCREMENT,
            `ar_reporter_id` varchar(50) NOT NULL COMMENT '신고자아이디',
            `ar_mb_id` varchar(50) NOT NULL COMMENT '신고대상아이디',
            `ar_type` varchar(20) NOT NULL COMMENT '신고타입',
            `ar_memo` text NOT NULL COMMENT '메모내용',
            `ar_me_id` int(11) NOT NULL COMMENT '메모idx',
            `ar_bo_table` varchar(50) NOT NULL COMMENT '게시판',
            `ar_wr_id` int(11) NOT NULL,
            `ar_reason` varchar(255) NOT NULL,
            `ar_datetime` datetime NOT NULL,
            `ar_ip` int(11) NOT NULL,
            `ar_sanction_idx` int(11) NOT NULL COMMENT '처리결과외래키',
            PRIMARY KEY (`ar_idx`),
            KEY `member` (`ar_reporter_id`,`ar_mb_id`),
            KEY `memo` (`ar_me_id`),
            KEY `board` (`ar_bo_table`,`ar_wr_id`,`ar_reporter_id`) USING BTREE,
            KEY `ar_sanction` (`ar_sanction_idx`) USING BTREE
          ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . " COMMENT='회원신고';";
            sql_query($sql, true);
            //설치완료
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 회원신고 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 회원신고 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 게시판 이슈 테이블 생성
     * @param type $table_name
     * @return type
     */
    public static function db_issue($table_name)
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
            `ai_idx` int(11) NOT NULL AUTO_INCREMENT,
            `ai_bo_table` varchar(50) NOT NULL,
            `ai_wr_id` int(11) NOT NULL,
            `ai_datetime` datetime NOT NULL,
            `ai_mb_id` varchar(50) NOT NULL,
            PRIMARY KEY (`ai_idx`),
            KEY `ai_bo_table` (`ai_bo_table`,`ai_wr_id`)
          ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . " COMMENT='게시판 이슈';";
        $result = sql_query($sql, true);
        return $result;
    }

    /**
     * 신고처리
     * @param type $table_name
     * @return type
     */
    public static function db_report_sanction($table_name)
    {
        //테이블 체크
        if (ASKDB::exsit_table($table_name) == false) {
            $sql = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
            `as_idx` int(11) NOT NULL AUTO_INCREMENT,
            `as_mb_id` varchar(150) NOT NULL COMMENT '피신고자',
            `as_type` varchar(10) NOT NULL COMMENT '제재종류',
            `as_start_day` date NOT NULL COMMENT '시작일',
            `as_end_day` date NOT NULL COMMENT '마지막일',
            `as_reason` varchar(255) NOT NULL COMMENT '사유',
            `as_memo` varchar(255) NOT NULL COMMENT '메모',
            `as_datetime` datetime NOT NULL COMMENT '처리일',
            UNIQUE KEY `as_idx` (`as_idx`) USING BTREE,
            KEY `date` (`as_start_day`,`as_end_day`,`as_mb_id`) USING BTREE
          ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . " COMMENT='회원신고처리';";
            $result = sql_query($sql, true);
            $result = "<div class='alert alert-info'><i class=\"fa fa-info\" aria-hidden=\"true\"></i> 회원신고처리 DB(" . $table_name . ") 설치 완료!</div>";
        } else {
            //이미설치완료
            $result = "<div class='alert alert-warning'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> 회원신고처리 DB(" . $table_name . ") 이미 설치되었습니다.</div>";
        }
        return $result;
    }

    /**
     * 게시물 예약등록
     * @param type $table_name
     * @return type
     */
    public static function db_reserve($table_name)
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
            `ar_idx` int(11) NOT NULL AUTO_INCREMENT,
            `ar_bo_table` varchar(50) NOT NULL,
            `ar_wr_id` int(11) NOT NULL,
            `ar_board` varchar(50) NOT NULL,
            `ar_datetime` datetime NOT NULL,
            `ar_result_id` int(11) NOT NULL,
            PRIMARY KEY (`ar_idx`),
            KEY `ar_datetime` (`ar_datetime`)
          ) ENGINE=MyISAM DEFAULT CHARSET=" . G5_DB_CHARSET . " COMMENT='예약게시물처리';";
        $result = sql_query($sql, true);
        return $result;
    }
}
