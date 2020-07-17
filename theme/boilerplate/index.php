<?php

/**
 * index.php
 * Indexpage
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
define('_INDEX_', true);
include_once(G5_THEME_PATH . '/head.php');
add_stylesheet('<link rel="stylesheet" href="' . BP_ASSETS_URL . '/css/bp_pages.css">', 200);

?>
<div>
    <?php
    // run_event('메인상단배너', '메인상단배너');

    // echo bp_banner(1);
    ####################################################################################################
    # 슬라이더를 이벤트로 호출할 수 있습니다.
    # run_event('슬라이더위치', '슬라이더위치','슬라이더스킨');
    # 슬라이더 위치는 등록한 슬라이더 이름을 입력해야 합니다.
    # 슬라이더 스킨은 theme/boilerplate/_slider/폴더명 입니다.
    # 생략하면 슬라이더 관리자에서 지정한 스킨이 사용됩니다.
    ####################################################################################################
    run_event('메인 배너', '메인 배너');
    // echo bp_tag_banner('베너');
    ?>

    </br>
</br>
</br>

</div>


<div class="latest-list row">
    <div class='col-sm-12 col-md-12'>
        <div class='tab-skin-wrap latst-no-title latest-simple'>
            <?php 
            echo bp_tab_latest('theme/basic', 'free,recommend,notice', 5, 33); 
            echo '</br>'; 
            echo bp_tab_latest('theme/basic', 'entertainment,animal,tech_science', 5, 33); 
            echo "<script>

            $('.inner-atag').click(function(){
                var active = $(this).attr('clicked'); 
                if(active == 'active'){
                    window.location.href = $(this).attr('href');
                    console.log('wowowowow'); 
                } else {
                    $('.inner-atag').each(function(){
                        var active = $(this).attr('clicked'); 
                        if(active == 'active'){
                            $(this).attr('clicked', ''); 
                        }
                    })
                    $(this).attr('clicked', 'active');
                }
            });
            </script>";
            ?>
        </div>
    </div>
</div>

<?php //run_event('메인하단배너', '메인하단배너'); ?>

<?php
include_once(G5_THEME_PATH . '/tail.php');
