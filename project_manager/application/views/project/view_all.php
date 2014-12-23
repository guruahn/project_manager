<?php
/**
 * Post list
 *
 * @category  View
 * @package   post
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/

?>

<div id="wrapper" >
    <div id="title-area" class="small-11 small-centered columns">
        <h2><?php echo $title;?></h2>
    </div>

    <div id="content-area" class="small-11 small-centered panel radius columns">

        <div class="project_list ">
            <?php
            foreach($project as $item):
                $obj_project = (object) $item;
                ?>
                <h3>
                    <a href="<?php echo _BASE_URL_;?>/pages/view_all/<?php echo $obj_project->idx; ?>">
                        <?php echo text_cut_utf8($obj_project->name, 70); ?>
                    </a>
                </h3>
                <p class="button-group radius">
                    <span><a href="<?php echo _BASE_URL_;?>/project/editForm/<?php echo $obj_project->idx; ?>" class="button radius secondary tiny">수정</a></span>
                    <span><a href="<?php echo _BASE_URL_;?>/project/del/<?php echo $obj_project->idx; ?>" class="button radius secondary tiny">삭제</a></span>
                </p>
            <?php
            endforeach;
            ?>

        </div>
    </div>

    <div class="small-11 small-centered columns">
        <p class="button-group radius">
            <span><a href="<?php echo _BASE_URL_;?>/project/writeForm" class="button radius tiny">Add</a></span>
        </p>
    </div>
</div>