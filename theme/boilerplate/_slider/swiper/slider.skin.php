<?php

/**
 * Swiper Slider 기본 스킨
 * YOUTUBE 배경 플레이어 
 * 
 */
if (isset($_cfg['bs_use']) && $_cfg['bs_use'] == false) {
    //echo "<div class='alert alert-danger'>이 슬라이더는 사용 중지된 슬라이더입니다.</div>";
    echo "<!-- 이 슬라이더는 사용 중지된 슬라이더입니다. -->";
    return;
}
$uniqe_id = uniqid('uid_');
add_stylesheet('<link rel="stylesheet" href="' . BP_SLIDER_SKIN_URL . '/swiper/slider.css">', 200);
?>
<section class='bg-slider-wrap'>
    <div class="swiper-container slide-<?php echo $uniqe_id ?>" id="bg-slider_<?php echo $uniqe_id ?>">
        <div class="swiper-wrapper">
            <?php
            $x = 0;
            foreach ($item as $_item) {
                $slider_image_tag = " style='background-color:#999'";
                if ($_item['bss_image']) {
                    $slider_image_tag = " style='background-image:url(" . BP_SLIDERSAVE_URL . DIRECTORY_SEPARATOR . $_item['bss_image'] . ")' ";
                }

                $video_id = false;
                $coverimage = '';
                //유튜브 링크 체크 
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $_item['bss_url'], $match)) {
                    $video_id = $match[1];
                    $slider_image_tag = " style='background-color:#efefef'";
                    //이미지 등록시 커버로 사용
                    if ($_item['bss_image']) {
                        $coverimage = ",coverImage:'" . BP_SLIDERSAVE_URL . DIRECTORY_SEPARATOR . $_item['bss_image'] . "'";
                    }
                }
                $interval = '';
                if ($_item['bss_interval']) {
                    $interval = "data-swiper-autoplay='{$_item['bss_interval']}'";
                } else {
                    $interval = "data-swiper-autoplay='5000'";
                }
                //슬라이드
                echo "<div class='swiper-slide slide-number-{$x} {$_item['bss_class']} embed-responsive {$_cfg['bs_ratio']}' {$interval} id='ytp-wrap-{$video_id}{$x}' {$slider_image_tag}>" . PHP_EOL;
                if ($_item['bss_subject'] != '' || $_item['bss_content'] != '') {
                    echo '<div class="carousel-caption animate ">' . PHP_EOL;
                    if ($_item['bss_url']) {
                        echo "<h5><a href='{$_item['bss_url']}'>{$_item['bss_subject']}</a></h5>" . PHP_EOL;
                        echo "<p><a href='{$_item['bss_url']}'>{$_item['bss_content']}</a></p>" . PHP_EOL;
                    } else {
                        echo "<h5>{$_item['bss_subject']}</h5>" . PHP_EOL;
                        echo "<p>{$_item['bss_content']}</p>" . PHP_EOL;
                    }
                    echo '</div>' . PHP_EOL;
                }
                //URL 에 youtube가 있다면 배경 플레이어로 동작
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $_item['bss_url'], $match)) {
                    $video_id = $match[1];
                    echo "<!-- 플레이어 설정 videoURL : 유튜브 주소--><!-- 소리출력 아래 옵션(data-property)중 mute:false 로 하면 출력하지 않음, 출력하고싶다면 false -->" . PHP_EOL;
                    echo "<div class='align-items-end ytp-control-wrap ytp-button{$x}'>
                        <button class='btn btn-link ytp-play mr-2 shadow' data-playstate=''></button>
                        <button class='btn btn-link ytp-mute shadow' data-volumestate=''><i class='fa fa-volume-off' aria-hidden='true'></i></button>
                        <!-- <button class='btn btn-link ytp-fullscreen shadow' data-fullscreen=''><i class='fa fa-arrows-alt' aria-hidden='true'></i></button> -->
                    </div>";
                    echo "<script>
                    //동영상 컨트롤
                    $(function(){
                        $('.ytp-button{$x} .ytp-fullscreen').on('click',function(){
                            $('#bgPlayer{$x}').YTPFullscreen();
                        });
                        $('.ytp-button{$x} .ytp-play').on('click',function(){
                            var playstate = $(this).data('playstate');
                            if(playstate == 'play'){
                                $('#bgPlayer{$x}').YTPPause();
                            }else if(playstate == 'pause'){
                                $('#bgPlayer{$x}').YTPPlay();
                            }                            
                        });
                        $('.ytp-button{$x} .ytp-mute').on('click',function(){
                            var volumestate = $(this).data('volumestate');
                            console.log(volumestate);
                            if(volumestate == 'mute' || volumestate == ''){
                                $('#bgPlayer{$x}').YTPUnmute();
                            }else if(volumestate == 'unmute'){
                                $('#bgPlayer{$x}').YTPMute();
                            }                            
                        });

                        //플레이 이벤트
                        //play event
                         $('#bgPlayer{$x}').on('YTPPlay',function(e){
                            //console.log('PLAY');
                            var targetItem = $(this);
                            setTimeout(function(){
                                targetItem.siblings('.ytp-control-wrap').find('.ytp-play').data('playstate','play').html('<i class=\'fa fa-pause\' aria-hidden=\'true\'></i>');
                            }, 150);
                         });

                        //pause event
                        $('#bgPlayer{$x}').on('YTPPause',function(e){
                            //console.log('PAUSE');
                            var targetItem = $(this);
                            setTimeout(function(){
                                targetItem.siblings('.ytp-control-wrap').find('.ytp-play').data('playstate','pause').html('<i class=\'fa fa-play\' aria-hidden=\'true\'></i>');
                            }, 150);
                         });
                        //Mute event
                         $('#bgPlayer{$x}').on('YTPMuted',function(e){
                            //console.log('Muted');
                            var targetItem = $(this);
                            setTimeout(function(){
                                targetItem.siblings('.ytp-control-wrap').find('.ytp-mute').data('volumestate','mute').html('<i class=\'fa fa-volume-off\' aria-hidden=\'true\'></i>');
                            }, 150);

                         });
                         //Unmute event
                         $('#bgPlayer{$x}').on('YTPUnmuted',function(e){
                            //console.log('Unmuted');
                            var targetItem = $(this);
                            setTimeout(function(){
                                targetItem.siblings('.ytp-control-wrap').find('.ytp-mute').data('volumestate','unmute').html('<i class=\'fa fa-volume-up\' aria-hidden=\'true\'></i>');
                            }, 150);
                         });

                         /*
                         //Fullscreen Event
                         $('#bgPlayer{$x}').on('YTPFullScreenStart',function(e){
                            setTimeout(function(){
                                bp_swiper_stop();
                            }, 150);
                         });

                         //Fullscreen Event
                         $('#bgPlayer{$x}').on('YTPFullScreenEnd',function(e){

                         });
                        */
                    });
                    </script>";
                    //mute:true 가 아니면 autoplay 되지 않습니다. 웹브라우저 기본 정책입니다.
                    echo '<div id="bgPlayer' . $x . '" data-player-id="bgPlayer' . $x . '" class="player youtube-player" data-property="{videoURL:\'https://www.youtube.com/watch?v=' . $video_id . '\',vol:\'90\',stopMovieOnBlur:false,containment:\'#ytp-wrap-' . $video_id . $x . '\',showControls:false,startAt:0,mute:true,autoPlay:true,loop:true,opacity:1,quality:\'highres\',optimizeDisplay:true,ratio:\'auto\'' . $coverimage . '}"></div>' . PHP_EOL;
                } //end
                echo "</div>" . PHP_EOL;
                $x++;
            } ?>
        </div>
        <!-- 페이징-->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

