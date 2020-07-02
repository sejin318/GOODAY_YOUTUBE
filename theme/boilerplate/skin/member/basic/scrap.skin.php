<?php

/**
 * scrap.skin.php
 * 스크랩 목록
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
include_once G5_THEME_PATH . "/head.php";
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);
run_event('마이페이지메뉴', '마이페이지메뉴');

?>

<!-- 스크랩 목록 시작 { -->
<div class="scrap-wrap">
    <div class="jumbotron p-4">
        <h1 class="display-5"><?php echo $g5['title'] ?></h1>
        <hr />
        <p class="lead">나의 스크랩 목록</p>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>제목</th>
                    <th>분류</th>
                    <th>날짜</th>
                    <th><i class="fa fa-trash-o" aria-hidden="true"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($list); $i++) {  ?>
                    <tr>
                        <td>
                            <a href="<?php echo $list[$i]['opener_href_wr_id'] ?>" class="scrap_tit" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href_wr_id'] ?>'; return false;"><?php echo cut_str($list[$i]['subject'], 33) ?></a>
                        </td>
                        <td>
                            <a href="<?php echo $list[$i]['opener_href'] ?>" class="scrap_cate" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href'] ?>'; return false;"><?php echo $list[$i]['bo_subject'] ?></a>
                        </td>
                        <td>
                            <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$i]['ms_datetime'] ?>
                        </td>
                        <td>
                            <a href="<?php echo $list[$i]['del_href'];  ?>" onclick="del(this.href); return false;" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i><span class="sr-only">삭제</span></a>
                        </td>
                    </tr>
                <?php }  ?>

                <?php if ($i == 0) echo "<td class=\"empty_li\" colspan='4'>자료가 없습니다.</td>";  ?>
            </tbody>
        </table>
    </div>
    <div class="paging mb-3 pt-3 pb-3">
        <?php echo get_paging($config['cf_write_pages'], $page, $total_page, "?$qstr&amp;page="); ?>
    </div>
    <div class="form-action d-flex">
        <button type="button" onclick="window.close();" class="btn btn-danger mr-auto ml-auto">창닫기</button>
    </div>
</div>
<!-- } 스크랩 목록 끝 -->

<?php
include_once G5_THEME_PATH . "/tail.php";
