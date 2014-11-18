<?php
/**
 * UsersController Class
 *
 * @category  Controller
 * @package   user manager
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/

class UsersController extends Controller {

    function view($id = null,$name = null) {
        $this->set('title',$name.' - GJboard View App');
        $this->set('post',$this->Post->getPost( "*", array("id"=>$id) ));

    }

    function joinForm() {
        $this->set('title','join user - Project manager');
    }

    function add() {
        $referer = (isset($_POST['referer'])? $_POST['referer'] : _BASE_URL_."/project/view_all" );

        if( !trim($_POST['name']) || !trim($_POST['id']) || !trim($_POST['password']) ){
            msg_page("Required fields are missing.");
        }

        $data = Array(
            "id" => trim(strval($_POST['id'])),
            "name" => trim(strval($_POST['name'])),
            "password" => $this->User->func('SHA1(?)', Array( trim(strval($_POST['password'])).SALT) ),
            "insert_date" => date("Y-m-d H:i:s")
        );
        $this->User->getUser("id", array("id"=>$data['id']));
        if( $this->User->count > 0 ){
            msg_page("ID is already subscribed.");
        }

        $id = $this->set('user',$this->User->add($data));
        redirect($referer);
    }

    function loginForm() {
        $this->set('title','login user - Project Manager App');
    }

    function login() {
        $referer = (isset($_POST['referer']) && !empty($_POST['referer']) ? $_POST['referer'] : _BASE_URL_."/project/view_all" );

        if( !trim($_POST['id']) || !trim($_POST['password']) ){
            msg_page("Required fields are missing.");
        }

        $data = Array(
            "id" => trim(strval($_POST['id'])),
            "password" => SHA1( $_POST['password'].SALT )
        );

        $user = $this->User->getUser("*", $data);
        if( $this->User->count > 0 ){
            if( $user['level'] <= 5){
                $_SESSION['LOGIN_NO'] = $user["idx"];
                $_SESSION['LOGIN_ID'] = $user["id"];
                $_SESSION['LOGIN_NAME'] = $user["name"];
                $_SESSION['LOGIN_LEVEL'] = $user["level"];

                /*check is save id */
                $is_save_id =  ( isset($_POST['is_save_id']) ? trim(strval($_POST['is_save_id'])) : "N");
                if($is_save_id == "Y"){
                    setcookie("is_save_id", "Y" , time()+60*60*24*365,"/");
                    setcookie("LOGIN_ID", $user['id'] , time()+60*60*24*365,"/");
                }else{
                    setcookie("is_save_id", "" , time()+60*60*24*365,"/");
                }
            }else{
                msg_page("You do not have permission to access.");
            }
        }else{
            msg_page("information does not match.");
        }
        redirect($referer);
    }

    function logout(){
        $referer = (isset($_POST['referer'])? $_POST['referer'] : _BASE_URL_."/project/view_all" );
        unset($_SESSION['LOGIN_NO']);
        unset($_SESSION['LOGIN_ID']);
        unset($_SESSION['LOGIN_NAME']);
        unset($_SESSION['LOGIN_LEVEL']);
        redirect($referer);
    }

}