<?php
$sub_menu = "800110";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

//테이블 체크
if (ASKDB::exsit_table(BP_SLIDER_TABLE) == false) {
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}

$g5['title'] = 'Boilerplate  테마 슬라이더 목록';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');
$sql = "SELECT * from `" . BP_SLIDER_TABLE . "`";
$result = sql_query($sql);
?>
<section class='slider-list-wrap'>
    <div class="jumbotron p-5">
        <h1>슬라이더</h1>
        <p class="lead">
            슬라이더 생성 후 하위 페이지를 등록하세요.
        </p>
    </div>
    <?php echo bp_display_message(); ?>

    <table class="table table-bordered">
        <caption>등록된 슬라이더 목록</caption>
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>사용</th>
                <th>자동넘기기</th>
                <th>컨트롤</th>
                <th>인디케이터</th>
                <th>페이드</th>
                <th>페이지</th>
                <th>관리</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                echo "<tr>";
                echo "<td>{$rows['bs_name']}</td>";
                echo $rows['bs_use'] == true ? "<td><i class='fa fa-play' aria-hidden='true'></i> 사용</td>" : '<td><i class="fa fa-ban" aria-hidden="true"></i> 중지</td>';
                echo $rows['bs_autoplay'] == true ? "<td><i class='fa fa-play' aria-hidden='true'></i> 사용</td>" : '<td><i class="fa fa-ban" aria-hidden="true"></i> 중지</td>';
                echo $rows['bs_control'] == true ? "<td><i class='fa fa-play' aria-hidden='true'></i> 사용</td>" : '<td><i class="fa fa-ban" aria-hidden="true"></i> 중지</td>';
                echo $rows['bs_indicator'] == true ? "<td><i class='fa fa-play' aria-hidden='true'></i> 사용</td>" : '<td><i class="fa fa-ban" aria-hidden="true"></i> 중지</td>';
                echo $rows['bs_crossfade'] == true ? "<td><i class='fa fa-play' aria-hidden='true'></i> 사용</td>" : '<td><i class="fa fa-ban" aria-hidden="true"></i> 중지</td>';
                echo $rows['bs_page_count'] == true ? "<td>{$rows['bs_page_count']} Page <br/><a href='./bp_slider_preview.php?idx={$rows['bs_idx']}' class='btn btn-link btn-sm' target='_blank'><i class='fa fa-eye' aria-hidden='true'></i> 미리보기</a></td>" : '<td>없음</td>';
                echo "<td><a href='./bp_slider_add.php?parent_idx={$rows['bs_idx']}' class='btn btn-info mr-1'><i class=\"fa fa-plus\" aria-hidden=\"true\"></i> 등록 </a><a href='./bp_slider.php?w=u&idx={$rows['bs_idx']}' class='btn btn-primary'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i> 수정</a> <a href='./bp_slider.delete.php?w=de&idx={$rows['bs_idx']}' class='btn btn-danger delete-item'><i class=\"fa fa-trash\" aria-hidden=\"true\"></i> 삭제</a> </td>";
                echo "</tr>";
            }
            if ($i == 0) {
                echo "<tr><td colspan='7' class='p-4'> 등록된 슬라이더가 없습니다. <a href='./bp_slider.php' class='btn btn-link'>슬라이더 생성하기</a></td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>
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
<div class="btn_fixed_top btn_confirm">
    <a href="./bp_slider.php" class="btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i> 슬라이더 생성</a>
</div>
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
