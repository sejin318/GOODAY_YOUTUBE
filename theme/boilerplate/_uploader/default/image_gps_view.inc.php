<?php

/**
 * 이미지 첨부 GPS 출력
 */
if (!defined('_GNUBOARD_')) {
    exit;
}

######################
# GALLERY 기능
######################
$v_img_count = count($view['file']);
if ($v_img_count) {

    echo "<div id='bo_v_img'>" . PHP_EOL;

    for ($i = 0; $i <= count($view['file']); $i++) {
        if ($view['file'][$i]['view']) {

            if (function_exists('exif_read_data')) {
                $exif = @exif_read_data(G5_DATA_PATH . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR . $bo_table . DIRECTORY_SEPARATOR . $view['file'][$i]['file'], 'IFD0');
            } else {
                $exif = false;
            }
            $exif['gps_info'] = bp_get_image_location($exif);
            $flashfired       = 'No';
            $CameraMaker      = strtoupper($exif['Make'] . ' ' . $exif['Model']);
            if ($exif['Flash'] == 1) {
                $flashfired = 'Yes';
            }
            if ($exif['Flash'] == 2) {
                $flashfired = 'Strobe Return Light Detected';
            }
            if ($exif['Flash'] == 4) {
                $flashfired = 'Strobe Return Light Not Detected';
            }
            if ($exif['Flash'] == 8) {
                $flashfired = 'Compulsory Flash Mode';
            }
            if ($exif['Flash'] == 16) {
                $flashfired = '자동';
            }
            if ($exif['Flash'] == 32) {
                $flashfired = '없음';
            }
            if ($exif['Flash'] == 64) {
                $flashfired = 'Red Eye Reduction Mode';
            }

            if ($exif['WhiteBalance'] == 0) {
                $WhiteBalance = '자동';
            }
            if ($exif['WhiteBalance'] == 1) {
                $WhiteBalance = '수동';
            }

            echo "<!-- 이미지첨부 GPS map --><div class='image-exif'>" . PHP_EOL;
            $image_tag = "<img src='" .  G5_DATA_URL . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR . $bo_table . DIRECTORY_SEPARATOR . "{$view['file'][$i]['file']}'>";

            echo get_view_thumbnail($image_tag);


            $addres_info     = '';
            $map             = "";
            $map_view        = "";
            $photo_menu_icon = '<i class="fa fa-info-circle" aria-hidden="true"></i>';

            if (($exif['gps_info']['Latitude'] && $exif['gps_info']['Longitude'])) {
                //bf_address 주소정보 입력
                $view['file'][$i]['bf_address'] = bp_get_address($view['file'][$i]['file']);

                # 주소가 없으면 카카오 API로 주소 가져와서 입력
                if ($view['file'][$i]['bf_address'] == '') {
                    $photo_address = bp_kakao_request('/v2/local/geo/coord2regioncode', "x=" . $exif['gps_info']['Longitude'] . "&y=" . $exif['gps_info']['Latitude'] . "&input_coord=WGS84", $view['file'][$i]['file']);
                } else {
                    $photo_address = $view['file'][$i]['bf_address'];
                }

                $addres_info     = "<li><span>위치</span> <a href='http://map.daum.net/link/map/{$photo_address},{$exif['gps_info']['Latitude']},{$exif['gps_info']['Longitude']}' target='_blank'>{$photo_address} <i class='fa fa-map' aria-hidden='true'></i></a></li>";
                $photo_menu_icon = '<i class="fa fa-map-marker" aria-hidden="true"></i>';
                $map             = "<div id='map_{$i}' class='kakao-map'></div>";
                $map_view        = "data-mapid='map_{$i}' data-lat='{$exif['gps_info']['Latitude']}' data-long='{$exif['gps_info']['Longitude']}'";
            }

            echo '<button class="view-exif-info" ' . $map_view . '>' . $photo_menu_icon . '</i></button>';
            echo "<div class='exif-info'>" . PHP_EOL;

            echo "<div class='map-wrap'>{$map}</div>";
            echo "<ul class='ex-list'>" . PHP_EOL;
            if ($exif['Make']) {
                echo "<li><span>카메라</span> {$CameraMaker}</li>";
            }
            if ($exif['FileSize']) {
                echo "<li><span>크기</span> " . number_format($exif['FileSize'] / 1024 / 1024, 2) . "MB </li>";
            }
            if ($exif['DateTime']) {
                echo "<li><span>날짜</span> " . date("Y-m-d H:i:s", strtotime($exif['DateTime'])) . "</li>";
            }
            if ($exif['COMPUTED']['Width'] && $exif['COMPUTED']['Height']) {
                echo "<li><span>해상도</span> {$exif['COMPUTED']['Width']} x {$exif['COMPUTED']['Height']}</li>";
            }
            if ($exif['COMPUTED']['ApertureFNumber']) {
                echo "<li><span>조리개</span> {$exif['COMPUTED']['ApertureFNumber']}</li>";
            }
            if (isset($exif['Flash'])) {
                echo "<li><span>플래시</span> {$flashfired}</li>";
            }
            if (isset($exif['WhiteBalance'])) {
                echo "<li><span>화이트밸런스</span> {$WhiteBalance}</li>";
            }
            if ($exif['ISOSpeedRatings']) {
                echo "<li><span>ISO</span> {$exif['ISOSpeedRatings']}</li>";
            }
            if ($exif['FocalLength']) {
                echo "<li><span>초점거리</span> {$exif['FocalLength']} mm</li>";
            }
            if ($exif['ExposureTime']) {
                echo "<li><span>노출시간</span> {$exif['ExposureTime']} s</li>";
            }
            echo $addres_info;

            echo "<li><span>원본보기</span> <a href='" . G5_DATA_URL . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR . $bo_table . DIRECTORY_SEPARATOR . $view['file'][$i]['file'] . "' target='_blank'>{$view['file'][$i]['source']} <i class='fa fa-link' aria-hidden='true'></i></a></li>";
            echo "</ul></div>" . PHP_EOL; //.image-exif
            echo "</div>" . PHP_EOL; //#bo_v_img
        }
    } //for
    echo "</div>" . PHP_EOL;
}

?>
<script>
    function bp_make_map(mapId, lat, long) {
        var mapContainer = document.getElementById(mapId), // 지도를 표시할 div
            mapOption = {
                center: new daum.maps.LatLng(lat, long), // 지도의 중심좌표
                level: 5 // 지도의 확대 레벨
            };


        // 마커가 지도 위에 표시되도록 설정합니다

        setTimeout(function() {
            var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다
            console.log(mapId + "맵생성!!");
            // 마커가 표시될 위치입니다
            var markerPosition = new daum.maps.LatLng(lat, long);

            // 마커를 생성합니다
            var marker = new daum.maps.Marker({
                position: markerPosition
            });

            marker.setMap(map);
        }, 200);
    }
    $(function() {
        //Exif 버튼
        $('.view-exif-info').click(function() {
            //닫기
            if ($(this).siblings('.exif-info').hasClass('show-item')) {
                $(this).siblings('.exif-info').removeClass('show-item');
            } else {
                //다른창은 모두 닫기
                $('.exif-info').removeClass('show-item');
                //열기
                $(this).siblings('.exif-info').addClass('show-item');
                //맵
                var mapid = $(this).data('mapid');
                var gps_lat = $(this).data('lat');
                var gps_long = $(this).data('long');
                if (mapid, gps_lat, gps_long) {
                    //맵초기화
                    $("#" + mapid).text('');
                    $("#" + mapid).html('');
                    bp_make_map(mapid, gps_lat, gps_long);
                }
            }
        });
    });
</script>