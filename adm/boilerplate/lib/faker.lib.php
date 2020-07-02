<?php
include_once G5_PLUGIN_PATH . '/ask-faker/src/autoload.php';
$faker = Faker\Factory::create('ko_KR');
if (!function_exists('bp_fake_member')) {
    /**
     * 테스트용 가짜 회원 생성
     *
     * @param [type] $count
     * @return void
     */
    function bp_fake_member($count)
    {
        global $faker, $g5, $config;

        for ($i = 0; $count > $i; $i++) {
            $mb_id = cut_str($faker->word . $faker->word, 10, '') . $faker->numberBetween(1, 9999);
            $mb_name = $faker->name;
            $mb_nick = "FAKE" . $mb_name;
            $mb_hp = $faker->phoneNumber;
            $mb_password = $faker->password;
            $mb_email = $faker->safeEmail;
            $mb_homepage = "http://" . $faker->domainName;
            $mb_tel = $faker->phoneNumber;
            $mb_zip1 = substr($faker->postcode, 0, 3);
            $mb_zip2 = substr($faker->postcode, 3, 2);
            $mb_addr1 = $faker->address;
            $ipaddress = $faker->ipv4;
            $point = $faker->numberBetween(1000, 9000);
            $sql = " insert into {$g5['member_table']}
                                set mb_id = '{$mb_id}',
                                    mb_password = '" . get_encrypt_string($mb_password) . "',
                                    mb_name = '{$mb_name}',
                                    mb_nick = '{$mb_nick}',
                                    mb_nick_date = '" . G5_TIME_YMD . "',
                                    mb_email = '{$mb_email}',
                                    mb_homepage = '{$mb_homepage}',
                                    mb_tel = '{$mb_tel}',
                                    mb_zip1 = '{$mb_zip1}',
                                    mb_zip2 = '{$mb_zip2}',
                                    mb_addr1 = '{$mb_addr1}',
                                    mb_signature = 'faker-member',
                                    mb_profile = 'faker-member',
                                    mb_today_login = '" . G5_TIME_YMDHIS . "',
                                    mb_datetime = '" . G5_TIME_YMDHIS . "',
                                    mb_ip = '{$ipaddress}',
                                    mb_level = '2',
                                    mb_login_ip = '{$_SERVER['REMOTE_ADDR']}',
                                    mb_mailling = '0',
                                    mb_sms = '0',
                                    mb_open = '1',
                                    mb_open_date = '" . G5_TIME_YMD . "',
                                    mb_10 = 'faker-member',
                                    mb_hp = '{$mb_hp}',
                                    mb_certify = '',
                                    mb_adult = 0,
                                    mb_birth = '',
                                    mb_sex = '',
                                    mb_email_certify = '" . G5_TIME_YMDHIS . "' ";
            sql_query($sql, true);
            // 회원가입 포인트 부여
            insert_point($mb_id, $point, '회원가입 축하', '@member', $mb_id, 'faker-member');
        }
    }
}

