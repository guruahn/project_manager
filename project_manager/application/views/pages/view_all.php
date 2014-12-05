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
<!--popup-->
<div id="task_to_pop_up">
    <a href="#" class="b-close">X</a>
    <h3>할일 목록</h3>
    <div class="content">
        <ul id="task-list"></ul>
        <div class="row submit_task_wrap">
            <div class="large-6 columns" style="padding:0">
                <input type="text" name="title" />
            </div>
            <div class="large-4 columns" >
                <select name="user" id="user">
                    <option value="0">담당자</option>
                    <?php
                    foreach($users as $user):
                        $obj_user = (object) $user;
                    ?>
                        <option value="<?php echo $obj_user->idx;?>"><?php echo $obj_user->name; ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="large-2 columns" style="padding:0">
                <button class="submit_task button radius tiny" data-project-idx="<?php echo $filter_project_id; ?>">추가</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo _BASE_URL_;?>/public/js/jquery.bpopup.min.js"></script>
<script type="text/javascript">
$(function(){
    var total_page = $('.page').length;
    var success_page = $('.page .success').length;
    print_progress(total_page, success_page);


    /*완전삭제 준비중*/
    $('.del_complete').click(function(){
        alert('준비중입니다.');
        return false;
    });

    /*할일목록 팝업*/
    $('.task').click(function(){
        var page_idx = $(this).find('a').attr('data-idx');
        $('#task_to_pop_up').bPopup({
            onOpen: function(){
                ajax_get_task_list(page_idx);
            }
        });
        return false;
    });
    /*할일 추가*/
    $('#task_to_pop_up').on('click', '.submit_task', function(){
        var title = $('input[name=title]').val();
        var receiver_idx = $('select[name=user]').val();
        if( !title){
            alert('내용을 입력해주세요.');
            return false;
        }else{
            ajax_insert_task(title, $(this).attr('data-idx'), $(this).attr('data-project-idx'), receiver_idx);
        }
        return false;
    });
    /*상태변경-완료처리*/
    $('#task_to_pop_up').on('click', '.ing', function(){
        ajax_update_task_status($(this).attr('data-idx'));
    });
});
    /*상태변경-완료처리*/
    function ajax_update_task_status(idx){
        $.ajax({
            type: "POST",
            url: "<?php echo _BASE_URL_;?>/api/tasks/updateStatus/"+idx,
            data: {status: 2},
            dataType: "json"
        }).success(function(data){
            if(data.result) {
                $('li[data-idx='+idx+']').addClass('completed').removeClass('ing');
            }
        }).fail(function(response){
            console.log(printr_json(response));
        });
    }
    /*task 추가*/
    function ajax_insert_task(title, page_idx, project_idx, receiver_idx){
        $.ajax({
            type: "POST",
            url: "<?php echo _BASE_URL_;?>/api/tasks/addTask/",
            data: {title: title, page_idx: page_idx, project_idx: project_idx, receiver_idx: receiver_idx},
            dataType: "json"
        }).success(function(data){
            if(data.result) {
                $('#task-list .header').after('<li class="ing" data-idx="'+data.idx+'"><span class="title">'+title+'</span><span class="receiver">'+receiver_idx+'</span><span class="do">완료</span></li>');
                $('input[name=title]').val('');
            }
        }).fail(function(response){
            console.log(printr_json(response));
        });
    }
    /*task 리스트*/
    function ajax_get_task_list(page_idx){
        $.ajax({
            type: "POST",
            url: "<?php echo _BASE_URL_;?>/api/tasks/view_all/"+page_idx,
            dataType: "json"
        }).success(function(data){
            if(data.result) {
                console.log(printr_json(data));
                var list = data.list.map(function(item, index){
                    return '<li class="'+makeStatus(item.status)+'" data-idx="'+item.idx+'"><span class="title">'+item.title+'</span><span class="receiver">'+item.receiver_idx+'</span><span class="do">완료</span></li>';
                }).join('');
                var header = '<li class="header"><span class="title">제목</span><span class="receiver">담당</span><span class="do">처리</span></li>'
                $('#task-list').html(header+list);
                $('.submit_task').attr('data-idx', page_idx);
                $('input[name=title]').val('');
            }
        }).fail(function(response){
            console.log(printr_json(response));
        });
    }

    function makeStatus(status){
        if( status == 1 ){
            return 'ing';
        }else if( status == 2 ){
            return 'completed';
        }else{
            return "delete";
        }
    }
    /*task 상태바 애니메이션*/
    function print_progress(total_page, success_page){
        if( success_page > 0){
            var success_percent = (success_page/total_page)*100;
            /*progress animation start*/
            $('.meter').animate({
                width: success_percent+"%"
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
    }
</script>