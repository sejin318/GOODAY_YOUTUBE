<?php

/**
 * point.skin.php
 * 포인트내역
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

include_once G5_THEME_PATH . "/head.php";
?>
<div class="point-wrap">
    <h3 class='page-title p-2 mb-3'><?php echo $g5['title'] ?></h3>
    <div class="table-responsive table-wrap">
        <table class="table table-bordered">
            <caption>
                보유포인트
                <span><?php echo number_format($member['mb_point']); ?></span>
            </caption>
            <thead class="thead-dark">
                <tr>
                    <th>내역</th>
                    <th>포인트</th>
                    <th>포인트</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sum_point1 = $sum_point2 = $sum_point3 = 0;

                $sql = " select * {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
                $result = sql_query($sql);
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $point1 = $point2 = 0;
                    $point_use_class = '';
                    if ($row['po_point'] > 0) {
                        $point1 = '+' . number_format($row['po_point']);
                        $sum_point1 += $row['po_point'];
                    } else {
                        $point2 = number_format($row['po_point']);
                        $sum_point2 += $row['po_point'];
                        $point_use_class = 'point_use';
                    }

                    $po_content = $row['po_content'];

                    $expr = '';
                    if ($row['po_expired'] == 1)
                        $expr = ' txt_expired';
                    ?>
                    <tr class="<?php echo $point_use_class; ?>">
                        <td>
                            <?php echo $po_content; ?>
                        </td>
                        <td>
                            <?php if ($point1) {
                                    echo $point1;
                                } else {
                                    echo $point2;
                                }  ?>
                        </td>
                        <td>
                            <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $row['po_datetime']; ?>
                            <span class="point_date<?php echo $expr; ?>">
                                <?php if ($row['po_expired'] == 1) { ?>
                                    만료 <?php echo substr(str_replace('-', '', $row['po_expire_date']), 2); ?>
                                <?php } else echo $row['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date']; ?>
                            </span>
                        </td>
                    </tr>
                <?php
                } //for

                if ($i == 0) {
                    echo '<td colspan="3" class="empty_li">자료가 없습니다.</td>';
                } else {
                    if ($sum_point1 > 0) {
                        $sum_point1 = "+" . number_format($sum_point1);
                    }
                    $sum_point2 = number_format($sum_point2);
                }
                ?>


            </tbody>
            <tfoot>
                <tr>
                    <td>
                        소계
                    </td>
                    <td>
                        <span><?php echo $sum_point1; ?> Point</span>
                    </td>
                    <td>
                        <span><?php echo $sum_point2; ?> Point</span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- 페이지 -->
    <div class="paging mb-3 pt-3 pb-3">
        <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='); ?>
    </div>
</div>

<?php
include_once G5_THEME_PATH . "/tail.php";
