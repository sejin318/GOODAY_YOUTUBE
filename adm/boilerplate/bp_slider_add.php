<?php
$sub_menu = "800120";
include_once './_common.php';
include_once G5_LIB_PATH . '/thumbnail.lib.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

//테이블 체크
if (ASKDB::exsit_table(BP_SLIDER_LIST_TABLE) == false) {
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}
//수정
if ($w == 'u' && $idx) {
    $sql = "SELECT * from `" . BP_SLIDER_LIST_TABLE . "` where `bss_idx` = '{$idx}'";
    $_subpage = sql_fetch($sql);
    $parent_idx = $_subpage['bss_parent'];
}

//새 페이지 등록시 부모값이 없으면 이동
if (!$w && !$parent_idx) {
    alert('잘못된 접속입니다.', './bp_slider_list.php');
    exit;
}

$g5['title'] = 'Boilerplate  테마 슬라이더 페이지 추가';
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
<?php echo bp_display_message(); ?>

<div class="jumbotron p-5">
    <h1>슬라이더 페이지 등록</h1>
    <p class="lead">
        하위 페이지를 등록하세요. 항목별 도움말을 참고하세요.
    </p>
</div>
<div class="page-add-wrap frm-wrap">
    <form name="bp_addform" id="bp_addform" method="post" enctype="multipart/form-data" onsubmit="return bp_addsubmit(this);">
        <input type="hidden" name="token" value="" id="token">
        <input type="hidden" name='bss_parent' value="<?php echo $parent_idx ?>" />
        <?php if ($w == 'u' && $_subpage) { ?>
            <input type="hidden" name='bss_idx' value="<?php echo $_subpage['bss_idx'] ?>" />
        <?php } ?>
        <input type="hidden" name='w' value="<?php echo $w ?>" />
        <div class='frm-group'>
            <label class='frm-label'><span>페이지 이름</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bss_name" value="<?php echo $_subpage['bss_name'] ?>" required class="frm-input required" />
                    <div class="alert alert-info">
                        페이지의 용도를 알 수 있게 이름을 입력하세요.
                    </div>
                </div>
            </div>
        </div>

        <div class='frm-group'>
            <label class='frm-label'><span>Caption 제목</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bss_subject" value="<?php echo $_subpage['bss_subject'] ?>" class="frm-input" />
                    <div class="alert alert-info">
                        출력될 텍스트를 입력하세요.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>Caption 내용</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bss_content" value="<?php echo $_subpage['bss_content'] ?>" class="frm-input" />
                    <div class="alert alert-info">
                        출력될 텍스트를 입력하세요.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>링크</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bss_url" value="<?php echo $_subpage['bss_url'] ?>" class="frm-input" />
                    <div class="alert alert-info">
                        URL을 입력하세요. <br/>
                        swiper 스킨 사용시 유튜브 주소 입력시 유튜브 배경으로 플레이 됩니다.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>Class 지정</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bss_class" value="<?php echo $_subpage['bss_class'] ?>" class="frm-input" />
                    <div class="alert alert-info">
                        페이지에 class 를 지정 할 수 있습니다. 스타일 편집시 클래스를 선택하여 편집하면 페이지별 스타일을 손쉽게 지정 가능합니다.<br />
                        미리 선언된 스타일을 이용 할 수 있습니다. font-dark로 하면 글자가 검은색, font-light로 하면 글자가 흰색 계열로 됩니다.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>슬라이더 이미지</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="file" name="bss_image" value="<?php echo $_subpage['bss_image'] ?>" class="frm-input bss_image" />
                    <div class="alert alert-info">
                        슬라이더에 사용될 이미지를 등록하세요. 이미지는 비율이 같은 이미지를 등록하세요. 
                        <br/>
                        유튜브 등록시 커버이미지로 등록됩니다.
                    </div>
                    <?php
                    if ($_subpage['bss_image']) {
                        echo "<div class='image-wrap'>";
                        $img_tag = get_view_thumbnail("<img src='" . BP_SLIDERSAVE_URL . "/{$_subpage['bss_image']}' class='bss-image'>", 200);
                        echo "<a href='" . BP_SLIDERSAVE_URL . "/{$_subpage['bss_image']}' target='_blank'>{$img_tag}</a><br/>";
                        echo "<label><input type='checkbox' name='bss_image_delete' value='{$_subpage['bss_image']}' class='bss_image_delete'> <i class=\"fa fa-trash\" aria-hidden=\"true\"></i> 삭제 </label>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>정렬</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bss_order" value="<?php echo $_subpage['bss_order'] ?>" class="frm-input w-25" placeholder="100" />
                    <div class="alert alert-info">
                        작은 숫자가 먼저 출력됩니다. 숫자만 입력하세요.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>기간설정</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bss_startday" value="<?php echo $_subpage['bss_startday'] ?>" class="frm-input w-25 datepicker" placeholder="시작일 <?php echo G5_TIME_YMD ?>" autocomplete="off" readonly> ~
                    <input type="text" name="bss_endday" value="<?php echo $_subpage['bss_endday'] ?>" class="frm-input w-25 datepicker" placeholder="종료일 <?php echo date('Y-m-d', strtotime(G5_TIME_YMD  . " +1 week")) ?>" autocomplete="off" readonly>
                    <button type="button" class="reset-date btn btn-secondary btn-sm">재설정</button>
                    <div class="alert alert-info">
                        지정된 기간에만 출력할 수 있습니다. 시작일 ~ 종료일을 입력하세요. <?php echo G5_TIME_YMD ?>과 같은 형식으로 입력하세요. 미입력시 항상 출력됩니다.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>Interval 설정</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bss_interval" value="<?php echo $_subpage['bss_interval'] ?>" class="frm-input w-25" placeholder="3000 or 5000 or 10000" />
                    <div class="alert alert-info">
                        페이지를 보여줄 시간 설정, 1/1000초 단위로 입력하세요. 3초라면 3000 입력. 미입력시 기본 5초입니다.
                    </div>
                </div>
            </div>
        </div>

        <div class="btn_fixed_top btn_confirm">
            <?php if ($w == 'u' && $_subpage) { ?>
                <a href='./bp_slider.php?w=u&idx=<?php echo $_subpage['bss_parent'] ?>' class='btn btn-info'><i class="fa fa-list" aria-hidden="true"></i> 페이지 목록</a>
            <?php } ?>
            <input type="submit" value="확인" class="btn_submit btn btn-primary" accesskey="s">
        </div>
    </form>
</div>
<script>
    function bp_addsubmit(f) {

        var regNum = /^[0-9]+$/;

        //이미지가 등록되면 삭제 체크한다.
        if (f.bss_image.files[0] != undefined) {
            if (f.bss_image.files[0].name && f.bss_image_delete) {
                $('.bss_image_delete').attr('checked', true);
            }
        }

        //순서
        if (regNum.test(f.bss_order.value) == false && f.bss_order.value != '') {
            alert('정렬 값은 숫자만 입력하세요.');
            return false;
        }

        if ((f.bss_startday.value != '' && f.bss_endday.value == '') || (f.bss_startday.value == '' && f.bss_endday.value != '')) {
            alert('기간은 시작날짜 및 종료 날짜를 모두 입력해야 합니다.');
            return false;
        }

        //기간설정 - 둘다 입력시
        if (f.bss_startday.value != '' && f.bss_endday.value != '') {
            var startDate = f.bss_startday.value;
            var startDateArr = startDate.split('-');

            var endDate = f.bss_endday.value;
            var endDateArr = endDate.split('-');

            var startDateCompare = new Date(startDateArr[0], parseInt(startDateArr[1]) - 1, startDateArr[2]);
            var endDateCompare = new Date(endDateArr[0], parseInt(endDateArr[1]) - 1, endDateArr[2]);

            if (startDateCompare.getTime() > endDateCompare.getTime()) {
                alert("시작날짜와 종료날짜를 확인해 주세요.");
                return false;
            }
        }

        //인터벌
        if (regNum.test(f.bss_interval.value) == false && f.bss_interval.value != '') {
            alert('Interval 값은 숫자만 입력하세요.');
            return false;
        }

        f.action = "./bp_slider_add.update.php";
        return true;
    }
</script>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
