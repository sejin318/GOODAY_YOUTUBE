<?php
if (!defined("_GNUBOARD_")) {
    exit; // 개별 페이지 접근 불가
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/poll/poll.basic.css">', 50);
?>
<div class='poll-wrap'>
    <!-- 설문조사 시작 { -->
    <form name="fpoll" action="<?php echo G5_BBS_URL ?>/poll_update.php" onsubmit="return fpoll_submit(this);" method="post">
        <input type="hidden" name="po_id" value="<?php echo $po_id ?>">
        <input type="hidden" name="skin_dir" value="<?php echo urlencode($skin_dir); ?>">
        <section id="poll" class='border p-2 background-7'>
            <header>
                <h2 class="page-title border-color-6 border-bottom p-2">설문조사</h2>
            </header>
            <div class="poll_con">
                <h3><?php echo $po['po_subject'] ?></h3>
                <ul class='poll-item'>
                    <?php for ($i = 1; $i <= 9 && $po["po_poll{$i}"]; $i++) {  ?>
                        <li class="chk_box">
                            <input type="radio" name="gb_poll" value="<?php echo $i ?>" id="gb_poll_<?php echo $i ?>">
                            <label for="gb_poll_<?php echo $i ?>">
                                <span></span>
                                <?php echo $po['po_poll' . $i] ?>
                            </label>
                        </li>
                    <?php }  ?>
                </ul>
                <div class='btn-navbar text-center'>
                    <button type="submit" class="btn_poll btn btn-primary">투표</button>
                    <?php if ($is_admin == "super") {  ?>
                        <a href="<?php echo G5_ADMIN_URL ?>/poll_form.php?w=u&amp;po_id=<?php echo $po_id ?>" class="btn btn-secondary" title="설문관리"><i class="fa fa-cog"></i><span class="sr-only">설문관리</span></a>
                    <?php }  ?>
                    <a href="<?php echo G5_BBS_URL . "/poll_result.php?po_id=$po_id&amp;skin_dir=" . urlencode($skin_dir); ?>" target="_blank" onclick="poll_result(this.href); return false;" class="btn btn-secondary">결과보기</a>
                </div>
            </div>
        </section>
    </form>

    <script>
        function fpoll_submit(f) {
            <?php
            if ($member['mb_level'] < $po['po_level'])
                echo " alert('권한 {$po['po_level']} 이상의 회원만 투표에 참여하실 수 있습니다.'); return false; ";
            ?>

            var chk = false;
            for (i = 0; i < f.gb_poll.length; i++) {
                if (f.gb_poll[i].checked == true) {
                    chk = f.gb_poll[i].value;
                    break;
                }
            }

            if (!chk) {
                alert("투표하실 설문항목을 선택하세요");
                return false;
            }

            var new_win = window.open("about:blank", "win_poll", "width=616,height=500,scrollbars=yes,resizable=yes");
            f.target = "win_poll";

            return true;
        }

        function poll_result(url) {
            <?php
            if ($member['mb_level'] < $po['po_level'])
                echo " alert('권한 {$po['po_level']} 이상의 회원만 결과를 보실 수 있습니다.'); return false; ";
            ?>

            win_poll(url);
        }
    </script>

</div>
<!-- } 설문조사 끝 -->