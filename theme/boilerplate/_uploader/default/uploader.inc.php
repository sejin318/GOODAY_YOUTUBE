<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

/**
 * 콘텐츠 개별 포인트 설정 및 등록
 * 게시판확장설정 다운로드-등록레벨 이상만 등록 가능
 */
if ($board['bb_use_download_point'] && ($board['bo_upload_level'] <= $member['mb_level'] && $board['bb_use_download_level'] <= $member['mb_level'])) {
    require_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'uploader_point.inc.php';
    return;
}

//그누보드 기본 업로드
for ($i = 0; $is_file && $i < $file_count; $i++) { ?>
    <div class='form-group mb-1 mt-1'>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class='input-group-text'><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sr-only"> 파일 #<?php echo $i + 1 ?></span></span>
            </div>
            <input type="file" name="bf_file[]" id="bf_file_<?php echo $i + 1 ?>" title="파일첨부 <?php echo $i + 1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="form-control ">

            <?php if ($board['bb_use_download_point'] && $is_admin == 'super') { ?>
                <div class='input-group-append'>
                    <input type="text" name="bf_download_point[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_download_point'] : ''; ?>" title="다운로드포인트" class="form-control form-download-point" size="15" placeholder="포인트입력">
                </div>
            <?php } ?>

            <?php if ($is_file_content) { ?>
                <div class='input-group-append'>
                    <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="form-control form-download-content" size="50" placeholder="파일 설명을 입력해주세요.">
                </div>
            <?php } ?>
        </div>
        <?php if ($w == 'u' && $file[$i]['file']) { ?>
            <label><input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <span><?php echo cut_str($file[$i]['source'], 30) . '(' . $file[$i]['size'] . ')';  ?> <i class="fa fa-trash" aria-hidden="true"></i></span></label>
        <?php } ?>
    </div>
<?php } ?>