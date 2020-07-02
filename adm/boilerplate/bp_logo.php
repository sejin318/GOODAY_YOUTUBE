<?php
$sub_menu = "800101";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

//테이블 체크
if (ASKDB::exsit_table(BP_LOGO_TABLE) == false) {
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}

//수정
if ($w == 'u' && $idx) {
    $sql = "SELECT * from `" . BP_LOGO_TABLE . "` where `lm_idx` = '{$idx}'";
    $_logo = sql_fetch($sql);
}

$g5['title'] = 'Boilerplate  테마 로고 설정';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">', 100);
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/jqueryui/jquery-ui.min.css">', 100);
add_javascript("<script src='" . BP_ASSETS_URL . "/jqueryui/jquery-ui.min.js'></script>", 100);
?>
<script>
    $(function() {
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $('.reset-date').click(function() {
            $(".datepicker").val('');
        });
    });
</script>
<div class="jumbotron p-5">
    <h1>사이트 로고</h1>
    <p class="lead">
        특정 기간별 사이트 로고를 지정할 수 있습니다. 로고를 지정하지 않으면 테마-기본설정 ->사이트 로고 이미지 설정이 출력 됩니다.
    </p>
</div>
<?php echo bp_display_message(); ?>
<div class="page-add-wrap frm-wrap">
    <form name="bp_logoform" action="./bp_logo.update.php" id="bp_logoform" method="post" enctype="multipart/form-data" onsubmit="return bp_submit(this);">
        <input type="hidden" name="token" value="" id="token">
        <input type="hidden" name='idx' value="<?php echo $_logo['lm_idx'] ?>" />
        <input type="hidden" name='w' value="<?php echo $w ?>" />
        <div class='frm-group'>
            <label class='frm-label'><span>로고 이미지 ALT</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="lm_alt" value="<?php echo $_logo['lm_alt'] ?>" required class="frm-input required" />
                    <div class="alert alert-info">
                        로고 이미지의 ALT 값을 입력하세요.
                    </div>
                </div>
            </div>
        </div>

        <div class='frm-group'>
            <label class='frm-label'><span>로고 링크</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="lm_link" value="<?php echo $_logo['lm_link'] ?>" required class="frm-input required" />
                    <div class="alert alert-info">
                        로고 이미지 링크를 설정하세요. 이벤트 로고일 경우 이벤트 페이지로 연결하세요.
                    </div>
                </div>
            </div>
        </div>

        <div class='frm-group'>
            <label class='frm-label'><span>로고 이미지</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="file" name="lm_file" value="<?php echo $_logo['lm_file'] ?>" <?php echo $w != 'u' ? "required" : "" ?> class="<?php echo $w != 'u' ? "required" : "" ?> frm-input bss_image" />
                    <div class="alert alert-info">
                        로고 이미지를 등록하세요. width는 110px ~ 200px 사이가 좋습니다. 높이는 40px에 최적화 되어 있습니다.
                    </div>
                    <?php
                    if ($_logo['lm_file']) {
                        echo "<div class='image-wrap bg-dark p-2'>";
                        $img_tag = "<img src='" . BP_FILE_URL . "/{$_logo['lm_file']}' class='bp_logo'>";
                        echo "<a href='" . BP_FILE_URL . "/{$_logo['lm_file']}' target='_blank'>{$img_tag}</a><br/>";
                        echo "</div>";
                        echo "<label><input type='checkbox' name='lm_file_delete' value='{$_logo['lm_file']}' class='lm_file_delete'> <i class=\"fa fa-trash\" aria-hidden=\"true\"></i> 삭제 </label>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>기간설정</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="lm_startday" value="<?php echo $_logo['lm_startday'] ?>" class="frm-input w-25 required datepicker" placeholder="시작일 <?php echo G5_TIME_YMD ?>" required autocomplete="off" readonly> ~
                    <input type="text" name="lm_endday" value="<?php echo $_logo['lm_endday'] ?>" class="frm-input w-25 required datepicker" placeholder="종료일 <?php echo date('Y-m-d', strtotime(G5_TIME_YMD  . " +1 week")) ?>" required autocomplete="off" readonly>
                    <button type="button" class="reset-date btn btn-secondary btn-sm">재설정</button>
                    <div class="alert alert-info">
                        지정된 기간에만 출력할 수 있습니다. 시작일 ~ 종료일을 입력하세요. <?php echo G5_TIME_YMD ?>과 같은 형식으로 입력하세요. 미입력시 항상 출력됩니다.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>정렬</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="lm_order" value="<?php echo $_logo['lm_order'] ?>" class="frm-input w-25" placeholder="100" />
                    <div class="alert alert-info">
                        기간이 중복될 경우 작은 숫자가 먼저 출력 됩니다.
                    </div>
                </div>
            </div>
        </div>
        <div class="btn_fixed_top btn_confirm">
            <?php if ($w == 'u') {
                echo "<a href='./bp_logo.php' class='btn btn-secondary'>신규등록</a>";
            } ?>
            <input type="submit" value="<?php echo $w == 'u' ? "수정하기" : "신규등록"; ?>" class="btn_submit btn btn-primary" accesskey="s">
        </div>
    </form>
    <?php
    $sql = "SELECT * from `" . BP_LOGO_TABLE . "` order by lm_idx";
    $result = sql_query($sql);
    ?>
    <div class="logo-list-wrap">
        <h2 class="page-title mt-4 mb-2">등록된 로고 목록</h2>
        <table class="table table-bordered table-dark">
            <thead class="thead-dark">
                <tr>
                    <th>로고</th>
                    <th>ALT</th>
                    <th>링크</th>
                    <th>기간</th>
                    <th>순서</th>
                    <th>관리</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    echo "<tr>";
                    echo "<td class='text-center'><img src='" . BP_FILE_URL . "/{$row['lm_file']}' class='bp_logo'></td>";
                    echo "<td>{$row['lm_alt']}</td>";
                    echo "<td>{$row['lm_link']}</td>";
                    echo "<td>{$row['lm_startday']} ~ {$row['lm_endday']}</td>";
                    echo "<td>{$row['lm_order']}</td>";
                    echo "<td><a href='./bp_logo.php?w=u&idx={$row['lm_idx']}' class='btn btn-secondary'><i class='fa fa-pencil' aria-hidden='true'></i></a> <a href='./bp_logo.update.php?w=de&idx={$row['lm_idx']}' class='delete-item btn btn-danger'><i class='fa fa-trash-o' aria-hidden='true'></i></a></td>";
                    echo "</tr>";
                }
                if ($i == 0) {
                    echo "<tr><td colspan='5'> <span class='empty'> 등록된 로고가 없습니다.</span></td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function() {
        //삭제 처리, 토큰 넘기기
        $(document).on("click", ".delete-item", function() {
            if (confirm('삭제하시겠습니까?')) {
                var token = get_ajax_token();

                if (!token) {
                    alert("토큰 정보가 올바르지 않습니다.");
                    return false;
                }
                var href = $(this).attr('href');
                $(this).attr('href', href + '&token=' + token);
                return true;
            } else {
                return false;
            }
        });
    });

    function bp_submit(f) {
        var regNum = /^[0-9]+$/;

        //이미지가 등록되면 삭제 체크한다.
        if (f.lm_file.files[0] != undefined) {
            if (f.lm_file.files[0].name && f.lm_file) {
                $('.lm_file_delete').attr('checked', true);
            }
        }

        //순서
        if (regNum.test(f.lm_order.value) == false && f.lm_order.value != '') {
            alert('정렬 값은 숫자만 입력하세요.');
            return false;
        }

        if ((f.lm_startday.value != '' && f.lm_endday.value == '') || (f.lm_startday.value == '' && f.lm_endday.value != '')) {
            alert('기간은 시작날짜 및 종료 날짜를 모두 입력해야 합니다.');
            return false;
        }

        //기간설정 - 둘다 입력시
        if (f.lm_startday.value != '' && f.lm_endday.value != '') {
            var startDate = f.lm_startday.value;
            var startDateArr = startDate.split('-');

            var endDate = f.lm_endday.value;
            var endDateArr = endDate.split('-');

            var startDateCompare = new Date(startDateArr[0], parseInt(startDateArr[1]) - 1, startDateArr[2]);
            var endDateCompare = new Date(endDateArr[0], parseInt(endDateArr[1]) - 1, endDateArr[2]);

            if (startDateCompare.getTime() > endDateCompare.getTime()) {
                alert("시작날짜와 종료날짜를 확인해 주세요.");
                return false;
            }
        }

        f.action = "./bp_logo.update.php";
        return true;
    }
</script>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
