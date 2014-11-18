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

<nav class="top-bar" data-topbar role="navigation">
    <ul class="title-area">
        <li class="name">
            <h1><a href="<?php echo _BASE_URL_; ?>/site/main">Project manager</a></h1>
        </li>

    </ul>

    <section class="top-bar-section">
        <!-- Right Nav Section -->
        <ul class="right">
            <li><a href="<?php echo _BASE_URL_; ?>/users/joinForm">Join</a></li>
            <?php
            if( isset($_SESSION['LOGIN_ID']) && !empty($_SESSION['LOGIN_ID']) ){
            ?>
            <li><a href="<?php echo _BASE_URL_; ?>/users/logout">Logout</a></li>
            <?php
            }else{
            ?>
            <li><a href="<?php echo _BASE_URL_; ?>/users/loginForm">Login</a></li>
            <?php
            }
            ?>
        </ul>

        <!-- Left Nav Section -->
        <ul class="left">
            <li class="has-dropdown posts">
                <a href="<?php echo _BASE_URL_; ?>/project/view_all">Project</a>
                <ul class="dropdown">
                    <li><a href="<?php echo _BASE_URL_; ?>/project/view_all">All Project</a></li>
                    <li><a href="<?php echo _BASE_URL_; ?>/project/writeform">Add Project</a></li>
                </ul>
            </li>
            <li class="categories">
                <a href="<?php echo _BASE_URL_; ?>/categories/view_all">Categories</a>
            </li>
            <li class="posts">
                <a href="<?php echo _BASE_URL_; ?>/posts/view_all">Posts</a>
            </li>
        </ul>
    </section>
</nav>
