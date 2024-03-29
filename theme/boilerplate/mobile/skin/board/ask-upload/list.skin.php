<?php
    if (!defined('_GNUBOARD_')) {
        exit;
    }
    // 개별 페이지 접근 불가
    include_once G5_LIB_PATH . '/thumbnail.lib.php';

    //ASKUPLOAD 환경설정
    inc_auconfig($bo_table);

    // add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
    //ASK-Uploader
    add_stylesheet('<link rel="stylesheet" href="' . G5_PLUGIN_URL . '/ask-uploader/player/plyr.css">', 30);
    add_stylesheet('<link rel="stylesheet" href="' . G5_PLUGIN_URL . '/ask-uploader/css/askuploader.css">', 31);
    add_javascript('<script src="' . G5_PLUGIN_URL . '/ask-uploader/player/plyr.min.js"></script>');
    add_javascript('<script src="' . G5_PLUGIN_URL . '/ask-uploader/player/plyr.polyfilled.min.js"></script>');
?>

<script src="<?php echo G5_JS_URL; ?>/jquery.fancylist.js"></script>

<?php if ($rss_href || $write_href) {?>
    <ul class="<?php echo isset($view) ? 'view_is_list btn_top' : 'btn_top top'; ?>">
        <?php if ($rss_href) {?><li><a href="<?php echo $rss_href ?>" class="btn_b01"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php }?>
<?php if ($admin_href) {?><li><a href="<?php echo $admin_href ?>" class="btn_admin"><i class="fa fa-user-circle" aria-hidden="true"></i><span class="sound_only">관리자</span></a></li><?php }?>
<?php if ($write_href) {?><li><a href="<?php echo $write_href ?>" class="btn_b02"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php }?>
    </ul>
<?php }?>

