<?php
$sub_menu = "800221";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

if (ASKDB::exsit_table(AT_REPORT_SANCTION_TABLE) == false) {
    //테마 설치 후 이용하세요.
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}

$g5['title'] = '회원신고 처리';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">', 100);
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/jqueryui/jquery-ui.min.css">', 100);
add_javascript("<script src='" . BP_ASSETS_URL . "/jqueryui/jquery-ui.min.js'></script>", 100);
$_data['report'] = array();

//관리자 등록이 아닐경우 신고 불러옴
if (!$newitem) {
    //신고 데이터 가져오기
    $_data['report'] = DB::get_report(Asktools::xss_clean($idx));
}

//신고건 수정
if ($_GET['w'] == 'u' && $_data['report']['ar_sanction_idx']) {
    $report_sanction = DB::get_report_sanction($_data['report']['ar_sanction_idx']);
    $_data['report'] = array_merge($_data['report'], (array) $report_sanction);
} elseif ($_GET['w'] == 'u' && !$_data['report']['ar_sanction_idx']) {
    //관리자가 직접 등록한 신고건
    $_data['report'] = DB::get_report_sanction($_GET['idx']);
}

$report = $_data['report'];

//데이터 없을경우 처리
if (!$_data['report'] || count($_data['report']) === 0) {
    alert("처리할 데이터가 없습니다.", './mb_report_list.php');
    exit;
} else {
    //아이디 읽기 전용 처리
    $_data['readonly'] = "readonly";
}

?>
<div class="jumbotron p-5">
    <h1>회원 신고 처리</h1>
    <p class="lead">
        회원이 신고한 내역을 처리합니다.
    </p>
</div>

