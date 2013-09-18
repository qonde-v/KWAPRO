<?php
  class User_privatetag_manage extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
	    $this->load->model('q2a/Tag_process');
	 }

	 //////////////////////////////////////////////////////////////////////////////////
	 //*******************************TAG ADDED FUNCTION*****************************//
	 //////////////////////////////////////////////////////////////////////////////////

	 //process the event: add new tags to spefic sub category
	 //input: array('uId','sub_cate_id','category_id','langCode','tag_arr')
	 function privatetag_add_process($data)
	 {
		$new_tag_data = array();

		foreach($data['tag_arr'] as $tag_item)
		{
		   $tag_item = trim($tag_item);
		   $tag_id = $this->tag_match_from_DB(array('tag'=>$tag_item,'sub_cate_id'=>$data['sub_cate_id']));
		   $tag_data = array('sub_cate_id'=>$data['sub_cate_id'],'category_id'=>$data['category_id'],'langCode'=>$data['langCode'],'tag_name'=>$tag_item,'count'=>0);

		   if(!$tag_id)
		   {
			  $tag_id = $this->Tag_process->tag_insert($tag_data);
		   }

		   $tag_data['tag_id'] = $tag_id;
		   $tag_data['uId'] = $data['uId'];
		   unset($tag_data['count']);

		   array_push($new_tag_data,$tag_data);
	    }
	    $id_info = array('uId'=>$data['uId'], 'sub_cate_id'=>$data['sub_cate_id'], 'category_id'=>$data['category_id']);
	    $this->user_provatetag_save($new_tag_data,$id_info);
	 }

	 //match tag in DB, and return tag_id if matched,
	 //otherwise return null
	 //input: array('tag','sub_cate_id')
	 function tag_match_from_DB($data)
	 {
		if(isset($data['tag']) && !empty($data['tag']))
		{
			$tag_str = strtoupper($data['tag']);
			//$sql = "SELECT tag_id,tag_name FROM tag WHERE sub_cate_id = {$data['sub_cate_id']} AND UPPER(tag_name) = '{$tag_str}'";
			//$query = $this->db->query($sql);

			$this->db->select('tag_id,tag_name');
		    $this->db->where('sub_cate_id',$data['sub_cate_id']);
		    $this->db->where('UPPER(tag_name)',$tag_str);
		    $query = $this->db->get('tag');

			if($query->num_rows() > 0)
			{
			   $row = $query->row_array();
			   return $row['tag_id'];
			}
		}
		return '';
	 }

	 //store tag relation data to user's private tag table
	 //input: array('uId','sub_cate_id','category_id') , array of array('uId','sub_cate_id','category_id','langCode','tag_id','tag_name')
	 function user_provatetag_save($tag_data,$id_info)
	 {
		//get all tag id that store in user's private tag table
		$tag_id_arr = $this->get_privatetag_id($id_info);

		//print_r($tag_id_arr);

		foreach($tag_data as $tag_item)
		{
		   $index = array_search($tag_item['tag_id'], $tag_id_arr);

		   if($index === false)
		   {
			 $this->user_privatetag_insert($tag_item);
		   }
		   else
		   {
			 unset($tag_id_arr[$index]);
		   }
		}

		if(count($tag_id_arr))
		{
			$user_id = $id_info['uId'];
			$this->user_privatetag_delete($tag_id_arr,$user_id);
	    }
	 }

	 //get all tag id that user added as its private tags
	 //input: array('uId','category_id','sub_cate_id')
	 //output: array of tag id
	 function get_privatetag_id($data)
	 {
		$this->db->select('tag_id');
		$this->db->where($data);
		$query = $this->db->get('user_private_tag');

		$tag_data = array();

		if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($tag_data, $row->tag_id);
            }
        }
        return $tag_data;
	 }

	 //insert tag data into user's private tag table
	 //input: array('uId','sub_cate_id','category_id','langCode','tag_id','tag_name')
	 function user_privatetag_insert($tag_data)
	 {
		if(isset($tag_data['tag_name']) && !empty($tag_data['tag_name']))
		{
		  $this->db->insert('user_private_tag',$tag_data);
		}
     }

     //delete user's prviate tag(s) record
     //input: array of tag id ,user id
     function user_privatetag_delete($tag_id_arr,$user_id)
     {
		$this->_fun_privatetag_delete($tag_id_arr,$user_id,'tag_id');
	 }

	 //
	 function _fun_privatetag_delete($id_arr,$user_id,$id_column)
	 {
		if(count($id_arr))
		{
			/*$id_str = '('.implode(',',$id_arr).')';
			$sql = "DELETE FROM user_private_tag WHERE {$id_column} IN {$id_str} AND uId = {$user_id}";
			$this->db->query($sql);*/

			$this->db->where('uId',$user_id);
			$this->db->where_in($id_column,$id_arr);
		    $this->db->delete('user_private_tag');
	    }
	 }

	 //get user's private tags data
	 //input: array('uId','category_id','sub_cate_id')
	 //output: array of tags;
	 function get_privatetag_data($data)
	 {
		$this->db->select('tag_name');
		$this->db->where($data);
		$query = $this->db->get('user_private_tag');

		$tag_data = array();

		if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($tag_data, $row->tag_name);
            }
        }
        return $tag_data;
	 }


	 //load user's tag id information by user id
	 //input: user id
	 //output: array('tag_id','cate','sub_cate');
	 function load_privatetag_by_user_id($user_id)
	 {
	    $this->db->select('category_id,sub_cate_id,tag_id');
		$this->db->where('uId',$user_id);
		$query = $this->db->get('user_private_tag');

		$tag_data = array();
	    $sub_cate_data = array();
	    $cate_data = array();

	    if($query->num_rows() > 0)
	    {
		       foreach($query->result() as $row)
			   {
				   array_push($tag_data,$row->tag_id);
			       array_push($sub_cate_data, $row->sub_cate_id);
			       array_push($cate_data, $row->category_id);
			   }
	    }

	    $sub_cate_data = array_values(array_unique($sub_cate_data));
	    $cate_data = array_values(array_unique($cate_data));

	    $return_data = array('tag'=>$tag_data, 'sub_cate'=>$sub_cate_data, 'cate'=>$cate_data);
		return $return_data;
	 }


	 //select user by matching the tag_id
	 //input: array of tag_id
	 //output: array of user id
	 function get_user_by_privatetag($tag_data)
	 {
	    if(empty($tag_data))
		{
		  return array();
		}

		/*$id_str = '('.implode(',',$tag_data).')';
		$sql = "SELECT DISTINCT uId FROM user_private_tag WHERE tag_id IN {$id_str}";
		$query = $this->db->query($sql);*/

		$this->db->select('uId');
		$this->db->where_in('tag_id',$tag_data);
		$query = $this->db->get('user_private_tag');


		$user_id_arr = array();

		if($query->num_rows() > 0)
	    {
		   foreach($query->result() as $row)
		   {
			   array_push($user_id_arr, $row->uId);
		   }
	    }
		return $user_id_arr;
	 }

     //get a user's private tag data
     //input:user id
     //output: array(array('category_id','sub_cate_id','tag_id','tag_name'))
     //table--'user_private_tag'
     function get_user_private_tag($uId)
     {
        $this->db->select('tag_id,tag_name,category_id,sub_cate_id');
        $this->db->where('uId',$uId);
        $query = $this->db->get('user_private_tag');
        $result = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($result,array('category_id'=>$row->category_id,'sub_cate_id'=>$row->sub_cate_id,'tag_id'=>$row->tag_id,'tag_name'=>$row->tag_name));
            }
        }
        return $result;
     }
     
     	//save user's private tag
     	//input:$data = array('uId','langCode','tag','location','rcv_rss')
     	//table--'user_private_tag'
     	function user_private_tag_save($data)
     	{
     		$uId = $data['uId'];
     		$tag_data = $data['tag'];
     		$private_tag_id_arr = $this->get_privatetag_id(array('uId'=>$uId));
     		foreach($tag_data as $tag_item)
     		{   			
     			if($tag_item['tag_id'] == 0)
     			{
     				$tag_item['tag_id'] = $this->tag_match_from_DB(array('tag'=> $tag_item['tag_name'], 'sub_cate_id'=> $tag_item['sub_cate_id']));
     			}
     			if($tag_item['tag_id'] == '')
     			{
     				$tag_item['langCode'] = $data['langCode'];
     				$tag_data = $tag_item;
     				$tag_data['count'] = 0;
     				unset($tag_data['tag_id']);
     				$tag_id = $this->Tag_process->tag_insert($tag_data);
     				$tag_item['tag_id'] = $tag_id;
     				$tag_item['uId'] = $uId;
     				$this->user_privatetag_insert($tag_item);
     			}
     			else
     			{
     				if(in_array($tag_item['tag_id'],$private_tag_id_arr))
     				{
     					unset($private_tag_id_arr[array_search($tag_item['tag_id'],$private_tag_id_arr)]);
     				}
     				else
     				{
     					$tag_item['uId'] = $uId;
     					$tag_item['langCode'] = $data['langCode'];
     					$this->user_privatetag_insert($tag_item);
     				}
     			}
     		}
     		$this->user_privatetag_delete($private_tag_id_arr,$uId);
    	}
		
		//get a user's selected subcate according to the tag setting
		//input : user id
		//output: array of sub_cate_id
		//table--'user_private_tag'
		function get_user_sub_cate($uId)
		{
			$this->db->select('sub_cate_id');
			$this->db->where('uId',$uId);
			$this->db->distinct();
			$query = $this->db->get('user_private_tag');
			$result = array();
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					array_push($result,$row->sub_cate_id);
				}
			}
			return $result;
		}
     
  }//class

/*End of file*/
/*Location: ./system/appllication/model/user_privatetag_manage.php*/
