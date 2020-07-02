<?php
/**
 *  회원 메모 입력 폼
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
if (!$config['bp_member_memo']) {
    return;
}

if (!$is_member) {
    return;
}
//본인 게시물 패스~
if ($member['mb_id'] == $view['mb_id']) {
    return;
}
//본인쪽지 패스~
if ($member['mb_id'] == $mb['mb_id']) {
    return;
}

if($view){
    $target_mb_id = $view['mb_id'];
    $name = $view['wr_name'];
}
if($memo){
    $target_mb_id = $mb['mb_id'];
    $name = $mb['mb_nick'];
}

//메모 가져오기
$member_memo = DB::get_member_memo($member['mb_id'], $target_mb_id);
?>
<div class='btn-memo d-flex'>
    <!-- 메모 버튼 -->
    <button type="button" class="btn btn-link btn-sm ml-auto mb-2" data-toggle="modal" data-target="#staticBackdrop">
        <span class='badge badge-info'><i class="fa fa-envelope-open" aria-hidden="true"></i> 회원메모 <span class='memo-text'><?php echo $member_memo['bm_memo'] ? "- {$member_memo['bm_memo']}" : " - 없음";  ?></span></span>
    </button>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">회원메모</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class='alert alert-info'>
                    <i class="fa fa-info" aria-hidden="true"></i> 회원 메모는 게시글 작성자 아래에 표시됩니다.
                </div>
                <div class='member-memo-wrap mt-2 mb-2 position-relative'>
                    <div class="input-group member-memo-form">
                        <div class='input-group-prepend'><span class='input-group-text'><i class="fa fa-envelope-open-o" aria-hidden="true"></i></span></div>
                        <input type="text" name="memo" id="memo-content" class="form-control memo-content" value='<?php echo $member_memo['bm_memo'] ?>' placeholder="<?php echo $name ?> 회원님에 대한 메모를 입력하세요. 메모작성자 본인만 볼 수 있습니다." aria-describedby="sufixId">
                        <input type='hidden' name='token' id='memo_token' />
                        <button type='button' class='btn btn-danger memo-delete'><i class='fa fa-trash-o' aria-hidden='true'></i></button>
                        <button type='button' class="btn btn-primary memo-save"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                    </div>
                    <div class="toast memo-save-result position-absolute" data-delay='3000' role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="mr-auto"><i class="fa fa-info-circle" aria-hidden="true"></i> Message</strong>
                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body">
                            <span class='return-message'></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        <?php
        if ($member_memo) {
            echo "$('.memo-delete').show();";
        } else {
            echo "$('.memo-delete').hide();";
        }
        ?>
        //메모 저장
        $(document).on("click", '.memo-save', function() {
            // 토큰 넘기기
            var token = _get_delete_token();
            if (!token) {
                alert("토큰 정보가 올바르지 않습니다.");
                return false;
            } else {
                $('#memo_token').val(token);
            }
            var memo = $('.memo-content').val();
            if (memo == '') {
                alert('회원 메모 내용을 입력하세요.');
                return false;
            }
            var fd = new FormData();
            fd.append('mb_id', '<?php echo $target_mb_id ?>');
            fd.append('token', token);
            fd.append('memo', memo);
            $.ajax({
                url: '<?php echo G5_PLUGIN_URL . DIRECTORY_SEPARATOR . 'ask-member' . DIRECTORY_SEPARATOR . 'user_memo.update.php'; ?>',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(r) {
                    $('.return-message').text('회원메모가 저장되었습니다.');
                    $('.memo-save-result').toast('show');
                    $('.memo-delete').show();
                    $('.memo-text').text(r.memo);
                },
            }); //ajax
        });
        //메모 삭제
        $(document).on("click", '.memo-delete', function() {
            // 토큰 넘기기
            var token = _get_delete_token();
            if (!token) {
                alert("토큰 정보가 올바르지 않습니다.");
                return false;
            } else {
                $('#memo_token').val(token);
            }
            var memo = $('.memo-content').val();
            var fd = new FormData();
            fd.append('mb_id', '<?php echo $target_mb_id ?>');
            fd.append('token', token);
            fd.append('mode', 'delete');
            $.ajax({
                url: '<?php echo G5_PLUGIN_URL . DIRECTORY_SEPARATOR . 'ask-member' . DIRECTORY_SEPARATOR . 'user_memo.update.php'; ?>',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(r) {
                    $('.memo-content').val('');
                    $('.return-message').text('회원메모가 삭제되었습니다.');
                    $('.memo-save-result').toast('show');
                    $('.memo-delete').hide();
                    $('.memo-text').text('- 없음');
                },
            }); //ajax
        });
    });
</script>