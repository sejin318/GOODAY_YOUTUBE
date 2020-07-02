<?php

/**
 * 배너 출력
 */
include_once "./_common.php";
if (!function_exists('bp_banner_hook')) {
    /**
     * 배너 출력
     *
     * @return void
     */
    function bp_banner_hook()
    {
        //배너용 이벤트 훅 리스트
        $hook = BP_BANNER_HOOK;
        foreach ($hook as $item) {
            add_event($item, 'bp_display_banner', 10, 5);
        }
    }
}

if (!function_exists('bp_display_banner')) {
    /**
     * 배너 출력
     *
     * @return void
     */
    function bp_display_banner($item)
    {

        $sql = "SELECT * from `" . BP_BANNER_TABLE . "` where `bb_area` = '{$item}' and  ((date_format(now(), '%Y-%m-%d') BETWEEN `bb_startday` and `bb_endday`) or (`bb_startday` = '0000-00-00' and `bb_endday` = '0000-00-00')) order by bb_idx";
        $result = sql_query($sql);
        while ($banner = sql_fetch_array($result)) {
            $banner_item[] = bp_banner_gen($banner);
        }
        //여러개일 경우 랜덤으로 하나만 출력
        if ($banner_item && is_array($banner_item)) {
            shuffle($banner_item);
        }
        echo $banner_item[0];
    }
}

if (!function_exists('bp_banner')) {
    /**
     * 배너 개별 출력
     *
     * @return void
     */
    function bp_banner($banner_idx, $preview = false)
    {
        if ($preview == true) {
            $sql = "SELECT * from `" . BP_BANNER_TABLE . "` where `bb_idx` = '{$banner_idx}' order by bb_idx";
        } else {
            $sql = "SELECT * from `" . BP_BANNER_TABLE . "` where `bb_idx` = '{$banner_idx}' and  ((date_format(now(), '%Y-%m-%d') BETWEEN `bb_startday` and `bb_endday`) or (`bb_startday` = '0000-00-00' and `bb_endday` = '0000-00-00')) order by bb_idx";
        }

        $_banner = sql_fetch($sql);
        return bp_banner_gen($_banner);
    }
}

if (!function_exists('bp_tag_banner')) {
    /**
     * 배너 태그 검색으로 출력
     *
     * @return void
     */
    function bp_tag_banner($tag)
    {

        $sql = "SELECT * from `" . BP_BANNER_TABLE . "` where `bb_tag`  like '%{$tag}%' and  ((date_format(now(), '%Y-%m-%d') BETWEEN `bb_startday` and `bb_endday`) or (`bb_startday` = '0000-00-00' and `bb_endday` = '0000-00-00')) order by bb_idx";
        $result = sql_query($sql);
        while ($banner = sql_fetch_array($result)) {
            $banner_item[] = bp_banner_gen($banner);
        }
        //여러개일 경우 랜덤으로 하나만 출력
        shuffle($banner_item);
        echo $banner_item[0];
    }
}

if (!function_exists('bp_banner_gen')) {
    /**
     * 배너 태그 생성
     *
     * @param [type] $type
     * @return void
     */
    function bp_banner_gen($banner)
    {
        $str = '';
        if ($banner['bb_type'] == 'text') {
            $str .= "<div class='text-banner-wrap'><a href='" . G5_PLUGIN_URL . "/ask-ads/links.php?idx={$banner['bb_idx']}' target='_blank' class='text-links'>{$banner['bb_name']}</a></div>";
            return $str;
        }
        if ($banner['bb_type'] == 'image') {
            $str .= "<div class='image-banner-wrap ml-auto mr-auto mt-1 mb-1 text-center'><a href='" . G5_PLUGIN_URL . "/ask-ads/links.php?idx={$banner['bb_idx']}' target='_blank' class='text-links'><img src='" . BP_FILE_URL . "/{$banner['bb_image']}' alt='{$banner['bb_name']}' class='banner-image'></a></div>";
            return $str;
        }
        if ($banner['bb_type'] == 'html') {
            $str .= "<div class='html-banner-wrap'>{$banner['bb_html']}</div>";
            return $str;
        }
    }
}

bp_banner_hook();