<div class='report-sanction-wrap'>

    <div class=''>
        <div class='contents-box'>
            <h2 class="frm-head"><?php echo $g5['title'] ?></h2>
            <div class="alert alert-info">
                &middot; 글쓰기 차단된 회원은 1:1 문의만 가능합니다.<br />
                &middot; 쪽지 차단 회원은 쪽지 읽기 및 삭제만 가능합니다.<br />
                &middot; 게시물은 신고처리 후 직접 삭제해야 합니다.<br />
                &middot; 사유불충분은 쪽지를 발송하지 않습니다.
            </div>

            <?php if ($report['ar_idx']) { ?>
                <div class="report_info">
                    <table class="table table-bordered">
                        <caption>신고내용</caption>
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    신고자
                                </th>
                                <th>
                                    피신고자
                                </th>
                                <th>
                                    형태
                                </th>
                                <th>
                                    사유
                                </th>
                                <th>
                                    시간
                                </th>
                                <th>
                                    IP
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <a href="<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&mb_id=<?php echo $report['ar_reporter_id'] ?>" target="_blank"><?php echo $report['ar_reporter_id'] ?> <i class="fa fa-external-link" aria-hidden="true"></i></a>
                                </td>
                                <td>
                                    <a href="<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&mb_id=<?php echo $report['ar_mb_id'] ?>" target="_blank"><?php echo $report['ar_mb_id'] ?> <i class="fa fa-external-link" aria-hidden="true"></i></a>
                                </td>
                                <td>
                                    <?php if ($report['ar_type'] == 'board') { ?>
                                        <a href='<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $report['ar_bo_table'] ?>&amp;wr_id=<?php echo $report['ar_wr_id'] ?>' target='_blank'>게시물<i class="fa fa-external-link" aria-hidden="true"></i></a>
                                    <?php } else { ?>
                                        메모
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php echo $report['ar_reason'] ?>
                                </td>
                                <td>
                                    <?php echo $report['ar_datetime'] ?>
                                </td>
                                <td>
                                    <?php echo $report['ipaddress'] ?>
                                </td>
                            </tr>
                        </tbody>

                        <?php if ($report['ar_type'] == 'memo') { ?>

                            <thead>
                                <tr>
                                    <th colspan="6">
                                        쪽지내용
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">
                                        <?php echo $report['ar_memo'] ?>
                                    </td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>
            <hr />
            <form action='./mb_report_sanction.update.php' method="post" class="form-horizontal report_form">
                <input type="hidden" name="token" value="" id="token">
                <input type="hidden" name="new" value="<?php $new ?>" />
                <input type="hidden" name="newitem" value="<?php $newitem ?>" />
                <input type="hidden" name="w" value="<?php echo $w ?>" />
                <input type="hidden" name="ar_idx" value="<?php echo $report['ar_idx'] ?>" />
                <input type="hidden" name="as_idx" value="<?php echo $report['as_idx'] ?>" />
                <input type="hidden" name="as_reporter_id" value="<?php echo $report['ar_reporter_id'] ?>">
                <input type="hidden" name="page" value="<?php echo $page ?>" />
                <input type="hidden" name="list" value="<?php echo $list ?>" />
                <div class="form-group">
                    <label for="" class="control-label">피신고자</label>
                    <div class="">
                        <?php
                        if ($report['ar_mb_id']) {
                            $mb_id = $report['ar_mb_id'];
                        } else {
                            $mb_id = $report['as_mb_id'];
                        }
                        ?>
                        <input type="text" class="form-control w-25" name="as_mb_id" value="<?php echo $mb_id ?>" {{readonly}} placeholder="피신고자 회원아이디">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">처리방법</label>
                    <div class=" radio_list">

                        <label>
                            <input type="radio" name="as_type" value="memo" <?php echo $report['as_type'] == 'memo' ? "checked" : ""; ?>> 쪽지 차단
                        </label>
                        <label>
                            <input type="radio" name="as_type" value="write" <?php echo $report['as_type'] == 'write' ? "checked" : ""; ?>> 글쓰기(댓글포함) 차단
                        </label>
                        <label>
                            <input type="radio" name="as_type" value="all" <?php echo $report['as_type'] == 'all' ? "checked" : ""; ?>> 모두 차단
                        </label>
                        <label>
                            <input type="radio" name="as_type" value="reject" <?php echo $report['as_type'] == 'reject' ? "checked" : ""; ?>> 사유불충분
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">회원메세지</label>
                    <div class="">
                        <textarea name="as_reason" class="form-control" rows="6" placeholder="피신고자에게 발송될 쪽지 및 쪽지,글쓰기 실행시 출력될 메세지"><?php echo $report['as_reason'] ?></textarea>
                        <p class="text text-info">
                            &middot; 예) 홍보성 게시물 등록으로 인해 7일간 글쓰기가 차단되었습니다.
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">메모</label>
                    <div class="">
                        <textarea name="as_memo" class="form-control" rows="6" placeholder="신고처리에 대한 메모 - 관리자 전용"><?php echo $report['as_memo'] ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">차단시작일 ~ 차단마지막일</label>
                    <div class="frm-wrap">
                        <input type="text" name="as_start_day" value="<?php echo $report['as_start_day'] ?>" class="frm-input w-25 datepicker" autocomplete="off" placeholder="지정일부터 차단됨" />
                        ~
                        <input type="text" name="as_end_day" value="<?php echo $report['as_end_day'] ?>" class="frm-input w-25 datepicker" autocomplete="off" placeholder="지정일까지 차단됨" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">쪽지발송</label>
                    <div class=" radio_list">
                        <label>
                            <input type="checkbox" name="send_memo" value="1" <?php echo $report['send_memo'] ? "checked" : ""; ?> {{send_memo_disable}}> 처리결과 쪽지 발송(신고자, 피신고자 모두에게 발송)
                        </label>
                    </div>
                </div>

                <div class="btn_fixed_top btn_confirm">
                    <input type="submit" value="확인" class="btn_submit btn btn-primary" accesskey="s">
                </div>
            </form>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('.report_form').submit(function() {
            if ($('input[name=as_mb_id]').val() === '') {
                alert('피신고자 아이디를 입력하세요.');
                return false;
            }
            //처리방법
            var as_type = $('input[name=as_type]:checked').val();
            if (as_type === undefined) {
                alert('처리방법을 선택하세요.');
                return false;
            }

            //사유불충분은 나머지 데이터 저장하지 않아도 저장되게.
            if (as_type === 'reject') {
                return true;
            }

            //회원메세지
            var as_reason = $('textarea[name=as_reason]').val();
            if (as_reason === '' || as_reason.length < 10) {
                alert('회원메세지를 입력하세요. 10자 이상 입력해야 합니다.');
                return false;
            }

            //날짜 검사
            var startDay = $('input[name=as_start_day]').val();
            var endDay = $('input[name=as_end_day]').val();
            if (!startDay) {
                alert('시작날짜를 입력하세요.');
                $('input[name=as_start_day]').addClass('form-input-error');
                return false;
            }
            if (!endDay) {
                alert('종료날짜를 입력하세요.');
                $('input[name=as_end_day]').addClass('form-input-error');
                return false;
            }

            //날짜 비교 
            var toDay = '<?php echo G5_TIME_YMD ?>';
            var toDayDateArr = toDay.split('-');

            var startDate = startDay;
            var startDateArr = startDate.split('-');

            var endDate = endDay;
            var endDateArr = endDate.split('-');

            var startDateCompare = new Date(startDateArr[0], startDateArr[1], startDateArr[2]);
            var endDateCompare = new Date(endDateArr[0], endDateArr[1], endDateArr[2]);
            var toDayCompare = new Date(toDayDateArr[0], toDayDateArr[1], toDayDateArr[2]);

            if (startDateCompare.getTime() > endDateCompare.getTime()) {
                alert("시작날짜와 종료날짜를 확인해 주세요.");
                return false;
            }


            <?php if ($w != 'u') { ?>
                if (toDayCompare.getTime() > startDateCompare.getTime()) {
                    alert("시작날짜를 오늘보다 이전 날짜로 지정할 수 없습니다.");
                    return false;
                }

                if (toDayCompare.getTime() > endDateCompare.getTime()) {
                    alert("종료날짜를 오늘보다 이전 날짜로 지정할 수 없습니다.");
                    return false;
                }
            <?php } ?>
        });

    });
</script>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