</section>
<!-- Initialize Swiper -->
<script>

    //슬라이더 설정
    var swiper_<?php echo $uniqe_id ?> = new Swiper('.slide-<?php echo $uniqe_id ?>', {
            init: false,
            pagination: {
                el: '.swiper-pagination',
                dynamicBullets: true,
                clickable: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            paginationClickable: true,
            effect: 'slide', //fade, slide, flip, coverflow
            flipEffect: {
                rotate: 30,
                slideShadows: false
            },
            speed: 1000,
            <?php if ($_cfg['bs_autoplay']) { ?>
                autoplay: {
                    disableOnInteraction: false
                }
            <?php } else { ?>
                autoplay: false
            <?php } ?>
        });

        function bp_swiper_stop() {
            <?php if ($_cfg['bs_autoplay']) { ?>
                swiper_<?php echo $uniqe_id ?>.autoplay.stop();
                return true;
            <?php } ?>
            return false;
        }
    $(function() {
        

        //mouse hover stop
        $(".slide-<?php echo $uniqe_id ?>").hover(function() {
            <?php if ($_cfg['bs_autoplay']) { ?>
                swiper_<?php echo $uniqe_id ?>.autoplay.stop();
            <?php } ?>
        }, function() {
            <?php if ($_cfg['bs_autoplay']) { ?>
                swiper_<?php echo $uniqe_id ?>.autoplay.start();
            <?php } ?>
        });
        //Init
        swiper_<?php echo $uniqe_id ?>.on('init', function() {
            //console.log('Swiper Init');
            //text animation
            setTimeout(function() {
                $('.swiper-slide-active').find('.carousel-caption').addClass('slide-in-blurred-top');
            }, 800);

            //활성화 슬라이더는 플레이
            var active_player_id = "#" + $('.swiper-slide-active').find('.youtube-player').data('player-id');
            //console.log(active_player_id);
            if (active_player_id != '#undefined') {
                $(active_player_id).YTPlayer();
                $(active_player_id).YTPPlay();
            }

        });
        swiper_<?php echo $uniqe_id ?>.init();

        //transition start
        swiper_<?php echo $uniqe_id ?>.on('transitionStart', function() {
            //console.log('Swiper transitionStart');
        });

        //touchStart touchStart
        swiper_<?php echo $uniqe_id ?>.on('touchStart', function() {
            //console.log('Swiper touchStart');
        });

        //touchStart touchEnd
        swiper_<?php echo $uniqe_id ?>.on('touchEnd', function() {
            //console.log('Swiper touchEnd');

        });

        //transition End
        swiper_<?php echo $uniqe_id ?>.on('transitionEnd', function() {
            //console.log('Swiper transitionEnd');
            //비활성화 슬라이더 플레이어 pause
            var youtube_pause = $('.swiper-slide').not('.swiper-slide-active').find('.youtube-player');
            $.each(youtube_pause, function(idx, item) {
                var deActive_id = '#' + item.id;
                if (deActive_id != '#undefined') {
                    setTimeout(function() {
                        $(deActive_id).YTPPause();
                    }, 10);
                }
            });

            setTimeout(function() {
                $('.swiper-slide').not('.swiper-slide-active').removeClass('slide-in-blurred-top');
                $('.swiper-slide-next').find('.carousel-caption').removeClass('slide-in-blurred-top');
                $('.swiper-slide-prev').find('.carousel-caption').removeClass('slide-in-blurred-top');
            }, 200);

            setTimeout(function() {
                //활성화 슬라이더는 플레이
                var active_player_id = "#" + $('.swiper-slide-active').find('.youtube-player').data('player-id');
                if (active_player_id != '#undefined') {
                    $(active_player_id).YTPlayer();
                    $(active_player_id).YTPPlay();
                    $(active_player_id).siblings('.ytp-control-wrap').find('.ytp-play').data('playstate','play').html('<i class=\'fa fa-pause\' aria-hidden=\'true\'></i>');
                }
            }, 200);

        });

        //resize 
        swiper_<?php echo $uniqe_id ?>.on('resize', function() {
            //console.log('Swiper resize');
        });
        //slideChange TransitionStart  
        swiper_<?php echo $uniqe_id ?>.on('slideChangeTransitionStart', function() {
            //console.log('Swiper slideChangeTransitionStart');
            //animation

            setTimeout(function() {
                $('.swiper-slide-active').find('.carousel-caption').addClass('slide-in-blurred-top');
            }, 500);

        });

    });
</script>