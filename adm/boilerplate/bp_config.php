<?php
$sub_menu = "800100";
include_once './_common.php';
include_once './_ftp_inc.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

if (ASKDB::exsit_table(BP_CONFIG_TABLE) == false) {
    //테마 설치 후 이용하세요.
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}

$g5['title'] = 'Boilerplate  테마 기본 설정';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');
//Boilerplate 테마 사용 체크
?>
<div class="jumbotron p-5">
    <h1>Boilerplate 기본 설정</h1>
    <p class="lead">
        항목별 도움말을 참고하여 설정하세요.
    </p>
</div>
<?php echo bp_display_message(); ?>
<form name="pb_configform" id="pb_configform" method="post" enctype="multipart/form-data" onsubmit="return bp_submit(this);" autocomplete="off">
    <input type="hidden" name="token" value="" id="token">
    <section>
        <h2 class="frm-head">테마 기본 설정</h2>
        <div class='frm-wrap'>
            <div class='frm-group border-top-1'>
                <label class='frm-label'><span>사이트 로고 이미지</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <input type="file" name="bp_logo" value="<?php echo $config['bp_logo'] ?>" class="frm-input bss_image" />
                        <div class="alert alert-info">
                            로고 이미지를 등록하세요. width는 110px ~ 200px 사이가 좋습니다. 높이는 40px에 최적화 되어 있습니다.
                        </div>
                        <?php
                        if ($config['bp_logo']) {
                            echo "<div class='image-wrap bg-dark p-2'>";
                            $img_tag = "<img src='" . BP_FILE_URL . "/{$config['bp_logo']}' class='bp_logo'>";
                            echo "<a href='" . BP_FILE_URL . "/{$config['bp_logo']}' target='_blank'>{$img_tag}</a><br/>";
                            echo "</div>";
                            echo "<label><input type='checkbox' name='bp_logo_delete' value='{$config['bp_logo']}' class='bp_logo_delete'> <i class=\"fa fa-trash\" aria-hidden=\"true\"></i> 삭제 </label>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>컬러셋</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <?php $files = glob(G5_PATH . '/_assets/css/colorset.*.css'); ?>
                        <select name='bp_colorset' class='frm-input bp_colorset w-50'>
                            <option value="">선택하세요.</option>
                            <?php
                            if (is_array($files)) {
                                foreach ((array) $files as $k => $css_file) {
                                    $fileinfo = pathinfo($css_file);
                                    $ext = $fileinfo['extension'];
                                    //14폰트 파일 패스
                                    if (stristr($fileinfo['basename'], 'font14px')) {
                                        continue;
                                    }
                                    if ($ext !== 'css') {
                                        continue;
                                    }
                                    $title = explode(".", $fileinfo['basename']);
                                    $checked = '';
                                    if ($config['bp_colorset'] == $fileinfo['basename']) {
                                        $checked = "selected";
                                    }
                                    echo "<option value='{$fileinfo['basename']}' {$checked}>{$title[1]}</option>";
                                }
                            }
                            ?>
                        </select>
                        <label><input type='checkbox' name="bp_night_mode" value="1" <?php echo $config['bp_night_mode'] ? "checked" : ""; ?> />오후7시 이후 Dark 컬러셋 사용</label>
                        <div class="alert alert-info">
                            <i class="fa fa-link" aria-hidden="true"></i> <?php echo "<a href='" . G5_URL . '/_assets/css/' . $config['bp_colorset'] . "' target='_blank'>" . G5_URL . '/_assets/css/' . $config['bp_colorset'] . "</a>" ?><br />
                            <i class="fa fa-info-circle" aria-hidden="true"></i> 오후7시 이후 Dark 컬러셋 사용 옵션을 체크하면 설정에 상관없이 오후 7시~ 오전 7시 까지는 dark 컬러셋이 적용됩니다.
                        </div>
                    </div>
                </div>
            </div>

            <div class='frm-group'>
                <label class='frm-label'><span>폰트사이즈</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type='checkbox' name="bp_font_size" value="1" <?php echo $config['bp_font_size'] ? "checked" : ""; ?> />14px (0.875rem) 사용</label>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle" aria-hidden="true"></i> 기본 브라우저 폰트 사이즈는 16px(1rem)입니다. 14px (0.875rem)를 사용하려면 체크 하세요.
                        </div>
                    </div>
                </div>
            </div>

            <div class='frm-group'>
                <label class='frm-label'><span>사이트 너비 설정</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <select name='bp_container' class='bp_container frm-input w-50'>
                            <option value="">선택하세요.</option>
                            <option value="container-fluid" <?php echo $config['bp_container'] == 'container-fluid' ? "selected" : ""; ?>>Full width(전체) container-fluid </option>
                            <option value="container" <?php echo $config['bp_container'] == 'container' ? "selected" : ""; ?>>Fixed width(박스) container </option>
                            <option value="container-md" <?php echo $config['bp_container'] == 'container-md' ? "selected" : ""; ?>>Fixed width(박스) container-md </option>
                            <option value="container-lg" <?php echo $config['bp_container'] == 'container-lg' ? "selected" : ""; ?>>Fixed width(박스) container-lg </option>
                            <option value="container-xl" <?php echo $config['bp_container'] == 'container-xl' ? "selected" : ""; ?>>Fixed width(박스) container-xl / max-width 1140px</option>
                            <option value="container-xxl" <?php echo $config['bp_container'] == 'container-xxl' ? "selected" : ""; ?>>Fixed width(박스) container-xxl / max-width 1440px</option>
                        </select>
                        <div class="alert alert-info">
                            전체형으로 설정하면 화면 width 전체를 100%로 사용하며 박스형은 최대 width 1140px~1440px를 사용하는 박스형태입니다.<br />
                            박스형태가 여러개인 것은 bootstrap 4.4에 추가된 반응형 박스입니다. <a href='https://getbootstrap.com/docs/4.4/layout/grid/#grid-options' target="_blank"><i class="fa fa-link" aria-hidden="true"></i> 링크참고</a><br />
                            Fluid 형은 전체 폭 반응형이며 이 외의 컨테이너는 중단점이 있습니다. container와 container-sm 은 동일하며 중단점이 단계별 모두 있습니다.<br />
                            container 는 브라우저의 너비에 따라 540px,720px,960px,1140px,1440px의 최대 width 값을 사용합니다.<br />
                            container-xxl 은 최대 박스 크기가 1440px 이며 나머지는 1140px입니다. 큰 박스 화면을 사용하려면 container-xxl을 선택하세요.

                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>주메뉴 - 배경색</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <select name='bp_pc_menu_color' class='bp_pc_menu_color frm-input w-25'>
                            <option value="">선택하세요.</option>
                            <option value="primary" <?php echo $config['bp_pc_menu_color'] == 'primary' ? "selected" : ""; ?> class='bg-primary text-white'>primary</option>
                            <option value="secondary" <?php echo $config['bp_pc_menu_color'] == 'secondary' ? "selected" : ""; ?> class='bg-secondary text-white'>secondary</option>
                            <option value="success" <?php echo $config['bp_pc_menu_color'] == 'success' ? "selected" : ""; ?> class='bg-success text-white'>success</option>
                            <option value="danger" <?php echo $config['bp_pc_menu_color'] == 'danger' ? "selected" : ""; ?> class='bg-danger text-white'>danger</option>
                            <option value="warning" <?php echo $config['bp_pc_menu_color'] == 'warning' ? "selected" : ""; ?> class='bg-warning'>warning</option>
                            <option value="info" <?php echo $config['bp_pc_menu_color'] == 'info' ? "selected" : ""; ?> class='bg-info'>info</option>
                            <option value="light" <?php echo $config['bp_pc_menu_color'] == 'light' ? "selected" : ""; ?> class='bg-light'>light</option>
                            <option value="white" <?php echo $config['bp_pc_menu_color'] == 'white' ? "selected" : ""; ?> class='bg-white'>white</option>
                            <option value="dark" <?php echo $config['bp_pc_menu_color'] == 'dark' ? "selected" : ""; ?> class='bg-dark text-white'>dark</option>
                        </select>
                        <div class="alert alert-info">
                            PC용 주메뉴 배경색 선택
                        </div>
                        <div class="bd-example border overflow-hidden d-inline-block">
                            <div class="p-3 bg-primary text-white float-left">primary</div>
                            <div class="p-3 bg-secondary text-white float-left">secondary</div>
                            <div class="p-3 bg-success text-white float-left">success</div>
                            <div class="p-3 bg-danger text-white float-left">danger</div>
                            <div class="p-3 bg-warning text-dark float-left">warning</div>
                            <div class="p-3 bg-info text-white float-left">info</div>
                            <div class="p-3 bg-light text-dark float-left">light</div>
                            <div class="p-3 bg-dark text-white float-left">dark</div>
                            <div class="p-3 bg-white text-dark float-left">white</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='frm-group'>
                <label class='frm-label'><span>주메뉴 - PC용</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <select name='bp_pc_menu' class='bp_pc_menu frm-input w-50'>
                            <option value="">선택하세요.</option>
                            <?php
                            $_bp_pc_menu = scandir(G5_THEME_PATH . DIRECTORY_SEPARATOR . '_menu' . DIRECTORY_SEPARATOR . 'pc');
                            if ($_bp_pc_menu) {
                                foreach ($_bp_pc_menu as $dir) {
                                    if ($dir == '.' || $dir == '..') {
                                        continue;
                                    }
                                    $checked = '';
                                    if ($config['bp_pc_menu'] == $dir) {
                                        $checked = "selected";
                                    }

                                    echo "<option value='{$dir}' {$checked}>{$dir}</option>";
                                }
                            }
                            ?>
                        </select>
                        <label><input type='checkbox' name="bp_pc_menu_container" value="1" <?php echo $config['bp_pc_menu_container'] ? "checked" : ""; ?> />박스형 메뉴 사용</label>
                        <div class="alert alert-info">
                            PC용 주메뉴 선택,메뉴는 기본으로 전체 width를 사용합니다. 박스형을 사용하려면 박스형 메뉴 사용에 체크하세요.
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>주메뉴 - 모바일용</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <select name='bp_mobile_menu' class='bp_mobile_menu frm-input w-50'>
                            <option value="">선택하세요.</option>
                            <?php
                            $_bp_mobile_menu = scandir(G5_THEME_PATH . DIRECTORY_SEPARATOR . '_menu' . DIRECTORY_SEPARATOR . 'mobile');
                            foreach ($_bp_mobile_menu as $dir) {
                                if ($dir == '.' || $dir == '..') {
                                    continue;
                                }
                                $checked = '';
                                if ($config['bp_mobile_menu'] == $dir) {
                                    $checked = "selected";
                                }

                                echo "<option value='{$dir}' {$checked}>{$dir}</option>";
                            }
                            ?>
                        </select>
                        <div class="alert alert-info">
                            모바일용용 주메뉴 선택
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>헤더/푸터</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <select name='bp_header_footer' class='bp_header_footer frm-input w-50'>
                            <option value="">선택하세요.</option>
                            <?php
                            $_header_footer = scandir(BP_HEADER_FOOTER_PATH);
                            foreach ($_header_footer as $dir) {
                                if ($dir == '.' || $dir == '..') {
                                    continue;
                                }
                                $checked = '';
                                if ($config['bp_header_footer'] == $dir) {
                                    $checked = "selected";
                                }

                                echo "<option value='{$dir}' {$checked}>{$dir}</option>";
                            }
                            ?>
                        </select>
                        <div class="alert alert-info">
                            사이트 구조를 결정하는 해더 푸터를 선택하여 사용할 수 있습니다.
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>구형브라우저 경고창</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type='checkbox' name="bp_browser_update" value="1" <?php echo $config['bp_browser_update'] ? "checked" : ""; ?> /> 사용</label>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle" aria-hidden="true"></i> 오래된 웹브라우저로 접속하면 경고창을 사이트 하단에 출력<br />
                            <i class="fa fa-link" aria-hidden="true"></i> <a href='https://browser-update.org/#install' target="_blank">https://browser-update.org/#install</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--//.frm-wrap-->
        <h2 class="frm-head">게시판설정</h2>
        <div class="frm-wrap">
            <div class='frm-group border-top-1'>
                <label class='frm-label'><span>게시판 업로더 선택</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <select name='bp_board_uploader' class='bp_board_uploader frm-input w-50'>
                            <option value="">선택하세요.</option>
                            <?php
                            $_bp_uploader = scandir(BP_UPLOADER_PATH);
                            foreach ($_bp_uploader as $dir) {
                                if ($dir == '.' || $dir == '..') {
                                    continue;
                                }
                                $checked = '';
                                if ($config['bp_board_uploader'] == $dir) {
                                    $checked = "selected";
                                }

                                echo "<option value='{$dir}' {$checked}>{$dir}</option>";
                            }
                            ?>
                        </select>
                        <div class="alert alert-info w-50">
                            PC용 주메뉴 선택
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>게시판즐겨찾기</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bp_use_favorite" value="1" <?php echo $config['bp_use_favorite'] == true ? "checked" : ""; ?> /> 사용</label>
                        <div class="alert alert-info w-50">
                            게시판 즐겨찾기 사용 설정
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="frm-head">회원기능</h2>
        <div class="frm-wrap">
            <div class='frm-group border-top-1'>
                <label class='frm-label'><span>신고기능 사용</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bp_use_report" value="1" <?php echo $config['bp_use_report'] == true ? "checked" : ""; ?> /> 사용</label>
                        <div class="alert alert-info w-50">
                            신고기능을 사용, 미사용 선택하세요.
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>회원메모 사용</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bp_member_memo" value="1" <?php echo $config['bp_member_memo'] == true ? "checked" : ""; ?> /> 사용</label>
                        <div class="alert alert-info w-50">
                            회원에 대한 메모를 작성해 둘 수 있습니다.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="frm-head">포인트</h2>
        <div class="frm-wrap">
            <div class='frm-group border-top-1'>
                <label class='frm-label'><span>포인트 구매 사용</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bp_point_charge" value="1" <?php echo $config['bp_point_charge'] == true ? "checked" : ""; ?> /> 사용</label>
                        <div class="alert alert-info w-50">
                            회원이 포인트를 구매할 수 있습니다.
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>포인트 설정</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <input type="text" name="bp_point_list" value="<?php echo $config['bp_point_list'] ?>" class="form-control frm-input" autocomplete="off" />
                        <div class="alert alert-info">
                            구매 할 수 있는 포인트 목록을 설정합니다. | 로 구분해서 입력하세요. ex) 1000|2000|5000|10000
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>입금은행</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <input type="text" name="bp_bank_list" value="<?php echo $config['bp_bank_list'] ?>" class="form-control frm-input" autocomplete="off" />
                        <div class="alert alert-info">
                            포인트 구매 대금을 입금할 은행을 입력하세요. | 로 구분해서 여러 은행을 입력하세요. ex) 국민은행 012-345-6789-0 홍길동|우리은행 111-222-333-4455 홍길동
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="frm-head">알람기능</h2>
        <div class="frm-wrap">
            <div class='frm-group border-top-1'>
                <label class='frm-label'><span>알람 사용</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bp_use_alarm" value="1" <?php echo $config['bp_use_alarm'] == true ? "checked" : ""; ?> /> 사용</label>
                        <div class="alert alert-info w-50">
                            게시물에 댓글이 달리거나 쪽지를 받으면 알람으로 알려주는 기능입니다.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a name='ftp' class="anchor"></a>
        <h2 class="frm-head">WEB FTP</h2>
        <div class="alert alert-info">
            <i class="fa fa-info-circle" aria-hidden="true"></i> 추가설정안내<br />
            추가 설정은 FTP 설정 파일인 plugin/ask-ftp/ask_ftp.const.php 파일을 편집하세요.
        </div>
        <div class="alert alert-danger">
            <i class="fa fa-info-circle" aria-hidden="true"></i> 서버 환경에 따라 접속이 안될 수 있습니다.
        </div>
        <div class="frm-wrap">
            <div class='frm-group border-top-1'>
                <label class='frm-label'><span>FTP 사용</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bp_ftp_use" value="1" <?php echo $config['bp_ftp_use'] == true ? "checked" : ""; ?> /> 사용</label>
                        <div class="alert alert-info">
                            WEB FTP를 사용하려면 체크 하세요. 보안을 위해 사용하지 않는다면 체크 해제 하세요. ID , 비번도 삭제하세요.
                        </div>
                        <?php if ($config['bp_ftp_use'] && ($config['bp_ftp_id'] && $config['bp_ftp_password'])) { ?>
                            <label><input type="checkbox" name="bp_ftp_reset" value="1" /> FTP 정보 삭제</label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>FTP ID</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <input type="text" name="bp_ftp_id" value="<?php echo $config['bp_ftp_id'] ?>" class="form-control frm-input w-25" autocomplete="off" />
                        <div class="alert alert-info w-25">
                            FTP ID 입력
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>FTP Password</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <input type="password" name="bp_ftp_password" value="" class="form-control frm-input w-25" autocomplete="new-password" />
                        <div class="alert alert-info">
                            FTP 비밀번호 입력, 함호화 후 저장됩니다. <?php echo $config['bp_ftp_password'] != '' ? "<strong>FTP 비밀번호가 저장되었습니다.</strong>" : ""; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>FTP PORT</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <input type="text" name="bp_ftp_port" value="<?php echo $config['bp_ftp_port'] ?>" class="form-control frm-input w-25" placeholder="21" />
                        <div class="alert alert-info w-25">
                            FTP Port 입력
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>FTP Passive Mode 사용</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bp_ftp_pasv" value="1" <?php echo $config['bp_ftp_pasv'] == true ? "checked" : ""; ?> /> 사용</label>
                        <div class="alert alert-info w-50">
                            FTP 접속이 안되면 패시브 모드를 해제 후 사용해 보세요.
                        </div>
                    </div>
                </div>
            </div>

            <div class='frm-group'>
                <label class='frm-label'><span>FTP ROOT</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <input type="text" name="bp_ftp_root" value="<?php echo $config['bp_ftp_root'] ?>" class="form-control frm-input w-25" placeholder="" />
                        <div class="alert alert-info">
                            SSH 접속한 계정 루트와 다릅니다. 파일질라와 같은 FTP Client로 접속시 루트 폴더를 입력하세요. EX) /public_html
                        </div>
                    </div>
                </div>
            </div>
            <div class='frm-group'>
                <label class='frm-label'><span>FTP Backup</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <input type="text" name="bp_ftp_backup" value="<?php echo $config['bp_ftp_backup'] ?>" class="form-control frm-input w-25" placeholder="ex) _ftp_backup" />
                        <div class="alert alert-info">
                            파일을 수정할 경우 수정 전 원본 파일을 백업할 경로 입력. FTP root 아래 생성됩니다.
                        </div>
                    </div>
                </div>
            </div>

            <div class='frm-group'>
                <label class='frm-label'><span>수정,삭제, 변경 기능</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <label><input type="checkbox" name="bp_ftp_modify" value="1" <?php echo $config['bp_ftp_modify'] == true ? "checked" : ""; ?> /> 사용</label>
                        <div class="alert alert-info w-50">
                            수정, 삭제, 이름변경, 권한변경 , 다운로드 기능 사용 여부
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <div class="btn_fixed_top btn_confirm">
        <input type="submit" value="확인" class="btn_submit btn btn-primary" accesskey="s">
    </div>
