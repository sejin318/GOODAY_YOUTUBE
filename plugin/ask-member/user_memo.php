<?php
include_once "./_common.php";
/**
 *  회원 메모 입력 폼
 */

if (!$is_member) {
    alert_close('로그인 후 이용하세요.');
}

if (!$config['bp_member_memo']) {
    exit;
}

if ($_GET['mb_id']) {
    //메모 가져오기
    $member_memo = DB::get_member_memo($member['mb_id'], Asktools::xss_clean($mb_id));
} else {
    alert_close('Error');
    exit;
}
include_once G5_THEME_PATH . '/head.sub.php';
?>
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">회원 메모하기</a>
</nav>
<div class="container">
    <div class='member-memo mt-3'>
        <div class='alert alert-info'>
            <i class="fa fa-envelope-open" aria-hidden="true"></i> <span class='memo-text'><?php echo $member_memo['bm_memo'] ? "{$member_memo['bm_memo']}" : "없음";  ?></span>
        </div>

    </div>
    <div class='member-memo-wrap mt-2 mb-2 position-relative'>
        <div class="input-group member-memo-form">
            <div class='input-group-prepend'><span class='input-group-text'><i class="fa fa-envelope-open-o" aria-hidden="true"></i></span></div>
            <input type="text" name="memo" id="memo-content" class="form-control memo-content" value='<?php echo $member_memo['bm_memo'] ?>' placeholder="<?php echo $view['wr_name'] ?> 회원님에 대한 메모를 입력하세요. 메모작성자 본인만 볼 수 있습니다." aria-describedby="sufixId">
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
        <button type="button" class="btn btn-danger mt-5 pull-right close-window">닫기</button>
    </div>

    <script>
        $(function() {
            $('.close-window').click(function(){
                opener.location.reload();
                window.close();
            });
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
                fd.append('mb_id', '<?php echo Asktools::xss_clean($mb_id); ?>');
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
                fd.append('mb_id', '<?php echo Asktools::xss_clean($mb_id); ?>');
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
                        $('.memo-text').text('없음');
                    },
                }); //ajax
            });
        });
    </script>
</div>
<?php
include_once G5_THEME_PATH . '/tail.sub.php';
