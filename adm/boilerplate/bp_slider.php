<?php
$sub_menu = "800110";
include_once './_common.php';
include_once G5_LIB_PATH . '/thumbnail.lib.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

//테이블 체크
if (ASKDB::exsit_table(BP_SLIDER_TABLE) == false) {
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}
//수정
if ($w == 'u' && $idx) {
    $sql = "SELECT * from `" . BP_SLIDER_TABLE . "` where `bs_idx` = '{$idx}'";
    $_slider = sql_fetch($sql);
}

$g5['title'] = 'Boilerplate  테마 슬라이더 설정';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');
?>
<div class="jumbotron p-5">
    <h1>슬라이더</h1>
    <p class="lead">
        슬라이더를 생성 후 페이지를 등록해야 합니다.
    </p>
</div>
<?php echo bp_display_message(); ?>
<form name="pb_sliderform" id="pb_sliderform" method="post" enctype="multipart/form-data" onsubmit="return bp_submit(this);">
    <input type="hidden" name="token" value="" id="token">
    <input type="hidden" name='w' value="<?php echo $w ?>" />
    <input type="hidden" name='bs_idx' value="<?php echo $idx ?>" />
    <section class="swiper-form-wrap">
        <h2 class="frm-head">슬라이더 생성</h2>
        <div class='frm-wrap'>
            <div class='frm-group border-top-1'>
                <label class='frm-label'><span>슬라이더 사용여부</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bs_use" value="1" <?php echo $_slider['bs_use'] == true ? "checked" : ""; ?> /> 사용</label>
                        <div class="alert alert-info">
                            슬라이더 사용 / 미사용 설정
                        </div>
                    </div>
                </div>
            </div>

            <div class='frm-group'>
                <label class='frm-label'><span>슬라이더 이름</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <input type="text" name="bs_name" value="<?php echo $_slider['bs_name'] ?>" required class="frm-input required" placeholder="한영,숫자만 입력하세요." />
                        <div class="alert alert-info">
                            슬라이더의 이름을 설정합니다. 그누보드 Event 를 이용해 아래와 같이 출력 가능합니다. 중복불가,한영,숫자만 입력하세요<br />
                            <?php if ($w == 'u' && $idx) { ?>
                                &lt;?php run_event('<?php echo $_slider['bs_name'] ?>', '<?php echo $_slider['bs_name'] ?>'); ?&gt;
                            <?php } else { ?>
                                &lt;?php run_event('슬라이더 이름', '슬라이더 이름'); ?&gt;
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>슬라이더 스킨</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <select name='bs_skin' class='bs_skin frm-input required'>
                            <option value="">스킨을 선택하세요.</option>
                            <?php
                            $_bs_skin = scandir(BP_SLIDER_SKIN_PATH);
                            foreach ($_bs_skin as $dir) {
                                if ($dir == '.' || $dir == '..') {
                                    continue;
                                }
                                $checked = '';
                                if ($_slider['bs_skin'] == $dir) {
                                    $checked = "selected";
                                }

                                echo "<option value='{$dir}' {$checked}>{$dir}</option>";
                            }
                            ?>
                        </select>
                        <div class="alert alert-info">
                            슬라이더의 스킨을 설정합니다. bg-slider를 이용하면 높이가 고정됩니다.<br />
                            swiper 스킨 사용시 유튜브 등록 가능합니다.
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>슬라이더 비율</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <select name='bs_ratio' class='bs_ratio frm-input required'>
                            <option value="">비율을 선택하세요.</option>
                            <option value="embed-responsive-21by9" <?php echo $_slider['bs_ratio'] == 'embed-responsive-21by9' ? "selected" : ""; ?>>21:9</option>
                            <option value="embed-responsive-16by9" <?php echo $_slider['bs_ratio'] == 'embed-responsive-16by9' ? "selected" : ""; ?>>16:9</option>
                            <option value="embed-responsive-5by1" <?php echo $_slider['bs_ratio'] == 'embed-responsive-5by1' ? "selected" : ""; ?>>5:1</option>
                            <option value="embed-responsive-4by3" <?php echo $_slider['bs_ratio'] == 'embed-responsive-4by3' ? "selected" : ""; ?>>4:3</option>
                            <option value="embed-responsive-4by1" <?php echo $_slider['bs_ratio'] == 'embed-responsive-4by1' ? "selected" : ""; ?>>4:1</option>
                            <option value="embed-responsive-3by1" <?php echo $_slider['bs_ratio'] == 'embed-responsive-3by1' ? "selected" : ""; ?>>3:1</option>
                            <option value="embed-responsive-2by1" <?php echo $_slider['bs_ratio'] == 'embed-responsive-2by1' ? "selected" : ""; ?>>2:1</option>
                            <option value="embed-responsive-1by1" <?php echo $_slider['bs_ratio'] == 'embed-responsive-1by1' ? "selected" : ""; ?>>1:1</option>
                        </select>
                        <div class="alert alert-info">
                            슬라이더 이미지 비율을 선택하세요. 비율에 맞게 이미지를 등록해 주세요.<br/>
                            default 스킨은 적용되지 않습니다. 
                        </div>
                    </div>
                </div>
            </div>

            <div class='frm-group'>
                <label class='frm-label'><span>자동넘기기</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bs_autoplay" value="1" <?php echo $_slider['bs_autoplay'] == true ? "checked" : ""; ?> /> 자동넘기기 사용</label>
                        <div class="alert alert-info">
                            슬라이더가 자동으로 페이지 넘기기 여부 설정
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>컨트롤 표시</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bs_control" value="1" <?php echo $_slider['bs_control'] == true ? "checked" : ""; ?> /> 컨트롤 사용</label>
                        <div class="alert alert-info">
                            좌/우 이동 버튼 사용 / 미사용 설정
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>하단 Indicator 표시</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bs_indicator" value="1" <?php echo $_slider['bs_indicator'] == true ? "checked" : ""; ?> /> Indicator사용</label>
                        <div class="alert alert-info">
                            하단 네비게이션 버튼 출력 여부
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>크로스페이드</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bs_crossfade" value="1" <?php echo $_slider['bs_crossfade'] == true ? "checked" : ""; ?> /> Crossfade 사용</label>
                        <div class="alert alert-info">
                            페이지 전환 효과 Crossfade 사용 여부 설정
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--//.frm-wrap-->
    </section>
    <div class="btn_fixed_top btn_confirm">
        <?php if ($w == 'u' && $idx) { ?>
            <a href="./bp_slider_add.php?parent_idx=<?php echo $_slider['bs_idx'] ?>" class="btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i> 슬라이더 페이지 등록</a>
        <?php } ?>
        <a href="./bp_slider_list.php" class="btn btn-secondary"><i class="fa fa-list" aria-hidden="true"></i> 목록</a>
        <input type="submit" value="확인" class="btn_submit btn btn-primary" accesskey="s">
    </div>
</form>
<script>
    function bp_submit(f) {

        f.action = "./bp_slider.update.php";
        return true;
    }
</script>
<?php if ($w == 'u' && $idx) { ?>
    <hr />
    <?php
    $sql = "SELECT * from `" . BP_SLIDER_LIST_TABLE . "` where `bss_parent` = '{$idx}' order by bss_order";
    $result = sql_query($sql, true);
    ?>
    <div class="sub-page-list">
        <h3 class="frm-head">등록된 페이지</h3>
        <div class='form-group text-right'>
            <a href='./bp_slider_preview.php?idx=<?php echo $idx ?>' class="btn btn-primary" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> 슬라이더 미리보기</a>
        </div>
        <section>
            <table class="table table-bordered">
                <caption>슬라이더에 등록된 하위 페이지 목록</caption>
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>제목</th>
                        <th>캡션</th>
                        <th>이미지</th>
                        <th>정렬</th>
                        <th>인터벌</th>
                        <th>기간</th>
                        <th>관리</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                        echo "<tr>";
                        echo "<td>{$rows['bss_name']}</td>";
                        echo "<td>{$rows['bss_subject']}</td>";
                        echo "<td>{$rows['bss_content']}</td>";
                        if ($rows['bss_image']) {
                            $img_tag = get_view_thumbnail("<img src='" . BP_SLIDERSAVE_URL . DIRECTORY_SEPARATOR . $rows['bss_image'] . "' class='bss-image'/>", 150);
                            echo "<td>{$img_tag}</td>";
                        } else {
                            echo "<td>No Image</td>";
                        }

                        echo "<td>{$rows['bss_order']}</td>";
                        echo $rows['bss_interval'] ? "<td>" . ($rows['bss_interval'] / 1000) . "초</td>" : "<td>5초</td>";
                        $기간정보 = '';
                        if ($rows['bss_endday'] < date('Y-m-d', time())) {
                            $기간정보 = '<i class="fa fa-hourglass-end" aria-hidden="true"></i> 기간만료';
                        }
                        if ($rows['bss_startday'] > date('Y-m-d', time())) {
                            $기간정보 = '<i class="fa fa-hourglass-start" aria-hidden="true"></i> 시작전';
                        }
                        if ($rows['bss_startday'] <= date('Y-m-d', time()) && $rows['bss_endday'] >= date('Y-m-d', time())) {
                            $기간정보 = '<i class="fa fa-play" aria-hidden="true"></i> 출력중';
                        }
                        echo $rows['bss_startday'] != '0000-00-00' ? "<td>{$rows['bss_startday']} ~ {$rows['bss_endday']} <br/><span class='badge badge-nfo'>{$기간정보}</span></td>" : "<td>항상출력</td> ";
                        echo "<td><a href='./bp_slider_add.php?w=u&idx={$rows['bss_idx']}' class='btn btn-primary btn-sm'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a> <a href='./bp_slider_add.delete.php?w=de&idx={$rows['bss_idx']}' class='delete-item btn btn-danger btn-sm'><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a> </td>";
                        echo "</tr>";
                    }
                    if ($i == 0) {
                        echo "<tr><td colspan='8' class='p-4'> 등록된 슬라이더 페이지가 없습니다. <a href='./bp_slider_add.php?parent_idx={$_slider['bs_idx']}' class='btn btn-link'>페이지 등록하기</a></td></tr>";
                    }
                    ?>

                </tbody>
            </table>
        </section>
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
    </script>
<?php } ?>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
