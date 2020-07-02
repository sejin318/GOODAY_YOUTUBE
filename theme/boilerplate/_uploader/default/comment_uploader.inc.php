<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * 댓글 업로더
 * 기본 업로더는 댓글 업로드 기능이 없다.
 * 회원만 가능
 */

 if ($board['bb_comment_image'] && $is_member) {
    //add_javascript("<script src='" . BP_ASSETS_URL . "/js/simpleajaxuploader.js'></script>", 300);
?>
    <script>
        function regex_escape(text) {
            return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
        }

        function replaceAll(str, searchStr, replaceStr) {
            return str.split(searchStr).join(replaceStr);
        }
        /**
         * 확장자 가져오기
         * @param {type} filename
         * @return {getFileExtension.ext|undefined|String}
         */
        function getFileExtension(filename) {
            var ext = /^.+\.([^.]+)$/.exec(filename);
            return ext == null ? "" : ext[1];
        }
        /**
         * 배열에서 찾기
         * @param {type} needle
         * @param {type} haystack
         * @return {Boolean}
         */
        function inArray(needle, haystack) {
            var length = haystack.length;
            for (var i = 0; i < length; i++) {
                if (haystack[i] == needle)
                    return true;
            }
            return false;
        }
        $(function() {
            //upload file name
            $('#cmt-upload').on('change', function() {
                var fileName = $('#cmt-upload')[0].files[0].name;
                $(this).next('.custom-file-label').html(fileName);
                if (!fileName) {
                    $(this).next('.custom-file-label').html('');
                }
            });
            //업로드
            $(document).on("click", '.upload-image', function() {
                // 토큰 넘기기
                var token = _get_delete_token();
                if (!token) {
                    alert("토큰 정보가 올바르지 않습니다.");
                    return false;
                } else {
                    $('#comment_image_token').val(token);
                }

                var fd = new FormData();
                var files = $('#cmt-upload')[0].files[0];
                if (files === undefined) {
                    alert('이미지를 선택하세요.');
                    return false;
                }
                fd.append('bf_file', files);
                fd.append('bo_table', '<?php echo $bo_table ?>');
                fd.append('comment_image_token', token);
                $.ajax({
                    url: '<?php echo BP_UPLOADER_URL . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'comment_uploader.php'; ?>',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(r) {
                        //console.log(r);
                        //고유키
                        $('#comment_image_key').val($('#comment_image_key').val() + ',' + r.key);
                        //이미지태그입력
                        var orgVal = $('#wr_content').val();
                        var fileExtenion = getFileExtension(r.file);
                        if (inArray(fileExtenion, ['jpg', 'jpeg', 'png', 'gif'])) {
                            var imgtag = orgVal + "\n" + '[img]<?php echo G5_DATA_URL . '/file/' . $bo_table . '/'; ?>' + r.file + '[/img]';
                            var imgtagPreview = "\n" + '<div class="col-sm-12 col-md-4 col-lg-3 mb-2 text-center parent-wrap"><div class="position-relative image-preview-inside d-inline-block"><img src="<?php echo G5_THEME_URL . '/_uploader/' . $config['bp_board_uploader'] . '/image_preview.php?bo_table=' . $bo_table . '&filename='; ?>' + r.file + '" class="border comment-image-preview">';
                            imgtagPreview += "<button class='btn btn-danger delete-item btn-sm' type='button' data-filename='" + r.file + "' data-key='" + r.key + "' data-delete=" + '[img]<?php echo G5_DATA_URL . '/file/' . $bo_table . '/'; ?>' + r.file + '[/img]' + "><i class='fa fa-trash-o' aria-hidden='true'></i></button>";
                            imgtagPreview += "<button class='btn btn-primary insert-item btn-sm' type='button' data-insert=" + '[img]<?php echo G5_DATA_URL . '/file/' . $bo_table . '/'; ?>' + r.file + '[/img]' + "><i class='fa fa-arrow-up' aria-hidden='true'></i></button>";
                            imgtagPreview += "</div></div>";
                            $('#wr_content').val(imgtag);
                            $('.image-preview-wrap').append(imgtagPreview).addClass('p-3');
                            //file input clear
                            $('#cmt-upload').val('');
                            $('.custom-file-label').text('이미지선택');
                        }

                    },
                }); //ajax
            });

            //삭제
            $(document).on("click", '.delete-item', function() {
                //textarea에서 삭제
                var textarea = $('#wr_content').val();
                var targetItem = $(this).data('delete');
                var inputHidden = $('#comment_image_key').val();
                var targetKey = $(this).data('key');
                var deleteTags = $(this).parents('.parent-wrap');
                // 토큰 넘기기
                var token = _get_delete_token();
                if (!token) {
                    alert("토큰 정보가 올바르지 않습니다.");
                    return false;
                } else {
                    $('#comment_image_token').val(token);
                }

                //ajax 삭제
                var form = new FormData();
                form.append('filename', $(this).data('filename'));
                form.append('target_key', targetKey);
                form.append('bo_table', '<?php echo $bo_table ?>');
                form.append('comment_image_token', token);
                $.ajax({
                    url: '<?php echo BP_UPLOADER_URL . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'comment_uploader.delete.php'; ?>',
                    type: 'post',
                    data: form,
                    contentType: false,
                    processData: false,
                    success: function(r) {
                        console.log(r);
                        //같은 이미지 전체 삭제
                        $('#wr_content').val(replaceAll(textarea, targetItem, ''));
                        //key 삭제 
                        $('#comment_image_key').val(inputHidden.replace(',' + targetKey, ""));
                        //이미지 미리보기 삭제
                        deleteTags.remove();
                    },
                }); //ajax
            });

            //삽입
            $(document).on("click", '.insert-item', function() {
                var orgVal = $('#wr_content').val();
                var insertItem = $(this).data('insert');
                $('#wr_content').val(orgVal + "\n\n" + insertItem);
            });
        });
    </script>
    <div class='alert alert-info mb-1 mt-1 p-1 pl-3'><i class="fa fa-info" aria-hidden="true"></i> 사진 선택후 필히 업로드 버튼을 클릭하세요.</div>
    <div class='comment-uploader-wrap input-group mt-1 mb-4'>
        <input type='hidden' name="comment_image_token" id='comment_image_token' value="" />
        <input type='hidden' name="comment_image_key" id='comment_image_key' value="" />
        <div class='input-group-prepend'>
            <span class='input-group-text'><i class="fa fa-file-image-o" aria-hidden="true"></i></span>
        </div>
        <div class="custom-file">
            <input type="file" id="cmt-upload" class='custom-file-input' name="bf_file" aria-describedby="commentimageupload" accept="image/*">
            <label class="custom-file-label" for="cmt-upload">이미지선택</label>
        </div>
        <div class="input-group-append">
            <button type='button' class='upload-image btn btn-success' id='commentimageupload'><i class="fa fa-upload" aria-hidden="true"></i></button>
        </div>
    </div>
    <div class='container-fluid'>
        <div class='image-preview-wrap mt-2 mb-2 bg-secondary row'></div>
    </div>

<?php }
