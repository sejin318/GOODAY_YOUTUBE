<?php

include_once('./_common.php');
include_once(G5_LIB_PATH.'/register.lib.php');
mailer("hello", "sejin97318@gmail.com", "jghg2724@naver.com", "hello world!", "hello world!", 0);
?>




<!--function mailer($fname, $fmail, $to, $subject, $content, $type=0, $file="", $cc="", $bcc="")-->
