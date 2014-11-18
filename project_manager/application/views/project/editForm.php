<?php
/**
 * Post Edit
 *
 * @category  Manager View
 * @package   post
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/
$obj_project = (object) $project;
?>


<div id="wrapper" >
    <div id="title-area" class="small-11 small-centered panel radius columns">
        <h2><?php echo $title;?></h2>
    </div>
    <div id="content-area" class="small-11 small-centered panel radius columns">
        <form action="<?php echo _BASE_URL_;?>/project/updateProject/<?php echo $obj_project->idx; ?>" method="post" name="edit_project"  data-abide>
            <input type="hidden" name="ip" value="<?php echo $_SERVER['SERVER_ADDR']; ?>" />
            <div class="row">
                <div class="large-12 columns">
                    <label for="name">name
                        <input name="name" id="name" type="text" class="large-5 columns" value="<?php echo $obj_project->name; ?>" required/>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns submit-button">
                    <input type="submit" value="submit" class="button radius"/>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns button-group">
                    <a href="<?php echo _BASE_URL_;?>/project/delete/<?php echo $obj_project->idx?>" class="button radius secondary tiny">
                        Delete this project
                    </a>

                    <a href="<?php echo _BASE_URL_;?>/project/view_all/" class="button radius secondary tiny">
                        list project
                    </a>
                </div>
            </div>
        </form>
    </div>


</div>






<script>
    $(function(){


    });



</script>