<!-- 게시판 목록 시작 -->
<div id="bo_gall">

    <?php if ($is_category) {?>
        <nav id="bo_cate">
            <h2><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?> 카테고리</h2>
            <ul id="bo_cate_ul">
                <?php echo $category_option ?>
            </ul>
        </nav>
    <?php }?>

    <div class="sound_only">
        <span>전체                                         <?php echo number_format($total_count) ?>건</span>
        <?php echo $page ?> 페이지
    </div>

    <form name="fboardlist"  id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <input type="hidden" name="sw" value="">

        <h2>이미지 목록</h2>

        <?php if ($is_checkbox) {?>
            <div id="gall_allchk">
                <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
                <input type="checkbox" id="chkall" onclick="if (this.checked)
                                all_checked(true);
                            else
                                all_checked(false);">
            </div>
        <?php }?>

        <ul id="gall_ul">
            <?php for ($i = 0; $i < count($list); $i++) {
                ?>
                <li class="gall_li<?php if ($wr_id == $list[$i]['wr_id']) {?>gall_now<?php }?>">
                    <div class="gall_li_wr">

                        <?php if ($is_checkbox) {?>
                            <span class="gall_li_chk">
                                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                            </span>
                        <?php }?>
                        <span class="sound_only">
                            <?php
                                if ($wr_id == $list[$i]['wr_id']) {
                                        echo "<span class=\"bo_current\">열람중</span>";
                                    } else {
                                        echo $list[$i]['num'];
                                    }

                                ?>
                        </span>

                        <div class="gall_img">
                            <?php
                                //ASK-Uploader
                                    /**
                                     * 첨부된 동영상부터 확인합니다.
                                     */
                                    $thumb         = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);
                                    $poster        = "";
                                    $display_video = '';
                                    if ($list[$i]['file']['count'] > 0) {
                                        //첨부파일 확장자
                                        $ext = au_get_ext($list[$i]['file']['0']['file']);
                                        //동영상일 경우 동영상 우선출력하고 없으면 링크에 유튜브 검사
                                        if (stristr(AU_FILE_VIDEO, $ext)) {
                                            if ($thumb['src']) {
                                                $poster        = "poster='{$thumb['src']}'";
                                                $display_video = "display_video";
                                            }
                                        ?>

                                    <!-- 동영상 플레이어 -->
                                    <div class="list-video-wrapper                                                                                                                                     <?php echo $display_video ?> player_<?php echo $i ?>">
                                        <div class="videocontent">
                                            <video id="ask-video-player_list_<?php echo $i ?>"<?php echo $poster ?> class='' src='<?php echo G5_DATA_URL . "/file/{$bo_table}/" . $list[$i]['file']['0']['file'] ?>' playsinline controls crossorigin preload="auto" width="100%">
                                                <source src='<?php echo G5_DATA_URL . "/file/{$bo_table}/" . $list[$i]['file']['0']['file'] ?>' type="video/<?php echo $ext ?>">";
                                                <p class="">
                                                    HTML5 지원 브라우저에서 플레이 가능합니다. 업그레이드 하시거나 크롬을 사용하시기 바랍니다.
                                                </p>
                                            </video>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(function () {
                                            const upload_player_<?php echo $i ?> = new Plyr('#ask-video-player_list_<?php echo $i ?>', {
                                                controls: ['play'],
                                                settings: [],
                                                autoplay: false
                                            });
                                            $('.player_<?php echo $i ?>').hover(
                                                    function () {
                                                        upload_player_<?php echo $i ?>.play();
                                                    },
                                                    function () {
                                                        upload_player_<?php echo $i ?>.pause();
                                                    }
                                            );
                                        });

                                    </script>
                                    <?php
                                        } else {

                                                    /**
                                                     * 첨부파일이 동영상이 아니면 유튜브 링크가 있는지 확인해서 플레이어 출력
                                                     * 유튜브 플레이어 - 1번 링크만 확인합니다.
                                                     */
                                                    $youtube1 = '';
                                                    $my_arr   = '';
                                                    if (isset($list[$i]['link']['1']) && $list[$i]['link']['1'] != null) {
                                                        if ($thumb['src']) {
                                                            $poster        = $thumb['src'];
                                                            $display_video = "display_video";
                                                        }
                                                        if (strstr($list[$i]['link']['1'], 'youtube.com')) {
                                                            parse_str(parse_url($list[$i]['link']['1'], PHP_URL_QUERY), $my_arr);
                                                            $youtube1 = $my_arr['v'];
                                                        } elseif (strstr($list[$i]['link']['1'], 'youtu.be')) {
                                                            preg_match("/youtu.be\/([^&]+)/", $list[$i]['link']['1'], $my_arr);
                                                            $youtube1 = $my_arr['1'];
                                                        }
                                                    ?>
                                        <!-- 동영상 플레이어 -->
                                        <div class="list-video-wrapper                                                                                                                                             <?php echo $display_video ?> player_<?php echo $i ?>">
                                            <div class="videocontent">
                                                <div id="ask-video-player_list_<?php echo $i ?>" class='youtube-list-player' data-plyr-provider="youtube" data-plyr-embed-id="<?php echo $youtube1 ?>" playsinline controls crossorigin preload="auto"></div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(function () {
                                                const youtube_player_<?php echo $i ?> = new Plyr('#ask-video-player_list_<?php echo $i ?>', {
                                                    controls: ['play'],
                                                    settings: [],
                                                    autoplay: false
                                                });
                                                youtube_player_<?php echo $i ?>.source = {
                                                    poster: "<?php echo $poster ?>"
                                                };
                                                $('.player_<?php echo $i ?>').hover(
                                                        function () {
                                                            youtube_player_<?php echo $i ?>.play();
                                                        },
                                                        function () {
                                                            youtube_player_<?php echo $i ?>.pause();
                                                        }
                                                );
                                            });

                                        </script>
                                        <?php
                                            }
                                                    }
                                                }
                                            ?>
                            <a href="<?php echo $list[$i]['href'] ?>">
                                <?php if ($list[$i]['is_notice']) { // 공지사항    ?>
                                    <span class="is_notice">공지</span>
                                    <?php
                                        } else {
                                                if ($thumb['src']) {
                                                    $img_content = '<img src="' . $thumb['src'] . '" alt="' . $thumb['alt'] . '" >';
                                                } else {
                                                    $img_content = '<div class="no_image mob" style="--aspect-ratio:16/9;"><span class="noimg-text mob">no image</span></div>';
                                                }
                                                if (!$display_video) {
                                                    echo $img_content;
                                                }
                                            }
                                        ?>
                            </a>
                        </div>
                        <div class="gall_text_href">
                            <?php
                                // echo $list[$i]['icon_reply']; 갤러리는 reply 를 사용 안 할 것 같습니다. - 지운아빠 2013-03-04
                                    if ($is_category && $list[$i]['ca_name']) {
                                    ?>
                                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                            <?php }?>
                            <a href="<?php echo $list[$i]['href'] ?>" class="gall_li_tit">
                                <?php echo $list[$i]['subject'] ?>
