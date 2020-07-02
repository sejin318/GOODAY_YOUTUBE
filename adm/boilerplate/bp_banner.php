<?php
$sub_menu = "800115";
include_once './_common.php';
include_once G5_LIB_PATH . '/thumbnail.lib.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

//테이블 체크
if (ASKDB::exsit_table(BP_BANNER_TABLE) == false) {
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}
//수정
if ($w == 'u' && $idx) {
    $sql = "SELECT * from `" . BP_BANNER_TABLE . "` where `bb_idx` = '{$idx}'";
    $_banner = sql_fetch($sql);
}

$g5['title'] = 'Boilerplate  테마 배너 등록';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">', 100);
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/jqueryui/jquery-ui.min.css">', 100);
add_javascript("<script src='" . BP_ASSETS_URL . "/jqueryui/jquery-ui.min.js'></script>", 100);
add_javascript("<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js'></script>", 110);
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
    <h2>배너 등록</h2>
    <p class='mb-2 lead'>
        &middot; 일반페이지 및 게시판 목록, 내용에 배너를 출 력할 수 있습니다.<br />
        &middot;  배너 실행용 HOOK은  theme/boilerplate/_lib/_boilerplate.constant.php 파일에 정의되어 있습니다. <br />
        &middot; define('BP_BANNER_HOOK', array('메인상단배너', '메인하단배너', '게시판목록상단', '게시판목록하단', '게시판내용상단', '게시판내용하단'));에 배열로 선언되어 있습니다.
        <br /><br />
        &middot; 배너위치 추가는 위 배열에 위치명을 추가 후 출력될 페이지에  &lt?php run_event('배너위치명', '배너위치명'); ?&gt; 을 추가해야 합니다.<br/>
        &middot; 입력된 태그 기준으로 출력이 가능합니다.&lt;?php echo bp_tag_banner('태그명');?&gt; 을 이용하세요. Tag 입력 란에 태그명이 포함되어 있는 배너를 모두 출력합니다. 
    </p>

    <?php if ($w == 'u') {
        echo "<p class='mt-2 lead'>위치에 상관없이 이 배너({$_banner['bb_name']})를 출력하려면 아래와 같이 사용하세요.<br/>&lt;?php echo bp_banner({$idx});?&gt;</p>";
    }
    echo "<h2 class='page-title mt-3'>배너 미리보기</h2>";
    echo "<hr/>";
    echo bp_banner($idx , true);
    ?>
