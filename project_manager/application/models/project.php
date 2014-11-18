<?php
/**
 * Post Model Class
 *
 * @category  Model
 * @package   Post
 * @author    Gongjam <guruahn@gmail.com>
 * @copyright Copyright (c) 2014
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0
 **/

class Project extends Model {
    /*
	* Get a post
	* @param
	* @return array
	*/
    public function getPost($column = "*", $where = null)
    {
        if( is_array($where) && !is_null($where) )
        {
            foreach($where as $key => $value)
            {
                $this->where($key,$value);
            }
            $post = $this->getOne("project", $column);
        }else{
            $post = $this->get("project", $column);

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
        $posts = $this->get('project', $limit);
        return $posts;
    }

    /*
    * add post
    * @param
    * @return array
    */
    public function add($data)
    {
        $id = $this->insert('project', $data);
        return	$id;
    }

    /*
    * update post
    * @param
    * @return array
    */
    public function updateProject($idx, $data)
    {
        $this->where ('idx', $idx);
        return	$this->update('project', $data);
    }

    /*
    * delete post
    * @param
    * @return array
    */
    public function del($idx)
    {
        $this->where ('idx', $idx);
        return	$this->delete('project');
    }


}