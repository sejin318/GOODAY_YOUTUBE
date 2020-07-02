<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * Ftp client  확장
 */
class AskFtpClient extends \FtpClient\FtpClient
{
}

//인스턴트 생성
$ftp = new AskFtpClient();
/**
 * ASK FTP Library
 */

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

//폴더아이콘
function af_icon_list($ext)
{
    $ext_ico = '<i class="fa fa-file-o" aria-hidden="true"></i>';
    //이미지
    if (in_array($ext['extension'], array('jpg', 'png', 'gif'))) {
        $ext_ico = '<i class="fa fa-file-image-o" aria-hidden="true"></i>';
    }
    //text file
    if (in_array($ext['extension'], array('txt'))) {
        $ext_ico = '<i class="fa fa-file-text-o" aria-hidden="true"></i>';
    }
    //zip
    if (in_array($ext['extension'], array('zip'))) {
        $ext_ico = '<i class="fa fa-file-archive-o" aria-hidden="true"></i>';
    }
    //code php
    if (in_array($ext['extension'], array('php'))) {
        $ext_ico = '<i class="fa fa-code" aria-hidden="true"></i>';
    }
    //code html
    if (in_array($ext['extension'], array('html', 'htm'))) {
        $ext_ico = '<i class="fa fa-html5" aria-hidden="true"></i>';
    }
    //code js
    if (in_array($ext['extension'], array('js', 'json', 'ts'))) {
        $ext_ico = '<i class="fa fa-file-code-o" aria-hidden="true"></i>';
    }
    //css
    if (in_array($ext['extension'], array('css'))) {
        $ext_ico = '<i class="fa fa-css3" aria-hidden="true"></i>';
    }
    return $ext_ico;
}
/**
 * FTP LIST
 * $dir = $_GET['dir]
 */
