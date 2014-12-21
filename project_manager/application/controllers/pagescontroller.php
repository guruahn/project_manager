<?php
/**
 * PostsController Class
 *
 * @category  Controller
 * @package   Posts
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/

class PagesController extends Controller {
    public $treeHTML = "";
    function view($id = null,$name = null) {
        $this->set('title',$name);
        $post = $this->Post->getPost( "*", array("id"=>$id) );
        $user = new User();
        $post['user_name'] = $user->getUser("name",array('user_id'=>$post["user_id"]));
        $category = new Category();
        $post['category'] = $category->getCategory("*", array('id'=>$post['category_id']));
        $this->set('post',$post);
    }

    function view_all($project_idx) {
        $thispage = 1;
        $limit = array( ($thispage-1)*10, 10 );

        $project = new Project();
        $project_list = $project->getList( array('insert_date'=>'desc'), "1000" );
        if(is_null($project_idx)) $project_idx = $project_list[0]['idx'];

        $user = new User();
        $users = $user->getList( array('insert_date'=>'desc'), "1000" );

        $category = new Category();
        $where = array( "project_idx"=>$project_idx );
        $categories = $category->getList( array('insert_date'=>'asc'), $limit, $where );
        $this->make_tree(0,0,$project_idx);
        $this->set('title','Pages');
        $this->set('categories',$categories);
        $this->set('tree',$this->treeHTML);
        $this->set('project_list',$project_list);
        $this->set('filter_project_id', $project_idx);
        $this->set('users', $users);
    }

    function make_tree($parent_idx = 0, $level = 0, $project_idx){
        // retrieve all children of $parent
        $thispage = 1;
        $limit = array( ($thispage-1)*10, 1000 );
        $where = array(
            'parent_idx'=> $parent_idx,
            'project_idx'=> $project_idx
        );
        $category = new Category();
        $categories = $category->getList( array('insert_date'=>'asc'), $limit, $where );
        //printr($categories);
        $this->treeHTML .= "<ul>";
        // display each child
        foreach ($categories as $category_item) {
            // indent and display the title of this child
            $category_obj = (object) $category_item;
            $this->treeHTML .= "<li class='level-".$level."'>";

            if( $level == 0 ) $this->treeHTML .= "<hr />";

            $this->treeHTML .= $this->makeBreadcrumbs($category_obj, $level);


            //call pages
            $page_where = array(
                'category_idx'=>$category_obj->idx,
                'project_idx'=>$project_idx
            );

            $pages = $this->Page->getList( array('insert_date'=> 'asc'), array(0, 1000), $page_where);
            if(!empty($pages)){
                $this->treeHTML .= "<ul>";
                foreach ( $pages as $page ):
                    $page_obj = (object) $page;
                    $state =  $this->makeState($page_obj->state);
                    $task = New Task();
                    $count_of_tasks = count( $task->getList('task',array('insert_date'=>'asc'), array(0, 1000), array('page_idx'=>$page_obj->idx, 'status'=>1), array("idx")) );
                    $del_open = ($page_obj->state == 4)? "<del>" : "";
                    $del_close = ($page_obj->state == 4)? "</del>" : "";
                    $this->treeHTML .= "<li class='page'>";
                        $this->treeHTML .= "<span class='radius state ".$state['en']." ".$state['class']."'>".$state['ko']."</span>";
                        $this->treeHTML .= "<span class='name'>".$del_open."<a href='".$page_obj->link."' target='_blank'>".$page_obj->name."</a>".$del_close."</span>";
                        if($page_obj->state != 0){
                            $this->treeHTML .= "<span class='modify'><a href="._BASE_URL_."/pages/editForm/".$page_obj->idx." >수정</a></span>";
                            $this->treeHTML .= "<span class='del'><a href="._BASE_URL_."/pages/del/".$page_obj->idx."/".$project_idx." >삭제</a></span> ";
                            $this->treeHTML .= "<span class='task'><a data-idx='".$page_obj->idx."' href="._BASE_URL_."/tasks/view_all/".$page_obj->idx." >할일(<span class='count_of_task_".$count_of_tasks."'>".$count_of_tasks."</span>)</a></span> ";
                        }else{
                            $this->treeHTML .= "<span class='del_complete'><a href="._BASE_URL_."/pages/delComplete/".$page_obj->idx."/".$project_idx." >완전삭제</a></span> ";
                        }
                    $this->treeHTML .= "</li>";
                endforeach;
                $this->treeHTML .= "</ul>";
            }


            // call this function again to display this
            // child's children
            $this->make_tree($category_obj->idx, $level+1, $project_idx);
            $this->treeHTML .= "</li>";
        }
        $this->treeHTML .= "</ul>";

    }

    function makeBreadcrumbs($category_obj, $level){
        $breadcrumbsHTML = '<li class="current"><a href="'._BASE_URL_.'/categories/editForm/'.$category_obj->idx.'">'.$category_obj->name.'</a></li>';
        for ($i = $level; $i >= 0; $i--) {
            $where = array(
                "idx"=>$category_obj->parent_idx,
                "project_idx"=>$category_obj->project_idx
            );
            $category = new Category();
            $parent_category = $category->getCategory( "*", $where );
            if($parent_category){
                $category_obj = (object) $parent_category;
                $breadcrumbsHTML = '<li><a href="'._BASE_URL_.'/categories/editForm/'.$category_obj->idx.'">'.$category_obj->name.'</a></li>'.$breadcrumbsHTML;
            }
        }
        return '<nav class="breadcrumbs">'.$breadcrumbsHTML.'</nav>';
    }

    function makeState($state){
        $result = array(
            "en"=>"",
            "ko"=>""
        );
        if($state == 0){
            $result["en"] = "ready";
            $result["ko"] = "작업중";
            $result["class"] = "button tiny alert state0";
        }else if($state == 1){
            $result["en"] = "develop-finish";
            $result["ko"] = "개발 완료";
            $result["class"] = "button tiny success state0";
        }
        return $result;
    }
    function writeForm($project_idx) {
        $limit = array( 0, 1000 );
        $where = array(
            'project_idx'=> $project_idx
        );
        $category = new Category();
        $categories = $category->getList( array('insert_date'=>'asc'), $limit, $where );
        $this->set('project_idx', $project_idx);
        $this->set('categories', $categories);
        $this->set('title','Write  pages');
    }

    function addPage() {
        $data = Array(
            "link" => $_POST['link'],
            "name" => $_POST['name'],
            "state" => $_POST['state'],
            "description" => $_POST['description'],
            "project_idx" => $_POST['project_idx'],
            "category_idx" => $_POST['category_idx']
        );

        $this->set('page',$this->Page->add($data));
        redirect(_BASE_URL_."/pages/view_all/".$_POST['project_idx']);
    }

    function del($idx = null, $project_idx) {

        $data = Array(
            "state" => 4,
        );

        $this->Page->updatePost($idx, $data);
        redirect(_BASE_URL_."/pages/view_all/".$project_idx);
    }

    function delComplete($idx, $project_idx){
        $this->Page->del($idx);
        redirect(_BASE_URL_."/pages/view_all/".$project_idx);
    }

    function editForm($idx = null) {
        $category = new Category();
        $categories = $category->getList( array('insert_date'=>'asc'), "1000" );

        $this->set('categories', $categories);
        $this->set('title','Edit Page');
        $this->set('page',$this->Page->getPage( "*", array("idx"=>$idx) ));
    }

    function updatePost($idx = null) {

        $data = Array(
            "link" => $_POST['link'],
            "name" => $_POST['name'],
            "state" => $_POST['state'],
            "description" => $_POST['description'],
            "category_idx" => $_POST['category_idx']
        );
        if( isset($_POST['finish_date']) ) $data["finish_date"] = $_POST['finish_date'];
        $this->Page->updatePost($idx, $data);
        redirect(_BASE_URL_."/pages/view_all/".$_POST['project_idx']);
    }


}