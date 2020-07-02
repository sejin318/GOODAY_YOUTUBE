<?php
$sub_menu = "800400";
include_once './_common.php';


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
if ($w == 'u' && $bo_table) {
    $sql = "SELECT * from `" . BP_BOARD_TABLE . "` where `bb_bo_table` = '{$bo_table}'";
    $_board = sql_fetch($sql);
    //확장필드 값이 없으면 추가해주기
    if (!$_board) {
        $sql = "INSERT into `" . BP_BOARD_TABLE . "` set `bb_bo_table` = '{$bo_table}',
                                                        `bb_list_skin` = 'list',
                                                        `bb_comment_image` = '0',
                                                        `bb_use_font` = '0',
                                                        `bb_gallery_col` = '3',
                                                        `bb_webzine_col` = '1',
                                                        `bb_exif_gps` = '0',
                                                        `bb_use_download_point`='0',
                                                        `bb_use_download_level` = '0',
                                                        `bb_use_download_save` = '0'";
        sql_query($sql, true);
        echo "<script>self.location.reload();</script>";
    }
}

if (!$w) {
    alert('잘못된 접속입니다.', './bp_board_list.php');
    exit;
}

$g5['title'] = 'Boilerplate 게시판확장설정 수정';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">', 100);
$board_name = ASKDB::get_board_info($_board['bb_bo_table']);
?>

<?php echo bp_display_message(); ?>

<div class="jumbotron p-5">
    <h2><span class='btn-primary'><?php echo $board_name['bo_subject'] ?></span> 게시판확장설정</h2>
    <p class="lead">
        항목별 도움말을 참고하세요.
    </p>
