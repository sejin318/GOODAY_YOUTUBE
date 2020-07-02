<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
//유튜브스킨 - 썸네일 처리
if ($board['bb_list_skin'] == 'youtube') {
    if ($wr_link2) {
        $tube_tmp = explode("\n", $wr_link2);
        $tube_arr = array();
        $a = 0;
        foreach ($tube_tmp as $t) {
            if ($a > 0) {
                continue;
            }
            $t = trim($t);
            if ($t != '') {
                $tube_arr[$a] = $embera->getUrlData($t);
                $a++;
            }
        }
        $i = 0;
        $youtube = array();
        foreach ($tube_arr as $_item) {
            foreach ($_item as $_y) {
                if ($i == 0) {
                    $youtube_thumbnail = $_y['thumbnail_url'];
                }
                continue;
                $i++;
            }
        }
        if ($youtube_thumbnail) {
            if ($w == '' || $w == 'r') {
                $_wr_id = $wr_id;
            } elseif ($w == 'u') {
                $_wr_id = $wr['wr_id'];
            }
            //새글
            $sql = "UPDATE {$write_table} set wr_1 = '{$youtube_thumbnail}' where wr_id = '{$_wr_id}' limit 1";
            sql_query($sql, true);
        }
    }
}