function af_list()
{
    global $ftp, $dir, $_afc, $login_server_index, $config;

    if ($dir) {
        $directory = $dir;
    } else {
        $directory = $ftp->pwd();
    }
    //폴더 스캔
    $items = $ftp->scanDir($directory, false);

    $pwd = $directory;
    $depth = explode('/', $pwd);
    $dir_depth = count(array_filter($depth, 'strlen'));

    if ($dir && $dir != '/') {
        //출력하지 않을 폴더로 이동시 차단
        if (in_array(array_pop(explode('/', $dir)), explode(',', AF_EXCLUDE_DIR))) {
            alert('접근할 수 없는 경로입니다.');
            exit;
        }
    }
    $host =  af_Decrypt($_SESSION['SS_FTP_HOST']);
    //카운트
    $count['directory'] = $ftp->count($directory, 'directory', false);
    $count['file'] = $ftp->count($directory, 'file', false);
    echo "<div class='dir-info'>";
    echo "<div class='dir-pwd input-group'><div class='input-group-prepend'><span class='input-group-text'>현재위치 <span class='host-pwd'>&nbsp;{$host}@</span></span></div><input class='form-control' type='text' value='{$pwd}' readonly>
    <div class='input-group-append'><span class='input-group-text'> <i class='fa fa-folder-o' aria-hidden='true'></i>&nbsp; {$count['directory']}개 /&nbsp;<i class='fa fa-file-o' aria-hidden='true'></i> &nbsp;{$count['file']}개</span></div> </div>";
    echo "</div>";
    echo "<table class='table table-bordered table-striped table-hover'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    echo "<th>이름</th><th>크기</th><th>날짜</th><th>종류</th><th>권한</th><th>소유자/그룹</th><th>관리</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    //하위폴더
    if ($dir_depth > 0) {
        //last dir
        $up_dir_link = str_replace('/' . array_pop($depth), '', $pwd);
        if ($up_dir_link == '') {
            $up_dir_link = '/';
        }
        echo "<tr>";
        echo "<td class='up_directory directory'><a href='./ask_ftp.php?dir={$up_dir_link}'> <i class='fa fa-arrow-up' aria-hidden='true'></i> ..</a></td><td></td><td></td><td></td><td></td><td></td><td></td>";
        echo "</tr>";
    }

    ##################
    # DIRECTORY LIST
    ##################
    $i = 0;
    foreach ($items as $key => $ftp_dir) {
        if ($ftp_dir['type'] == 'directory') {
            //출력 제외 DIR
            if (in_array($ftp_dir['name'], explode(',', AF_EXCLUDE_DIR))) {
                continue;
            }

            $addslash = '';
            if ($dir_depth > 0) {
                $addslash = '/';
            }
            //시간
            $dir_time = date('Y-m-d H:i:s', strtotime($ftp_dir['month'] . '-' . $ftp_dir['day'] . ' ' . $ftp_dir['time']));

            $display_perm = "{$ftp_dir['owner']} / {$ftp_dir['group']}";
            $ftp_dir['name_tag'] = "<a href='./ask_ftp.php?dir={$directory}{$addslash}{$ftp_dir['name']}'>{$ftp_dir['name']}</a>";
            echo "<tr>";
            $ftp_dir['size'] = formatSizeUnits($ftp_dir['size']);
            echo "<td class='directory'>
                <i class='fa fa-folder' aria-hidden='true'></i> {$ftp_dir['name_tag']}
                <div class='detail-view'>
                    {$ftp_dir['size']} / {$ftp_dir['month']}-{$ftp_dir['day']}-{$ftp_dir['time']} / {$ftp_dir['permissions']}
                </div>
            </td>
            <td>{$ftp_dir['size']}</td>
            <td>
                {$dir_time}
            </td>
            <td><i class='fa fa-folder-o' aria-hidden='true'></i></td>
            <td>{$ftp_dir['permissions']}</td>
            <td>{$display_perm}</td>
            <td>
                " . ftp_buttons($pwd, $i, $ftp_dir, $dir_depth) . "
            </td>";
            echo "</tr>";
            $i++;
        }
    }

    ###############
    # FILE LIST
    ###############
    $x = $i;
    foreach ($items as $key => $ftp_file) {

        if ($ftp_file['type'] == 'file') {
            $file_color = "";

            //확장자별 아이콘
            $ext = pathinfo($ftp_file['name']);
            $ext['extension'] = strtolower($ext['extension']);
            //확장자가 있어야 출력제외
            if ($ext['extension']) {
                //출력 제외 파일
                if (in_array($ext['extension'], explode(',', AF_EXCLUDE))) {
                    continue;
                }
            }

            //download
            $file_path = $directory . '/' . $ftp_file['name'];
            $addbtn = '';
            $file_download = "<a href='./af_download.php?af_file={$file_path}' class='dropdown-item'><i class='fa fa-download' aria-hidden='true'></i> 다운로드</a>";
            $addbtn .= $file_download;
            $display_perm = "{$ftp_file['owner']} / {$ftp_file['group']}";

            //php, js 파일 색
            if (in_array($ext['extension'], array('php', 'js'))) {
                $file_color = "phpjs";
            }
            $ext_ico = af_icon_list($ext);

            $display_file_name = $ftp_file['name'];
            //이미지링크
            if (in_array($ext['extension'], array('jpg', 'png', 'gif'))) {
                $gnuboard_url = str_replace($config['bp_ftp_root'], '', $pwd);
                $display_file_name = "<a href='{$gnuboard_url}/{$ftp_file['name']}' target='_blank'>{$ftp_file['name']}</a>";
            }

            echo "<tr>";
            $ftp_file['size'] = formatSizeUnits($ftp_file['size']);

            //ASCII 파일은 편집 버튼 출력
            $edit_btn = '';
            if (in_array($ext['extension'], explode(',', AF_ASCII))) {
                $edit_btn = "<a href='./af_editor.php?edit_file={$dir}/{$ftp_file['name']}' class='dropdown-item'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> 수정</a>";
            }
            $addbtn .= $edit_btn;
            //시간
            $file_time = date('Y-m-d H:i:s', strtotime($ftp_file['month'] . '-' . $ftp_file['day'] . ' ' . $ftp_file['time']));
            echo "<td class='{$file_color}'>
                {$ext_ico}
                {$display_file_name}
                <div class='detail-view'>
                    {$ftp_file['size']} / {$ftp_file['month']}-{$ftp_file['day']}-{$ftp_file['time']} / {$ftp_file['permissions']}
                </div>
            </td>
            <td>{$ftp_file['size']}</td>
            <td>
                <!-- {$ftp_file['month']}-{$ftp_file['day']}-{$ftp_file['time']} <br/> -->
                {$file_time}
            </td>
            <td><i class='fa fa-file-o' aria-hidden='true'></i></td>
            <td>{$ftp_file['permissions']}</td>
            <td>{$display_perm}</td>
            <td>" . ftp_buttons($pwd, $x, $ftp_file, $dir_depth, $addbtn) . "</td>";
            echo "</tr>";
            $x++;
        }
    }
    echo "</tbody>";
    echo "</table>";
}

