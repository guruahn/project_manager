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

        $category = new Category();
        $where = array( "project_idx"=>$project_idx );
        $categories = $category->getList( array('insert_date'=>'asc'), $limit, $where );
        $this->make_tree(0,0,$project_idx);
        $this->set('title','Pages');
        $this->set('categories',$categories);
        $this->set('tree',$this->treeHTML);
        $this->set('project_list',$project_list);
        $this->set('filter_project_id', $project_idx);

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
        foreach ($categories as $category) {
            // indent and display the title of this child
            $category_obj = (object) $category;
            $this->treeHTML .= "<li class='level-".$level."'>";
            $this->treeHTML .= "<a href='"._BASE_URL_."/categories/editForm/".$category_obj->idx."'>";
            $this->treeHTML .= str_repeat(' ',$level).$category_obj->name."\n";
            $this->treeHTML .= "</a>";

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
                    $insert_date = (empty($page_obj->insert_date))? "" : date('Y-m-d',strtotime($page_obj->insert_date));
                    $finish_date = (empty($page_obj->finish_date))? "" : date('Y-m-d',strtotime($page_obj->finish_date));
                    $del_open = ($page_obj->state == 4)? "<del>" : "";
                    $del_close = ($page_obj->state == 4)? "</del>" : "";
                    $this->treeHTML .= "<li class='page'>";
                        $this->treeHTML .= "<span class='radius state ".$state['en']." ".$state['class']."'>".$state['ko']."</span>";
                        $this->treeHTML .= "<span class='name'>".$del_open."<a href='".$page_obj->link."' target='_blank'>".$page_obj->name."</a>".$del_close."</span>";
                        $this->treeHTML .= "<span class='description'>".$page_obj->description."</span>";
                        $this->treeHTML .= "<span class='insert_date'>".$insert_date."</span>";
                        $this->treeHTML .= "<span class='finish_date'>".$finish_date."</span>";
                        if($page_obj->state != 4){
                            $this->treeHTML .= "<span class='modify'><a href="._BASE_URL_."/pages/editForm/".$page_obj->idx." >수정</a></span>";
                            $this->treeHTML .= "<span class='del'><a href="._BASE_URL_."/pages/del/".$page_obj->idx."/".$project_idx." >삭제</a></span> ";
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

    function makeState($state){
        $result = array(
            "en"=>"",
            "ko"=>""
        );
        if($state == 0){
            $result["en"] = "ready";
            $result["ko"] = "작업중";
            $result["class"] = "button tiny state0";
        }else if($state == 1){
            $result["en"] = "publish-finish";
            $result["ko"] = "퍼블리싱 완료";
            $result["class"] = "button tiny alert state0";
        }else if($state == 2){
            $result["en"] = "develop-finish";
            $result["ko"] = "개발 완료";
            $result["class"] = "button tiny success state0";
        }else if($state == 3){
            $result["en"] = "update";
            $result["ko"] = "업데이트 중";
            $result["class"] = "button tiny state0";
        }else if($state == 4){
            $result["en"] = "delete";
            $result["ko"] = "삭제";
            $result["class"] = "button tiny secondary state0";
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