</div>
<?php echo bp_display_message(); ?>
<div class="page-add-wrap frm-wrap">
    <form name="bp_bannerform" id="bp_bannerform" method="post" enctype="multipart/form-data" onsubmit="return form_submit(this);">
        <input type="hidden" name="token" value="" id="token">
        <?php if ($w == 'u' && $_banner) { ?>
            <input type="hidden" name='bb_idx' value="<?php echo $_banner['bb_idx'] ?>" />
        <?php } ?>
        <input type="hidden" name='w' value="<?php echo $w ?>" />
        <div class='frm-group'>
            <label class='frm-label'><span>배너 이름</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bb_name" value="<?php echo $_banner['bb_name'] ?>" class="frm-input" />
                    <div class="alert alert-info">
                        텍트스 배너일 경우 텍스트로 출력되며 이미지 배너일 경우 ALT 값으로 출력 됩니다.
                    </div>
                </div>
            </div>
        </div>

        <div class='frm-group'>
            <label class='frm-label'><span>배너위치</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <select name="bb_area" class="frm-input w-25">
                        <option value="">--위치선택--</option>
                        <?php
                        foreach (BP_BANNER_HOOK as $hooks) {
                            $selected = "";
                            if ($_banner['bb_area'] == $hooks) {
                                $selected = "selected";
                            }
                            echo "<option value='{$hooks}' {$selected}>{$hooks}</option>";
                        }
                        ?>
                    </select>
                    <div class="alert alert-info">
                        출력될 배너의 위치를 지정하세요. 개별 출력 또는 Tag로 선택하여 출력을 한다면 선택하지 않아도 됩니다.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>배너형식</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <label><input type="radio" name="bb_type" value="text" <?php echo $_banner['bb_type'] == 'text' ? "checked" : ""; ?> />TEXT Banner</label>
                    <label><input type="radio" name="bb_type" value="image" <?php echo $_banner['bb_type'] == 'image' ? "checked" : ""; ?> />Image Banner</label>
                    <label><input type="radio" name="bb_type" value="html" <?php echo $_banner['bb_type'] == 'html' ? "checked" : ""; ?> />HTML, Adsense Banner</label>

                    <div class="alert alert-info">
                        배너의 형식을 선택하세요. 텍스트링크 또는 이미지, HTML(Adsense)중 하나를 필히 선택하세요.
                    </div>
                </div>
            </div>
            <script>
                $(function() {
                    var editor = ace.edit('bb_html');
                    var textarea = $('textarea[name="bb_html"]');
                    editor.getSession().on("change", function() {
                        textarea.val(editor.getSession().getValue());
                    });
                    editor.session.setMode("ace/mode/php");
                    editor.setReadOnly(false); //읽기전용
                    editor.resize(true);
                    setTimeout(function() {
                        $('input[name=bb_type]:checked').trigger('click');
                    }, 200);

                    $('input[name=bb_type]').click(function() {
                        var $set_type = $('input[name=bb_type]:checked').val();
                        if ($set_type !== undefined || $load_type !== '') {
                            if ($set_type == 'text') {
                                $('.field-url').removeClass('d-none');
                                $('.field-image').addClass('d-none');
                                $('.field-html').addClass('d-none');
                            }
                            if ($set_type == 'image') {
                                $('.field-url').removeClass('d-none');
                                $('.field-image').removeClass('d-none');
                                $('.field-html').addClass('d-none');
                            }
                            if ($set_type == 'html') {
                                $('.field-url').addClass('d-none');
                                $('.field-image').addClass('d-none');
                                $('.field-html').removeClass('d-none');
                            }
                        }
                    });
                });
            </script>
        </div>

        <div class='frm-group field-image d-none'>
            <label class='frm-label'><span>배너이미지</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="file" name="bb_image" value="<?php echo $_banner['bb_image'] ?>" class="frm-input bb_image" />
                    <div class="alert alert-info">
                        배너 이미지는 jpg, gif. png 파일을 등록하세요.
                    </div>
                    <?php
                    if ($_banner['bb_image']) {
                        echo "<input type='hidden' name='bb_org_image' value='{$_banner['bb_image']}'>";
                        echo "<div class='image-wrap'>";
                        $img_tag = get_view_thumbnail("<img src='" . BP_FILE_DIR . "/{$_banner['bb_image']}' class='bb_image'>", 200);
                        echo "<a href='" . BP_FILE_URL . "/{$_banner['bb_image']}' target='_blank'>{$img_tag}</a><br/>";
                        echo "<label><input type='checkbox' name='bb_image_delete' value='{$_banner['bb_image']}' class='bb_image_delete'> <i class=\"fa fa-trash\" aria-hidden=\"true\"></i> 삭제 </label>";
                        echo "</div>";
                    } else {
                        echo "<input type='hidden' name='bb_org_image' value=''>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class='frm-group field-url d-none'>
            <label class='frm-label'><span>링크 URL</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bb_url" value="<?php echo $_banner['bb_url'] ?>" class="frm-input" />
                    <div class="alert alert-info">
                        배너 링크될 주소, http 또는 https 를 포함한 전체 주소를 입력하세요.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group field-html d-none'>
            <label class='frm-label'><span>HTML, Adsense</span></label>
            <div class='frm-control'>
                <div class='frm-cont position-relative'>
                    <div class='code-editor' id='bb_html'><?php echo htmlspecialchars($_banner['bb_html']) ?></div>
                    <textarea name='bb_html' class='frm-input d-none' placeholder="HTML 또는 Adsense 코드를 삽입하세요."><?php echo $_banner['bb_html'] ?></textarea>
                    <div class="alert alert-info">
                        HTML 또는 Adsense 입력
                        <?php if ($w == 'u' && $_banner['bb_type'] == 'html') { ?>
                            <br />
                            HTML 배너의 링크 히트를 업데이트 하려면 미리 HTML 배너를 등록 후 링크를 아래와 같이 수정 하세요.<br />
                            &lt;a href='<?php echo G5_PLUGIN_URL ?>/ask-ads/links.php?idx=<?php echo $idx ?>&url=https://boilerplate.kr' target='_blank'&gt; 링크 &lt;/a&gt;
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>Tag 입력</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bb_tag" value="<?php echo $_banner['bb_tag'] ?>" class="frm-input" placeholder="분류를 , 로 구분해서 입력" />
                    <div class="alert alert-info">
                        입력한 단어로 배너를 묶어서 출력 가능합니다.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>기간설정</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="bb_startday" value="<?php echo $_banner['bb_startday'] ?>" class="frm-input w-25 datepicker" placeholder="시작일 <?php echo G5_TIME_YMD ?>" autocomplete="off" readonly> ~
                    <input type="text" name="bb_endday" value="<?php echo $_banner['bb_endday'] ?>" class="frm-input w-25 datepicker" placeholder="종료일 <?php echo date('Y-m-d', strtotime(G5_TIME_YMD  . " +1 week")) ?>" autocomplete="off" readonly>
                    <button type="button" class="reset-date btn btn-secondary btn-sm">재설정</button>
                    <div class="alert alert-info">
                        지정된 기간에만 출력할 수 있습니다. 시작일 ~ 종료일을 입력하세요. <?php echo G5_TIME_YMD ?>과 같은 형식으로 입력하세요. 미입력시 항상 출력됩니다.
                    </div>
                </div>
            </div>
        </div>

        <div class="btn_fixed_top btn_confirm">
            <?php
            if ($w == 'u') {
                echo "<a href='./bp_banner.php' class='btn btn-success mr-1'><i class='fa fa-plus' aria-hidden='true'></i> 신규등록</a>";
                echo "<a href='./bp_banner_list.php' class='btn btn-secondary'><i class='fa fa-list' aria-hidden='true'></i> 목록</a>";
            }
            ?>
            <input type="submit" value="확인" class="btn_submit btn btn-primary" accesskey="s">
        </div>
    </form>
</div>
<script>
    function form_submit(f) {
        if (f.bb_name.value == '') {
            alert('배너 이름을 입력하세요.');
            return false;
        }
        /*
        if (f.bb_area.value == '') {
            alert('배너 위치를 선택하세요.');
            return false;
        }*/

        //배너형식 체크
        var $bb_type = $('input[name=bb_type]:checked').val();
        if ($bb_type === undefined) {
            alert('배너 형식을 선택하세요.');
            return false;
        }

        //텍스트 배너
        if ($bb_type == 'text') {
            if (f.bb_url.value == '') {
                alert('URL을 입력하세요.');
                return false;
            }
        }
        //이미지 배너
        if ($bb_type == 'image') {
            if (f.bb_url.value == '') {
                alert('URL을 입력하세요.');
                return false;
            }
            if (f.bb_image.files[0] === undefined && f.bb_org_image.value == '') {
                alert('배너 이미지를 등록하세요.');
                return false;
            }
        }

        //HTML, Adsense
        if ($bb_type == 'html') {
            if (f.bb_html.value == '') {
                alert('HTML, Adsense 내용을 입력하세요.');
                return false;
            }
        }
        //이미지가 등록되면 삭제 체크한다.
        if (f.bb_image.files[0] != undefined && f.bb_org_image.value != '') {
            if (f.bb_image.files[0].name && f.bb_image_delete) {
                $('.bb_image_delete').attr('checked', true);
            }
        }

        if ((f.bb_startday.value != '' && f.bb_endday.value == '') || (f.bb_startday.value == '' && f.bb_endday.value != '')) {
            alert('기간은 시작날짜 및 종료 날짜를 모두 입력해야 합니다.');
            return false;
        }

        //기간설정 - 둘다 입력시
        if (f.bb_startday.value != '' && f.bb_endday.value != '') {
            var startDate = f.bb_startday.value;
            var startDateArr = startDate.split('-');

            var endDate = f.bb_endday.value;
            var endDateArr = endDate.split('-');

            var startDateCompare = new Date(startDateArr[0], parseInt(startDateArr[1]) - 1, startDateArr[2]);
            var endDateCompare = new Date(endDateArr[0], parseInt(endDateArr[1]) - 1, endDateArr[2]);

            if (startDateCompare.getTime() > endDateCompare.getTime()) {
                alert("시작날짜와 종료날짜를 확인해 주세요.");
                return false;
            }
        }

        f.action = "./bp_banner.update.php";
        return true;
    }
</script>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
