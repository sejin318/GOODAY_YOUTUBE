<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
$cssfile = "latest." . $skin_dir . ".css";
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/latest/{$cssfile}\">", 50);
?>
<div class="basic-latest border background-8 mb-3">
    <h3 class="latest-title border-bottom background-7"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?></a></h3>
    <div class='padding-box'>
        <ul>
            <?php for ($i = 0; $i < count($list); $i++) { ?>
                <li class='text-cut border-bottom'>
                    <?php
                    echo "<div class='latest-info datetime'>{$list[$i]['datetime2']}</div>";
                    //비밀글
                    if ($list[$i]['icon_secret']) {
                        echo "<div class='latest-info  d-sm-inline-block'><i class='fa fa-lock' aria-hidden='true'></i><span class='sound_only'>비밀글</span></div>";
                    }

                    //인기게시물
                    if ($list[$i]['icon_hot']) {
                    }
                    //새게시물
                    if ($list[$i]['icon_new']) {
                    }
                    //답변 띄우기
                    //echo $list[$i]['icon_reply'] . " ";
                    /*
                    //첨부파일
                    if ($list[$i]['icon_file']) {
                        echo " <div class='latest-info'><i class='fa fa-download' aria-hidden='true'></i></div>";
                    }
                    //링크
                    if ($list[$i]['icon_link']) {
                        echo "<div class='latest-info'> <i class='fa fa-link' aria-hidden='true'></i></div>";
                    }
                    */

                    //댓글수
                    if ($list[$i]['comment_cnt']) {
                        echo "<div class='latest-info comment-count-wrap'><i class='fa fa-comment-o' aria-hidden='true'></i>  {$list[$i]['comment_cnt']}</div>";
                    }

                    echo "<a href='{$list[$i]['href']}'> ";
                    if ($list[$i]['is_notice']) {
                        //공지사항
                        echo "<strong>{$list[$i]['subject']}</strong>";
                    } else {
                        echo "<span class='ca-name'>{$list[$i]['ca_name']}</span> ";
                        echo $list[$i]['subject'];
                    }
                    echo "</a>";
                    ?>
                </li>
            <?php } ?>
            <?php if (count($list) == 0) { ?>
                <li class="empty-item">
                    <span class="d-inline-block p-5"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>게시물이 없습니다.</span>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>