/**
 * FTP 관리 버튼
 */
function ftp_buttons($pwd, $i, $value, $dir_depth, $addbtn = '')
{
    global $config;
    if (!$config['bp_ftp_modify']) {
        return "<button class='btn btn-warning'>미사용</button>";
    }
    $hostname = af_Decrypt($_SESSION['SS_FTP_HOST']);
    //웹루트에서는 출력하지 않음
    if ($dir_depth <= 0 && (defined('AF_ROOT_MANAGE') && AF_ROOT_MANAGE == 0)) {
        return "webroot";
    }
    if ($addbtn) {
        $btn_add = "<div class='dropdown-divider'></div>{$addbtn}";
    }

    //삭제금지 폴더 처리
    if (in_array($value['name'], explode(',', AF_EXCLUDE_DELETE_DIR))) {
        $btn_disable = ' disabled ';
        $btn_disable_text = '<br/>삭제금지된 디렉토리입니다. asf_ftp.const.php 파일에서 설정합니다.';
    }
    //이름변경 금지 폴더 처리
    if (in_array($value['name'], explode(',', AF_EXCLUDE_RENAME_DIR))) {
        $btn_disable_rename = ' disabled ';
        $btn_disable_rename_text = '<br/>이름변경이 금지된 디렉토리입니다. asf_ftp.const.php 파일에서 설정합니다.';
    }

    $setting_info = '';
    $setting_info_script = "";
    if (!$config['bp_ftp_modify']) {
        $setting_info = "<div class='alert alert-info'><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> FTP 수정, 삭제, 편집 기능이 사용중지되어 있습니다.</div>";
        $setting_info_script = "$('.ask-ftp-action button[type=submit]').attr('disabled', true);";
    }
    $str = "<!-- 이름변경 -->
    <form action='./af_upload.php' method='post' class='ask-ftp-action'>
        <input type='hidden' name='type' value='filerename'>
        <input type='hidden' name='dir' value='{$pwd}'>
        <div class='modal fade' id='target_rename_{$i}' tabindex='-1' role='dialog' aria-labelledby='centerModal_{$i}' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title' id='centerModal_{$i}'>{$hostname}</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                </div>
                <div class='modal-body'>
                    <h4>이름변경</h4>
                    <div class='alert alert-danger'>소유자가 다른 파일(nobody,apache등) 처리 안될 수 있습니다. 
                    {$btn_disable_rename_text}
                    </div>
                    <div class='form-group'>
                        <label for='org-name_{$i}' class='col-form-label'>원본이름</label>
                        <input type='text' name='org_name' value='{$value['name']}' class='form-control' readonly id='org-name_{$i}'>
                    </div>
                    <div class='form-group'>
                        <label for='dest-name_{$i}' class='col-form-label'>변경할이름</label>
                        <input type='text' name='dest_name' class='form-control' required id='dest-name_{$i}'>
                    </div>
                    {$setting_info}
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary mr-auto' data-dismiss='modal'>취소</button>
                    <button type='submit' class='btn btn-primary' {$btn_disable_rename}>변경</button>
                </div>
                </div>
            </div>
        </div>
    </form>

    <!-- 권한설정 -->
    <form action='./af_upload.php' method='post' class='ask-ftp-action'>
        <input type='hidden' name='type' value='fileperm'>
        <input type='hidden' name='dir' value='{$pwd}'>
        <div class='modal fade' id='perm_{$i}' tabindex='-1' role='dialog' aria-labelledby='centerModal_{$i}' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title' id='centerModal_{$i}'>{$hostname}</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                </div>
                <div class='modal-body'>
                    <h4>권한설정</h4>
                    <div class='alert alert-danger'>
                    소유자가 다른 파일(nobody,apache등) 처리 안될 수 있습니다. <br/> 윈도우서버는 지원하지 않습니다.
                    
                    </div>
                    <div class='form-group'>
                        <label for='org-file_{$i}' class='col-form-label'>대상 {$value['type']}</label>
                        <div class='input-group'>
                            <input type='text' name='target_name' value='{$value['name']}' class='form-control' readonly id='org-file_{$i}'>
                            <div class='input-group-append'>
                                <span class='input-group-text'>{$value['permissions']}</span>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='chmod_{$i}' class='col-form-label'>권한설정</label>
                        <input type='text' name='perm_number' class='form-control' numberOnly required id='chmod_{$i}' placeholder='예) 0755 또는 0644'>
                        <div class='alert alert-info'> 0600 또는 0100등 실행권한이 없으면 DIR를 정상적으로 읽지 못합니다.</div>
                    </div>
                    {$setting_info}
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary mr-auto' data-dismiss='modal'>취소</button>
                    <button type='submit' class='btn btn-primary'>변경</button>
                </div>
                </div>
            </div>
        </div>
    </form>

    <!-- 삭제 -->
    <form action='./af_upload.php' method='post' class='ask-ftp-action'>
        <input type='hidden' name='type' value='delete'>
        <input type='hidden' name='file_directory' value='{$value['type']}'>
        <input type='hidden' name='dir' value='{$pwd}'>
        <div class='modal fade' id='delete_{$i}' tabindex='-1' role='dialog' aria-labelledby='centerModal_{$i}' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title' id='centerModal_{$i}'>{$hostname}</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                </div>
                <div class='modal-body'>
                    <h4>삭제</h4>
                    <div class='alert alert-danger'>
                        소유자가 다른 파일(nobody,apache등) 처리 안될 수 있습니다.
                        {$btn_disable_text}
                    </div>
                    <div class='form-group'>
                        <label for='org-del_{$i}' class='col-form-label'>삭제할 {$value['type']}</label>
                        <div class='input-group'>
                            <input type='text' name='target_name' value='{$value['name']}' class='form-control' readonly id='org-del_{$i}'>
                        </div>
                    </div>
                    {$setting_info}
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary mr-auto' data-dismiss='modal'>취소</button>
                    <button type='submit' class='btn btn-danger' {$btn_disable}>삭제</button>
                </div>
                </div>
            </div>
        </div>
    </form>
    
    <div class='dropdown'>
        <button class='btn btn-danger btn-sm dropdown-toggle' type='button' id='dropmenu_{$i}' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            관리
        </button>
        <div class='dropdown-menu' aria-labelledby='dropmenu_{$i}'>
            <a class='dropdown-item' href='#ftprename' data-toggle='modal' data-target='#target_rename_{$i}'><i class='fa fa-exchange' aria-hidden='true'></i> 이름변경</a>
            <a class='dropdown-item' href='#ftpperm' data-toggle='modal' data-target='#perm_{$i}'><i class='fa fa-users' aria-hidden='true'></i> 권한변경</a>
            <a class='dropdown-item' href='#ftpdelete' data-toggle='modal' data-target='#delete_{$i}'> <i class='fa fa-trash' aria-hidden='true'></i> 삭제</a>
            {$btn_add}
        </div>
    </div>
    <script>
    $(function(){
        //숫자만입력.
        $('input:text[numberOnly]').on('keyup', function() {
            $(this).val($(this).val().replace(/[^0-9]/g,''));
        });
        {$setting_info_script}
    });
    </script>
    ";
    return $str;
}

