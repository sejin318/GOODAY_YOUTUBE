<?php
/**
 * 그누보드 버전 제작 Vorfeed
 */
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function editor_html($id, $content, $is_dhtml_editor=true)
{
    global $g5, $config, $w, $board, $write;
    static $js = true;

    if( 
        $is_dhtml_editor && $content && 
        (
        (!$w && (isset($board['bo_insert_content']) && !empty($board['bo_insert_content'])))
        || ($w == 'u' && isset($write['wr_option']) && strpos($write['wr_option'], 'html') === false )
        )
    ){       //글쓰기 기본 내용 처리
        if( preg_match('/\r|\n/', $content) && $content === strip_tags($content, '<a><strong><b>') ) {  //textarea로 작성되고, html 내용이 없다면
            $content = nl2br($content);
        }
    }

    $editor_url = G5_EDITOR_URL.'/'.$config['cf_editor'];

    $html = "";
    $html .= "<span class=\"sound_only\">웹에디터 시작</span>";
    $html .= "\n<textarea name=\"$id\" id=\"$id\" >".htmlspecialchars_decode($content)."</textarea>";
    if ($is_dhtml_editor && $js) {
        add_stylesheet('<link href="'.$editor_url.'/keditor.min.css" rel="stylesheet">',1);
        add_stylesheet('<link href="'.$editor_url.'/file.css" rel="stylesheet">',1);        
        add_stylesheet('<link href="'.$editor_url.'/keditor-contents.css" rel="stylesheet">',1);        
        add_javascript('<script src="'.$editor_url.'/keditor.min.js"></script>',1);
        add_javascript('<script src="'.$editor_url.'/ko.js"></script>',1);
        add_javascript('<script src="'.$editor_url.'/config.js"></script>',1);
        $html .= "\n"."<script>";
        $html .= "\n"."var editor_".$id." = KEDITOR.create('$id', config);";
        $html .= "\n"."</script>";
        $html .= "\n".'<div class="image-list image_wrapper" id="editor_'.$id.'_wrapper">';
        $html .= "\n".'    <div class="file-list-info">';
        $html .= "\n".'        <span>이미지</span>';
        $html .= "\n".'        <span class="xefu-btn">';
        $html .= "\n".'            <label class="files-text" for="editor_'.$id.'_file">추가</label>';
        $html .= "\n".'            <input type="file" id="editor_'.$id.'_file" accept="image/*" multiple="multiple" class="files-text files-input" />';
        $html .= "\n".'        </span>';
        $html .= "\n".'        <span class="total-size text-small-2 image_size">0KB</span>';
        $html .= "\n".'        <button class="btn btn-md btn-danger image_remove" type="button" disabled onclick="deleteCheckedImages(editor_'.$id.', \'editor_'.$id.'_wrapper\')">삭제</button>';
        $html .= "\n".'    </div>';
        $html .= "\n".'    <div class="file-list">';
        $html .= "\n".'        <ul class="image_list">';
        $html .= "\n".'        </ul>';
        $html .= "\n".'    </div>';
        $html .= "\n".'</div>';
        $html .= "\n"."<script>";
        $html .= "\n"."editor_".$id.".onImageUpload = function (targetImgElement, index, state, imageInfo, remainingFilesCount) {";
        $html .= "\n"."    var idx = parseInt($('#editor_".$id."_wrapper').data('idx'));";
        $html .= "\n"."    console.log(idx);";
        $html .= "\n"."    if (state === 'delete') {";
        $html .= "\n"."        imageList[idx].splice(findIndex(imageList, index), 1);";
        $html .= "\n"."        $('#editor_".$id."_wrapper').find('.img_'+index).remove();";
        $html .= "\n"."    } else {";
        $html .= "\n"."        if (state === 'create') {";
        $html .= "\n"."            var image = editor_".$id.".getImagesInfo()[findIndex(editor_".$id.".getImagesInfo(), index)];";
        $html .= "\n"."            Keditor_image(targetImgElement, imageInfo);";
        $html .= "\n"."            imageList[idx].push(image)";
        $html .= "\n"."        } else { // update }";
        $html .= "\n"."    }";
        $html .= "\n"."";
        $html .= "\n"."        if (remainingFilesCount === 0) {";
        $html .= "\n"."            setImageList('editor_".$id."_wrapper', idx)";
        $html .= "\n"."        }";
        $html .= "\n"."    }";
        $html .= "\n"."}";
        $html .= "\n"."";
        $html .= "\n"."// Upload from outside the editor";
        $html .= "\n"."document.getElementById('editor_".$id."_file').addEventListener('change', function (e) {";
        $html .= "\n"."    if (e.target.files) {";
        $html .= "\n"."        editor_".$id.".insertImage(e.target.files)";
        $html .= "\n"."        e.target.value = ''";
        $html .= "\n"."    }";
        $html .= "\n"."})";
        $html .= "\n"."</script>";
        $html .= "\n".'<script src="'.$editor_url.'/image.plugin.js"></script>';
        $html .= "\n"."<script>";
        $html .= "\n"."imageList.push(new Array());";
        $html .= "\n"."selectedImages.push(new Array());";
        $html .= "\n"."</script>";
        $js = false;
    }
    $html .= "\n<span class=\"sound_only\">웹 에디터 끝</span>";
    return $html;
}


// textarea 로 값을 넘긴다. javascript 반드시 필요
function get_editor_js($id, $is_dhtml_editor=true)
{
    if ($is_dhtml_editor) {
        return "var {$id}_editor_data = editor_{$id}.getContents();f.{$id}.value = editor_{$id}.getContents();";
    } else {
        return "var {$id}_editor = document.getElementById('{$id}');\n";
    }
}


//  textarea 의 값이 비어 있는지 검사
function chk_editor_js($id, $is_dhtml_editor=true)
{
    if ($is_dhtml_editor) {
        return "if (!{$id}_editor_data || jQuery.inArray({$id}_editor_data.toLowerCase(), ['&nbsp;','<p>&nbsp;</p>','<p><br></p>','<p></p>','<br>']) != -1) { alert(\"내용을 입력해 주십시오.\"); editor_${id}.focus(); return false; }else{f.{$id}.value = editor_{$id}.getContents();}\n";
    } else {
        return "if (!{$id}_editor.value) { alert(\"내용을 입력해 주십시오.\"); {$id}_editor.focus(); return false; }\n";
    }
}
?>
