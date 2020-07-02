<?php
$sub_menu = "800400";
include_once './_common.php';

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

//테이블 체크
if (ASKDB::exsit_table(BP_BOARD_TABLE) == false) {
    alert('테마 설치 후 이용하세요.', G5_THEME_URL . '/_install.php');
    exit;
}

$g5['title'] = 'Boilerplate  테마 게시판설정확장 목록';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');
$sql = "SELECT * from `" . BP_BOARD_TABLE . "`";
$result = sql_query($sql);
?>
<section class='board-list-wrap'>
    <div class="jumbotron p-5">
        <h1>게시판 확장 설정</h1>
        <p class="lead">
            게시판 설정의 여분필드를 사용하지 않고 별도 테이블에 분리해서 설정
        </p>
    </div>
    <?php echo bp_display_message(); ?>

    <table class="table table-bordered">
        <caption>등록된 게시판확장설정 목록</caption>
        <thead class="table-dark">
            <tr>
                <th>게시판</th>
                <th>목록스킨</th>
                <th>댓글첨부</th>
                <th>제목폰트</th>
                <th>갤러리Col</th>
                <th>웹진Col</th>
                <th>사진GPS</th>
                <th>다운로드포인트</th>
                <th>수정</th>
            </tr>
        </thead>
        <tbody class='text-center'>
            <?php
            for ($i = 0; $rows = sql_fetch_array($result); $i++) {
                $board_name = ASKDB::get_board_info($rows['bb_bo_table']);
                if(!$board_name){
                    continue;
                }
                echo "<tr>";
                echo "<td><a href='" . get_pretty_url($rows['bb_bo_table']) . "' target='_blank'>{$board_name['bo_subject']}</a></td>";
                echo "<td>" . ($rows['bb_list_skin'] == "list" ? "텍스트목록" : "") .
                    ($rows['bb_list_skin'] == "webzine" ? "웹진" : "") .
                    ($rows['bb_list_skin'] == "gallery" ? "갤러리" : "") .
                    ($rows['bb_list_skin'] == "card" ? "카드형" : "") .
                    ($rows['bb_list_skin'] == "youtube" ? "유튜브" : "") . "</td>";
                echo "<td>" . ($rows['bb_comment_image'] ? "<span class='badge badge-info'>사용</span>" : "미사용") . "</td>";
                echo "<td>" . ($rows['bb_use_font'] ? "<span class='badge badge-info'>사용</span>" : "미사용") . "</td>";
                echo "<td>{$rows['bb_gallery_col']}열</td>";
                echo "<td>{$rows['bb_webzine_col']}열</td>";
                echo "<td>" . ($rows['bb_exif_gps'] ? "<span class='badge badge-info'>사용</span>" : "미사용") . "</td>";
                echo "<td>" . ($rows['bb_use_download_point'] ? "<span class='badge badge-info'>사용</span>" : "미사용") . "</td>";
                echo "<td> <a href='./bp_board.php?w=u&bo_table={$rows['bb_bo_table']}' class='btn btn-primary'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i> 수정</a></td>";
                echo "</tr>";
            }
            if ($i == 0) {
                echo "<tr><td colspan='9' class='p-4'> 등록된 설정이 없습니다.  </td></tr>";
            }
            ?>
        </tbody>
    </table>
</section>

<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';
