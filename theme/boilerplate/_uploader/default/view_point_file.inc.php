<?php

if (!defined('_GNUBOARD_')) {
    exit;
}

##########################
# 파일별 다운로드 포인트
##########################
if ($cnt && $board['bb_use_download_point'] && $board['bo_download_level'] <= $member['mb_level']) {
    if ($board['bb_use_download_point']) {
        //파일 포인트 추가
        $sql = " SELECT * from `{$g5['board_file_table']}` where `bo_table` = '{$bo_table}' and `wr_id` = '{$wr_id}' order by `bf_no` ";
        $result = sql_query($sql);
        for ($i = 0; $row = sql_fetch_array($result); $i++) {
            if ($row['bf_download_point']) {
                $view['file'][$i]['bf_download_point'] = $row['bf_download_point'];
            }
        }
    }
?>
    <section class='board-attach file-point-wrap mb-2'>
        <div class='row no-gutters'>
            <div class='col-sm-12'>
                <div class="alert alert-info">
                    <i class="fa fa-info" aria-hidden="true"></i> 다운로드시 포인트가 차감됩니다. 다시 다운로드 받으시려면 마이페이지에서 다운로드 하세요.<br />
                </div>
                <?php if ($view['wr_2']) {
                    echo "<div class='alert alert-danger'>";
                    echo "<h4 class='write-title'> <i class='fa fa-info' aria-hidden='true'></i> 라이센스 안내</h4>";
                    echo nl2br($view['wr_2']);
                    echo '</div>';
                } ?>

            </div>
            <?php
            // 가변 파일
            for ($i = 0; $i < count($view['file']); $i++) {
                if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
                    $parse_href = parse_url($view['file'][$i]['href']);
            ?>
                    <div class='at-box col-sm-12 col-md-4 col-lg-3 mb-2'>
                        <div class="card">
                            <h5 class="card-header">
                                <span class="card-title"><?php echo $view['file'][$i]['content'] ?>
                            </h5>
                            <div class='card-img-top d-flex pt-4 pb-4 justify-content-center'>
                                <svg class="bi bi-files" width="3em" height="3em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 2h8a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V4a2 2 0 012-2zm0 1a1 1 0 00-1 1v10a1 1 0 001 1h8a1 1 0 001-1V4a1 1 0 00-1-1H3z" clip-rule="evenodd" />
                                    <path d="M5 0h8a2 2 0 012 2v10a2 2 0 01-2 2v-1a1 1 0 001-1V2a1 1 0 00-1-1H5a1 1 0 00-1 1H3a2 2 0 012-2z" />
                                </svg>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><?php echo $view['file'][$i]['source'] ?><br />
                                    (<?php echo $view['file'][$i]['size'] ?>) <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드 | DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
                                </p>
                            </div>
                            <div class="card-body d-flex justify-content-center border-top">
                                <a href="<?php echo G5_THEME_URL ?>/bp_download_preview.php?<?php echo $parse_href['query'] ?>" class="view-file-point-download card-link btn btn-primary" data-point='<?php echo $view['file'][$i]['bf_download_point'] ?>'>
                                    <i class="fa fa-download" aria-hidden="true"></i> <?php echo number_format($view['file'][$i]['bf_download_point']); ?> Point
                                </a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </section>
    <script>
        $(function() {
            $(".view-file-point-download").click(function() {
                if (!g5_is_member) {
                    alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
                    return false;
                }

                var point = $(this).data('point');
                var msg = "파일을 다운로드 하시면 포인트(" + point + ")가 차감됩니다.\n\n다운로드 하시겠습니까?";

                if (confirm(msg)) {
                    var href = $(this).attr("href") + "&js=on";
                    $(this).attr("href", href);

                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>
<?php } ?>