<?php
if (!defined("_GNUBOARD_")) {
    exit; // 개별 페이지 접근 불가
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/search/search.basic.css">', 50);
?>
<div class='search-wrap'>
    <h2 class="page-title border-color-6 border-bottom pt-2 pb-2 mb-2">전체검색</h2>
    <!-- 전체검색 시작 { -->
    <form name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
        <input type="hidden" name="srows" value="<?php echo $srows ?>">
        <fieldset class='form-group'>
            <legend class="sr-only">상세검색</legend>
            <div class="input-group">
                <div class='input-group-prepend'>
                    <?php echo str_replace('class="select"', 'class="select form-control"', $group_select); ?>
                    <script>
                        document.getElementById("gr_id").value = "<?php echo $gr_id ?>";
                    </script>
                </div>
                <div class='input-group-prepend'>
                    <label for="sfl" class="sr-only">검색조건</label>
                    <select name="sfl" id="sfl" class="form-control">
                        <option value="wr_subject||wr_content" <?php echo get_selected($_GET['sfl'], "wr_subject||wr_content") ?>>제목+내용</option>
                        <option value="wr_subject" <?php echo get_selected($_GET['sfl'], "wr_subject") ?>>제목</option>
                        <option value="wr_content" <?php echo get_selected($_GET['sfl'], "wr_content") ?>>내용</option>
                        <option value="mb_id" <?php echo get_selected($_GET['sfl'], "mb_id") ?>>회원아이디</option>
                        <option value="wr_name" <?php echo get_selected($_GET['sfl'], "wr_name") ?>>이름</option>
                    </select>
                </div>
                <label for="stx" class="sr-only">검색어<strong class="sr-only"> 필수</strong></label>
                <input type="text" name="stx" value="<?php echo $text_stx ?>" id="stx" required class="form-control" size="40">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> 검색</button>
            </div>
            <script>
                function fsearch_submit(f) {
                    if (f.stx.value.length < 2) {
                        alert("검색어는 두글자 이상 입력하십시오.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                    var cnt = 0;
                    for (var i = 0; i < f.stx.value.length; i++) {
                        if (f.stx.value.charAt(i) == ' ')
                            cnt++;
                    }

                    if (cnt > 1) {
                        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }

                    f.action = "";
                    return true;
                }
            </script>

            <div class="switch-field">
                <input type="radio" value="and" <?php echo ($sop == "and") ? "checked" : ""; ?> id="sop_and" name="sop">
                <label for="sop_and">AND</label>
                <input type="radio" value="or" <?php echo ($sop == "or") ? "checked" : ""; ?> id="sop_or" name="sop">
                <label for="sop_or">OR</label>
            </div>
        </fieldset>
    </form>

    <div class="search-result-wrap">
        <?php
        if ($stx) {
            if ($board_count) {
        ?>
                <section class="result-info jumbotron">
                    <h4><strong><?php echo $stx ?></strong> 전체검색 결과</h4>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">게시판 <?php echo $board_count ?>개</li>
                        <li class="breadcrumb-item">게시물 <?php echo number_format($total_count) ?>개</li>
                        <li class="breadcrumb-item"><?php echo number_format($page) ?>/<?php echo number_format($total_page) ?> 페이지 열람 중</li>
                    </ul>
                </section>
        <?php
            }
        }
        ?>

        <?php
        if ($stx) {
            if ($board_count) {
        ?>
                <ul class="list-group">
                    <li class="list-group-item"><a href="?<?php echo $search_query ?>&amp;gr_id=<?php echo $gr_id ?>" <?php echo $sch_all ?>>전체게시판</a></li>
                    <?php echo str_replace('<li>', '<li class="list-group-item">', $str_board_list); ?>
                </ul>
            <?php
            } else {
            ?>
                <div class="empty_list">검색된 자료가 하나도 없습니다.</div>
        <?php }
        }  ?>

        <hr>

        <?php if ($stx && $board_count) { ?>
            <section class="search-list">
            <?php }  ?>
            <?php
            $k = 0;
            for ($idx = $table_index, $k = 0; $idx < count($search_table) && $k < $rows; $idx++) {
            ?>
                <h4 class="border-bottom border-color-6 pt-2 pb-2 mb-3 mt-5"><a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>"><?php echo $bo_subject[$idx] ?> 게시판 내 결과</a></h4>
                <ul class="list-group">
                    <?php
                    for ($i = 0; $i < count($list[$idx]) && $k < $rows; $i++, $k++) {
                        if ($list[$idx][$i]['wr_is_comment']) {
                            $comment_def = '<span class="cmt_def"><i class="fa fa-commenting-o" aria-hidden="true"></i><span class="sr-only">댓글</span></span> ';
                            $comment_href = '#c_' . $list[$idx][$i]['wr_id'];
                        } else {
                            $comment_def = '';
                            $comment_href = '';
                        }
                    ?>

                        <li class="list-group-item">
                            <div class="search-title pt-1 pb-1">
                                <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" class="sch_res_title"><?php echo $comment_def ?><?php echo $list[$idx][$i]['subject'] ?></a>
                                <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" target="_blank" class="pop_a"><i class="fa fa-window-restore" aria-hidden="true"></i><span class="sr-only">새창</span></a>
                            </div>
                            <p class="search-content pl-3"><?php echo $list[$idx][$i]['content'] ?></p>
                            <div class="text-right">
                                <?php echo $list[$idx][$i]['name'] ?>
                                <span class="sch_datetime"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$idx][$i]['wr_datetime'] ?></span>
                            </div>
                        </li>
                    <?php }  ?>
                </ul>
                <hr />
                <div class="btn-nav text-right">
                    <a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>" class="btn btn-secondary btn-sm">더보기</a>
                </div>
            <?php }  ?>
            <?php if ($stx && $board_count) {  ?>
            </section>
        <?php }  ?>
        <div class="paging mb-3 pt-3 pb-3">
            <?php echo $write_pages ?>
        </div>

    </div>
    <!-- } 전체검색 끝 -->
</div>