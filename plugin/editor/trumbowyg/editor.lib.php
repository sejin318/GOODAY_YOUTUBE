<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function editor_html($id, $content, $is_dhtml_editor = true)
{
	global $g5, $config, $w, $board, $write;
	static $js = true;

	if($is_dhtml_editor && $content && 
        (
        (!$w && (isset($board['bo_insert_content']) && !empty($board['bo_insert_content'])))
        || ($w == 'u' && isset($write['wr_option']) && strpos($write['wr_option'], 'html') === false)
        )
	) {       //글쓰기 기본 내용 처리
		if(preg_match('/\r|\n/', $content) && 
		$content === strip_tags($content, '<a><strong><b>') ) {
			//textarea로 작성되고, html 내용이 없다면
            $content = nl2br($content);
        }
	}
	
	$editor_url = G5_EDITOR_URL.'/'.$config['cf_editor'];
	$html = "";

	if ($is_dhtml_editor && $js) {
		// trumbowyg 파일 추가
		add_stylesheet('<link rel="stylesheet" href="'.$editor_url.'/ui/trumbowyg.min.css">', 1);
		add_stylesheet('<link rel="stylesheet" href="'.$editor_url.'/plugins/colors/ui/trumbowyg.colors.min.css">', 2);
		add_javascript('<script src="'.$editor_url.'/trumbowyg.min.js"></script>', 1);
		add_javascript('<script src="'.$editor_url.'/langs/ko.min.js"></script>', 2);
		add_javascript('<script src="'.$editor_url.'/plugins/fontsize/trumbowyg.fontsize.min.js"></script>', 2);
		add_javascript('<script src="'.$editor_url.'/plugins/cleanpaste/trumbowyg.cleanpaste.min.js"></script>', 2);
		add_javascript('<script src="'.$editor_url.'/plugins/noembed/trumbowyg.noembed.min.js"></script>', 2);
		add_javascript('<script src="'.$editor_url.'/plugins/colors/trumbowyg.colors.min.js"></script>', 2);
		add_javascript('<script src="'.$editor_url.'/plugins/upload/trumbowyg.upload.min.js"></script>', 2);
		add_javascript('<script src="'.$editor_url.'/config.js"></script>', 3);

		if ($content) {
			$content = str_replace(
				array("&lt;", "&gt;", "&#034;", "&#039;"), 
				array("<", ">", "\"", "\'"),
			$content);
		}

		// html으로 코드 출력
		$html .= "<div id=\"$id\">$content</div>\n";
		$html .= "<script>\nvar ed_nonce = \"".ft_nonce_create('trumbowyg')."\";\n$('#$id').trumbowyg(trumbowyg_config);\n</script>\n";
	} else {
		// 일반 텍스트 영역으로 지정
		$html .= "<textarea id=\"$id\" name=\"$id\" style=\"width:100%;height:300px;\" maxlength=\"65536\">$content</textarea>\n";
	}

	return $html;
}

// textarea 로 값을 넘긴다. javascript 반드시 필요
function get_editor_js($id, $is_dhtml_editor = true)
{
	if ($is_dhtml_editor) {
		return "var {$id}_editor_data = $('#{$id}').trumbowyg('html');\n";
	} else {
		return "var {$id}_editor = document.getElementById('{$id}');\n";
	}
}

//  textarea 의 값이 비어 있는지 검사
function chk_editor_js($id, $is_dhtml_editor = true)
{
	if ($is_dhtml_editor) {
		return "if (!{$id}_editor_data || jQuery.inArray({$id}_editor_data.toLowerCase(), ['&nbsp;','<p>&nbsp;</p>','<p><br></p>','<p></p>','<br>']) != -1) { alert(\"내용을 입력해 주십시오.\"); $('#{$id}').focus(); return false; }\n";
	} else {
		return "if (!{$id}_editor.value) { alert(\"내용을 입력해 주십시오.\"); {$id}_editor.focus(); return false; }\n";
	}
}

/*
https://github.com/timostamm/NonceUtil-PHP
*/

if (!defined('FT_NONCE_UNIQUE_KEY'))
    define( 'FT_NONCE_UNIQUE_KEY' , sha1($_SERVER['SERVER_SOFTWARE'].G5_MYSQL_USER.session_id().G5_TABLE_PREFIX) );

if (!defined('FT_NONCE_SESSION_KEY'))
    define( 'FT_NONCE_SESSION_KEY' , substr(md5(FT_NONCE_UNIQUE_KEY), 5) );

if (!defined('FT_NONCE_DURATION'))
    define( 'FT_NONCE_DURATION' , 60 * 30  ); // 300 makes link or form good for 5 minutes from time of generation,  300은 5분간 유효, 60 * 60 은 1시간

if (!defined('FT_NONCE_KEY'))
    define( 'FT_NONCE_KEY' , '_nonce' );

// This method creates a key / value pair for a url string
if(!function_exists('ft_nonce_create_query_string')){
    function ft_nonce_create_query_string( $action = '' , $user = '' ){
        return FT_NONCE_KEY."=".ft_nonce_create( $action , $user );
    }
}

if(!function_exists('ft_get_secret_key')){
    function ft_get_secret_key($secret){
        return md5(FT_NONCE_UNIQUE_KEY.$secret);
    }
}

// This method creates an nonce. It should be called by one of the previous two functions.
if(!function_exists('ft_nonce_create')){
    function ft_nonce_create( $action = '',$user='', $timeoutSeconds=FT_NONCE_DURATION ){

        $secret = ft_get_secret_key($action.$user);

		$salt = ft_nonce_generate_hash();
		$time = time();
		$maxTime = $time + $timeoutSeconds;
		$nonce = $salt . "|" . $maxTime . "|" . sha1( $salt . $secret . $maxTime );

        set_session('nonce_'.FT_NONCE_SESSION_KEY, $nonce);

		return $nonce;

    }
}

// This method validates an nonce
if(!function_exists('ft_nonce_is_valid')){
    function ft_nonce_is_valid( $nonce, $action = '', $user='' ){

        $secret = ft_get_secret_key($action.$user);

		if (is_string($nonce) == false) {
			return false;
		}
		$a = explode('|', $nonce);
		if (count($a) != 3) {
			return false;
		}
		$salt = $a[0];
		$maxTime = intval($a[1]);
		$hash = $a[2];
		$back = sha1( $salt . $secret . $maxTime );
		if ($back != $hash) {
			return false;
		}
		if (time() > $maxTime) {
			return false;
		}
		return true;
    }
}

// This method generates the nonce timestamp
if(!function_exists('ft_nonce_generate_hash')){
    function ft_nonce_generate_hash(){
		$length = 10;
		$chars='1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
		$ll = strlen($chars)-1;
		$o = '';
		while (strlen($o) < $length) {
			$o .= $chars[ rand(0, $ll) ];
		}
		return $o;
    }
}
?>