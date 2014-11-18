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
$obj_post = (object) $post;
?>
<!--froala editor style start-->
<link href="<?php echo _BASE_URL_;?>/public/css/froala/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo _BASE_URL_;?>/public/css/froala/froala_editor.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo _BASE_URL_;?>/public/css/froala/froala_reset.min.css" rel="stylesheet" type="text/css">
<!--froala editor style end-->


<div id="wrapper">
    <div id="title-area" class="small-11 small-centered panel radius columns">
        <h2><?php echo $title;?></h2>
    </div>
    <div id="content-area" class="small-11 small-centered panel radius columns">
        <form action="<?php echo _BASE_URL_;?>/posts/updatePost/<?php echo $obj_post->idx; ?>" method="post" name="edit_post"  data-abide>
            <input type="hidden" name="ip" value="<?php echo $_SERVER['SERVER_ADDR']; ?>" />
            <div class="row">
                <div class="large-12 columns">
                    <label for="Title">Title
                        <input name="title" id="title" type="text" class="large-5 columns" value="<?php echo $obj_post->title; ?>" required/>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="user_id">Writer
                        <span><?php echo $obj_post->user_id; ?></span>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="content">content</label>
                    <textarea name="content" id="content" size="30"required >
                        <?php echo $obj_post->content; ?>
                    </textarea>
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="category_id">category
                        <select name="category_id" id="category_id" >
                            <?php
                            foreach($categories as $category){
                                $obj_category = (object) $category;
                                echo '<option value="'.$obj_category->idx.'">'.$obj_category->name."</option>";
                            }
                            ?>
                        </select>
                    </label>
                </div>

                <div class="large-6 columns">
                    <label for="tags">tags</label>
                    <input name="tags" id="tags" type="text" size="30" value="<?php echo $obj_post->tags; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <label>is notice</label>
                    <input type="radio" name="is_notice" value="Y" id="is_notice_Y" <?php echo ($obj_post->is_notice == "Y" ? "checked" : ""); ?> />
                    <label for="is_notice_Y">yes</label>

                    <input type="radio" name="is_notice" value="N" id="is_notice_N" <?php echo ($obj_post->is_notice == "N" ? "checked" : ""); ?> />
                    <label for="is_notice_N">no</label>
                </div>
                <div class="large-6 columns">
                    <label for="is_notice_Y">is secret</label>
                    <input type="radio" name="is_secret" value="Y" id="is_secret_Y" <?php echo ($obj_post->is_secret == "Y" ? "checked" : ""); ?> />
                    <label for="is_notice_Y">yes</label>

                    <input type="radio" name="is_secret" value="N" id="is_secret_N" <?php echo ($obj_post->is_secret == "N" ? "checked" : ""); ?> />
                    <label for="is_notice_N">no</label>
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="modify_date">modify date</label>
                    <input name="modify_date" id="modify_date" type="text" size="30" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns submit-button">
                    <input type="submit" value="submit" class="button radius"/>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns button-group">
                    <a href="<?php echo _BASE_URL_;?>/posts/delete/<?php echo $obj_post->idx?>" class="button radius secondary tiny">
                        Delete this post
                    </a>

                    <a href="<?php echo _BASE_URL_;?>/posts/view_all/" class="button radius secondary tiny">
                        list post
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>





<!--froala editor js start http://editor.froala.com/-->
<script src="<?php echo _BASE_URL_;?>/public/js/froala/libs/beautify/beautify-html.js"></script>
<script src="<?php echo _BASE_URL_;?>/public/js/froala/froala_editor.min.js"></script>
<!--[if lt IE 9]>
<script src="<?php echo _BASE_URL_;?>/public/js/froala/froala_editor_ie8.min.js"></script>
<![endif]-->
<script src="<?php echo _BASE_URL_;?>/public/js/froala/plugins/tables.min.js"></script>
<script src="<?php echo _BASE_URL_;?>/public/js/froala/plugins/colors.min.js"></script>
<script src="<?php echo _BASE_URL_;?>/public/js/froala/plugins/fonts/fonts.min.js"></script>
<script src="<?php echo _BASE_URL_;?>/public/js/froala/plugins/fonts/font_family.min.js"></script>
<script src="<?php echo _BASE_URL_;?>/public/js/froala/plugins/fonts/font_size.min.js"></script>
<script src="<?php echo _BASE_URL_;?>/public/js/froala/plugins/block_styles.min.js"></script>
<script src="<?php echo _BASE_URL_;?>/public/js/froala/plugins/video.min.js"></script>
<script src="<?php echo _BASE_URL_;?>/public/js/froala/plugins/media_manager.min.js"></script>
<script src="<?php echo _BASE_URL_;?>/public/js/froala/langs/ko.js"></script>
<script>
    $(function(){
        $('#content')
            .editable({
                inlineMode: false,
                textNearImage: false,
                language: 'ko',
                height: 300,
                imageUploadURL: "<?php echo _BASE_URL_;?>/api/posts/uploadFile",
                imageUploadParams: {id: "<?php echo $obj_post->idx; ?>"},
                imagesLoadURL: "<?php echo _BASE_URL_;?>/api/posts/loadFile/<?php echo $obj_post->idx; ?>/<?php echo $obj_post->user_id; ?>",
                imageDeleteURL: "<?php echo _BASE_URL_;?>/api/posts/deleteFile"
            })
            .on('editable.imagesLoaded ', function (e, editor, data) {
                // Set the image source to the image delete params.
                console.log(data);

            });

        $('.f-image-list').on('click','.f-delete-img', function(){
            deleteFile( $(this).parent().find('img').attr('src') );
        });


    });

    function deleteFile(src){
        //console.log(data);
        $.ajax({
            type: "POST",
            url: "<?php echo _BASE_URL_;?>/api/posts/deleteFile/",
            data: {src: src },
            dataType: "json"
        }).success(function( data ) {
                if(data.result); alert('upload success');
            }).fail(function(response){
                //console.log(printr_json(response));
            });
    }

</script>