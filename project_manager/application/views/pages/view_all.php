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
        <?php
        foreach($project_list as $project):
            $obj_project = (object) $project;
            if( $obj_project->idx == $filter_project_id ) $title = text_cut_utf8($obj_project->name, 70);
        endforeach;
        ?>
        <h2><?php echo $title;?></h2>
    </div>

    <div class="small-11 small-centered columns ">
            
        <div class="state_list">
            <ul class="button-group">
              <li><a href="#" class="button tiny radius state0">작업중</a></li>
              <li><a href="#" class="button tiny radius alert state1">퍼블리싱 완료</a></li>
              <li><a href="#" class="button tiny radius success  state2">개발 완료</a></li>
              <li><a href="#" class="button tiny radius state3">업데이트 중</a></li>
              <li><a href="#" class="button tiny radius secondary state4">삭제</a></li>
            </ul>
        </div>
        
    </div>
    <div id="content-area" class="small-11 small-centered panel radius columns">
        <div class="progress small-4 success round" style="float: right;">
            <span class="meter" style="width: 0%"></span><span id="meter_text">0</span>%
        </div>
        <div class="page_list ">
            <?php
            echo $tree;
            ?>

        </div>
    </div>

    <div class="small-11 small-centered columns">
        <p class="button-group radius">
            <span><a href="<?php echo _BASE_URL_;?>/pages/writeform/<?php echo $filter_project_id; ?>" class="button radius tiny">Add</a></span>
            <span><a href="<?php echo _BASE_URL_;?>/project/view_all" class="button secondary radius tiny">Project List</a></span>
        </p>
    </div>
</div>
<script type="text/javascript">
$(function(){
    var total_page = $('.page').length;
    var success_page = $('.page .success').length;
    if( success_page > 0){
        var success_percent = (success_page/total_page)*100;
        /*progress animation start*/
        $('.meter').animate({
            width: success_percent+"%",
        },2000, function(){});
        var rn = Math.round(Math.random() * 99999);
        $("#msg").text("Random Number = " + rn);
        
        /*percent text animation start*/
        var $el = $("#meter_text");
        $({ val : 0 }).animate({ val : success_percent }, {
            duration: 2000,
            step: function() {
                $el.text(Math.floor(this.val));
            },
            complete: function() {
                $el.text(Math.floor(this.val));
            }
        });
    }

    /*완전삭제 준비중*/
    $('.del_complete').click(function(){
        alert('준비중입니다.');
        return false;
    });
});
</script>