<?php
/**
 * Category Edit
 *
 * @category  View
 * @package   category
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/

$obj_category = (object) $category;
?>

<div id="wrapper">
    <div id="title-area" class="small-11 small-centered columns">
        <h2><?php echo $title; ?></h2>
    </div>
    <div id="content-area" class="small-11 small-centered panel radius columns">
            <form id="editForm" action="<?php echo _BASE_URL_;?>/categories/edit/<?php echo $obj_category->idx; ?>" method="post" data-abide>
                <input type="hidden" name="project_idx" value="<?php echo $obj_category->project_idx; ?>" />
                <label>Category name <small>required</small>
                    <input name="name" type="text" value="<?php echo $obj_category->name; ?>" />
                </label>
                <small class="error">Name is required.</small>

                <label>Category slug <small>required</small>
                    <input name="slug" type="text" value="<?php echo $obj_category->slug; ?>" />
                </label>
                <small class="error">Slug is required.</small>

                <label>Project <small>required</small>
                    <select name="project_idx" >
                        <option value="">값을 선택하세요</option>
                        <?php
                        foreach($project_list as $project):
                            $obj_project = (object) $project;
                            $selected = "";
                            if( $obj_project->idx == $obj_category->project_idx ) $selected = "selected";
                            echo '<option value="'.$obj_project->idx.'" '.$selected.'>'.$obj_project->name.'</option>';
                        endforeach;
                        ?>
                    </select>
                </label>
                <small class="error">Project is required.</small>

                <label>Parent
                    <select name="parent_idx" >
                        <option value="">값을 선택하세요</option>
                        <?php
                        foreach($categories as $category):
                            $obj_category2 = (object) $category;
                            $selected = "";
                            if( $obj_category2->idx == $obj_category->parent_idx ) $selected = "selected";
                            if( $obj_category->idx != $obj_category2->idx){
                                echo '<option value="'.$obj_category2->idx.'" '.$selected.'>'.$obj_category2->name.'</option>';
                            }

                        endforeach;
                        ?>
                    </select>
                </label>

                <p class="button-group radius">
                    <span><button class="radius tiny">Edit</button></span>
                    <span><a href="<?php echo _BASE_URL_;?>/categories/view_all/<?php echo $obj_category->project_idx; ?>" class="button radius tiny">Category List</a></span>
                </p>
            </form>

    </div>

</div><!--//#wrapper-->