</form>
<script>
    $(function() {
        $('input[name=bp_pc_menu_container]').on('click', function() {
            var siteContainer = $('.bp_container').val();
            if (siteContainer == 'container-fluid') {
                alert('사이트 너비는 전체로 설정하면 박스형 메뉴를 사용할 수 없습니다.');
                setTimeout(function() {
                    $('input[name=bp_pc_menu_container]').prop("checked", false);
                }, 10);
                return false;
            }
        });
    });

    function bp_submit(f) {
        if ($('.bp_colorset').val() == '') {
            alert('컬러셋을 선택하세요.');
            return false;
        }

        if ($('.bp_container').val() == '') {
            alert('사이트 너비 설정을 선택하세요.');
            return false;
        }

        if ($('input[name=bp_pc_menu_container]').is(":checked") == true) {
            var siteContainer = $('.bp_container').val();
            if (siteContainer == 'container-fluid') {
                alert('사이트 너비는 전체로 설정하면 PC용 박스형 메뉴를 사용할 수 없습니다. \n박스형 메뉴 체크를 해제 하시거나 사이트 너비설정을 박스형으로 하세요.');
                $('input[name=bp_pc_menu_container]').attr("checked", false);
                return false;
            }
        }

        if ($('.bp_pc_menu_color').val() == '') {
            alert('PC용 주메뉴 배경색을 선택하세요.');
            return false;
        }
        if ($('.bp_pc_menu').val() == '') {
            alert('PC용 주메뉴를 선택하세요.');
            return false;
        }
        if ($('.bp_mobile_menu').val() == '') {
            alert('모바일용 메뉴를 선택하세요.');
            return false;
        }
        if ($('.bp_header_footer').val() == '') {
            alert('헤더 푸터 레이아웃을 선택하세요.');
            return false;
        }
        if ($('.bp_board_uploader').val() == '') {
            alert('게시판 업로더를 선택하세요.');
            return false;
        }
        //포인트 구매 사용
        if ($('input[name=bp_point_charge]').is(':checked') == true) {
            if ($('input[name=bp_point_list]').val() == '') {
                alert('포인트 설정을 입력하세요.');
                return false;
            }
            if ($('input[name=bp_bank_list]').val() == '') {
                alert('입금은행을 입력하세요.');
                return false;
            }
        }
        f.action = "./bp_config.update.php";
        return true;
    }
</script>

<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
