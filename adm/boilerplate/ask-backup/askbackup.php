<?php

/**
 * ASK Backup 
 * 
 */
$sub_menu = '800300';
include_once "./_common.php";
include_once "./askbackup.config.php";
include_once "./askbackup.lib.php";


$g5['title'] = 'Boilerplate DB Backup';
include_once G5_ADMIN_PATH . DIRECTORY_SEPARATOR . 'admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/ask-backup/css/style.css">', 100);
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/boilerplate/style.css">');

?>
<div class="jumbotron p-5">
    <h1>그누보드 DB 백업</h1>
    <div class="led">
        <p>관리자에서 간단하게 백업할 수 있습니다.</p>
        <p>백업완료되면 자동다운로드 됩니다. 대용량 백업시 오류가 날 수 있으니 SSH에 접속해 직접 Dump 하시기 바랍니다.</p>
        <p>SQL 복원시 기존 DB 테이블 삭제 후 복원됩니다.</p>
        <p>테이블 크기가 다르게 출력되는 부분은 테이블 최적화를 하세요.</p>
    </div>
</div>


<section class="db-list">
    <form name="fbackup" id="fbackup" action="./askbackup.update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" value="" id="token">

        <div class='form-action'>
            <div class='options float-left'>
                <label><input type="radio" name='data_type' value="structure" />DB구조만 백업</label>
                <label><input type="radio" name='data_type' value="data" />DB데이터만 백업</label>
                <label><input type="radio" name='data_type' value="all" checked="checked" />구조,데이터 모두 백업</label>
            </div>
        </div>
        <?php
        //MySQL Table schema
        $sql = "SELECT *,TABLE_COLLATION as tbl_coll, TABLE_NAME AS 'tablename', table_rows AS 'rows', (data_length + index_length) AS 'size'
                FROM information_schema.tables WHERE information_schema.tables.table_schema='" . G5_MYSQL_DB . "'";
        $result = sql_query($sql);
        $table = "<table class='db-list table table-bordered'>" . PHP_EOL;
        $table .= "<thead class='thead-dark'>" . PHP_EOL;
        $table .= "<tr>" . PHP_EOL;
        $table .= "<th class='table-no'><label><input type='checkbox' name='allcheck' value=''> All</label></th><th>테이블명</th><th>데이터정렬방식</th><th>엔진</th><th>행</th><th>크기(Kb)</th>" . PHP_EOL;
        //$table .= "<th>부담</th>";
        $table .= "</tr></thead>" . PHP_EOL;
        $table .= "<tbody>" . PHP_EOL;
        $overhead_size = 0;
        for ($i = 0; $list = sql_fetch_array($result); $i++) {
            $no = $i + 1;
            /*
              $sql2 = "select DATA_FREE as data_free FROM INFORMATION_SCHEMA.PARTITIONS WHERE TABLE_SCHEMA = '" . G5_MYSQL_DB . "' AND  TABLE_NAME   = '{$list['tablename']}'";
              $tbl_status = sql_fetch($sql2);
              $tr_bg = '';
              $overhead_class = '';
              //테이블 오버헤드
              /*
              if ($tbl_status['data_free'] > 0) {
              $tr_bg = "class='overhead-table'";
              $overhead_size += $tbl_status['data_free'];
              $overhead_class = 'overhead';
              }
             * 
             */
            $table .= "<tr {$tr_bg}>" . PHP_EOL;
            $table .= "<td><label for='{$list['tablename']}'><input class='{$overhead_class}' type='checkbox' name='tables[]' value='{$list['tablename']}' id='{$list['tablename']}'/> {$no}</label></td>" . PHP_EOL;
            $table .= "<td><label for='{$list['tablename']}'>{$list['tablename']}</label></td>" . PHP_EOL;
            $table .= "<td>{$list['tbl_coll']}</td>" . PHP_EOL;
            $table .= "<td>{$list['ENGINE']}</td>" . PHP_EOL;
            $table .= "<td>{$list['rows']}</td>" . PHP_EOL;
            $table .= "<td><span>" . round($list['size'] / 1024, 1) . "</span> kb</td>" . PHP_EOL;
            //$table .= "<td>{$tbl_status['data_free']}</td>";
            $table .= "<tr>" . PHP_EOL;
        }
        $table .= "</tbody>" . PHP_EOL;
        $table .= "</table>" . PHP_EOL;
        echo $table . PHP_EOL;
        ?>
        <div class="btn_fixed_top btn_confirm">
            <button class='btn btn-primary' type='submit'>백업하기</button>
        </div>
    </form>
</section>
<script type="text/javascript">
    $(function() {
        $('input[name=overhead]').click(function(event) {
            if ($(this).is(':checked') == true) {
                $('.overhead').attr('checked', true);
            } else {
                $('.overhead').attr('checked', false);
            }
        });
        $('input[name=allcheck]').click(function(event) {
            if ($(this).is(':checked') == true) {
                $('input[name="tables[]"]').attr('checked', true);
            } else {
                $('input[name="tables[]"]').attr('checked', false);
            }
        });
        $("#fbackup").submit(function(event) {
            if ($('input[name=data_type]').is(':checked') == false) {
                alert('백업 종류를 선택하세요. DB구조 또는 DB구조 및 데이터 백업');
                return false;
            }
            var table_arr = $('input[name="tables[]"]:checked').length;
            if (table_arr == 0) {
                alert('하나이상의 테이블을 선택하세요.');
                return false;
            }
            return true;
        });
    });
</script>
<?php
include_once G5_ADMIN_PATH . DIRECTORY_SEPARATOR . 'admin.tail.php';
