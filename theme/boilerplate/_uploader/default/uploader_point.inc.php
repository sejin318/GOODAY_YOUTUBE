<?php
if (!defined('_GNUBOARD_')) {
    exit;
}


//파일 포인트 추가
$sql = " SELECT * from `{$g5['board_file_table']}` where `bo_table` = '{$bo_table}' and `wr_id` = '{$wr_id}' order by `bf_no` ";
$result = sql_query($sql);
for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $file[$i]['bf_download_point'] = $row['bf_download_point'];
}
echo "<h4 class='p-2 mt-4 write-title'><i class='fa fa-file-archive-o' aria-hidden='true'></i> 컨텐츠 라이센스</h4>";
echo "<div class='form-group'><textarea class='form-control' rows='5' name='wr_2'>{$write['wr_2']}</textarea></div>";
/**
 * 개별 파일 포인트 설정용 업로드
 */
echo "<h4 class='p-2 mt-4 write-title'><i class='fa fa-file-archive-o' aria-hidden='true'></i> 컨텐츠 등록</h4>";
echo "<div class='alert alert-info'> <i class='fa fa-info' aria-hidden='true'></i> 파일, 다운로드 포인트, 컨텐츠명을 모두 입력하세요. 컨텐츠명 항목이 없다면 게시판 관리자에서 파일설명 사용에 체크하세요.</div>";
echo "<div class='form-group point-file-wrap row mb-1 mt-1'>";
for ($i = 0; $is_file && $i < $file_count; $i++) { ?>
    <div class="col-sm-12 col-md-4">
        <div class="card mb-2">
            <div class="card-header">
                <i class="fa fa-folder-open" aria-hidden="true"></i> File <?php echo $i + 1 ?>
            </div>
            <div class="card-body">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class='input-group-text'>File</span>
                    </div>
                    <input type="file" name="bf_file[]" id="bf_file_<?php echo $i + 1 ?>" title="파일첨부 <?php echo $i + 1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="form-control ">
                </div>
                <?php if ($board['bb_use_download_point']) { ?>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class='input-group-text'>Point</span>
                        </div>
                        <input type="number" name="bf_download_point[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_download_point'] : ''; ?>" title="다운로드포인트" class="form-control form-download-point" size="15" placeholder="포인트입력">
                    </div>
                <?php } ?>
                <?php if ($is_file_content) { ?>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class='input-group-text'>Name</span>
                        </div>
                        <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="컨텐츠명을 입력해주세요." class="form-control form-download-content" size="50" placeholder="파일 설명을 입력해주세요.">
                    </div>
                <?php } ?>
            </div>
            <div class='card-footer'>
                <?php if ($w == 'u' && $file[$i]['file']) { ?>
                    <label><input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <span><?php echo cut_str($file[$i]['source'], 21) . '(' . $file[$i]['size'] . ')';  ?> <i class="fa fa-trash" aria-hidden="true"></i></span></label>
                <?php } ?>
            </div>
        </div>
    </div>
<?php }
echo "</div>"; ?>