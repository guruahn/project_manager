<?php
/**
 * User add
 *
 * @category  View
 * @package   user
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/
?>

</head>
<body>

<div id="wrapper">
    <div id="title-area" class="small-5 small-centered panel radius columns">
        <h2><?php echo $title;?></h2>
    </div>
    <div id="content-area" class="small-5 small-centered panel radius columns">
        <form action="<?php echo _BASE_URL_;?>/users/login" method="post" name="loginForm">
            <input type="hidden" name="ip" value="<?php echo $_SERVER['SERVER_ADDR']; ?>" />
            <input type="hidden" name="referer" value="<?php echo (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "" ); ?>" />
            
            <label for="id">ID</label>
            <input name="id" id="id" type="text" size="30" value="<?php echo isset($_COOKIE['is_save_id']) ? $_COOKIE['LOGIN_ID'] : ""; ?>" />
            <p class="is_save"><input name="is_save_id" id="is_save_id" type="checkbox" value="<?php echo isset($_COOKIE['is_save_id']) ? "Y" : ""; ?>"/> is save id</p>
            
            <label for="password">password</label>
            <input name="password" id="password" type="password" size="30" value="" />

            <p><input type="submit" value="submit" class="button radius small"/> </p>
        </form>
    </div>
</div>