<?php

/** 
 * 파일 개별 포인트 다운로드
 * 다운받을때 항상 포인트 차감한다.
 */
include_once('./_common.php');

$no = Asktools::clean($no);
$bo_table = Asktools::clean($bo_table);
$wr_id = Asktools::clean($wr_id);

$download_url = G5_THEME_URL . "/bp_download.php?" . $_SERVER['QUERY_STRING'];
$write = ASKDB::get_article_info($bo_table, $wr_id);

// 다른곳에서 링크 거는것을 방지하기 위한 코드
if (!get_session('ss_view_' . $bo_table . '_' . $wr_id)) {
    alert('잘못된 접근입니다.');
    exit;
}

//비회원 차단
if ($is_guest) {
    alert('회원전용입니다.');
    exit;
}

//파일정보
$file = ASKDB::get_file($bo_table, $wr_id, $no);
if (!$file['bf_file']) {
    alert_close('파일 정보가 존재하지 않습니다.');
    exit;
}
// JavaScript 불가일 때
if ($js != 'on') {
    die('스크립트를 실행을 할 수 없습니다 ');
    exit;
}

if ($member['mb_level'] < $board['bo_download_level']) {
    $alert_msg = '다운로드 권한이 없습니다.';
    if ($member['mb_id']) {
        alert($alert_msg);
        exit;
    } else {
        alert($alert_msg . '\\n회원이시라면 로그인 후 이용해 보십시오.', G5_BBS_URL . '/login.php?wr_id=' . $wr_id . '&amp;' . $qstr . '&amp;url=' . urlencode(get_pretty_url($bo_table, $wr_id)));
        exit;
    }
}

$filepath = G5_DATA_PATH . '/file/' . $bo_table . '/' . $file['bf_file'];
$filepath = addslashes($filepath);
$file_exist_check = (!is_file($filepath) || !file_exists($filepath)) ? false : true;

if (false === run_replace('download_file_exist_check', $file_exist_check, $file)) {
    alert('파일이 존재하지 않습니다.');
    exit;
}

if (($write['mb_id'] && $write['mb_id'] == $member['mb_id']) || $is_admin) {
        //본인, 관리자 통과
    ;
} else if ($board['bo_download_level'] >= 1) {
    // 회원이상 다운로드가 가능하다면
    // 다운로드 포인트가 음수이고 회원의 포인트가 0 이거나 작다면
    if ($member['mb_point'] + $file['bf_download_point'] < 0) {
        alert('보유하신 포인트(' . number_format($member['mb_point']) . ')가 없거나 모자라서 다운로드(' . number_format($file['bf_download_point']) . ')가 불가합니다.\\n\\n포인트를 적립하신 후 다시 다운로드 해 주십시오.');
        exit;
    }
}
$timer = 15;
//컨텐츠 구매 목록에서 재구매인지 검사
$sql = "SELECT * from `" . BP_DOWNLOAD_TABLE . "` where `bd_mb_id` = '" . escape_trim($member['mb_id']) . "' and `bd_bo_table` = '{$bo_table}' and `bd_wr_id`='{$wr_id}' and `bd_bf_no`='{$no}'";
$down = sql_fetch($sql);
include_once(G5_THEME_PATH . '/head.php');
?>

<div class="jumbotron p-4 mb-3">
    <h1 class="display-5">다운로드</h1>
    <hr />
    <p class="lead">파일 다운로드시 <?php echo number_format($file['bf_download_point']) ?> 포인트가 필요합니다.</p>
