<?php

/**
 * Tiny MCE
 */
if (!defined('_GNUBOARD_')) {
  exit; // 개별 페이지 접근 불가
}
function editor_html($id, $content, $is_dhtml_editor = true)
{
  global $g5, $config, $w, $board, $write;
  static $js = true;
  $hostname = bp_get_hostname();

  if (
    $is_dhtml_editor && $content && (
      (!$w && (isset($board['bo_insert_content']) && !empty($board['bo_insert_content'])))
      || ($w == 'u' && isset($write['wr_option']) && strpos($write['wr_option'], 'html') === false))
  ) {       //글쓰기 기본 내용 처리
    if (preg_match('/\r|\n/', $content) && $content === strip_tags($content, '<a><strong><b>')) {  //textarea로 작성되고, html 내용이 없다면
      $content = nl2br($content);
    }
  }

  $editor_url = G5_EDITOR_URL . '/' . $config['cf_editor'];
  $editor_path = G5_EDITOR_PATH . '/' . $config['cf_editor'];

  $html = '';
  $html .= '<span class="sr-only">웹에디터 시작</span>';

  if ($is_dhtml_editor && $js) {
    $html .= '<script src="' . G5_EDITOR_URL . '/' . $config['cf_editor'] . '/jquery.tinymce.min.js"></script>';
    $html .= '<script src="' . G5_EDITOR_URL . '/' . $config['cf_editor'] . '/tinymce.min.js"></script>';
    //$html .= '<script src="' . G5_EDITOR_URL . '/' . $config['cf_editor'] . '/langs/ko_KR.js"></script>';
    $js = false;
  }

  $tinymce_class = $is_dhtml_editor ? 'tinymce-editor ' : '';
  $html .= '<textarea id="' . $id . '" name="' . $id . '" class=" form-control ' . $tinymce_class . '" maxlength="65536">' . $content . '</textarea>';
  $html .= '<span class="sr-only">웹 에디터 끝</span>';
  if (is_mobile()) {
    $mobile_theme = ",mobile: {theme: 'mobile',plugins: [ 'autosave', 'lists', 'autolink' ]}";
  }
  $html .= "<script>tinymce.init({selector: '#{$id}'{$mobile_theme},
    language:'ko_KR',
    height: 500,
    skin :'oxide',
    menubar: true,
    extended_valid_elements :'i[class|aria-hidden]',
    table_default_attributes :{class:'table table-bordered'},
    plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks codemirror fullscreen template',
      'insertdatetime media table paste help wordcount pagebreak quickbars'
    ],
    templates: '" . G5_PLUGIN_URL . "/editor/{$config['cf_editor']}/bp_templates.php',
    toolbar: 'undo redo | formatselect | bold italic backcolor template | image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | code pagebreak | fullscreen',
    codemirror: {
      indentOnInit: true, // Whether or not to indent code on init.
      path: 'codemirror', // Path to CodeMirror distribution
      indentWithTabs: true,
      smartIndent: true,
      fullscreen:false,
      config: {           // CodeMirror config object
          indentUnit: 4,
          lineNumbers: true,
          mode: 'htmlmixed',
          matchBrackets: true,
          autoCloseBrackets: true,
          autoCloseTags: true,
          matchTags: {bothTags: true},
          indentOnInit: true,
          smartIndent: true,
          indentWithTabs: true,
          lineWrapping: true,
          paletteHints: false,
          lint: false,
          lintOnChange: true,
          showHint: true,
          HTMLHint: true,
          CSSHint: true,
          JSHint: true,
          getAnnotations: true,
          gutters: ['CodeMirror-lint-markers', 'CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
          foldGutter: true,
          profile: 'html5',
          extraKeys: {
            \"Ctrl-Space\": \"autocomplete\",
            \"F11\": function(cm) {
              cm.setOption(\"fullScreen\", !cm.getOption(\"fullScreen\"));
            },
            \"Esc\": function(cm) {
              if (cm.getOption(\"fullScreen\")) cm.setOption(\"fullScreen\", false);
            }
            },
          value: document.documentElement.innerHTML
      },
      width: 1440,         // Default value is 800
      height: 600,        // Default value is 550
      saveCursorPosition: false,    // Insert caret marker
      jsFiles: [          // Additional JS files to load
         'mode/clike/clike.js',
         'mode/php/php.js',
         'mode/xml/xml.js',
         'mode/javascript/javascript.js',
         'mode/css/css.js',
         'mode/htmlmixed/htmlmixed.js',
         'mode/htmlembedded/htmlembedded.js',
         'addon/edit/matchbrackets.js',
         'addon/edit/closebrackets.js',
         'addon/edit/closetag.js',
         'addon/fold/xml-fold.js',
         'addon/fold/comment-fold.js',
         'addon/edit/matchtags.js',
         'mode/htmlmixed/htmlmixed.js',
         'addon/search/searchcursor.js',
         'addon/search/search.js',
         'addon/hint/show-hint.js',
         'addon/hint/anyword-hint.js',
         'addon/hint/html-hint.js',
         'addon/hint/css-hint.js',
         'addon/hint/xml-hint.js',
         'addon/hint/javascript-hint.js'
      ],
      cssFiles: [// Default CSS files
        'lib/codemirror.css',
        'addon/dialog/dialog.css',
        'addon/hint/show-hint.css',
        'addon/display/fullscreen.css',
        'addon/fold/foldgutter.css'
      ]
    },
    content_css: [
       '{$hostname}/_assets/css/{$config['bp_colorset']}',
       '{$hostname}/_assets/css/boards/board.basic.css',
       '{$hostname}/_assets/font-awesome/css/font-awesome.min.css',
       '" . G5_PLUGIN_URL . "/editor/{$config['cf_editor']}/plugins/codemirror/codemirror/lib/codemirror.css',
       '" . G5_PLUGIN_URL . "/editor/{$config['cf_editor']}/plugins/codemirror/codemirror/addon/hint/show-hint.css',
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i'

    ],
    relative_urls : false,
    remove_script_host : false,
    convert_urls : true,
    paste_data_images: false,
    images_upload_url: '{$editor_url}/image-uploader.php',
    automatic_uploads: true,
    images_reuse_filename:true,
    images_upload_base_path : '{$editor_path}/images',
    images_upload_credentials:true,
    images_dataimg_filter: function(img) {
        return img.hasAttribute('internal-blob');
      },
    file_picker_types: 'file image media',
    file_picker_callback: function(callback, value, meta) {
        console.log(value);
        console.log(meta);
        // Provide file and text for the link dialog
        if (meta.filetype == 'file') {
          callback('mypage.html', {text: 'My text'});
        }
    
        // Provide image and alt text for the image dialog
        if (meta.filetype == 'image') {
          callback('myimage.jpg', {alt: 'My alt text'});
        }
    
        // Provide alternative source and posted for the media dialog
        if (meta.filetype == 'media') {
          callback('movie.mp4', {source2: 'alt.ogg', poster: 'image.jpg'});
        }
      },
      images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
    
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '{$editor_url}/image-uploader.php');
    
        xhr.onload = function() {
          var json;
    
          if (xhr.status != 200) {
            failure('HTTP Error: ' + xhr.status);
            return;
          }
    
          json = JSON.parse(xhr.responseText);
    
          if (!json || typeof json.location != 'string') {
            failure('Invalid JSON: ' + xhr.responseText);
            return;
          }
    
          success(json.location);
        };
    
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
    
        xhr.send(formData);
      }
});</script>";

  return $html;
}


// textarea 로 값을 넘긴다. javascript 반드시 필요
function get_editor_js($id, $is_dhtml_editor = true)
{
  if ($is_dhtml_editor) {
    return " var {$id}_editor_data = tinymce.get('{$id}').getContent(); ";
  } else {
    return ' var ' . $id . '_editor = document.getElementById("' . $id . '"); ';
  }
}


//  textarea 의 값이 비어 있는지 검사
function chk_editor_js($id, $is_dhtml_editor = true)
{
  if ($is_dhtml_editor) {
    return ' if (!' . $id . '_editor_data) { alert("내용을 입력해 주십시오."); tinymce.activeEditor.focus();  return false; } if (typeof(f.' . $id . ')!="undefined") f.' . $id . '.value = ' . $id . '_editor_data; ';
  } else {
    return ' if (!' . $id . '_editor.value) { alert("내용을 입력해 주십시오."); ' . $id . '_editor.focus(); return false; } ';
  }
}
