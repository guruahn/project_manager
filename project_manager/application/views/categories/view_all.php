<?php
/**
 * Category list
 *
 * @category  View
 * @package   category
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/

?>

<div id="wrapper">
    <div id="title-area" class="small-11 small-centered panel radius columns">
        <h2><?php echo $title;?></h2>
    </div>
    <div id="content-area" class="small-11 small-centered panel radius columns">
        <div class="small-11 small-centered columns ">
            <dl class="sub-nav radius">
                <dt>Project:</dt>
                <?php
                $is_active = null;
                foreach($project_list as $project):
                    $obj_project = (object) $project;
                    $is_active = "";
                    if( $obj_project->idx == $filter_project_id ) $is_active = "active";
                    ?>
                    <dd class="<?php echo $is_active; ?>">
                        <a href="<?php echo _BASE_URL_;?>/categories/view_all/<?php echo $obj_project->idx; ?>"><?php echo text_cut_utf8($obj_project->name, 70); ?></a>
                    </dd>
                <?php
                endforeach;
                ?>
            </dl>
        </div>
        <div class="category_list radius small-5 columns">
            <ul>
            <?php
            echo $tree;
            ?>
            </ul>
        </div>
        <div class="add-form-box radius small-5 columns">
            <h3>Add Category</h3>
            <form id="addForm" action="<?php echo _BASE_URL_;?>/categories/add" method="post" data-abide>
                <input type="hidden" name="project_idx" value="<?php echo $filter_project_id; ?> />
                <label>Category name <small>required</small>
                    <input name="name" type="text" value="" required />
                </label>
                <small class="error">Name is required.</small>

                <label>Category slug <small>required</small>
                    <input name="slug" type="text" value="" required />
                </label>
                <small class="error">Slug is required.</small>

                <input type="hidden" name="project_idx" value="<?php echo $filter_project_id; ?>" />

                <label>Parent
                    <select name="parent_idx" >
                        <option value="">select parent category</option>
                        <?php
                        foreach($categories as $category):
                            $obj_category = (object) $category;
                            echo '<option value="'.$obj_category->idx.'">'.$obj_category->name.'</option>';
                        endforeach;
                        ?>
                    </select>
                </label>

                <p class="button-group radius">
                    <span><button class="radius tiny">Add</button></span>
                </p>
            </form>
        </div>
        <div style="clear:both"></div>
    </div><!--//#content-area-->
</div><!--//#wrapper-->