</div>
<div class='download-wrap'>
    <?php if (!$down) { ?>
        <div class="alert alert-danger">
            <i class="fa fa-info-circle" aria-hidden="true"></i> 이미 구매한 콘텐츠를 다시 다운받을 경우 <a href='<?php echo BP_MYPAGE_URL ?>'>마이페이지</a> -><a href='<?php echo BP_MYPAGE_URL ?>/my_download.php'> 다운로드</a>을 이용하시면 포인트가 차감되지 않습니다.
            <?php if ($write['mb_id'] == $member['mb_id']) { ?>
                <br /><i class="fa fa-info-circle" aria-hidden="true"></i> 본인의 콘텐츠는 포인트 적립/차감없이 다운됩니다.
            <?php } ?>
        </div>
        <div class='d-flex justify-content-center p-5 flex-column text-center'>
            <h2 id='dl_cntdwn' class="p-4">
                <span class='download-counter'>다운로드 시작 <i class="fa fa-clock-o" aria-hidden="true"></i> <strong class='down-counter'><?php echo $timer ?></strong>초 남았습니다.</span>
                <a href="<?php echo $download_url ?>" data-download='false' class="btn btn-primary btn-lg content-download-btn d-none"> <i class="fa fa-download" aria-hidden="true"></i> <?php echo $file['bf_content'] ?> 다운로드</a>
            </h2>
            <div class='msg' id='download-message'>
                <div class='autodown-start-message'>
                    <i class="fa fa-info-circle" aria-hidden="true"></i> 파일 다운로드가 자동으로 시작됩니다. <button type="button" id="dl_downstop" class="btn btn-primary btn-sm">자동 다운로드를 중지</button> 하고 수동으로 다운로드 받으실 수 있습니다.
                </div>
                <div class='autodown-stop-message d-none'>
                    <i class="fa fa-info-circle" aria-hidden="true"></i> 파일 다운로드가 중지되었습니다. 파일을 다운받으시려면 위 다운로드 버튼을 눌러주세요.
                </div>
                <div class='alert alert-success autodown-complete-message d-none'>
                    <i class="fa fa-info-circle" aria-hidden="true"></i> 파일 다운이 완료되었습니다. 다시 다운받을 경우 <a href='<?php echo BP_MYPAGE_URL ?>'>마이페이지</a> -><a href='<?php echo BP_MYPAGE_URL ?>/my_download.php'> 다운로드</a>을 이용하세요.
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class='content-info'>
            <div class='alert alert-info'>
                <i class="fa fa-info-circle" aria-hidden="true"></i> 이미 구매한 콘텐츠 입니다. 재구매 하시려면 아래 재구매 다운로드 버튼을 클릭하세요.
            </div>
            <table class='table table-bordered text-center'>
                <thead class="thead-dark">
                    <tr>
                        <th>컨텐츠명</th>
                        <th>구매일시</th>
                        <th>다운로드</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $down['bd_content'] ?></td>
                        <td><?php echo $down['bd_datetime'] ?></td>
                        <td><a href='<?php echo BP_MYPAGE_URL ?>/my_download.php'>마이페이지</a></td>
                    </tr>
                </tbody>
            </table>
            <div class='text-center mt-5 mb-5'>
                <a href="<?php echo $download_url ?>" data-download='false' class="btn btn-info btn-lg resales"><?php echo $file['bf_content'] ?> - 다운로드(-<?php echo number_format($file['bf_download_point']) ?>Point) 받기</a>
            </div>
        </div>
    <?php } ?>
    <?php if ($write['wr_2']) {
        echo "<div class='alert alert-danger pt-4'>";
        echo "<h4 class='write-title'> <i class='fa fa-info' aria-hidden='true'></i> 라이센스 안내</h4>";
        echo "<hr/>";
        echo nl2br($write['wr_2']);
        echo '</div>';
    } ?>
    <div class='alert alert-success content-view'>
        <?php
        echo "<h3>" . $write['wr_subject'] . "</h3>";
        echo nl2br($write['wr_content']);
        ?>
    </div>
</div>
<script>
    $(function() {
        $('.resales').on('click', function() {
            var thisState = $(this).data('download');
            if (thisState == true) {
                alert('다운로드가 이미 진행되었습니다. \n다시 다운받으시려면 마이페이지->다운로드에서 포인트 차감 없이 다시 다운로드 하세요.');
                return false;
            }
            if (confirm('<?php echo number_format($file['bf_download_point']) ?>포인트가 차감됩니다. 재구매 다운로드를 진행하시겠습니까?')) {
                if (thisState == false) {
                    $(this).data('download', true);
                    $(this).text('다운로드완료').removeClass('btn-primary').addClass('btn-secondary');
                    return true;
                }
            } else {
                return false;
            }
        });

        $('.content-download-btn').on('click', function(e) {
            var thisState = $(this).data('download');
            if (thisState == false) {
                $(this).data('download', true);
                $(this).text('다운로드완료').removeClass('btn-primary').addClass('btn-secondary');
                return true;
            } else if (thisState == true) {
                alert('다운로드가 이미 진행되었습니다. \n다시 다운받으시려면 마이페이지->다운로드에서 포인트 차감 없이 다시 다운로드 하세요.');
                return false;
            }
        });

        <?php if (!$down) { ?>

            var count = <?php echo $timer ?>;
            var countdown = setInterval(timer, 1000);

            function timer() {
                $(".down-counter").html(count);
                if (count == 0) {
                    clearInterval(countdown);
                    window.location = "<?php echo $download_url ?>";
                    //다운로드 메세지
                    $('.autodown-start-message').addClass('d-none');
                    $('.download-counter').addClass('d-none');
                    $('.autodown-complete-message').removeClass('d-none');
                    $("#dl_cntdwn").find('.content-download-btn').removeClass('d-none').data('download', true).text('다운로드완료').removeClass('btn-primary').addClass('btn-secondary');;
                    return;
                }
                count--;
            }

            $("#dl_downstop").click(function() {
                clearInterval(countdown);
                //다운로드 메세지
                $('.autodown-start-message').addClass('d-none');
                $('.download-counter').addClass('d-none');
                $('.autodown-stop-message').removeClass('d-none');
                $("#dl_cntdwn").find('.content-download-btn').removeClass('d-none');
            });

            $(document).on("click", ".dl_link", function() {
                $("#dl_downstop").trigger("click");
            });

        <?php } ?>
    });
</script>

<?php
include_once(G5_THEME_PATH . '/tail.php');
