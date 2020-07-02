<?php
$sub_menu = "800150";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}
//테이블 체크
if (ASKDB::exsit_table(BP_DUMMY_TABLE) == false) {
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}

$g5['title'] = 'Boilerplate Dummy 생성';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');
//Boilerplate 테마 사용 체크
?>
<div class="jumbotron p-4">
    <h2>Dummy Member</h2>
    <p class="lead">
        가짜 회원을 생성합니다. 사이트 제작시 레이아웃 확인 용 및 테스트용 데이터 입니다.
    </p>
</div>

<?php echo bp_display_message(); ?>
<form name="dummy_form" id="dummy_form" method="post" enctype="multipart/form-data" onsubmit="return form_action(this);" autocomplete="off">
    <input type="hidden" name="token" value="" id="token">
    <input type='hidden' name='dummy_type' value="member" />
    <section>
        <h2 class="frm-head">회원등록</h2>
        <div class='frm-wrap'>
            <div class='frm-group border-top-1'>
                <label class='frm-label'><span>Dummy 회원 등록</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <select name='dummy_member' class='dummy-member frm-input form-control w-25'>
                            <option value="0"> -- 회원수 입력 --</option>
                            <option value="50">50명 생성</option>
                            <option value="100">100명 생성</option>
                            <option value="500">500명 생성</option>
                            <option value="1000">1000명 생성</option>
                        </select>
                        <div class="alert alert-info"> 생성할 Dummy 회원수 선택</div>
                        <?php
                        $sql = "SELECT count(*) as cnt from `{$g5['member_table']}` where mb_10 = 'faker-member'";
                        $faker_member = sql_fetch($sql);
                        if ($faker_member['cnt'] > 0) {
                            echo "<label><input type='checkbox' name='delete_faker_member' class='delete_faker_member' value='1'> 등록된 {$faker_member['cnt']}명의 faker member를 삭제</label>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-action d-flex justify-content-end">
            <div class="btn-group">
                <input type='submit' value="확인" class="btn btn-primary" />
            </div>
        </div>
    </section>
</form>
<script>
    function form_action(f) {
        if ($('.dummy-member').val() == '0' && $('.delete_faker_member').is(':checked') == false) {
            alert('생성할 회원수를 입력하세요.');
            return false;
        }


        f.action = "./bp_dummy.update.php";
        return true;
    }
</script>
<div class="jumbotron p-4 mt-4">
    <h2>Dummy Article</h2>
    <p class="lead">
        가짜 게시물을 생성합니다. 사이트 제작시 레이아웃 확인 용 및 테스트용 데이터 입니다.
    </p>
</div>
<form name="dummy_form_board" method="post" enctype="multipart/form-data" onsubmit="return form_action_board(this);" autocomplete="off">
    <input type="hidden" name="token" value="" id="token">
    <input type='hidden' name='dummy_type' value="board" />
    <section>
        <h2 class="frm-head">게시물 등록</h2>
        <div class='frm-wrap'>
            <div class='frm-group border-top-1'>
                <label class='frm-label'><span>Dummy 게시물 등록</span></label>
                <div class='frm-control'>
                    <div class='frm-cont'>
                        <select name='bo_table' class='bo_table frm-input form-control w-25 pull-left mr-2'>
                            <option value=""> -- 게시판 선택 --</option>
                            <?php
                            $board_list = ASKDB::get_board_list();
                            foreach ($board_list as $boards) {
                                echo "<option value='{$boards['bo_table']}'>{$boards['bo_subject']}</option>";
                            }
                            ?>
                        </select>
                        <select name='dummy_board' class='dummy_board frm-input form-control w-25'>
                            <option value="0"> -- 게시물 수 입력 --</option>
                            <option value="1">1개 생성</option>
                            <option value="50">50개 생성</option>
                            <option value="100">100개 생성</option>
                            <option value="500">500개 생성</option>
                            <option value="1000">1000개 생성</option>
                        </select>
                        <label><input type="checkbox" name='add_images' value="1" /> 이미지 첨부 </label>
                        <div class="alert alert-info"> Dummy 게시물을 입력할 게시판 및 게시물 수를 선택하세요.</div>
                        <?php
                        $sql = "SELECT dm_bo_table as bo_table, count(*) as cnt from `" . BP_DUMMY_TABLE . "` group by `dm_bo_table` ";
                        $result = sql_query($sql);
                        for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                            $bo_subject = ASKDB::get_board_info($rows['bo_table']);
                            echo "<label><input type='checkbox' name='delete_faker_article[]' value='{$rows['bo_table']}'> <span class='badge badge-primary'>{$bo_subject['bo_subject']}</span> {$rows['cnt']}개 삭제</label><br/>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-action d-flex justify-content-end">
            <div class="btn-group">
                <input type='submit' value="확인" class="btn btn-primary" />
            </div>
        </div>
    </section>
</form>
<script>
    function form_action_board(f) {
        if ($('.bo_table').val() == '' && $('input[name^="delete_faker_article"]').is(':checked') == false) {
            alert('게시판을 선택하세요.');
            return false;
        }
        if ($('.dummy_board').val() == '0' && $('input[name^="delete_faker_article"]').is(':checked') == false) {
            alert('게시물 수를 선택하세요.');
            return false;
        }

        f.action = "./bp_dummy.update.php";
        return true;
    }
</script>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