if (!function_exists('print_t')) {
    function print_t($str)
    {
        echo "<textarea style='width:100%; height:500px;'>";
        print_r($str);
        echo "</textarea>";
    }
}

/**
 * PHP Class for handling Google Authenticator 2-factor authentication.
 *
 * @author Michael Kliewe
 * @copyright 2012 Michael Kliewe
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @link http://www.phpgangsta.de/
 */
class PHPGangsta_GoogleAuthenticator
{
    protected $_codeLength = 6;

    /**
     * Create new secret.
     * 16 characters, randomly chosen from the allowed base32 characters.
     *
     * @param int $secretLength
     *
     * @return string
     */
    public function createSecret($secretLength = 16)
    {
        $validChars = $this->_getBase32LookupTable();

        // Valid secret lengths are 80 to 640 bits
        if ($secretLength < 16 || $secretLength > 128) {
            throw new Exception('Bad secret length');
        }
        $secret = '';
        $rnd = false;
        if (function_exists('random_bytes')) {
            $rnd = random_bytes($secretLength);
        } elseif (function_exists('mcrypt_create_iv')) {
            $rnd = mcrypt_create_iv($secretLength, MCRYPT_DEV_URANDOM);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $rnd = openssl_random_pseudo_bytes($secretLength, $cryptoStrong);
            if (!$cryptoStrong) {
                $rnd = false;
            }
        }
        if ($rnd !== false) {
            for ($i = 0; $i < $secretLength; ++$i) {
                $secret .= $validChars[ord($rnd[$i]) & 31];
            }
        } else {
            throw new Exception('No source of secure random');
        }

        return $secret;
    }

