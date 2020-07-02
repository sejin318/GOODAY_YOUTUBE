<?php

/**
 * Boilerplate.kr
 * Basic 게시판 글씌기
 */
if (!defined('_GNUBOARD_')) {
    exit;
}
//board uploader 환경설정
include_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'config.inc.php';
add_stylesheet('<link rel="stylesheet" href="' . BP_CSS . '/boards/board.basic.css">', 30);
add_javascript("<script src='https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js'></script>", 110);
if ($board['bb_use_font']) {
    add_stylesheet('<link href="https://fonts.googleapis.com/css?family=Black+And+White+Picture|Black+Han+Sans|Cute+Font|Do+Hyeon|Dokdo|East+Sea+Dokdo|Gaegu|Gamja+Flower|Gugi|Hi+Melody|Jua|Kirang+Haerang|Nanum+Gothic|Nanum+Myeongjo|Nanum+Pen+Script|Noto+Sans+KR:400,700|Poor+Story|Single+Day|Song+Myung|Stylish|Sunflower:300|Yeon+Sung&display=swap&subset=korean" rel="stylesheet">', 200);
}
?>

<section class='board-write-wrap p-2'>
    <h1 class='board-title'><?php echo $board['bo_subject']; ?></h1>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
        <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
        <input type="hidden" name="w" value="<?php echo $w ?>">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <?php
        $option = '';
        $option_hidden = '';
        if ($is_notice || $is_html || $is_secret || $is_mail) {
            $option = '';
            if ($is_notice) {
                $option .= PHP_EOL . '<div class="form-check form-check-inline"><input type="checkbox" id="notice" name="notice"  class="form-check-input" value="1" ' . $notice_checked . '>' . PHP_EOL . '<label for="notice"  class="form-check-label"><span></span>공지</label></div>';
            }
            if ($is_html) {
                if ($is_dhtml_editor) {
                    $option_hidden .= '<input type="hidden" value="html1" name="html">';
                } else {
                    $option .= PHP_EOL . '<div class="form-check form-check-inline"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="form-check-input" value="' . $html_value . '" ' . $html_checked . '>' . PHP_EOL . '<label  class="form-check-label" for="html"><span></span>html</label></div>';
                }
            }
            if ($is_secret) {
                if ($is_admin || $is_secret == 1) {
                    $option .= PHP_EOL . '<li class="form-check form-check-inline"><input type="checkbox" id="secret" name="secret"  class="form-check-input" value="secret" ' . $secret_checked . '>' . PHP_EOL . '<label class="form-check-label" for="secret"><span></span>비밀글</label></li>';
                } else {
                    $option_hidden .= '<input type="hidden" name="secret" value="secret">';
                }
            }
            if ($is_mail) {
                $option .= PHP_EOL . '<div class="form-check form-check-inline"><input type="checkbox" id="mail" name="mail"  class="form-check-input" value="mail" ' . $recv_email_checked . '>' . PHP_EOL . '<label class="form-check-label" for="mail"><span></span>답변메일받기</label></div>';
            }
        }
        echo $option_hidden;
        ?>

        <?php if ($is_category) { ?>
            <div class="board-category form-group">
                <label for="ca_name" class="sr-only">분류<strong>필수</strong></label>
                <select name="ca_name" id="ca_name" required class='form-control'>
                    <option value="">분류를 선택하세요</option>
                    <?php echo $category_option ?>
                </select>
            </div>
        <?php } ?>

        <div class="write-info">
            <?php if ($is_name) { ?>
                <div class='form-group'>
                    <label for="wr_name" class="sr-only">이름<strong>필수</strong></label>
                    <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="form-control half_input required" placeholder="이름">
                </div>
            <?php } ?>

            <?php if ($is_password) { ?>
                <div class='form-group'>
                    <label for="wr_password" class="sr-only">비밀번호<strong>필수</strong></label>
                    <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="form-control half_input <?php echo $password_required ?>" placeholder="비밀번호">
                </div>
            <?php } ?>

            <?php if ($is_email) { ?>
                <div class='form-group'>
                    <label for="wr_email" class="sr-only">이메일</label>
                    <input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="form-control half_input email " placeholder="이메일">
                </div>
            <?php } ?>

            <?php if ($is_homepage) { ?>
                <div class='form-group'>
                    <label for="wr_homepage" class="sr-only">홈페이지</label>
                    <input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="form-control half_input" size="50" placeholder="홈페이지">
                </div>
            <?php } ?>
        </div>

        <?php if ($option) { ?>
            <div class="write-option form-group">
                <span class="sr-only">옵션</span>
                <?php echo $option ?>
            </div>
        <?php } ?>

        <div class="form-group">
            <label for="wr_subject" class="sr-only">제목<strong>필수</strong></label>

            <div id="autosave_wrapper" class="input-group">
                <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" data-font='<?php echo $write['wr_1'] ?>' required class="<?php echo $write['wr_1'] ?> mb-1 form-control full_input required" size="50" maxlength="255" placeholder="제목">
                <?php if ($board['bb_use_font']) { ?>
                    <script>
                        $(function() {
                            $('.use-font').change(function(e) {
                                var prev = $('#wr_subject').data('font');
                                var fonts = $(this).val();
                                console.log(prev);
                                if (fonts) {
                                    $('#wr_subject').removeClass(prev);
                                    $('#wr_subject').addClass(fonts);
                                    $('#wr_subject').data('font', fonts);
                                } else {
                                    var removeFonts = $('#wr_subject').data('font', fonts);
                                    $('#wr_subject').addClass(removeFonts);
                                    $('#wr_subject').removeClass(prev);
                                }
                            })
                        });
                    </script>
                    <div class='intpu-group-append'>
                        <select name='wr_1' class='use-font form-control mb-1'>
                            <option value="">-- 제목폰트설정 --</option>
                            <option value='font-notosans-kr' <?php echo $write['wr_1'] == 'font-notosans-kr' ? "selected" : ""; ?>>Noto Sans KR</option>
                            <option value='font-nanum-myeongjo' <?php echo $write['wr_1'] == 'font-nanum-myeongjo' ? "selected" : ""; ?>>Nanum Myeongjo</option>
                            <option value='font-nanum-pen-script' <?php echo $write['wr_1'] == 'font-nanum-pen-script' ? "selected" : ""; ?>>Nanum Pen Script</option>
                            <option value='font-sunflower' <?php echo $write['wr_1'] == 'font-sunflower' ? "selected" : ""; ?>>Sunflower</option>
                            <option value='font-black-han-sans' <?php echo $write['wr_1'] == 'font-black-han-sans' ? "selected" : ""; ?>>Black Han Sans</option>
                            <option value='font-do-hyeon' <?php echo $write['wr_1'] == 'font-do-hyeon' ? "selected" : ""; ?>>Do Hyeon</option>
                            <option value='font-gugi' <?php echo $write['wr_1'] == 'font-gugi' ? "selected" : ""; ?>>Gugi</option>
                            <option value='font-jua' <?php echo $write['wr_1'] == 'font-jua' ? "selected" : ""; ?>>Jua</option>
                            <option value='font-dokdo' <?php echo $write['wr_1'] == 'font-dokdo' ? "selected" : ""; ?>>Dokdo</option>
                            <option value='font-gaegu' <?php echo $write['wr_1'] == 'font-gaegu' ? "selected" : ""; ?>>Gaegu</option>
                            <option value='font-yeon-sung' <?php echo $write['wr_1'] == 'font-yeon-sung' ? "selected" : ""; ?>>Song Myung</option>
                            <option value='font-gamja-flower' <?php echo $write['wr_1'] == 'font-gamja-flower' ? "selected" : ""; ?>>Gamja Flower</option>
                            <option value='font-hi-melody' <?php echo $write['wr_1'] == 'font-hi-melody' ? "selected" : ""; ?>>Hi Melody</option>
                            <option value='font-poor-story' <?php echo $write['wr_1'] == 'font-poor-story' ? "selected" : ""; ?>>Poor Story</option>
                            <option value='font-cute-font' <?php echo $write['wr_1'] == 'font-cute-font' ? "selected" : ""; ?>>Cute Font</option>
                            <option value='font-stylish' <?php echo $write['wr_1'] == 'font-stylish' ? "selected" : ""; ?>>Stylish</option>
                            <option value='font-kirang-haerang' <?php echo $write['wr_1'] == 'font-kirang-haerang' ? "selected" : ""; ?>>Kirang Haerang</option>
                            <option value='font-east-sea-dokdo' <?php echo $write['wr_1'] == 'font-east-sea-dokdo' ? "selected" : ""; ?>>East Sea Dokdo</option>
                            <option value='font-black-white' <?php echo $write['wr_1'] == 'font-black-white' ? "selected" : ""; ?>>Black And White Picture</option>
                            <option value='font-single-day' <?php echo $write['wr_1'] == 'font-single-day' ? "selected" : ""; ?>>Single Day</option>
                        </select>
                    </div>
                <?php } ?>
                <?php if ($is_member) { ?>
                    <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
                    <?php if ($editor_content_js) echo $editor_content_js; ?>
                    <div class='intpu-group=append'>
                        <button type="button" id="btn_autosave" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">임시저장글 (<em id="autosave_count"><?php echo $autosave_count; ?></em>)</button>
                        <div class="dropdown-menu">
                            <div id="autosave_pop">
                                <ul></ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="wr_content" class="sr-only">내용<strong>필수</strong></label>
            <div class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
                <?php if ($write_min || $write_max) { ?>
                    <!-- 최소/최대 글자 수 사용 시 -->
                    <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 
                ?>
                <?php if ($write_min || $write_max) { ?>
                    <!-- 최소/최대 글자 수 사용 시 -->
                    <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </div>
        </div>

        <?php
        ####################################################################################################
        # 유튜브 스킨
        ####################################################################################################
        //유튜브
        if ($board['bb_list_skin'] == 'youtube') {
        ?>
            <div class="form-group">
                <textarea id='youtube-urls' class="form-control" rows="6" required name='wr_link2' placeholder="유튜브 주소를 한줄에 하나씩 입력"><?php echo $write['wr_link2'] ?></textarea>
                <div class='alert alert-info mt-1'>
                    <i class="fa fa-info" aria-hidden="true"></i> 유튜브 주소를 한줄에 하나씩 입력하세요. https://youtu.be/BzYnNdJhZQw?list=RDOxgiiyLp5pk 또는 https://www.youtube.com/watch?v=BzYnNdJhZQw <br/>
                    <i class="fa fa-info" aria-hidden="true"></i> 외부에서 재생할 수 없도록 설정한 동영상은 출력할 수 없습니다.<br/>
                    <i class="fa fa-info" aria-hidden="true"></i> 브라우저 정책에 의해서 자동실행이 안될 수 있습니다.<br/>
                    <i class="fa fa-info" aria-hidden="true"></i> 오래된 브라우저(IE11이하)는 지원하지 않습니다.
                </div>
            </div>

        <?php } ?>

        <?php
        for ($i = 1; $is_link && $i <= G5_LINK_COUNT; $i++) {
            //유튜브 스킨 사용시 #2번을 사용
            if ($board['bb_list_skin'] == 'youtube' && $i == 2) {
                continue;
            }
        ?>
            <div class='form-group'>
                <div class="input-group">
                    <div for="wr_link<?php echo $i ?>" class='input-group-prepend'>
                        <span class="input-group-text"><i class="fa fa-link" aria-hidden="true"></i>
                            <span class="sr-only"> 링크 #<?php echo $i ?></span>
                        </span>
                    </div>
                    <input type="text" name="wr_link<?php echo $i ?>" value="<?php echo $w == "u" ? $write['wr_link' . $i] : ""; ?>" id="wr_link<?php echo $i ?>" class="form-control full_input" size="50" placeholder="Youtube, Facebook, Twitter, Instargram, KAKAO TV, Naver Audioclip 링크등을 넣으면 컨텐츠를 자동으로 가져옵니다.">
                </div>
            </div>
        <?php } ?>

        <?php
        //첨부파일 업로드
        include_once BP_UPLOADER_PATH . DIRECTORY_SEPARATOR . $config['bp_board_uploader'] . DIRECTORY_SEPARATOR . 'uploader.inc.php';
        ?>

        <?php if ($is_use_captcha) { ?>
            <div class="form-control">
                <?php echo $captcha_html ?>
            </div>
        <?php } ?>

        <div class="form-group mt-5 mb-5">
            <div class='btn-toolbar'>
                <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn btn-danger mr-auto">취소</a>
                <button type="submit" id="btn_submit" accesskey="s" class="btn btn-primary">작성완료</button>
            </div>

        </div>
    </form>

    <script>
        <?php if ($write_min || $write_max) { ?>
            // 글자수 제한
            var char_min = parseInt(<?php echo $write_min; ?>); // 최소
            var char_max = parseInt(<?php echo $write_max; ?>); // 최대
            check_byte("wr_content", "char_count");

            $(function() {
                $("#wr_content").on("keyup", function() {
                    check_byte("wr_content", "char_count");
                });
            });

        <?php } ?>

        function html_auto_br(obj) {
            if (obj.checked) {
                result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
                if (result)
                    obj.value = "html2";
                else
                    obj.value = "html1";
            } else
                obj.value = "";
        }

        function fwrite_submit(f) {
            <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   
            ?>

            var subject = "";
            var content = "";
            $.ajax({
                url: g5_bbs_url + "/ajax.filter.php",
                type: "POST",
                data: {
                    "subject": f.wr_subject.value,
                    "content": f.wr_content.value
                },
                dataType: "json",
                async: false,
                cache: false,
                success: function(data, textStatus) {
                    subject = data.subject;
                    content = data.content;
                }
            });

            if (subject) {
                alert("제목에 금지단어('" + subject + "')가 포함되어있습니다");
                f.wr_subject.focus();
                return false;
            }

            if (content) {
                alert("내용에 금지단어('" + content + "')가 포함되어있습니다");
                if (typeof(ed_wr_content) != "undefined")
                    ed_wr_content.returnFalse();
                else
                    f.wr_content.focus();
                return false;
            }

            if (document.getElementById("char_count")) {
                if (char_min > 0 || char_max > 0) {
                    var cnt = parseInt(check_byte("wr_content", "char_count"));
                    if (char_min > 0 && char_min > cnt) {
                        alert("내용은 " + char_min + "글자 이상 쓰셔야 합니다.");
                        return false;
                    } else if (char_max > 0 && char_max < cnt) {
                        alert("내용은 " + char_max + "글자 이하로 쓰셔야 합니다.");
                        return false;
                    }
                }
            }

            <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  
            ?>

            document.getElementById("btn_submit").disabled = "disabled";

            return true;
        }
    </script>
</section>
<!-- } 게시물 작성/수정 끝 -->