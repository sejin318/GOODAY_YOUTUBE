<?php

/*
 * This file is part of the `nicolab/php-ftp-client` package.
 *
 * (c) Nicolas Tallefourtane <dev@nicolab.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Nicolas Tallefourtane http://nicolab.net
 */

namespace FtpClient;

/**
 * The FtpException class.
 * Exception thrown if an error on runtime of the FTP client occurs.
 * @inheritDoc
 * @author Nicolas Tallefourtane <dev@nicolab.net>
 */
class FtpException extends \Exception
{
    public function __construct($message, $code = 0)
    {
        // some code
        $this->customFunction($message, $code);

        // make sure everything is assigned properly
        parent::__construct($message, $code);
    }

    // custom string representation of object
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function customFunction($msg, $code)
    {

        if ($msg == 'Login incorrect') {
            return "로그인에 실패하였습니다. FTP 아이디, 비밀번호를 확인하세요.";
        }
        if ($code == 1001) {
            echo "<div class='alert alert-warning'> 디렉토리를 읽을 수 없습니다. 없는 디렉토리이거나 접근권한이 없습니다.</div>";
            return false;
        }
    }
}
