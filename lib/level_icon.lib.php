<?php
if (!defined('_GNUBOARD_')) exit;

// 포인트별 아이콘 부여
function get_level_icon($mb_id, $size) {
    global $g5;
//    $max_point = 3000; // 최저
//    $ren_point = 3000; // 나누기
//    $max_level = 450; // 마지막레벨

    $mb = get_member($mb_id, "mb_id, mb_point");
    $ic_mb_id = $mb['mb_id'];
    $is_admin = is_admin($ic_mb_id);
    if ($ic_mb_id) {
        // 관리자
        if ($is_admin == 'super') {
            $mb_icon = "<img src='".G5_IMG_URL."/level/g.png' align='absmiddle' title='관리자' width='$size' height='$size' >";
        //} else if ($ic_mb_id == 'test' || $ic_mb_id == 'test2') { // 특정회원들
        //    $mb_icon = "<img src='".G5_IMG_URL."/level/g.png' align='absmiddle' title='특별회원'>";
        }
        elseif ($is_admin == 'group') {
            $mb_icon = "<img src='".G5_IMG_URL."/level/a.png' align='absmiddle' title='그룹 관리자' width='$size' height='$size' >";
        }
        elseif ($is_admin == 'board'){
            $mb_icon = "<img src='".G5_IMG_URL."/level/b.png' align='absmiddle' title='게시판 관리자' width='$size' height='$size' >";
        }
        else {
            $mb_point = $mb['mb_point'];
            $level = 0;
            $ren_point = 300;
            while($mb_point >= 0){
                $level++;
                $mb_point -= $ren_point;
                if($level >= 19){
                    $ren_point *= 1.1;
                } else {
                    $ren_point *= 1.2;
                }
            }
//            $point = ($mb_point < $max_point) ? $max_point : $mb_point; // 최저포인트 이하
//            $mb_level = (int)($point / $ren_point);
//            $level = ($mb_level > $max_level) ? $max_level : $mb_level; // 맥스레벨 까지만
            $mb_icon = "<img src='"
                .G5_IMG_URL
                ."/level/"
                .$level
                .".png' align='absmiddle' title='포인트레벨 "
                .$level
                .", "
                .number_format($mb['mb_point'])
                ."점' width='$size' height='$size' >";
        }
    }
    else {
        // 비회원
        $mb_icon = "<img src='".G5_IMG_URL."/level/0.png' align='absmiddle' title='손님' width='$size' height='$size' >";
    }
    return $mb_icon;
    //echo $mb_icon;
}
?>
