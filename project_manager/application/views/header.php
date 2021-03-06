<?php
/**
 * Header
 *
 * @category  View
 * @package   header
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/
?>
<?php
if( !is_login() && $controller != "users") redirect(_BASE_URL_.'/users/loginForm');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Script-Type" content="text/javascript">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="author" content="gong-jam" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo _BASE_URL_; ?>/public/css/foundation/foundation.min.css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo _BASE_URL_; ?>/public/css/app.css">
        <script src="<?php echo _BASE_URL_; ?>/public/js/foundation/vendor/modernizr.js"></script>
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="<?php echo _BASE_URL_; ?>/public/js/foundation/foundation.min.js"></script>
        <script src="<?php echo _BASE_URL_; ?>/public/js/foundation/foundation.accordion.js"></script>

    </head>
    <body class="<?php echo $controller; ?> <?php echo $controller."-",$action; ?>">
