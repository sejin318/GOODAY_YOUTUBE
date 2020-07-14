<?php

/**
 * 텍스트 리스트 목록 스킨
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
?>

<?php include_once G5_LIB_PATH."/level_icon.lib.php"; ?> 

<!--######################### 목록 시작#########################-->
<div class="board-table-wrap mb-4">
    <table class='table table-striped'>
        <caption class='sr-only'><?php echo $board['bo_subject'] ?> 목록</caption>
        <thead class='thead-default'>
            <tr>
                <?php if ($is_checkbox) { ?>
                    <th class="all_chk chk_box">
                        
                    </th>
                <?php } ?>
                <th class='tcell number'>번호</th>
                <th class='tcell subject'>제목</th>
                <th class='tcell name'>글쓴이</th>
                <th class='tcell hit'><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회 </a></th>
                <?php if ($is_good) { ?><th class='tcell good'><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천 </a></th><?php } ?>
                <?php if ($is_nogood) { ?><th class='tcell nogood'><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천 </a></th><?php } ?>
                <th class='tcell datetime'><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜 </a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($list); $i++) {
                if ($i % 2 == 0) $lt_class = "even";
                else $lt_class = "";
            ?>
                <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?> <?php echo $lt_class ?>">
                    <?php if ($is_checkbox) { ?>
                        <td class="td_chk chk_box">
                            <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="selec_chk">
                            <label for="chk_wr_id_<?php echo $i ?>" class="sr-only">
                                <span></span>
                                <b class="sr-only"><?php echo $list[$i]['subject'] ?></b>
                            </label>
                        </td>
                    <?php } ?>
                    <td class='tcell number text-center'>
                        <?php
                        if ($list[$i]['is_notice']) { // 공지사항
                            echo '<strong class="notice_icon">공지</strong>';
                        } else if ($wr_id == $list[$i]['wr_id']) {
                            echo '<span class="bo_current"><i class="fa fa-arrow-right fa-spin" aria-hidden="true"></i></span>';
                        } else {
                            echo $list[$i]['num'];
                        }
                        ?>
                    </td>

                    <td class="tcell subject" style="padding-left:<?php echo $list[$i]['reply'] ? (strlen($list[$i]['wr_reply']) * 10) : '0'; ?>px">
                        <div class="bo_tit">
                            <?php if ($is_category && $list[$i]['ca_name']) { ?>
                                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                            <?php } ?>
                            <?php
                            $use_font = '';
                            if ($list[$i]['wr_1'] && $board['bb_use_font']) {
                                $use_font = $list[$i]['wr_1'];
                            }
                            ?>
                            <a href="<?php echo $list[$i]['href'] ?>" class='<?php echo $use_font ?>'>
                                <?php echo $list[$i]['icon_reply'] ?>
                                <?php
                                if (isset($list[$i]['icon_secret'])) {
                                    echo rtrim($list[$i]['icon_secret']);
                                }
                                ?>
                                <?php
                                if (is_mobile()) {
                                    echo cut_str($list[$i]['subject'], $board['bo_mobile_subject_len']);
                                } else {
                                    echo $list[$i]['subject'];
                                }
                                ?>
                            </a>
                            <?php
                            if ($list[$i]['icon_new']) {
                                echo "<span class=\"new_icon\"> <i class='fa fa-book' aria-hidden='true'></i> <span class=\"sr-only\">새글</span></span>";
                            }
                            // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
                            if (isset($list[$i]['icon_file'])) {
                                echo rtrim($list[$i]['icon_file']);
                            }
                            if (isset($list[$i]['icon_link'])) {
                                echo rtrim($list[$i]['icon_link']);
                            }
                            if (isset($list[$i]['icon_hot'])) {
                                echo rtrim($list[$i]['icon_hot']);
                            }
                            ?>
                            <?php if ($list[$i]['comment_cnt']) { ?>
                                <span class="sr-only">댓글</span><span class="comments-count"><?php echo $list[$i]['wr_comment']; ?></span><span class="sr-only">개</span>
                            <?php } ?>
                        </div>
                        <div class='wr-info d-block d-sm-none'>
                            <ul class="m-0 p-0">
                                <li><?php echo get_level_icon($list[$i]['mb_id']); echo $list[$i]['name']; ?></li>
                                <li><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $list[$i]['wr_hit'] ?></li>
                                <?php if ($is_good) { ?><li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?php echo $list[$i]['wr_good'] ?></li><?php } ?>
                                <?php if ($is_nogood) { ?><li><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> <?php echo $list[$i]['wr_nogood'] ?></li><?php } ?>
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$i]['datetime2'] ?></li>
                            </ul>
                        </div>
                    </td>
                    <td class="tcell name"><?php echo get_level_icon($list[$i]['mb_id']); echo $list[$i]['name']; ?></td>
                    <td class="tcell hit"><?php echo $list[$i]['wr_hit'] ?></td>
                    <?php if ($is_good) { ?><td class="tcell good"><?php echo $list[$i]['wr_good'] ?></td><?php } ?>
                    <?php if ($is_nogood) { ?><td class="tcell nogood"><?php echo $list[$i]['wr_nogood'] ?></td><?php } ?>
                    <td class="tcell datetime"><?php echo $list[$i]['datetime2'] ?></td>

                </tr>
            <?php } ?>
            <?php if (count($list) == 0) {
                echo '<tr><td colspan="' . $colspan . '" class="empty_table">게시물이 없습니다.</td></tr>';
            } ?>
        </tbody>
    </table>
</div>
<!--######################### 목록 끝 #########################-->