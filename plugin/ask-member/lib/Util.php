<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * Description of Util
 *
 * @author myaskpc
 */
class Util
{

    public static function print_t($var, $subject = null)
    {
        echo "<div class='well'>";
        if ($subject) {
            echo "<div class='alert alert-info'>{$subject}</div>";
        }
        echo "<textarea style='width:100%; height: 280px;'>";
        print_r($var);
        echo "</textarea>";
        echo "</div>";
    }

    /**
     * 리다이렉트
     * @param type $uri
     * @param string $method
     * @param type $code
     */
    public static function redirect($uri = '', $method = 'auto', $code = NULL)
    {
        // IIS environment likely? Use 'refresh' for better compatibility
        if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE) {
            $method = 'refresh';
        } elseif ($method !== 'refresh' && (empty($code) or !is_numeric($code))) {
            if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1') {
                $code = ($_SERVER['REQUEST_METHOD'] !== 'GET') ? 303 // reference: http://en.wikipedia.org/wiki/Post/Redirect/Get
                    : 307;
            } else {
                $code = 302;
            }
        }

        switch ($method) {
            case 'refresh':
                header('Refresh:0;url=' . $uri);
                break;
            default:
                header('Location: ' . $uri, TRUE, $code);
                break;
        }
        exit;
    }

    /**
     * 경고후 닫기
     * @param type $msg
     */
    public static function alert_close($msg)
    {
        echo "<script type='text/javascript'>";
        echo "alert('{$msg}'); opener.location.reload();window.close();";
        echo "</script>";
    }

    /**
     * 경고후 opener 주소 이동.
     * @param type $msg
     * @param type $url
     */
    public static function alert_redirect($msg, $url)
    {

        echo "<script type='text/javascript'>";
        echo "alert('{$msg}'); opener.location.replace('{$url}');window.close();";
        echo "</script>";
    }

    /**
     * 오래된 브라우저 경고창
     * https://browser-update.org/#install
     *
     * @return void
     */
    public static function browser_update()
    {
        return '<script>
        var $buoop = {
            required: {
                e: -4,
                f: -3,
                o: -3,
                s: -1,
                c: -3
            },
            insecure: true,
            unsupported: true,
            style: "bottom",
            api: 2020.01
        };
    
        function $buo_f() {
            var e = document.createElement("script");
            e.src = "//browser-update.org/update.min.js";
            document.body.appendChild(e);
        };
        try {
            document.addEventListener("DOMContentLoaded", $buo_f, false)
        } catch (e) {
            window.attachEvent("onload", $buo_f)
        }
    </script>';
    }
}
