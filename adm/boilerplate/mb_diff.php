<?php
$sub_menu = "800210";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

if (ASKDB::exsit_table(BP_CONFIG_TABLE) == false) {
    //테마 설치 후 이용하세요.
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}

$g5['title'] = 'Boilerplate - 회원비교';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');
?>
<div class="jumbotron p-5">
    <h1>회원간 간단 비교</h1>
    <p class="lead">
        회원간 비교가 쉽도록 출력합니다.
    </p>
</div>
<form action='./mb_diff.php' method="post" class="form">
    <div class="input-group">
        <input type="text" name='mb_id_arr' value='<?php echo $mb_id_arr ?>' class="form-control" placeholder="아이디 입력. 쉼표로 구분">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">조회</button>
        </div>
    </div><!-- /input-group -->
</form>
<?php if ($_POST) {
    $arr = explode(',', trim($mb_id_arr));
    $_data = DB::member_diff($arr);

?>
    <div class='result-diff mt-2'>
        <table class='table table-bordered table-striped'>
            <thead class="thead-dark">
                <tr>
                    <th>아이디</th>
                    <th>별명</th>
                    <th>이름</th>
                    <th>
                        아이피(로그인)
                    </th>
                    <th>주소</th>
                    <th>전화</th>
                    <th>휴대폰</th>
                    <th>가입일</th>
                    <th>이메일</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($_data) {
                    foreach ($_data as $rows) {
                ?>
                        <tr>
                            <td>
                                <a href="<?php echo G5_ADMIN_URL . DS . "member_form.php?w=u&mb_id={$rows['mb_id']}"; ?>"><i class="fa fa-external-link" aria-hidden="true"></i> <?php echo $rows['mb_id'] ?></a>
                            </td>
                            <td><?php echo $rows['mb_nick'] ?></td>
                            <td><?php echo $rows['mb_name'] ?></td>
                            <td>
                                <?php echo $rows['mb_ip'] ?><br />
                                (<?php echo $rows['mb_login_ip'] ?>)
                            </td>
                            <td><?php echo $rows['mb_addr1'] ?> <?php echo $rows['mb_addr2'] ?></td>
                            <td><?php echo $rows['mb_tel'] ?></td>
                            <td><?php echo $rows['mb_hp'] ?></td>
                            <td><?php echo $rows['mb_datetime'] ?></td>
                            <td><?php echo $rows['mb_email'] ?></td>
                        </tr>
                <?php }
                }else{
                    echo "<tr><td colspan='9' class='p-4 text-center'>데이터가 없습니다. 회원아이디를 정확히 입력하세요.</td></tr>";
                } ?>
            </tbody>
        </table>
    </div>
<?php } ?>

<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
