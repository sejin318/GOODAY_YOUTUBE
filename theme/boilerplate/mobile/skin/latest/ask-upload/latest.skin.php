<?php
    /**
     * ASK Upload 용 샘플 최신글
     */
    if (!defined('_GNUBOARD_')) {
        exit;
    }
    // 개별 페이지 접근 불가
    include_once G5_LIB_PATH . '/thumbnail.lib.php';
    //ASKUPLOAD 환경설정
    inc_auconfig($bo_table);
    // add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    add_stylesheet('<link rel="stylesheet" href="' . $latest_skin_url . '/style.css">', 0);
    //ASK-Uploader
    add_stylesheet('<link rel="stylesheet" href="' . G5_PLUGIN_URL . '/ask-uploader/player/plyr.css">', 30);
    add_stylesheet('<link rel="stylesheet" href="' . G5_PLUGIN_URL . '/ask-uploader/css/askuploader.css">', 31);
    add_javascript('<script src="' . G5_PLUGIN_URL . '/ask-uploader/player/plyr.min.js"></script>');
    add_javascript('<script src="' . G5_PLUGIN_URL . '/ask-uploader/player/plyr.polyfilled.min.js"></script>');
    $rand_id = rand(10000, 99999);
    //썸네일 크기
    $thumb_width  = 320;
    $thumb_height = 180;
?>


<div class="pic_lt">
    <h2 class="lat_title"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject ?></a></h2>
    <ul>

    <?php for ($i = 0; $i < count($list); $i++) {?>
        <li>
        <div class='latest-item-wrapper'>
        <?php

                //ASK-Uploader
                /**
                 * 첨부된 동영상부터 확인합니다.
                 */
                $thumb         = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);
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
                            <div class="<?php echo 'list-video-wrapper ' . $display_video ?> player_<?php echo $i . $rand_id ?>">
                                <div class="videocontent">
                                    <video id="ask-video-player_<?php echo $i . $rand_id ?>"<?php echo $poster ?> class='' src='<?php echo G5_DATA_URL . "/file/{$bo_table}/" . $list[$i]['file']['0']['file'] ?>'
                                        playsinline controls crossorigin preload="auto" width="100%">
                                        <source src='<?php echo G5_DATA_URL . "/file/{$bo_table}/" . $list[$i]['file']['0']['file'] ?>' type="video/<?php echo $ext ?>">";
                                        <p class="">
                                            HTML5 지원 브라우저에서 플레이 가능합니다. 업그레이드 하시거나 크롬을 사용하시기 바랍니다.
                                        </p>
                                    </video>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(function () {
                                    <?php echo "const upload_player_" . $i . $rand_id ?> = new Plyr(
                                        '#ask-video-player_<?php echo $i . $rand_id ?>', {
                                            controls: ['play'],
                                            settings: [],
                                            autoplay: false,
                                            muted: false
                                        });
                                    $('.player_<?php echo $i . $rand_id ?>').hover(
                                        function () {
                                            <?php echo "upload_player_" . $i . $rand_id ?>.play();
                                            /* 4초만 플레이
                                            setTimeout(function(){
                                                upload_player_<?php echo $i . $rand_id ?>.pause();
                                                }, 4000);
                                                */
                                        },
                                        function () {
                                            <?php echo "upload_player_" . $i . $rand_id ?>.pause();
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
                            <div class="<?php echo 'list-video-wrapper ' . $display_video ?> player_<?php echo $i . $rand_id ?>">
                                <div class="videocontent">
                                    <div id="ask-video-player_<?php echo $i . $rand_id ?>" class='youtube-list-player' data-plyr-provider="youtube" data-plyr-embed-id="<?php echo $youtube1 ?>" playsinline controls crossorigin preload="auto"></div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(function () {
                                    <?php echo "const youtube_player_" . $i . $rand_id ?> = new Plyr(
                                        '#ask-video-player_<?php echo $i . $rand_id ?>', {
                                            controls: ['play'],
                                            settings: [],
                                            autoplay: false,
                                            muted: false
                                        });
                                    <?php echo "youtube_player_" . $i . $rand_id ?>.source = {
                                        poster: "<?php echo $poster ?>"
                                    };
                                    $('.player_<?php echo $i . $rand_id ?>').hover(
                                        function () {
                                            <?php echo "youtube_player_" . $i . $rand_id ?>.play();
                                            /* 4초만 플레이
                                            setTimeout(function(){
                                                youtube_player_<?php echo $i . $rand_id ?>.pause();
                                            }, 4000);
                                            */
                                        },
                                        function () {
                                            <?php echo "youtube_player_" . $i . $rand_id ?>.pause();
                                        }
                                    );
                                });
                            </script>
                            <?php }
                                        }
                                    }
                                ?>
                            <a href="<?php echo $list[$i]['href'] ?>">
                                <?php if ($list[$i]['is_notice']) { // 공지사항   ?>
                                <span class="is_notice">공지</span>
                                <?php
                                    } else {
                                            if ($thumb['src']) {
                                                $img_content = '<img src="' . $thumb['src'] . '" alt="' . $thumb['alt'] . '" class="latest-photos">';
                                            } else {
                                                $img_content = '<div class="no_image" style="--aspect-ratio:16/9;"><span class="noimg-text">no image</span></div>';
                                            }
                                            if (!$display_video) {
                                                echo $img_content;
                                            }
                                        }
                                    ?>
                            </a>
            <?php
                //아이콘출력
                    if ($list[$i]['icon_secret']) {
                        echo "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";
                    }

                    if ($list[$i]['icon_new']) {
                        echo "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span>";
                    }

                    if ($list[$i]['icon_hot']) {
                        echo "<span class=\"hot_icon\">H<span class=\"sound_only\">인기글</span></span>";
                    }

                    echo "<a href=\"" . $list[$i]['href'] . "\"> ";
                    if ($list[$i]['is_notice']) {
                        echo "<strong>" . $list[$i]['subject'] . "</strong>";
                    } else {
                        echo $list[$i]['subject'];
                    }

                    echo "</a>";

                    // if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
                    // if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }

                    //echo $list[$i]['icon_reply']." ";
                    // if ($list[$i]['icon_file']) echo " <i class=\"fa fa-download\" aria-hidden=\"true\"></i>" ;
                    //if ($list[$i]['icon_link']) echo " <i class=\"fa fa-link\" aria-hidden=\"true\"></i>" ;

                    if ($list[$i]['comment_cnt']) {
                        echo "<span class=\"lt_cmt\">+ " . $list[$i]['wr_comment'] . "</span>";
                    }

                ?>

            <span class="lt_date"><?php echo $list[$i]['datetime2'] ?></span>
            </div>
        </li>
    <?php }?>
<?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
<?php }?>
    </ul>
    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>" class="lt_more"><span class="sound_only"><?php echo $bo_subject ?></span><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only"> 더보기</span></a>
</div>