<?php if ($list[$i]['comment_cnt']) {?><span class="sound_only">댓글</span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php }?>
                            </a>
                            <?php
                                // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                                    // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                                    if (isset($list[$i]['icon_new'])) {
                                        echo $list[$i]['icon_new'];
                                    }

                                    if (isset($list[$i]['icon_hot'])) {
                                        echo $list[$i]['icon_hot'];
                                    }

                                    //if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                                    //if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                                    //if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];
                                ?>
                            <span class="sound_only">작성자 </span><?php echo $list[$i]['name'] ?>
                            <div class="gall_info">
                                <span class="sound_only">조회 </span><strong><i class="fa fa-eye" aria-hidden="true"></i>                                                                                                                                                                                                                                                       <?php echo $list[$i]['wr_hit'] ?></strong>
                                <?php if ($is_good) {?><span class="sound_only">추천</span><strong><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><?php echo $list[$i]['wr_good'] ?></strong><?php }?>
<?php if ($is_nogood) {?><span class="sound_only">비추천</span><strong><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><?php echo $list[$i]['wr_nogood'] ?></strong><?php }?>
                                <span class="sound_only">작성일 </span><span class="date"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $list[$i]['datetime2'] ?></span>
                            </div>
                        </div>
                    </div>
                </li>
            <?php }?>
<?php
    if (count($list) == 0) {
        echo "<li class=\"empty_list\">게시물이 없습니다.</li>";
    }
?>
        </ul>

        <?php if ($list_href || $is_checkbox || $write_href) {?>
            <div class="bo_fx">
                <ul class="btn_bo_adm">
                    <?php if ($list_href) {?>
                        <li><a href="<?php echo $list_href ?>" class="btn_b01 btn"> 목록</a></li>
                    <?php }?>
<?php if ($is_checkbox) {?>
                        <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed = this.value" class="btn"><i class="fa fa-trash-o" aria-hidden="true"></i><span class="sound_only">선택삭제</span></button></li>
                        <li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed = this.value" class="btn"><i class="fa fa-files-o" aria-hidden="true"></i><span class="sound_only">선택복사</span></button></li>
                        <li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed = this.value" class="btn"><i class="fa fa-arrows" aria-hidden="true"></i> <span class="sound_only">선택이동</span></button></li>
                    <?php }?>
                </ul>
            </div>
        <?php }?>

    </form>
</div>


<?php if ($is_checkbox) {?>
    <noscript>
    <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
    </noscript>
<?php }?>

<!-- 페이지 -->
<?php echo $write_pages; ?>

<fieldset id="bo_sch">
    <legend>게시물 검색</legend>

    <form name="fsearch" method="get">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sop" value="and">
        <label for="sfl" class="sound_only">검색대상</label>
        <select name="sfl">
            <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
            <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
            <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
            <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
            <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
            <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
            <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
        </select>
        <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="sch_input" size="15" maxlength="20">
        <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i> <span class="sound_only">검색</span></button>
    </form>
</fieldset>


<?php if ($is_checkbox) {?>
    <script>
        function all_checked(sw) {
            var f = document.fboardlist;

            for (var i = 0; i < f.length; i++) {
                if (f.elements[i].name == "chk_wr_id[]")
                    f.elements[i].checked = sw;
            }
        }

        function fboardlist_submit(f) {
            var chk_count = 0;

            for (var i = 0; i < f.length; i++) {
                if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
                    chk_count++;
            }

            if (!chk_count) {
                alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
                return false;
            }

            if (document.pressed == "선택복사") {
                select_copy("copy");
                return;
            }

            if (document.pressed == "선택이동") {
                select_copy("move");
                return;
            }

            if (document.pressed == "선택삭제") {
                if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
                    return false;

                f.removeAttribute("target");
                f.action = "./board_list_update.php";
            }

            return true;
        }

        // 선택한 게시물 복사 및 이동
        function select_copy(sw) {
            var f = document.fboardlist;

            if (sw == 'copy')
                str = "복사";
            else
                str = "이동";

            var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

            f.sw.value = sw;
            f.target = "move";
            f.action = "./move.php";
            f.submit();
        }
    </script>
<?php }?>
<!-- 게시판 목록 끝 -->
