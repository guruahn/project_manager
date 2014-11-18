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
        <form action="<?php echo _BASE_URL_;?>/users/add" method="post" name="joinForm">
            <ul>

                <li>
                    <label for="id">ID</label>
                    <input name="id" id="id" type="text" size="30" value="" />
                </li>
                <li>
                    <label for="name">name</label>
                    <input name="name" id="name" type="text" size="30" value="" />
                </li>
                <li>
                    <label for="password">password</label>
                    <input name="password" id="password" type="text" size="30" value="" />
                </li>
                <li>
                    <label for="repassword">repeat password</label>
                    <input name="repassword" id="repassword" type="text" size="30" value="" />
                </li>

            </ul>
            <p><input type="submit" value="submit" class="button radius small"/> </p>
        </form>
    </div>
</div>