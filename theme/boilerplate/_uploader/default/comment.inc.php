<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * 댓글 출력, 썸네일 생성
 */
echo get_view_thumbnail(bp_bbcode_image_tag($comment));
