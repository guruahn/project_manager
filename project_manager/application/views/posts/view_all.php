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
    <div id="title-area" class="small-11 small-centered panel radius columns">
        <h2><?php echo $title;?></h2>
    </div>
    <div class="small-11 small-centered columns ">
        <dl class="sub-nav radius">
            <dt>Filter:</dt>
            <?php
            $is_active = null;
            foreach($categories as $category):
                $obj_category = (object) $category;
                $is_active = "";
                if( $obj_category->idx == $filter_category_id ) $is_active = "active";
                ?>
                <dd class="<?php echo $is_active; ?>">
                    <a href="<?php echo _BASE_URL_;?>/posts/view_all/1/category/<?php echo $obj_category->idx; ?>">category: <?php echo text_cut_utf8($obj_category->name, 70); ?></a>
                </dd>
            <?php
            endforeach;
            if(empty($filter)) {
                $is_active = "active";
            }else{
                $is_active = "";
            }
            ?>
            <dd class="<?php echo $is_active; ?>">
                <a href="<?php echo _BASE_URL_;?>/posts/view_all">all</a>
            </dd>
            <?php
            if(!empty($filter) && $filter == 'secret') {
                $is_active = "active";
            }else{
                $is_active = "";
            }
            ?>
            <dd class="<?php echo $is_active; ?>">
                <a href="<?php echo _BASE_URL_;?>/posts/view_all/1/secret">only secret</a>
            </dd>
        </dl>
    </div>
    <div id="content-area" class="small-11 small-centered panel radius columns">

        <div class="post_list ">
            <?php
            foreach($posts as $post):
                $obj_post = (object) $post;
                ?>
                <h3>
                    <a href="<?php echo _BASE_URL_;?>/posts/view/<?php echo $obj_post->idx; ?>">
                        <?php
                        if($obj_post->is_secret == 'Y') echo "[secret]";
                        ?>
                        <?php echo text_cut_utf8($obj_post->title, 70); ?>
                    </a>
                </h3>
                <p class="specify-group">by <?php echo $obj_post->user_id." / publish ".$obj_post->publish_date; ?></p>
                <p class="button-group radius">
                    <span><a href="<?php echo _BASE_URL_;?>/posts/editForm/<?php echo $obj_post->idx; ?>" class="button radius secondary tiny">수정</a></span>
                    <span><a href="<?php echo _BASE_URL_;?>/posts/del/<?php echo $obj_post->idx; ?>" class="button radius secondary tiny">삭제</a></span>
                </p>
            <?php
            endforeach;
            ?>

        </div>
    </div>

    <div class="small-11 small-centered columns">
        <p class="button-group radius">
            <span><a href="<?php echo _BASE_URL_;?>/posts/writeForm" class="button radius tiny">Add</a></span>
        </p>
    </div>
</div>