</div>
<div class="page-add-wrap frm-wrap">
    <form name="bp_board_form" id="bp_board_form" method="post" onsubmit="return bp_board_modify(this);">
        <input type="hidden" name="token" value="" id="token">
        <?php if ($w == 'u' && $_board) { ?>
            <input type="hidden" name='bb_idx' value="<?php echo $_board['bb_idx'] ?>" />
            <input type="hidden" name='bb_bo_table' value="<?php echo $_board['bb_bo_table'] ?>" />
        <?php } ?>
        <input type="hidden" name='w' value="<?php echo $w ?>" />
        <div class='frm-group'>
            <label class='frm-label'><span>목록스킨 선택</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <select name='bb_list_skin' class="form-control w-25 mb-1">
                        <option value=""> -- 목록 스킨 -- </option>
                        <?php
                        $_boardinfo = ASKDB::get_board_info($bo_table);
                        $_board_skin_path = get_skin_path('board', $_boardinfo['bo_skin']);
                        $_bp_board_skin = glob($_board_skin_path . DIRECTORY_SEPARATOR . '_list.*');
                        if (is_array($_bp_board_skin)) {
                            foreach ((array) $_bp_board_skin as $k => $list_skin) {
                                $fileinfo = pathinfo($list_skin);
                                $ext = $fileinfo['extension'];

                                if ($ext !== 'php') {
                                    continue;
                                }
                                $title = explode(".", $fileinfo['basename']);
                                $checked = '';
                                if ($_board['bb_list_skin'] == $fileinfo['basename']) {
                                    $checked = "selected";
                                }
                                echo "<option value='{$fileinfo['basename']}' {$checked}>{$title[1]}</option>";
                            }
                        }
                        ?>
                    </select>
                    <div class="alert alert-info">
                        게시판 목록의 형식을 지정하세요. 기본값은 텍스트 목록형입니다. 스킨 전체를 변경할 필요 없이 목록형을 목적에 맞게 사용할 수 있습니다.
                    </div>
                </div>
            </div>
        </div>

        <div class='frm-group'>
            <label class='frm-label'><span>댓글 이미지 첨부</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <label><input type="checkbox" name="bb_comment_image" value="1" <?php echo $_board['bb_comment_image'] ? "checked" : "" ?> class="form-control-checkbox" />사용</label>
                    <div class="alert alert-info">
                        댓글에 이미지를 첨부할 수 있습니다.
                    </div>
                </div>
            </div>
        </div>

        <div class='frm-group'>
            <label class='frm-label'><span>제목 폰트 </span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <label><input type="checkbox" name="bb_use_font" value="1" <?php echo $_board['bb_use_font'] ? "checked" : "" ?> class="form-control-checkbox" />사용</label>
                    <div class="alert alert-info">
                        회원이 제목에 폰트를 지정할 수 있습니다.
                    </div>
                </div>
            </div>
        </div>

        <div class='frm-group'>
            <label class='frm-label'><span>갤러리/카드 열</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <select name='bb_gallery_col' class="form-control w-25 mb-1">
                        <option value=""> -- 열 수 선택 -- </option>
                        <option value="1" <?php echo $_board['bb_gallery_col'] == '1' ? "selected" : "" ?>>1</option>
                        <option value="2" <?php echo $_board['bb_gallery_col'] == '2' ? "selected" : "" ?>>2</option>
                        <option value="3" <?php echo $_board['bb_gallery_col'] == '3' ? "selected" : "" ?>>3</option>
                        <option value="4" <?php echo $_board['bb_gallery_col'] == '4' ? "selected" : "" ?>>4</option>
                        <option value="6" <?php echo $_board['bb_gallery_col'] == '6' ? "selected" : "" ?>>6</option>
                    </select>
                    <div class="alert alert-info">
                        갤러리, 카드형 목록 열 수를 선택하세요. Desktop 출력 열 수 입니다. 모바일 기기는 자동 조절되어 출력됩니다.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>웹진 열</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <select name='bb_webzine_col' class="form-control w-25 mb-1">
                        <option value=""> -- 열 수 선택 -- </option>
                        <option value="1" <?php echo $_board['bb_webzine_col'] == '1' ? "selected" : "" ?>>1</option>
                        <option value="2" <?php echo $_board['bb_webzine_col'] == '2' ? "selected" : "" ?>>2</option>

                    </select>
                    <div class="alert alert-info">
                        웹진 열 수를 선택하세요. Desktop 출력 열 수 입니다. 모바일 기기는 자동 조절되어 출력됩니다.
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>EXIF GPS</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <label><input type="checkbox" name="bb_exif_gps" value="1" <?php echo $_board['bb_exif_gps'] ? "checked" : "" ?> class="form-control-checkbox" />사용</label>
                    <div class="alert alert-info">
                        사진의 GPS 정보를 이용하여 지도에 위치를 출력 할 수 있습니다.
                        <?php if (!$config['cf_kakao_rest_key'] || !$config['cf_kakao_client_secret'] || !$config['cf_kakao_js_apikey']) { ?>
                            기본환경 설정에서 <a href='https://boilerplate.kr/adm/config_form.php#anc_cf_sns' class='btn btn-link'>카카오 API 키 3종</a>을 설정해야 합니다.
                            <a href='https://accounts.kakao.com/login?continue=https://developers.kakao.com/login?redirectUrl=%2Fapps%2Fnew' target='blank' class="btn btn-primary btn-sm">API 발급</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>다운로드 - 포인트</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <label><input type="checkbox" name="bb_use_download_point" value="1" <?php echo $_board['bb_use_download_point'] ? "checked" : "" ?> class="form-control-checkbox" />사용</label>
                    <div class="alert alert-info">
                        <i class="fa fa-info" aria-hidden="true"></i> 첨부파일 개별 다운로드 포인트를 설정할 수 있습니다.<br />
                        <i class="fa fa-info" aria-hidden="true"></i> 테마기본설정->게시판 업로더-> default, 기본첨부파일 기능에서만 작동됩니다.

                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>다운로드 - 등록레벨</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <select name='bb_use_download_level' class="form-control w-25 mb-1">
                        <?php
                        for ($i = 2; $i <= 10; $i++) {
                            $selected = "";
                            if ($_board['bb_use_download_level'] == $i) {
                                $selected = "selected";
                            }
                            echo "<option value='{$i}' {$selected}>{$i}</option>";
                        }
                        ?>
                    </select>
                    <div class="alert alert-info">
                        <i class="fa fa-info" aria-hidden="true"></i> 첨부파일 개별 다운로드 포인트를 설정 이용 가능 레벨
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>다운로드 - 포인트적립</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <label><input type="checkbox" name="bb_use_download_save" value="1" <?php echo $_board['bb_use_download_save'] ? "checked" : "" ?> class="form-control-checkbox" />사용</label>
                    <div class="alert alert-info">
                        <i class="fa fa-info" aria-hidden="true"></i> 파일을 등록한 회원에게 다운로드에 사용된 포인트를 적립, 수수료는 <?php echo BP_POINT_COMMISSION ?>% 입니다. theme/boilerplate/lib/boilerplate/constant.php 파일에서 설정하세요.
                    </div>
                </div>
            </div>
        </div>

        <div class="btn_fixed_top btn_confirm">
            <?php if ($w == 'u' && $_board) { ?>
                <a href='<?php echo get_pretty_url($_board['bb_bo_table']) ?>' class='btn btn-secondary'><i class="fa fa-list-ul" aria-hidden="true"></i> 게시판</a>
                <a href='./bp_board_list.php' class='btn btn-info'><i class="fa fa-list" aria-hidden="true"></i> 목록</a>
            <?php } ?>
            <input type="submit" value="확인" class="btn_submit btn btn-primary" accesskey="s">
        </div>
    </form>
</div>
<script>
    function bp_board_modify(f) {
        if (f.bb_list_skin.value == '') {
            alert('목록스킨을 선택하세요.');
            return false;
        }
        if (f.bb_gallery_col.value == '') {
            alert('갤러리 열 수를 선택하세요.');
            return false;
        }
        if (f.bb_webzine_col.value == '') {
            alert('웹진 열 수를 선택하세요.');
            return false;
        }

        f.action = "./bp_board.update.php";
        return true;
    }
</script>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
