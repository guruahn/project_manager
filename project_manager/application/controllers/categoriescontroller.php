<?php
/**
 * CategoriesController Class
 *
 * @category  Controller
 * @package   category manager
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/

class CategoriesController extends Controller {
    public $treeHTML = "";

    function view($id = null,$name = null) {
        $this->set('title',$name.' - GJboard View App');
        $this->set('post',$this->Post->getPost( "*", array("id"=>$id) ));

    }

    function view_all($project_idx = null, $thispage=1) {

        if(is_null($thispage)) $thispage = 1;
        $limit = array( ($thispage-1)*10, 10 );

        $project = new Project();
        $project_list = $project->getList( array('insert_date'=>'desc'), "1000" );
        if(is_null($project_idx)) $project_idx = $project_list[0]['idx'];

        $where = array( "project_idx"=>$project_idx );
        $categories = $this->Category->getList( array('insert_date'=>'asc'), $limit, $where );
        $this->make_tree(0,0,$project_idx);
        $this->set('title','All Categires');
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
        $categories = $this->Category->getList( array('insert_date'=>'asc'), $limit, $where );
        //printr($categories);
        $this->treeHTML .= "<ul>";
        // display each child
        foreach ($categories as $category) {
            // indent and display the title of this child
            $category_obj = (object) $category;
            $this->treeHTML .= "<li class='level-".$level."'>";
            $this->treeHTML .= "<a href="._BASE_URL_."/categories/editForm/".$category_obj->idx."'>";
            $this->treeHTML .= str_repeat(' ',$level).$category_obj->name."\n";
            $this->treeHTML .= "</a>";
            $this->treeHTML .= "<a href="._BASE_URL_."/categories/del/".$category_obj->idx." >delete</a>";

            // call this function again to display this
            // child's children
            $this->make_tree($category_obj->idx, $level+1, $project_idx);
            $this->treeHTML .= "</li>";
        }
        $this->treeHTML .= "</ul>";

    }

    function editForm($idx = null) {
        $this->set('title','Edit Category');

        $project = new Project();
        $project_list = $project->getList( array('insert_date'=>'asc'), "1000" );
        $thispage = 1;
        $limit = array( ($thispage-1)*10, 100 );
        $categories = $this->Category->getList( array('insert_date'=>'desc'), $limit );

        $this->set('category',$this->Category->getCategory( "*", array("idx"=>$idx) ));
        $this->set('categories',$categories);
        $this->set('project_list',$project_list);
    }

    function edit($idx = null) {

        $data = Array(
            "name" => trim(strval($_POST['name'])),
            "slug" => trim(strval($_POST['slug'])),
            "project_idx" => trim($_POST['project_idx']),
            "parent_idx" => trim($_POST['parent_idx'])
        );
        $this->Category->updateCategory($idx, $data);
        redirect(_BASE_URL_."/categories/view_all");
    }

    function add() {
        $name = trim(strval($_POST['name']));
        $slug = trim(strval($_POST['slug']));
        $project_idx = trim($_POST['project_idx']);
        $parent_idx = trim($_POST['parent_idx']);
        $data = Array (
            "name" => $name,
            "slug" => $slug,
            "project_idx" => $project_idx,
            "parent_idx" => $parent_idx
        );
        $this->set('category',$this->Category->add($data));
        redirect(_BASE_URL_."/categories/view_all");
    }

    function del($id = null) {

        if( $this->Category->del($id) ){
            msg_page('Success delete post.', _BASE_URL_."/categories/view_all");
            exit;
        }else{
            msg_page('Cannot delete this post.');
            exit;
        }
    }

}