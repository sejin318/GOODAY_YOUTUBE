<?php
include_once './_common.php';
include_once G5_LIB_PATH . '/thumbnail.lib.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

$g5['title'] = 'Boilerplate  테마 슬라이더 미리보기';
include_once G5_THEME_PATH . '/head.php';
if (!$idx) {
    alert_close('잘못된 접근!!');
}
//설정 출력용
$sql = "SELECT * from `" . BP_SLIDER_TABLE . "` where `bs_idx` = '{$idx}'";
$_cfg_display = sql_fetch($sql);
?>
<div class='slider-preview-wrap bp-slider-wrap'>
    <div class="jumbotron p-5">
        <div class="container">
            <h1 class="display-4"><?php echo $_cfg_display['bs_name'] ?> - 슬라이더 미리보기</h1>
            <p class="lead">슬라이더 미리 보기 및 출력 코드를 확인 할 수 있습니다.</p>
            <hr class="my-4">
            <p class="lead">
                <?php
                echo ' 컨트롤 : ';
                echo $_cfg_display['bs_control'] ? "<span class='badge badge-primary'>사용</span>" : "<span class='badge badge-danger'>미사용</span>";
                echo ' 인디케이터 : ';
                echo $_cfg_display['bs_indicator'] ? "<span class='badge badge-primary'>사용</span>" : "<span class='badge badge-danger'>미사용</span>";
                echo ' 크로스페이드 : ';
                echo $_cfg_display['bs_crossfade'] ? "<span class='badge badge-primary'>사용</span>" : "<span class='badge badge-danger'>미사용</span>";
                echo ' 스킨 : ';
                echo $_cfg_display['bs_skin'];
                ?>
                <hr />

                <div class="alert alert-success">
                    <p>
                        <i class="fa fa-info-circle" aria-hidden="true"></i> 출력 방법<br />
                        &lt;?php echo bp_slider(<?php echo $idx ?>); ?&gt;
                    </p>
                    <p>
                        스킨을 관리자 설정을 따르지 않고 직접 지정하려면 아래와 같이 사용합니다. 스킨은 theme/boilerplate/_slider/폴더명 입니다. 여러군데 다른 스킨으로 출력시 유용합니다.<br />
                        &lt;?php echo bp_slider(<?php echo $idx ?>, 'default'); ?&gt;
                    </p>
                    <?php if (!$_cfg_display['bs_use']) {
                        echo "<div class='alert alert-danger'> <i class='fa fa-ban' aria-hidden='true'></i> 이 슬라이더는 사용중인 중지되었습니다.</div>";
                    } ?>
                    그누보드 Event 기능을 이용해 아래와 같이 출력할 페이지에 추가하면 출력됩니다.<br/>
                    &lt;?php  run_event('<?php echo $_cfg_display['bs_name'] ?>', '<?php echo $_cfg_display['bs_name'] ?>'); ?&gt;
                </div>
            </p>
        </div>
    </div>
    <?php
    if ($_cfg_display['bs_page_count'] > 0) {
        echo bp_slider($idx);
    } else {
        echo '<div class="alert alert-danger"> 등록된 슬라이더 페이지가 없습니다.</div>';
    }

    ?>
</div>
<?php
include_once G5_THEME_PATH . '/tail.php';
