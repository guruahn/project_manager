<?php
/**
 * Page Model Class
 *
 * @category  Model
 * @package   Page
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/

class Page extends Model {
    /*
	* Get a post
	* @param
	* @return array
	*/
    public function getPage($column = "*", $where = null)
    {
        if( is_array($where) && !is_null($where) )
        {
            foreach($where as $key => $value)
            {
                $this->where($key,$value);
            }
            $post = $this->getOne("page", $column);
        }else{
            $post = $this->get("page", $column);

        }
        return	$post;
    }

    /*
     * Get list
     * @param
     * @return array
     */
    public function getList($orderby = null, $limit, $where = null) {
        if( !is_null($orderby) && is_array($orderby) ){
            foreach($orderby as $key => $value){
                $this->orderBy($key,$value);
            }
        }
        if( !is_null($where) && is_array($where) ){
            foreach($where as $key => $value){
                if(!is_null($value)) $this->where($key,$value);
            }
        }
        $posts = $this->get('page', $limit);
        return $posts;
    }

    /*
    * add post
    * @param
    * @return array
    */
    public function add($data)
    {
        $id = $this->insert('page', $data);
        return	$id;
    }

    /*
    * update post
    * @param
    * @return array
    */
    public function updatePost($idx, $data)
    {
        $this->where ('idx', $idx);
        return	$this->update('page', $data);
    }

    /*
    * delete post
    * @param
    * @return array
    */
    public function del($id)
    {
        $this->where ('id', $id);
        return	$this->delete('page');
    }


}