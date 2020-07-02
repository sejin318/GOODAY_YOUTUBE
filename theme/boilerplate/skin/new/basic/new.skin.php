<?php
if (!defined("_GNUBOARD_")) {
    exit;
}

// 선택삭제으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_admin) $colspan++;
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/new/new.basic.css">', 50);

?>
<div class="new-board-list">
    <!-- 전체게시물 검색 시작 { -->
    <div class='d-flex justify-content-center'>
        <fieldset id="new_sch" class='search-form'>
            <legend class='sr-only'>상세검색</legend>
            <form name="fnew" method="get">
                <div class='form-group'>
                    <div class='input-group'>
                        <div class='input-group-prepend'>
                            <?php echo str_replace('id="gr_id"', 'id="gr_id" class="form-control"', $group_select); ?>
                        </div>
                        <label for="view" class="sr-only">검색대상</label>
                        <div class='input-group-prepend'>
                            <select name="view" id="view" class='form-control'>
                                <option value="">전체게시물</option>
                                <option value="w">원글만</option>
                                <option value="c">코멘트만</option>
                            </select>
                        </div>
                        <label for="mb_id" class="sr-only">검색어<strong class="sr-only"> 필수</strong></label>
                        <input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" required class="form-control" size="40" placeholder="회원아이디 검색">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> <span>검색</span></button>

                    </div>
                </div>
            </form>
            <script>
                /* 셀렉트 박스에서 자동 이동 해제
            function select_change()
            {
                document.fnew.submit();
            }
            */
                document.getElementById("gr_id").value = "<?php echo $gr_id ?>";
                document.getElementById("view").value = "<?php echo $view ?>";
            </script>
        </fieldset>
    </div>

    <!-- } 전체게시물 검색 끝 -->

    <!-- 전체게시물 목록 시작 { -->
    <form name="fnewlist" id="fnewlist" method="post" action="#" onsubmit="return fnew_submit(this);">
        <input type="hidden" name="sw" value="move">
        <input type="hidden" name="view" value="<?php echo $view; ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
        <input type="hidden" name="stx" value="<?php echo $stx; ?>">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
        <input type="hidden" name="page" value="<?php echo $page; ?>">
        <input type="hidden" name="pressed" value="">

        <?php if ($is_admin) { ?>
            <div class="btn-group mb-1">
                <button type="submit" onclick="document.pressed=this.title" title="선택삭제" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i><span> 선택삭제</span></button>
            </div>
        <?php } ?>
        <div class="table-wrap">
            <table class='table table-striped'>
                <thead class='thead-dark'>
                    <tr>
                        <?php if ($is_admin) { ?>
                            <th class="new-checkbox">
                                <input type="checkbox" id="all_chk" class="selec_chk">
                                <span class="sr-only">목록 전체</span>
                            </th>
                        <?php } ?>
                        <th class='new-group'>그룹</th>
                        <th class='new-board'>게시판</th>
                        <th class='new-subject'>제목</th>
                        <th class='new-name'>이름</th>
                        <th class="new-date">일시</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($list); $i++) {
                        $num = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
                        $gr_subject = cut_str($list[$i]['gr_subject'], 20);
                        $bo_subject = cut_str($list[$i]['bo_subject'], 20);
                        $wr_subject = get_text(cut_str($list[$i]['wr_subject'], 80));
                    ?>
                        <tr>
                            <?php if ($is_admin) { ?>
                                <td class="new-check-box">
                                    <input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i; ?>" class="selec_chk">
                                    <span class="sr-only"><?php echo $num ?>번</span>
                                    <input type="hidden" name="bo_table[<?php echo $i; ?>]" value="<?php echo $list[$i]['bo_table']; ?>">
                                    <input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
                                </td>
                            <?php } ?>
                            <td class="new-group"><a href="./new.php?gr_id=<?php echo $list[$i]['gr_id'] ?>"><?php echo $gr_subject ?></a></td>
                            <td class="new-board"><a href="<?php echo get_pretty_url($list[$i]['bo_table']); ?>"><?php echo $bo_subject ?></a></td>
                            <td class="new-subject">
                                <a href="<?php echo $list[$i]['href'] ?>" class="new_tit"><?php echo $list[$i]['comment'] ?><?php echo $wr_subject ?></a>
                                <div class="write-info">
                                    <a href="./new.php?gr_id=<?php echo $list[$i]['gr_id'] ?>"><?php echo $gr_subject ?></a> /
                                    <a href="<?php echo G5_URL . DIRECTORY_SEPARATOR . $list[$i]['bo_table'] ?>"><?php echo $bo_subject ?></a> /
                                    <?php echo $list[$i]['name'] ?> /
                                    <?php echo $list[$i]['datetime2'] ?>
                                </div>
                            </td>
                            <td class="new-name"><?php echo $list[$i]['name'] ?></td>
                            <td class="new-date"><?php echo $list[$i]['datetime2'] ?></td>
                        </tr>
                    <?php }  ?>

                    <?php if ($i == 0)
                        echo '<tr><td colspan="' . $colspan . '" class="empty_table">게시물이 없습니다.</td></tr>';
                    ?>
                </tbody>
            </table>
        </div>

        <div class='paging mb-3 pt-3 pb-3'>
            <!-- 페이지 -->
            <?php
            //반응형은 is_mobile() 함수로 모바일 체크해야 한다.
            echo get_paging(is_mobile() ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "?gr_id={$gr_id}&amp;view={$view}&amp;mb_id={$mb_id}&amp;page=");

            ?>
            <!-- 페이지 -->
        </div>

        <?php if ($is_admin) { ?>
            <div class="btn-group mb-1">
                <button type="submit" onclick="document.pressed=this.title" title="선택삭제" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i><span> 선택삭제</span></button>
            </div>
        <?php } ?>
    </form>

    <?php if ($is_admin) { ?>
        <script>
            $(function() {
                $('#all_chk').click(function() {
                    $('[name="chk_bn_id[]"]').attr('checked', this.checked);
                });
            });

            function fnew_submit(f) {
                f.pressed.value = document.pressed;

                var cnt = 0;
                for (var i = 0; i < f.length; i++) {
                    if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
                        cnt++;
                }

                if (!cnt) {
                    alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
                    return false;
                }

                if (!confirm("선택한 게시물을 정말 " + document.pressed + " 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
                    return false;
                }

                f.action = "./new_delete.php";

                return true;
            }
        </script>
    <?php } ?>
    <!-- } 전체게시물 목록 끝 -->
</div>