<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
if (!function_exists('bp_slider_hook')) {
    /**
     * Hook으로 슬라이더 출력
     *
     * @return void
     */
    function bp_slider_hook()
    {
        $sql = "SELECT * from `" . BP_SLIDER_TABLE . "`";
        $result = sql_query($sql);
        while ($row = sql_fetch_array($result)) {
            //슬라이더 출력용
            add_event($row['bs_name'], 'bp_slider_event', 10, 5);
        }
    }
}

add_event('마이페이지메뉴', 'bp_mypage_menu', 10, 5);
//슬라이더 훅으로 출력
bp_slider_hook();

