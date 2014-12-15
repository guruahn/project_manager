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
$obj_page = (object) $page;
?>
<link rel="stylesheet" href="<?php echo _BASE_URL_; ?>/public/js/jquery-ui-1.10.3.custom/css/ui-lightness/jquery-ui-1.10.3.custom.min.css">
</head>
<body>

<div id="wrapper">
    <div id="title-area" class="small-11 small-centered panel radius columns">
        <h2><?php echo $title?></h2>
    </div>
    <div id="content-area" class="small-11 small-centered panel radius columns ">
        <form method="post" action="<?=_BASE_URL_?>/pages/updatePost/<?php echo $obj_page->idx; ?>">
            <input type="hidden" name="project_idx" value="<?php echo $obj_page->project_idx; ?>" />
            <div class="row">
                <ul>
                    <li>
                        <label for="category_idx">카테고리
                            <select name="category_idx" id="category_idx" >
                                <?php
                                foreach($categories as $category){
                                    $obj_category = (object) $category;
                                    $selected = ( $obj_page->category_idx === $obj_category->idx )? "selected": "";
                                    echo '<option value="'.$obj_category->idx.'"  '.$selected.'>'.$obj_category->name."</option>";
                                }
                                ?>
                            </select>
                        </label>
                    </li>
                    <li>
                        <label for="Title">이름 <small>required</small>
                            <input name="name" id="name" type="text" size="30" value="<?php echo $obj_page->name; ?>" required/>
                        </label>

                    </li>
                    <li>
                        <label for="link">링크 <small>required</small>
                            <input name="link" id="link" type="url" size="30" value="<?php echo $obj_page->link; ?>" required/>
                        </label>

                    </li>
                    <li>

                        <label>Choose State</label>
                        <input type="radio" name="state" value="0" id="state0" <?php echo $obj_page->state == 0 ? "checked" : ""; ?> <?php echo $obj_page->state > 0 ? "disabled": "";?>><label for="state0">작업중</label>
                        <input type="radio" name="state" value="1" id="state1" <?php echo $obj_page->state == 1 ? "checked" : ""; ?> <?php echo $obj_page->state > 1 ? "disabled": "";?>><label for="state1">퍼블리싱 완료</label>
                        <input type="radio" name="state" value="2" id="state2" <?php echo $obj_page->state == 2 ? "checked" : ""; ?> <?php echo $obj_page->state > 3 ? "disabled": "";?>><label for="state2">개발 완료</label>
                        <input type="radio" name="state" value="3" id="state3" <?php echo $obj_page->state == 3 ? "checked" : ""; ?>><label for="state3">업데이트 중</label>
                        <input type="radio" name="state" value="4" id="state4" <?php echo $obj_page->state == 4 ? "checked" : ""; ?>><label for="state4">삭제</label>

                    </li>
                    <li>
                        <label for="description">상세 설명
                            <input name="description" id="description" type="text" size="30" value="<?php echo $obj_page->description; ?>" />
                        </label>
                    </li>
                    <li class="finish_date">
                        <label for="finish_date">종료일(개발완료 시)
                            <input name="finish_date" id="finish_date" type="text" size="30" value="<?php echo ($obj_page->finish_date)? $obj_page->finish_date : date('Y-m-d'); ?>" <?php echo ($obj_page->state > 1)? "" : "disabled" ?> />
                        </label>
                    </li>

                </ul>
            </div>
            <div class="row">
                <div class="large-12 columns submit-button">
                    <input type="submit" value="submit" class="button radius small"/>
                </div>
                <div class="large-12 columns button-group">

                    <a href="<?php echo _BASE_URL_;?>/pages/view_all/<?php echo $obj_page->project_idx; ?>" class="button radius secondary tiny">
                        list pages
                    </a>
                </div>
            </div>
        </form>
    </div><!--//#content-area-->
</div><!--//#wrapper-->
<script src="<?php echo _BASE_URL_; ?>/public/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
  
<script type="text/javascript">
    $(function(){
        $('input[name=state]').change(function(){
            if( $(this).val() == 2 ){
                $('input[name=finish_date]').prop("disabled", false);
            }
        });

        $('#finish_date').datepicker({ dateFormat: "yy-mm-dd" });
    });
</script>