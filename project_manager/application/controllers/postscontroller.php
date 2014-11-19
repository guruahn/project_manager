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

class PostsController extends Controller {

    function view($idx = null,$name = null) {
        $this->set('title',$name);
        $post = $this->Post->getPost( "*", array("idx"=>$idx) );
        $user = new User();
        $post['user_name'] = $user->getUser("name",array('id'=>$post["user_id"]));
        $category = new Category();
        $post['category'] = $category->getCategory("*", array('idx'=>$post['category_id']));
        $this->set('post',$post);
    }

    function view_all($thispage=1, $filter=null, $category_id = null) {
        $where = null;
        if(is_null($thispage) || empty($thispage)) $thispage = 1;
        $limit = array( ($thispage-1)*10, 10 );

        $category = new Category();
        $categories = $category->getList( array('insert_date'=>'asc'), "1000" );

        if(!is_null($filter)){
            if($filter == 'category') $where = array( "category_id" => $category_id );
            if($filter == 'secret') $where = array( "is_secret" => "Y" );
        }
        $posts = $this->Post->getList( array('publish_date'=>'desc'), $limit, $where);
        $this->set('title','All Posts');
        $this->set('categories',$categories);
        $this->set('filter_category_id',$category_id);
        $this->set('filter', $filter);
        $this->set('posts',$posts);

    }

    function writeForm() {
        $category = new Category();
        $categories = $category->getList( array('register_date'=>'asc'), "1000" );

        $this->set('categories', $categories);
        $this->set('title','Write  post');
    }

    function addPost() {
        $data = Array(
            "user_id" => $_SESSION['LOGIN_ID'],
            "title" => $_POST['title'],
            "category_id" => $_POST['category_id'],
            "content" => $_POST['content'],
            "tags" => $_POST['tags'],
            "is_notice" => $_POST['is_notice'],
            "is_secret" => $_POST['is_secret'],
            "publish_date" => date("Y-m-d H:i:s")
        );

        $this->set('post',$this->Post->add($data));
        redirect(_BASE_URL_."/posts/view_all");
    }

    function del($id = null) {

        if( $this->Post->del($id) ){
            msg_page('Success delete post.', _BASE_URL_."/posts/view_all");
            exit;
        }else{
            msg_page('Cannot delete this post.');
            exit;
        }
    }

    function editForm($idx = null) {
        $category = new Category();
        $categories = $category->getList( array('insert_date'=>'asc'), "1000" );
        $this->set('categories', $categories);
        $this->set('title','Edit Post');
        $this->set('post',$this->Post->getPost( "*", array("idx"=>$idx) ));
    }

    function updatePost($idx = null) {

        $data = Array(
            "title" => trim(strval($_POST['title'])),
            "category_id" => $_POST['category_id'],
            "content" => trim(strval($_POST['content'])),
            "tags" => trim(strval($_POST['tags'])),
            "is_notice" => trim(strval($_POST['is_notice'])),
            "is_secret" => trim(strval($_POST['is_secret'])),
            "ip" => trim(strval($_POST['ip'])),
            "modify_date" => date("Y-m-d H:i:s",strtotime($_POST['modify_date']))
        );
        $this->Post->updatePost($idx, $data);
        redirect(_BASE_URL_."/posts/view_all");
    }

    function uploadFile($file = null) {
        global $is_API;
        if(is_null($file)) $file = $_FILES;
        $result = array(
            'result'=>0,
            'link'=>''
        );
        if($file['file']['name']) {
            $file_check = explode(".", $file['file']['name']);
            $ext = strtolower($file_check[count($file_check)-1]);					// 파일 확장자 구하기
            $upfile = file_upload($file['file']['tmp_name'], "board_".date("YmdHis").rand(1000,9999), $ext, "..".UPLOAD_PATH."/".date("Y")."/".date("m")."/", 1);
            if($upfile){
                $result['result'] = 1;
                $result['link'] = _BASE_URL_.UPLOAD_PATH."/".date("Y")."/".date("m")."/".$upfile;
                $result['filename'] = $upfile;
            }
            //thumbnail($path."/".$upfile, $path."/thumb_".$upfile, 120, 100, 1);
            $post_id = (isset($_POST['id']) ? $_POST['id'] : "");
            $is_thumbnail = (isset($_POST['is_thumbnail']) ? $_POST['is_thumbnail'] : "N");
            if( !$this->addAttachment($post_id, $is_thumbnail, $file, $upfile, $result['link']) ) {
                $result['result'] = 0;
                $result['message'] = "file information update failed!";
            }
        }

        if($is_API){
            echo json_encode($result);
        }else{
            return $result;
        }
    }

    function loadFile($post_id = null, $user_id = null){
        global $is_API;

        $where = Array(
            "post_id" => $post_id,
            "user_id" => $user_id
        );
        $data = null;

        $files = $this->Post->getAttachment("url", $where);
        if($is_API){
            echo json_encode($files);
        }else{
            return $files;
        }

    }

    function deleteFile(){
        $result = array(
            'result'=>0
        );

        $src = $_POST['src'];
        $path = getcwd();
        $path = str_replace( "\\public", "", $path );

        $real_path = realpath($path.$src);
        // Check if file exists.
        if (file_exists($real_path)) {
            // Delete file.
            if(unlink($real_path)){
                //database delete...
                if( $this->Post->delAttachment( Array("url" => $src)) ) $result['result'] = 1;
            }
        }
        echo json_encode($result);
    }

    function addAttachment($post_id = "", $is_thumbnail = "N", $file = null, $name, $url) {
        if(is_null($file)) $file = $_FILES;
        $result = array(
            'result'=>0
        );

        $data = Array(
            "post_id" => $post_id,
            "user_id" => $_SESSION['LOGIN_ID'],
            "name" => $name,
            "original_name" => $file['file']['name'],
            "url" => $url,
            "mime" => $file['file']['type'],
            "size" => $file['file']['size'],
            "is_thumbnail" => $is_thumbnail,
            "register_date" => date("Y-m-d H:i:s"),
        );
        if( $this->Post->addAttachment($data) ) $result['result'] = 1;

        return $result;
    }
}