    /**
     * Calculate the code, with given secret and point in time.
     *
     * @param string   $secret
     * @param int|null $timeSlice
     *
     * @return string
     */
    public function getCode($secret, $timeSlice = null)
    {
        if ($timeSlice === null) {
            $timeSlice = floor(time() / 30);
        }

        $secretkey = $this->_base32Decode($secret);

        // Pack time into binary string
        $time = chr(0) . chr(0) . chr(0) . chr(0) . pack('N*', $timeSlice);
        // Hash it with users secret key
        $hm = hash_hmac('SHA1', $time, $secretkey, true);
        // Use last nipple of result as index/offset
        $offset = ord(substr($hm, -1)) & 0x0F;
        // grab 4 bytes of the result
        $hashpart = substr($hm, $offset, 4);

        // Unpak binary value
        $value = unpack('N', $hashpart);
        $value = $value[1];
        // Only 32 bits
        $value = $value & 0x7FFFFFFF;

        $modulo = pow(10, $this->_codeLength);

        return str_pad($value % $modulo, $this->_codeLength, '0', STR_PAD_LEFT);
    }

    /**
     * Get QR-Code URL for image, from google charts.
     *
     * @param string $name
     * @param string $secret
     * @param string $title
     * @param array  $params
     *
     * @return string
     */
    public function getQRCodeGoogleUrl($name, $secret, $title = null, $params = array())
    {
        $width = !empty($params['width']) && (int) $params['width'] > 0 ? (int) $params['width'] : 200;
        $height = !empty($params['height']) && (int) $params['height'] > 0 ? (int) $params['height'] : 200;
        $level = !empty($params['level']) && array_search($params['level'], array('L', 'M', 'Q', 'H')) !== false ? $params['level'] : 'M';

        $urlencoded = urlencode('otpauth://totp/' . $name . '?secret=' . $secret . '');
        if (isset($title)) {
            $urlencoded .= urlencode('&issuer=' . urlencode($title));
        }

        return "https://api.qrserver.com/v1/create-qr-code/?data=$urlencoded&size=${width}x${height}&ecc=$level";
    }

