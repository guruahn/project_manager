<?php
/**
 * Page Add
 *
 * @category  View
 * @package   page
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
          <form method="post" action="<?=_BASE_URL_?>/pages/addPage">
              <input type="hidden" name="state" value="0" />
              <input type="hidden" name="project_idx" value="<?php echo $project_idx; ?>" />
              <div class="row">
                  <ul>
                      <li>
                          <label for="category_idx">category
                              <select name="category_idx" id="category_idx" >
                                  <?php
                                  foreach($categories as $category){
                                      $obj_category = (object) $category;
                                      echo '<option value="'.$obj_category->idx.'">'.$obj_category->name."</option>";
                                  }
                                  ?>
                              </select>
                          </label>
                      </li>
                      <li>
                          <label for="Title">Name <small>required</small>
                            <input name="name" id="name" type="text" size="30" value="" />
                          </label>

                      </li>
                      <li>
                          <label for="link">Link <small>required</small>
                            <input name="link" id="link" type="url" size="30" value="http://" />
                          </label>

                      </li>

                      <li>
                          <label for="description">description
                            <input name="description" id="description" type="text" size="30" value="" />
                          </label>
                      </li>

                  </ul>
              </div>
              <div class="row">
                  <div class="large-12 columns submit-button">
                      <input type="submit" value="submit" class="button radius small"/>
                  </div>
                  <div class="large-12 columns button-group">

                      <a href="<?php echo _BASE_URL_;?>/pages/view_all/<?php echo $project_idx; ?>" class="button radius secondary tiny">
                          list pages
                      </a>
                  </div>
              </div>
          </form>
      </div><!--//#content-area-->
  </div><!--//#wrapper-->

