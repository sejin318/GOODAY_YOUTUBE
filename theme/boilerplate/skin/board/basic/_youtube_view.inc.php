<?php

/**
 * 유튜브 플레이어 View skin
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
####################
# Youtube 게시판용
####################
add_javascript("<script src='" . BP_PLYR . "/dist/plyr.min.js'></script>", 200);
add_javascript("<script src='" . BP_PLYR . "/dist/plyr.polyfilled.min.js'></script>", 201);
add_stylesheet("<link rel='stylesheet' href='" . BP_PLYR . "/dist/plyr.css'>", 200);
?>
<div class='youtube-view-wrap'>
    <?php
    //캐시 키값
    $_cache['key'] = "youtube_{$bo_table}_{$wr_id}" . md5($view['link'][2]);
    $_cache['string'] = $InstanceCache->get($_cache['key']);
    //캐시 없으면 실행
    if (is_null($_cache['string'])) {
        $tube_tmp = explode("\n", $view['link'][2]);
        $tube_arr = array();
        $a = 0;
        foreach ($tube_tmp as $t) {
            $t = trim($t);
            if ($t != '') {
                $tube_arr[$a] = $embera->getUrlData($t);
                $a++;
            }
        }
        $i = 0;
        $youtube = array();
        foreach ($tube_arr as $_item) {
            foreach ($_item as $_y) {
                $youtube[$i]['thumbnail'] = $_y['thumbnail_url'];
                $youtube[$i]['id'] = $_y['youtube_watch_id'];
                $youtube[$i]['title'] = $_y['title'];
                $youtube[$i]['html'] = $_y['html'];
                $youtube[$i]['author_name'] = $_y['author_name'];
                $youtube[$i]['author_url'] = $_y['author_url'];
                $i++;
            }
        }
        //캐시 저장 24시간
        $InstanceCache->set($_cache['key'], $youtube, 60 * 60 * 24);
    } else {
        $youtube = $_cache['string'];
    }

    if ($youtube) {
    ?>
        <div class="youtube-player-wrap position-relative">
            <div class='text-right'><span class='badge badge-info'>동영상 <?php echo count($youtube) ?>개</span></div>
            <div class="playlist">
                <!-- Player -->
                <div id="player" data-plyr-provider="youtube" controls data-plyr-embed-id="<?php echo $youtube[0]['id'] ?>"></div>

                <div class="btn-toolbar mt-2 justify-content-center" role="toolbar" aria-label="Toolbar with button groups">
                    <div class='btn-group btn-group-sm'>
                        <button type="button" data-state='' class="btn btn-primary js-play mr-1"><i class="fa fa-play" aria-hidden="true"></i></button>
                        <!-- <button type="button" class="btn btn-secondary js-pause mr-1"><i class="fa fa-pause" aria-hidden="true"></i></button> -->
                        <button type="button" class="btn btn-secondary js-stop mr-1"><i class="fa fa-stop" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-secondary js-rewind mr-1"><i class="fa fa-backward" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-secondary js-forward mr-1"><i class="fa fa-forward" aria-hidden="true"></i> </button>
                        <button type="button" class="btn btn-secondary js-volume-up mr-1"><i class="fa fa-volume-up" aria-hidden="true"></i> </button>
                        <button type="button" class="btn btn-secondary js-volume-down mr-1"><i class="fa fa-volume-down" aria-hidden="true"></i> </button>
                    </div>
                </div>
                <?php if (count($youtube) > 1) { ?>
                    <!-- Swiper Youtube List -->
                    <div class="swiper-container youtube-thumb-list-container mt-2 mb-2">
                        <div class="swiper-wrapper">
                            <?php
                            foreach ($youtube as $_l) { ?>
                                <div class="swiper-slide player-src <?php echo "slide_" . $_l['id'] ?>" data-poster="<?php echo $_l['thumbnail'] ?>" data-type="video" data-plyr-provider='youtube' data-video-id='<?php echo $_l['id'] ?>' playsinline preload="auto">
                                    <!-- <img src='<?php echo $_l['thumbnail'] ?>' class="img"> -->
                                    <div class='youtube-image d-flex align-items-center' style='background-image:url(<?php echo $_l['thumbnail'] ?>)'>
                                        <div class='play-state <?php echo "active_" . $_l['id'] ?>'><i class="fa fa-play-circle" aria-hidden="true"></i></div>
                                    </div>
                                    <div class='youtube-title block-with-text'><?php echo $_l['title'] ?></div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <!-- Add Pagination 
                        <div class="swiper-pagination"></div>
                        -->
                    </div>
                <?php } ?>
            </div>
        </div>
        <script>
            <?php if (is_mobile()) {
                echo "var isMobile = true;";
            } else {
                echo "var isMobile = false;";
            } ?>
            console.log(isMobile);

            function setCurrentSlide(ele, index) {
                $(".youtube-thumb-list-container .swiper-slide").removeClass("selected");
                ele.addClass("selected");
                //swiperTabMenu.initialSlide=index;
            }

            function getUrlParams(url) {
                var params = {};
                url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) {
                    params[key] = value;
                });
                return params;
            }

            //Youtube thumbnail list slider
            var player_swiper = new Swiper('.youtube-thumb-list-container', {
                slidesPerView: 3,
                spaceBetween: 20,
                /*
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                */
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                grabCursor: true,
                //해상도별 배너수 조절
                breakpoints: {
                    1200: {
                        slidesPerView: 6,
                        spaceBetween: 10
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 10
                    },
                    990: {
                        slidesPerView: 5,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 10
                    },
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    },
                    320: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    }
                }
            });

            document.addEventListener('DOMContentLoaded', () => {
                // Setup the player
                const player = new Plyr('#player', {
                    debug: false,
                    controls: [
                        'play-large', // The large play button in the center
                        'restart', // Restart playback
                        //'rewind', // Rewind by the seek time (default 10 seconds)
                        'play', // Play/pause playback
                        //'fast-forward', // Fast forward by the seek time (default 10 seconds)
                        'progress', // The progress bar and scrubber for playback and buffering
                        'current-time', // The current time of playback
                        'duration', // The full duration of the media
                        'mute', // Toggle mute
                        'volume', // Volume control
                        'captions', // Toggle captions
                        'settings',
                        'pip', // Picture-in-picture (currently Safari only)
                        'airplay', // Airplay (currently Safari only)
                        'fullscreen', // Toggle fullscreen
                    ],
                    title: 'Boilerplate Youtube Player',
                    settings: ['captions', 'quality', 'speed', 'loop'],
                    quality: {
                        default: 'hd720',
                        options: ['hd2160', 'hd1440', 'hd1080', 'hd720', 'large', 'medium', 'small', 'tiny']
                    }

                });

                // Expose
                window.player = player;
                //모바일은 자동실행 안됨
                if (isMobile == false) {
                    setTimeout(function() {
                        player.play();
                    }, 1000);
                }

                //플레이 준비됨
                player.on('ready', event => {
                    //console.log("------------------ PLAYER-READY ------------------");
                    const instance = event.detail.plyr;
                });
                $('.player-src').click('click', function() {
                    var src = $(this).data("video-id");
                    player.source = {
                        type: 'video',
                        sources: [{
                            src: src,
                            provider: 'youtube'
                        }]
                    };
                    setTimeout(function() {
                        player.play();
                    }, 1000);
                });

                //플레이
                player.on('play', event => {
                    const instance = event.detail.plyr;
                    //모바일은 아래와 같이 음소거를 해야 자동실행 됩니다.
                    //player.muted = true;
                    //console.log(" **************** PLAYER-PLAY **************** ");
                    const urlParams = new URLSearchParams(getUrlParams(instance.source));
                    var playActiveId = ".active_" + urlParams.get('v');
                    setTimeout(function() {
                        $('.play-state').removeClass('active');
                        $(playActiveId).addClass('active');
                    }, 100);
                    setTimeout(function() {
                        $('.js-play .fa-play').removeClass('fa-play').addClass('fa-pause');
                        $('.js-play').data('state', 'play');
                    }, 100);
                });

                //잠시멈춤
                player.on('pause', event => {
                    const instance = event.detail.plyr;
                    //console.log(" **************** PLAYER-PAUSE **************** ");
                    setTimeout(function() {
                        $('.js-play .fa-pause').removeClass('fa-pause').addClass('fa-play');
                        $('.js-play').data('state', 'pause');
                    }, 100);
                });

                //Youtube events
                player.on('statechange', event => {
                    const instance = event.detail.plyr;
                    //console.log(" **************** PLAYER-statechange **************** ");
                    //중단
                    if (event.detail.code == 5) {
                        setTimeout(function() {
                            $('.js-play .fa-pause').removeClass('fa-pause').addClass('fa-play');
                            $('.js-play').data('state', 'stop');
                        }, 50);
                    }
                    //플레이
                    if (event.detail.code == 1) {
                        setTimeout(function() {
                            $('.js-play .fa-play').removeClass('fa-play').addClass('fa-pause');
                            $('.js-play').data('state', 'play');
                        }, 50);
                    }

                });

                //종료
                player.on('ended', event => {
                    const instance = event.detail.plyr;
                    //console.log(" @@@@ PLAYER-ENDED @@@@ ");
                    const urlParams = new URLSearchParams(getUrlParams(instance.source));
                    var playActiveId = ".slide_" + urlParams.get('v');
                    //다음 동영상
                    setTimeout(function() {
                        $(playActiveId).next().trigger('click');
                        //스와이프 이동
                        player_swiper.slideTo(player_swiper.realIndex++);
                    }, 1000);

                });
                // Bind event listener
                function on(selector, type, callback) {
                    document.querySelector(selector).addEventListener(type, callback, false);
                }

                // Play
                on('.js-play', 'click', () => {
                    console.log($('.js-play').data('state'));
                    var playState = $('.js-play').data('state');
                    if (playState == 'play') {
                        player.pause();
                    }
                    if (playState == 'pause' || playState == 'stop') {
                        player.play();
                    }
                });

                // Pause
                /*
                on('.js-pause', 'click', () => {
                    player.pause();
                });*/

                // Stop
                on('.js-stop', 'click', () => {
                    player.stop();
                    $('.js-play').data('state', 'stop');
                });

                // Rewind
                on('.js-rewind', 'click', () => {
                    player.rewind();
                });

                // Forward
                on('.js-forward', 'click', () => {
                    player.forward();
                });
                on('.js-volume-up', 'click', () => {
                    player.increaseVolume(0.1);
                });
                on('.js-volume-down', 'click', () => {
                    player.decreaseVolume(0.1);
                });
            });
        </script>

    <?php } ?>
</div>