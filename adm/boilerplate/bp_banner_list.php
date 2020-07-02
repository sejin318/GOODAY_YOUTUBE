<?php
$sub_menu = "800115";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

//테이블 체크
if (ASKDB::exsit_table(BP_BANNER_TABLE) == false) {
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}

$g5['title'] = 'Boilerplate  테마 배너 목록';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');

$sql_common = " from `" . BP_BANNER_TABLE . "` ";
$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and (bb_name like '%{$stx}%' or bb_area like '%{$stx}%') ";
}

$sql_order = " order by bb_idx ";

$sql = " SELECT count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 15;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1;
} // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " SELECT * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
?>
<div class="jumbotron p-5">
    <h1>배너관리자 - 목록</h1>
    <p class="lead">
        사이트에 배너를 관리 할 수 있습니다.<br/>
    </p>
</div>
<?php echo bp_display_message(); ?>
<section class='slider-list-wrap'>
    <div class="search-wrap">
        <form action="./bp_banner_list.php" method="get">
            <div class="ml-auto mr-auto w-100 mb-2">
                <div class="input-group">
                    <input type="text" name="stx" value="<?php echo $stx ?>" class="form-control" placeholder="배너이름 or 위치" />
                    <?php if ($stx) {
                        echo '<button type="button" class="btn btn-danger" onclick="location.href=\'./bp_banner_list.php\'">목록</button>';
                    } ?>
                    <button type="submit" class="btn btn-primary">검색</button>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-bordered">
        <caption>등록된 배너 목록</caption>
        <thead class="table-dark">
            <tr>
                <th>배너이름</th>
                <th>위치</th>
                <th>형식</th>
                <th>Tag</th>
                <th>Hit</th>
                <th>기간</th>
                <th>미리보기</th>
                <th>관리</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                echo "<tr>";
                echo "<td>{$rows['bb_name']}</td>";
                echo "<td>{$rows['bb_area']}</td>";
                echo "<td>{$rows['bb_type']}</td>";
                echo "<td>{$rows['bb_tag']}</td>";
                echo "<td>{$rows['bb_hit']}</td>";
                if ($rows['bb_startday'] == '0000-00-00') {
                    echo "<td>기간없음</td>";
                } else {
                    echo "<td>{$rows['bb_startday']} ~ {$rows['bb_endday']}</td>";
                }
                echo "<td class='banner-preview'>";
                if ($rows['bb_type'] == 'text') {
                    echo "<a href='{$rows['bb_url']}' target='_blank'>{$rows['bb_name']}</a>";
                }
                if ($rows['bb_type'] == 'image') {
                    echo "<a href='{$rows['bb_url']}' target='_blank' class='w-100 banner-preview-link'><img src='" . BP_FILE_URL . DS . "{$rows['bb_image']}' alt='{$rows['bb_name']}'></a>";
                }
                if ($rows['bb_type'] == 'html') {
                    echo $rows['bb_html'];
                }
                echo "</td>";
                echo "<td> <a href='./bp_banner.php?w=u&idx={$rows['bb_idx']}' class='btn btn-primary'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a> <a href='./bp_banner.update.php?w=de&idx={$rows['bb_idx']}' class='btn btn-danger delete-item'><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a> </td>";
                echo "</tr>";
            }
            if ($i == 0) {
                echo "<tr><td colspan='8' class='p-4'> 등록된 배너가 없습니다. <a href='./bp_banner.php' class='btn btn-link'>배너등록하기</a></td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>
<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='); ?>
<div class="btn_fixed_top btn_confirm">
    <a href="./bp_banner.php" class="btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i> 배너등록</a>
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
<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
