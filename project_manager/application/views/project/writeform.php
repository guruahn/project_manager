<?php
/**
 * Post Add
 *
 * @category  View
 * @package   post
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/
?>

</head>
<body>

  <div id="wrapper">
      <div id="title-area" class="small-11 small-centered panel radius columns">
        <h2><?php echo $title?></h2>
      </div>
      <div id="content-area" class="small-11 small-centered panel radius columns ">
          <form method="post" action="<?=_BASE_URL_?>/project/addProject">
              <input type="hidden" name="ip" value="<?php echo $_SERVER['SERVER_ADDR']; ?>" />

              <div class="row">
                  <label for="Title">Title</label>
                  <input name="name" id="name" type="text" size="30" value="" />
              </div>
              <div class="row">
                  <div class="large-12 columns submit-button">
                      <input type="submit" value="submit" class="button radius"/>
                  </div>
                  <div class="large-12 columns button-group">

                      <a href="<?php echo _BASE_URL_;?>/project/view_all/" class="button radius secondary tiny">
                          list project
                      </a>
                  </div>
              </div>
          </form>
      </div>
  </div>

