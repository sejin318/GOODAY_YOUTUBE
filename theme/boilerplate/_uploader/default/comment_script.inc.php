<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
?>
<script>
    var save_before = '';
    var save_html = document.getElementById('bo_vc_w').innerHTML;

    function good_and_write() {
        var f = document.fviewcomment;
        if (fviewcomment_submit(f)) {
            f.is_good.value = 1;
            f.submit();
        } else {
            f.is_good.value = 0;
        }
    }

    function fviewcomment_submit(f) {
        var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

        f.is_good.value = 0;

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url + "/ajax.filter.php",
            type: "POST",
            data: {
                "subject": "",
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (content) {
            alert("내용에 금지단어('" + content + "')가 포함되어있습니다");
            f.wr_content.focus();
            return false;
        }

        // 양쪽 공백 없애기
        var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
        document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
        if (char_min > 0 || char_max > 0) {
            check_byte('wr_content', 'char_count');
            var cnt = parseInt(document.getElementById('char_count').innerHTML);
            if (char_min > 0 && char_min > cnt) {
                alert("댓글은 " + char_min + "글자 이상 쓰셔야 합니다.");
                return false;
            } else if (char_max > 0 && char_max < cnt) {
                alert("댓글은 " + char_max + "글자 이하로 쓰셔야 합니다.");
                return false;
            }
        } else if (!document.getElementById('wr_content').value) {
            alert("댓글을 입력하여 주십시오.");
            return false;
        }

        if (typeof(f.wr_name) != 'undefined') {
            f.wr_name.value = f.wr_name.value.replace(pattern, "");
            if (f.wr_name.value == '') {
                alert('이름이 입력되지 않았습니다.');
                f.wr_name.focus();
                return false;
            }
        }

        if (typeof(f.wr_password) != 'undefined') {
            f.wr_password.value = f.wr_password.value.replace(pattern, "");
            if (f.wr_password.value == '') {
                alert('비밀번호가 입력되지 않았습니다.');
                f.wr_password.focus();
                return false;
            }
        }

        <?php if ($is_guest) echo chk_captcha_js();  ?>

        set_comment_token(f);

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    <?php if ($board['bb_comment_image'] && $is_member) { ?>
        /** 
         * 수정시 댓글 이미지 가져오기
         */
        function get_comment_image(wr_id) {
            //console.log(wr_id);
            // 토큰 넘기기
            var token = _get_delete_token();
            if (!token) {
                alert("토큰 정보가 올바르지 않습니다.");
                return false;
            }
            //ajax 삭제
            var form = new FormData();
            form.append('wr_id', wr_id);
            form.append('bo_table', '<?php echo $bo_table ?>');
            form.append('comment_image_token', token);
            $.ajax({
                url: '<?php echo BP_UPLOADER_URL . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'comment_uploader.modify.php'; ?>',
                type: 'post',
                data: form,
                contentType: false,
                processData: false,
                success: function(r) {
                    console.log(r);
                    $.each(r, function(i, item) {
                        var imgtagPreview = "\n" + '<div class="col-sm-12 col-md-4 col-lg-3 mb-2 text-center parent-wrap"><div class="position-relative image-preview-inside d-inline-block"><img src="<?php echo G5_THEME_URL . '/_uploader/' . $config['bp_board_uploader'] . '/image_preview.php?bo_table=' . $bo_table . '&filename='; ?>' + item.bf_file + '" class="border comment-image-preview">';
                        imgtagPreview += "<button class='btn btn-danger delete-item ml-2 btn-sm' type='button' data-filename='" + item.bf_file + "'  data-key='" + item.wr_id + "' data-delete=" + '[img]<?php echo G5_DATA_URL . '/file/' . $bo_table . '/'; ?>' + item.bf_file + '[/img]' + "><i class='fa fa-trash-o' aria-hidden='true'></i></button>";
                        imgtagPreview += "<button class='btn btn-primary insert-item btn-sm' type='button' data-insert=" + '[img]<?php echo G5_DATA_URL . '/file/' . $bo_table . '/'; ?>' + item.bf_file + '[/img]' + "><i class='fa fa-arrow-up' aria-hidden='true'></i></button>";
                        imgtagPreview += "</div></div>";
                        $('.image-preview-wrap').append(imgtagPreview).addClass('p-3');
                    });
                }
            }); //ajax
        }
    <?php } ?>

    function comment_box(comment_id, work) {

        var el_id,
            form_el = 'fviewcomment',
            respond = document.getElementById(form_el);

        // 댓글 아이디가 넘어오면 답변, 수정
        if (comment_id) {
            if (work == 'c')
                el_id = 'reply_' + comment_id;
            else
                el_id = 'edit_' + comment_id;
        } else
            el_id = 'bo_vc_w';

        if (save_before != el_id) {
            if (save_before) {
                document.getElementById(save_before).style.display = 'none';
            }

            document.getElementById(el_id).style.display = '';
            document.getElementById(el_id).appendChild(respond);
            //입력값 초기화
            document.getElementById('wr_content').value = '';

            // 댓글 수정
            if (work == 'cu') {
                <?php if ($board['bb_comment_image'] && $is_member) {
                    echo "get_comment_image(comment_id);";
                } ?>
                document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
                if (typeof char_count != 'undefined')
                    check_byte('wr_content', 'char_count');
                if (document.getElementById('secret_comment_' + comment_id).value)
                    document.getElementById('wr_secret').checked = true;
                else
                    document.getElementById('wr_secret').checked = false;
            }

            document.getElementById('comment_id').value = comment_id;
            document.getElementById('w').value = work;

            if (save_before)
                $("#captcha_reload").trigger("click");

            save_before = el_id;
        }
    }

    function comment_delete() {
        return confirm("이 댓글을 삭제하시겠습니까?");
    }

    comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

    <?php if ($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>

        $(function() {
            // sns 등록
            $("#bo_vc_send_sns").load(
                "<?php echo G5_SNS_URL; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>",
                function() {
                    save_html = document.getElementById('bo_vc_w').innerHTML;
                }
            );
        });
    <?php } ?>
    $(function() {
        //댓글열기
        $(".cmt_btn").click(function() {
            $(this).toggleClass("cmt_btn_op");
            $("#bo_vc").toggle();
        });
    });
</script>