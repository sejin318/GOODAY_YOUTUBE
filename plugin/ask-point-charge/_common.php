<?php

/**
 * 불법복제 금지
 */

include_once '../../common.php';
if (!$config['bp_point_charge']) {
    die("Access Denied.");
    exit;
}
