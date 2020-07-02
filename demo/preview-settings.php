<?php
include_once('./_common.php');
/**
 * 미리보기 처리용 세선 설정
 */
//컬러셋 설정
if ($type == 'colorset' && $color) {
    set_session('BP_SS_COLORSET', $color);
}
//폰트사이즈
if ($type == 'fontsize' && $size) {
    if ($size == 16) {
        set_session('BP_FONT_SIZE', $size);
    }
    if ($size == 14) {
        set_session('BP_FONT_SIZE', $size);
    }
}
//박스형 모델
if ($type == 'box' && $model) {
    if ($model == 'fluid') {
        set_session('BP_CONTAINER', 'container-fluid');
    }
    if ($model == 'container') {
        set_session('BP_CONTAINER', 'container-xxl');
    }
}

//메인메뉴 박스 모델
if ($type == 'menubox' && $model) {
    if ($model == 'fluid') {
        set_session('BP_MENU_CONTAINER', 'fluid');
    }
    if ($model == 'container') {
        set_session('BP_MENU_CONTAINER', 'container');
    }
}
//메뉴배경색
if ($type == 'menubg' && $color) {
    if ($color == 'default') {
        set_session('BP_MENU_BG', 'dark');
    }
    if ($color == 'primary') {
        set_session('BP_MENU_BG', 'primary');
    }
    if ($color == 'secondary') {
        set_session('BP_MENU_BG', 'secondary');
    }
    if ($color == 'danger') {
        set_session('BP_MENU_BG', 'danger');
    }
    if ($color == 'warning') {
        set_session('BP_MENU_BG', 'warning');
    }
    if ($color == 'success') {
        set_session('BP_MENU_BG', 'success');
    }
    if ($color == 'info') {
        set_session('BP_MENU_BG', 'info');
    }
    if ($color == 'light') {
        set_session('BP_MENU_BG', 'light');
    }
    if ($color == 'white') {
        set_session('BP_MENU_BG', 'white');
    }
}

//aside
if ($type == 'aside' && $model) {
    if ($model == 'left') {
        set_session('BP_HEADER_FOOTER', 'left-aside');
    }
    if ($model == 'no') {
        set_session('BP_HEADER_FOOTER', 'no-aside');
    }
    if ($model == 'right') {
        set_session('BP_HEADER_FOOTER', 'right-aside');
    }
}

//설정용 세션 모두 리셋
if ($type == 'reset') {
    unset($_SESSION['BP_SS_COLORSET']);
    unset($_SESSION['BP_FONT_SIZE']);
    unset($_SESSION['BP_CONTAINER']);
    unset($_SESSION['BP_HEADER_FOOTER']);
    unset($_SESSION['BP_MENU_CONTAINER']);
    unset($_SESSION['BP_MENU_BG']);
}
include_once G5_THEME_PATH . '/head.sub.php';
?>
<script type="text/javascript">
    $(document).ready(function() {
        if (document.URL.indexOf("#") == -1) {
            url = document.URL + "#";
            top.location = "#";
            top.location.reload(true);
        }
    });
</script>
<?php 
include_once G5_THEME_PATH . '/tail.sub.php';