if (!function_exists('bp_faker_board')) {
    /**
     * Dummy 게시물 등록
     *
     * @param [type] $bo_table
     * @param [type] $count
     * @return void
     */
    function bp_faker_board($bo_table, $count, $image_upload = false)
    {
        global $faker, $g5, $config;
        $wr_id = '';
        $write_table = $g5['write_prefix'] . $bo_table;

        $board = ASKDB::get_board_info($bo_table);

        for ($i = 0; $count > $i; $i++) {
            //분류
            if ($board['bo_use_category']) {
                $categories = explode('|', $board['bo_category_list']);
                shuffle($categories);
            }

            $sql = "SELECT * FROM `{$g5['member_table']}` WHERE mb_10 = 'faker-member' order by rand() limit 1";
            $mb = sql_fetch($sql);
            if ($mb) {
                $mb_id = $mb['mb_id'];
                $mb_name = $mb['mb_nick'];
                $wr_name = $mb['mb_name'];
            } else {
                $mb_id = cut_str($faker->word . $faker->word, 10, '') . $faker->numberBetween(1, 9999);
                $mb_name = $faker->name;
                $wr_name = "FAKE" . $mb_name;
            }


            $mb_password = $faker->password;
            $wr_email = $faker->safeEmail;
            $wr_homepage = "http://" . $faker->domainName;

            $ipaddress = $faker->ipv4;
            $wr_subject = addslashes(clean_xss_tags($faker->realText(rand(20, 70), 2)));
            $wr_subject = substr(trim($wr_subject), 0, 255);
            $wr_subject = preg_replace("#[\\\]+$#", "", $wr_subject);

            $wr_content = addslashes(clean_xss_tags($faker->realText(rand(600, 4800), 2)));
            $wr_content = substr(trim($wr_content), 0, 65536);
            $wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
            $wr_content = str_replace(".", "." . PHP_EOL, $wr_content);

            $wr_password = get_encrypt_string($mb_password);

            $wr_num = get_next_num($write_table);

            //데이터를 못가져오는 버그 있음
            if (!$wr_content) {
                $wr_content = addslashes(clean_xss_tags($faker->realText(rand(600, 4800), 2)));
            }
            if (!$wr_subject) {
                $wr_subject = addslashes(clean_xss_tags($faker->realText(rand(20, 70), 2)));
            }
            if (!$wr_content) {
                $wr_content = addslashes(clean_xss_tags($faker->realText(rand(600, 4800), 2)));
            }
            if (!$wr_subject) {
                $wr_subject = addslashes(clean_xss_tags($faker->realText(rand(20, 70), 2)));
            }
            if (!$wr_content) {
                $wr_content = addslashes(clean_xss_tags($faker->realText(rand(600, 4800), 2)));
            }
            if (!$wr_subject) {
                $wr_subject = addslashes(clean_xss_tags($faker->realText(rand(20, 70), 2)));
            }
            if (!$wr_content) {
                $wr_content = addslashes(clean_xss_tags($faker->realText(rand(600, 4800), 2)));
            }
            if (!$wr_subject) {
                $wr_subject = addslashes(clean_xss_tags($faker->realText(rand(20, 70), 2)));
            }
            if (!$wr_content) {
                $wr_content = addslashes(clean_xss_tags($faker->realText(rand(600, 4800), 2)));
            }
            if (!$wr_subject) {
                $wr_subject = addslashes(clean_xss_tags($faker->realText(rand(20, 70), 2)));
            }

            //생성 오류시 기본데이터
            if (!$wr_content) {
                $wr_content = '테스트 게시물 입니다. Dummy 테스트 게시물 입니다. Dummy ';
            }

            if (!$wr_subject) {
                $wr_subject = '테스트 게시물 입니다';
            }
            $wr_subject = trim(preg_replace('/[^\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}0-9a-zA-Z\s]/u', "", $wr_subject));
            $wr_content = trim(preg_replace('/[^\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}0-9a-zA-Z\s]/u', "", $wr_content));
            $add = rand(1000, 9999);
            $wr_subject = $wr_subject . $add;

            //seo title
            $wr_seo_title = exist_seo_title_recursive('bbs', generate_seo_title($wr_subject), $write_table, $wr_id);

            $sql = " INSERT into $write_table
                set wr_num = '$wr_num',
                     wr_reply = '',
                     wr_comment = 0,
                     ca_name = '{$categories[0]}',
                     wr_option = '',
                     wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     wr_seo_title = '$wr_seo_title',
                     wr_link1 = '$wr_homepage',
                     wr_link2 = '$wr_homepage',
                     wr_link1_hit = 0,
                     wr_link2_hit = 0,
                     wr_hit = 0,
                     wr_good = 0,
                     wr_nogood = 0,
                     mb_id = '$mb_id',
                     wr_password = '$wr_password',
                     wr_name = '$wr_name',
                     wr_email = '$wr_email',
                     wr_homepage = '$wr_homepage',
                     wr_datetime = '" . G5_TIME_YMDHIS . "',
                     wr_last = '" . G5_TIME_YMDHIS . "',
                     wr_ip = '$ipaddress',
                     wr_10 = 'fake-board' ";
            sql_query($sql, true);

            $wr_id = sql_insert_id();

            // 부모 아이디에 UPDATE
            sql_query(" UPDATE $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

            // 새글 INSERT
            sql_query("INSERT into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$bo_table}', '{$wr_id}', '{$wr_id}', '" . G5_TIME_YMDHIS . "', '{$mb_id}' ) ");

            // 게시글 1 증가
            sql_query("UPDATE {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '{$bo_table}'");

            //더미 로그에 저장
            sql_query("INSERT into `" . BP_DUMMY_TABLE . "` set `dm_bo_table`='{$bo_table}', `dm_wr_id` = '{$wr_id}'", true);

            if ($image_upload == true) {
                //이미지 첨부 업로드 
                bp_faker_imageupload($bo_table, $wr_id);
            }
        } //for
    }
}


if (!function_exists('bp_faker_delete_array')) {
    /**
     * 삭제용 배열 생성
     *
     * @param [type] $bo_table
     * @return void
     */
    function bp_faker_delete_array($bo_table)
    {
        $sql = "SELECT * from `" . BP_DUMMY_TABLE . "` where dm_bo_table = '{$bo_table}'";
        $result = sql_query($sql);
        $array = array();
        $array['bo_table'] = $bo_table;
        for ($i = 0; $rows = sql_fetch_array($result); $i++) {
            $array['chk_wr_id'][$i] = $rows['dm_wr_id'];
        }
        return $array;
    }
}


if (!function_exists('bp_delete_all')) {
    /**
     * Dummy 게시물 일괄 삭제
     *
     * @param [type] $bo_table
     * @return void
     */
    function bp_delete_all($bo_table)
    {
        global $g5, $config;

        $tmp = bp_faker_delete_array($bo_table);
        $board = ASKDB::get_board_info($bo_table);

        $count_write = 0;
        $count_comment = 0;

        //일괄 삭제
        $tmp_array = $tmp['chk_wr_id'];

        $chk_count = count($tmp_array);

        $write_table = $g5['write_prefix'] . $bo_table;


        for ($i = $chk_count - 1; $i >= 0; $i--) {
            $write = sql_fetch(" select * from $write_table where wr_id = '$tmp_array[$i]' ");

            $len = strlen($write['wr_reply']);
            if ($len < 0) $len = 0;
            $reply = substr($write['wr_reply'], 0, $len);

            // 원글만 구한다.
            $sql = " select count(*) as cnt from $write_table
                where wr_reply like '$reply%'
                and wr_id <> '{$write['wr_id']}'
                and wr_num = '{$write['wr_num']}'
                and wr_is_comment = 0 ";
            $row = sql_fetch($sql);
            if ($row['cnt'])
                continue;

            $sql = " select wr_id, mb_id, wr_is_comment, wr_content from $write_table where wr_parent = '{$write['wr_id']}' order by wr_id ";
            $result = sql_query($sql);
            while ($row = sql_fetch_array($result)) {
                // 원글이라면
                if (!$row['wr_is_comment']) {
                    // 원글 포인트 삭제
                    if (!delete_point($row['mb_id'], $bo_table, $row['wr_id'], '쓰기'))
                        insert_point($row['mb_id'], $board['bo_write_point'] * (-1), "{$board['bo_subject']} {$row['wr_id']} 글 삭제");

                    // 업로드된 파일이 있다면
                    $sql2 = " SELECT * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$row['wr_id']}' ";
                    $result2 = sql_query($sql2);
                    while ($row2 = sql_fetch_array($result2)) {
                        // 파일삭제
                        $delete_file = run_replace('delete_file_path', G5_DATA_PATH . '/file/' . $bo_table . '/' . str_replace('../', '', $row2['bf_file']), $row2);
                        if (file_exists($delete_file)) {
                            @unlink($delete_file);
                        }

                        // 썸네일삭제
                        if (preg_match("/\.({$config['cf_image_extension']})$/i", $row2['bf_file'])) {
                            delete_board_thumbnail($bo_table, $row2['bf_file']);
                        }
                    }

                    // 에디터 썸네일 삭제
                    delete_editor_thumbnail($row['wr_content']);

                    // 파일테이블 행 삭제
                    sql_query(" DELETE from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '{$row['wr_id']}' ");

                    $count_write++;
                } else {
                    // 코멘트 포인트 삭제
                    if (!delete_point($row['mb_id'], $bo_table, $row['wr_id'], '댓글'))
                        insert_point($row['mb_id'], $board['bo_comment_point'] * (-1), "{$board['bo_subject']} {$write['wr_id']}-{$row['wr_id']} 댓글삭제");

                    $count_comment++;
                }
            }

            // 게시글 삭제
            sql_query(" DELETE from $write_table where wr_parent = '{$write['wr_id']}' ");

            // 최근게시물 삭제
            sql_query(" DELETE from {$g5['board_new_table']} where bo_table = '$bo_table' and wr_parent = '{$write['wr_id']}' ");

            // 스크랩 삭제
            sql_query(" DELETE from {$g5['scrap_table']} where bo_table = '{$bo_table}' and wr_id = '{$write['wr_id']}' ");

            $bo_notice = board_notice($board['bo_notice'], $write['wr_id']);
            sql_query(" UPDATE {$g5['board_table']} set bo_notice = '{$bo_notice}' where bo_table = '$bo_table' ");
            $board['bo_notice'] = $bo_notice;
        }

        // 글숫자 감소
        if ($count_write > 0 || $count_comment > 0) {
            sql_query(" UPDATE {$g5['board_table']} set bo_count_write = bo_count_write - '{$count_write}', bo_count_comment = bo_count_comment - '{$count_comment}' where bo_table = '{$bo_table}' ");
        }
        delete_cache_latest($bo_table);

        //dummy log 삭제
        sql_query("DELETE from `" . BP_DUMMY_TABLE . "` where `dm_bo_table` = '{$bo_table}'");
    }
}


if (!function_exists('bp_faker_imageupload')) {
    /**
     * dummy file upload
     *
     * @param [type] $bo_table
     * @param [type] $wr_id
     * @return void
     */
    function bp_faker_imageupload($bo_table, $wr_id)
    {
        global $g5;
        $write_table = $g5['write_prefix'] . $bo_table;
        $image_upload_count = rand(1, 5);


        $images = array();
        for ($i = 0; $i < 20; $i++) {
            $images[$i]['path_name'] = G5_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'ask-faker' . DIRECTORY_SEPARATOR . 'sample-image' . DIRECTORY_SEPARATOR;
            $images[$i]['file_name'] = "{$i}.jpg";
        }

        $chars_array = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

        // 가변 파일 업로드
        shuffle($images);
        $tmp_upload2 = array_slice($images, 0, $image_upload_count);
        $upload_files = array();
        $i = 0;
        foreach ($tmp_upload2 as $upload) {
            shuffle($chars_array);
            $shuffle = implode('', $chars_array);

            $upload['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])) . '_' . substr($shuffle, 0, 8) . '_' . replace_filename($upload['file_name']);

            $dest_file = G5_DATA_PATH . '/file/' . $bo_table . '/' . $upload['file'];

            //파일 복사
            copy($upload['path_name'] . $upload['file_name'], $dest_file) or die($_FILES['bf_file']['error'][$i]);

            // 올라간 파일의 퍼미션을 변경합니다.
            chmod($dest_file, G5_FILE_PERMISSION);

            $timg = @getimagesize($dest_file);
            $upload_files[$i]['image'] = $timg;
            $upload_files[$i]['source'] = $upload['file_name'];
            $upload_files[$i]['bf_file'] = $upload['file'];
            $upload_files[$i]['filesize'] = filesize($dest_file);
            $i++;
        }

        //DB 저장
        for ($i = 0; $i < count($upload_files); $i++) {

            $sql = " INSERT into {$g5['board_file_table']}
                    set bo_table = '{$bo_table}',
                         wr_id = '{$wr_id}',
                         bf_no = '{$i}',
                         bf_source = '{$upload_files[$i]['source']}',
                         bf_file = '{$upload_files[$i]['bf_file']}',
                         bf_content = 'faker-upload',
                         bf_fileurl = '',
                         bf_thumburl = '',
                         bf_storage = '',
                         bf_download = 0,
                         bf_filesize = '{$upload_files[$i]['filesize']}',
                         bf_width = '{$upload_files[$i]['image']['0']}',
                         bf_height = '{$upload_files[$i]['image']['1']}',
                         bf_type = '{$upload_files[$i]['image']['2']}',
                         bf_datetime = '" . G5_TIME_YMDHIS . "' ";
            sql_query($sql, true);
        }

        // 파일의 개수를 게시물에 업데이트 한다.
        $row = sql_fetch(" SELECT count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ", true);
        sql_query(" UPDATE {$write_table} set wr_file = '{$row['cnt']}' where wr_id = '{$wr_id}' ", true);
    }
}