    /**
     * Check if the code is correct. This will accept codes starting from $discrepancy*30sec ago to $discrepancy*30sec from now.
     *
     * @param string   $secret
     * @param string   $code
     * @param int      $discrepancy      This is the allowed time drift in 30 second units (8 means 4 minutes before or after)
     * @param int|null $currentTimeSlice time slice if we want use other that time()
     *
     * @return bool
     */
    public function verifyCode($secret, $code, $discrepancy = 1, $currentTimeSlice = null)
    {
        if ($currentTimeSlice === null) {
            $currentTimeSlice = floor(time() / 30);
        }

        if (strlen($code) != 6) {
            return false;
        }

        for ($i = -$discrepancy; $i <= $discrepancy; ++$i) {
            $calculatedCode = $this->getCode($secret, $currentTimeSlice + $i);
            if ($this->timingSafeEquals($calculatedCode, $code)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set the code length, should be >=6.
     *
     * @param int $length
     *
     * @return PHPGangsta_GoogleAuthenticator
     */
    public function setCodeLength($length)
    {
        $this->_codeLength = $length;

        return $this;
    }

    /**
     * Helper class to decode base32.
     *
     * @param $secret
     *
     * @return bool|string
     */
    protected function _base32Decode($secret)
    {
        if (empty($secret)) {
            return '';
        }

        $base32chars = $this->_getBase32LookupTable();
        $base32charsFlipped = array_flip($base32chars);

        $paddingCharCount = substr_count($secret, $base32chars[32]);
        $allowedValues = array(6, 4, 3, 1, 0);
        if (!in_array($paddingCharCount, $allowedValues)) {
            return false;
        }
        for ($i = 0; $i < 4; ++$i) {
            if (
                $paddingCharCount == $allowedValues[$i] &&
                substr($secret, - ($allowedValues[$i])) != str_repeat($base32chars[32], $allowedValues[$i])
            ) {
                return false;
            }
        }
        $secret = str_replace('=', '', $secret);
        $secret = str_split($secret);
        $binaryString = '';
        for ($i = 0; $i < count($secret); $i = $i + 8) {
            $x = '';
            if (!in_array($secret[$i], $base32chars)) {
                return false;
            }
            for ($j = 0; $j < 8; ++$j) {
                $x .= str_pad(base_convert(@$base32charsFlipped[@$secret[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
            }
            $eightBits = str_split($x, 8);
            for ($z = 0; $z < count($eightBits); ++$z) {
                $binaryString .= (($y = chr(base_convert($eightBits[$z], 2, 10))) || ord($y) == 48) ? $y : '';
            }
        }

        return $binaryString;
    }

    /**
     * Get array with all 32 characters for decoding from/encoding to base32.
     *
     * @return array
     */
    protected function _getBase32LookupTable()
    {
        return array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', //  7
            'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', // 15
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', // 23
            'Y', 'Z', '2', '3', '4', '5', '6', '7', // 31
            '=',  // padding char
        );
    }

    /**
     * A timing safe equals comparison
     * more info here: http://blog.ircmaxell.com/2014/11/its-all-about-time.html.
     *
     * @param string $safeString The internal (safe) value to be checked
     * @param string $userString The user submitted (unsafe) value
     *
     * @return bool True if the two strings are identical
     */
    private function timingSafeEquals($safeString, $userString)
    {
        if (function_exists('hash_equals')) {
            return hash_equals($safeString, $userString);
        }
        $safeLen = strlen($safeString);
        $userLen = strlen($userString);

        if ($userLen != $safeLen) {
            return false;
        }

        $result = 0;

        for ($i = 0; $i < $userLen; ++$i) {
            $result |= (ord($safeString[$i]) ^ ord($userString[$i]));
        }

        // They are only identical strings if $result is exactly 0...
        return $result === 0;
    }
}

//OTP 인증
$_ga = new PHPGangsta_GoogleAuthenticator();

/**
 * 구글 OTP
 * $login_check = true 는 로그인검사페이지
 */
function ask_2factor_auth($login_check, $code = '')
{
    global $_ga;

    //사용하지 않으면 
    if (AF_AUTH_OTP != 1) {
        return true;
    }

    //로그인 페이지에 출력
    if ($login_check == false) {
        //인증 사용 체크
        if (defined('AF_AUTH_OTP') && AF_AUTH_OTP) {
            //Secret Key 
            if (defined('AF_AUTH_SECRET') && AF_AUTH_SECRET == '') {
                //키가 없으면 생성 및 QR코드 출력
                $secret_key = $_ga->createSecret();
                $qrCodeUrl = $_ga->getQRCodeGoogleUrl('ASK-FTP', $secret_key);
                echo "<div class='alert alert-info'>";
                echo "<h1>Google OTP 인증</h1><hr/>";
                echo "<img src='" . $qrCodeUrl . "'/>";
                echo "<br/>";
                echo "2차 인증을 사용하도록 설정하였습니다. 아래 설정을 완료 후 로그인 하세요.<br/>";
                echo "Secret Key : <span class='badge badge-danger'>{$secret_key}</span> 를 ask_ftp.const.php 파일 AF_AUTH_SECRET 항목에 입력하세요.";
                echo "<br/>";
                echo "안드로이드(<a href='https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ko' target='_blank'>Google OTP</a>,
                <a href='https://play.google.com/store/apps/details?id=com.authy.authy' target='_blank'>Authy 2</a> ) 
                또는 iOS(<a href='https://apps.apple.com/kr/app/google-authenticator/id388497605' target='_blank'>Google Authenticator</a>,
                <a href='https://apps.apple.com/us/app/authy/id494168017' target='_blank'>Authy</a>) OTP 프로그램으로 QR코드를 스캔하세요";
                echo "<br/> 주의) 웹사이트가 운영되는 서버의 시간이 맞지 않으면 인증이 안됩니다.<br/>
                설정 완료 후 <strong>새로고침</strong>하세요.";
                echo "</div>";
            } elseif (defined('AF_AUTH_SECRET') && strlen(AF_AUTH_SECRET) == 16) {
                //키가 입력되어 있으면  키 입력폼 출력
                echo '<form action="./af_login_twofactor_check.php" name="ftp-login" class="ftp-login" method="post" autocomplete="off">';
                echo '<div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">Google OTP</span></div>
                    <input type="text" name="ftp_otp" class="form-control" id="ftp_otp" required placeholder="FTP OTP 입력">';
                echo "<div class='input-group-append'><button type='submit' class='btn btn-primary'>확인</button></div></div>";
                echo "</form>";
            }
        } else {
            return false;
        }
    } else {
        //로그인체크 - af_login_twofactor.php
        if (defined('AF_AUTH_SECRET') && strlen(AF_AUTH_SECRET) == 16) {
            $oneCode = $_ga->getCode(AF_AUTH_SECRET);
            $checkResult = $_ga->verifyCode(AF_AUTH_SECRET, $oneCode, 1);
            if ($checkResult && $oneCode == $code) {
                return true;
            } else {
                return false;
            }
        }
    }
}

//로그아웃용 - 세션 삭제
function af_unset_session()
{
    unset($_SESSION['SS_FTP_HOST']);
    unset($_SESSION['SS_FTP_LOGIN']);
    unset($_SESSION['SS_FTP_ID']);
    unset($_SESSION['SS_FTP_PASSWORD']);
    unset($_SESSION['SS_FTP_OTP']);
    unset($_SESSION['SS_FTP_PORT']);
}

//서버 목록에서 key 값 찾기
function get_server_key($server, $server_config)
{
    if (is_array($server_config)) {
        $key = array_search($server, array_column($server_config, 'host'));
        return $key;
    } else {
        return false;
    }
}

if ($server) {
    $server_index = get_server_key($server, $_afc['servers']);
}

if ($_SESSION['SS_FTP_HOST']) {
    //로그인 서버정보
    $login_server_index = get_server_key(af_Decrypt($_SESSION['SS_FTP_HOST']), $_afc['servers']);
}

//암호화
function af_Encrypt($str)
{
    $secret_key = AF_SECRET_KEY;
    $secret_iv = AF_SECRET_IV;
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    return str_replace(
        "=",
        "",
        base64_encode(
            openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv)
        )
    );
}

//복호화
function af_Decrypt($str)
{
    $secret_key = AF_SECRET_KEY;
    $secret_iv = AF_SECRET_IV;
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    return openssl_decrypt(
        base64_decode($str),
        "AES-256-CBC",
        $key,
        0,
        $iv
    );
}

//포트체크
function check_port($ip, $port)
{
    $timeout = 5; // The connection timeout, in seconds. 
    $fp = @fsockopen($ip, $port, $errno, $errstr, $timeout);
    if (is_resource($fp)) {
        echo 'Open';
        fclose($fp);
    } else {
        echo 'Close';
    }
}
