<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
$cssfile = "latest." . $skin_dir . ".css";
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/latest/{$cssfile}\">", 50);
?>
<div class="basic-simple-latest mb-3">
    <h3 class="latest-title border-bottom"><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?></a></h3>
    <div class='padding-box'>
        <?php for ($i = 0; $i < count($list); $i++) { ?>
            <div class="lists position-relative border-bottom">
                <?php
                echo "<div class='wr-subject-wrap'>";
                echo "<a href='{$list[$i]['href']}' class='subject-link text-cut d-block'>";
                if ($list[$i]['is_notice']) {
                    //공지사항
                    echo "<strong>{$list[$i]['subject']}</strong>";
                } else {
                    echo "<span class='ca-name'>{$list[$i]['ca_name']}</span> ";
                    echo $list[$i]['subject'];
                }
                echo "</a>";
                echo "<div class='wr-info-wrap'>";
                //비밀글
                if ($list[$i]['icon_secret']) {
                    echo "<div class='latest-info  d-sm-inline-block'><i class='fa fa-lock' aria-hidden='true'></i><span class='sound_only'>비밀글</span></div>";
                }
                //댓글수
                if ($list[$i]['comment_cnt']) {
                    echo "<div class='latest-info comment-count-wrap'><i class='fa fa-comment-o' aria-hidden='true'></i>  {$list[$i]['comment_cnt']}</div>";
                }
                echo "<div class='latest-info datetime'>{$list[$i]['datetime2']}</div>";
                echo "</div>";
                echo "</div>";

                ?>
            </div>
        <?php } ?>
        <?php if (count($list) == 0) { ?>
            <div class="empty-item">게시물이 없습니다.</div>
        <?php }  ?>
    </div>
</div>