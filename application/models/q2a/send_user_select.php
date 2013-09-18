<?php
  class Send_user_select extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
	    $this->load->model('q2a/Tag_process');
		$this->load->model('q2a/Question_data');
		$this->load->model('q2a/User_privatetag_manage');
		$this->load->model('q2a/Message_manage');		
	 }
	 
	 //select user for the submitted content
	 //input: node structure data
	 //output: array of user id
	 function select_send_user($data)
	 {
		 $user_id_arr = array();
		 
		 switch($data['ntId'])
		 {
		   case QUESTION:
		     $user_id_arr = $this->select_user4question($data);
		     break;
		   case ANSWER:
		     $user_id_arr = $this->select_user4answer($data);
		     break;
		   case COMMENT:
		     $user_id_arr = $this->select_user4comment($data);
		     break;
		   case MESSAGE:
		     $user_id_arr = $this->select_user4message($data);
		     break;
		   case MESSAGE_REPLY:
		     $user_id_arr = $this->select_user4message_reply($data);
		     break;
		   default:
		     break;
		 }
		 
		 return $user_id_arr;
	 }
	 
	 //select user to send question
	 //input: node structure data
	 //output: array of user id
	 function select_user4question($data)
	 {
	   $key_tagid_arr = $this->Question_data->get_quesiton_cate_id_info($data['nId']);
	   $location_tagid_arr = $this->Question_data->get_question_locationtag_data($data['nId']);
	   return $this->get_send_user4question(array('key_tag'=>$key_tagid_arr,'location_tag'=>$location_tagid_arr));
	 }
	 
	 //
	 function select_user4message($data)
	 {
	    return $this->Message_manage->_message_sent2user_id($data['nId']);
	 }
	 
	 //
	 function select_user4answer($data)
	 {
	    return $this->select_user4reply($data['nId']);
	 }
	 
	 //
	 function select_user4comment($data)
	 {
	    return $this->select_user4reply($data['nId']);
	 }
	 
	 //
	 function select_user4message_reply($data)
	 {
	    return $this->select_user4reply($data['nId']);
	 }
	 
	 //get the user of text that current text reply to
	 //input:  node id of current text
	 //output: array of user id
	 function select_user4reply($node_id)
	 {
	    $sql = "SELECT node.uId FROM node,node_relation WHERE node_relation.nFromId = {$node_id} AND node_relation.nToId = node.nId";
	    $query = $this->db->query($sql);
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
	 
	 //get user to send question
	 //intput: array('key_tag','location_tag')
	 function get_send_user4question($data)
	 {
	    $user_keyTag_arr  = $this->get_user_by_keytags($data['key_tag']);
	    $user_locationTag_arr  = $this->get_user_by_locationtag($data['location_tag']);
	    
	    if(empty($user_locationTag_arr))
	    {//not any location tag
 	       return empty($user_keyTag_arr) ? $this->get_top_level_user() : $user_keyTag_arr;
	    }
	    else
	    {
	      $intersect_user_arr = array_intersect($user_keyTag_arr,$user_locationTag_arr);
	      if(empty($intersect_user_arr))
	      {
	        $user_id_data = array_merge($user_keyTag_arr,$user_locationTag_arr);
	        return array_values(array_unique($user_id_data));  
	      }
	      else
	      {
	        return $intersect_user_arr;
	      }
	    }
	 }
	 
	 
	 
	/********************************************************************/ 
	/************************GET USER BY KEY TAG*************************/ 
	/********************************************************************/ 	 
	 //get user by matching key tag
	 //input: array of ('cate'=>array(), 'sub_cate'=>array(), 'tag'=>array())
	 //output: array of user id
	 function get_user_by_keytags($cate_data)
	 {
	    //$cate_data = $this->Tag_process->get_catedata_by_tag($data);
	    return $this->get_user_by_catedata($cate_data);
	 }
	 
	 //input: array of ('cate'=>array(), 'sub_cate'=>array(), 'tag'=>array())
	 //output: array of user id
	 function get_user_by_catedata($cate_data)
	 {
		 
		$user_id_arr  = $this->get_user_by_privateTag($cate_data['tag']);
		
		if(empty($user_id_arr))
		{ 
			$user_id_arr  = $this->get_user_by_subcate($cate_data['sub_cate']);
			if(empty($user_id_arr))
			{
				$user_id_arr = $this->get_user_by_cate($cate_data['cate']);
				if(empty($user_id_arr))
				{
				   //$user_id_arr = $this->get_top_level_user();
				}
			}
		}
		
	    return $user_id_arr;
	 }
	 
	 //get users by matching their private tags with question tags
	 //input: array of tag id
	 //output: array of user id
	 function get_user_by_privateTag($tag_data)
	 {
		//todo:
		return $this->User_privatetag_manage->get_user_by_privatetag($tag_data);
	 }
	 
	 //get user id by matching sub category id
	 //input: array of sub category id
	 //output: array of user id
	 function get_user_by_subcate($sub_cate_data)
	 {
	    return $this->get_user_by_specColumn($sub_cate_data,'sub_cate_id');
	 }
	 
     //get user id by matching category id
	 function get_user_by_cate($cate_data)
	 {
	    return $this->get_user_by_specColumn($cate_data,'category_id');
	 }
	 
	 //get user id by specify column data
	 //input:  $data--array of id value,$column--name of specify column
	 //output: array of user id 
	 function get_user_by_specColumn($data,$column)
	 {
	    if(empty($data))
		{
		  return array();
		}
		
	    $id_str = '('.implode(',',$data).')';
	    $sql = "SELECT DISTINCT uId FROM user_tag WHERE {$column} in {$id_str}";
	    $query = $this->db->query($sql);
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
	 
	 /********************************************************************/ 
	 /***********************GET USER BY LOCATION TAG*********************/ 
	 /********************************************************************/ 
	 //get user by matching location tags
	 //input: array of location data structure
	 //output: array of user id
	 function get_user_by_locationtag($data)
	 {
	    $user_id_arr = array();
	    foreach($data as $item)
	    {
	       $user_id_arr = array_merge($user_id_arr, $this->get_user_by_locationtag_item($item));
	    }
	    return array_values(array_unique($user_id_arr));
	 }
	 
	 //get user by matching location tags
	 //input: array of location data structure
	 //output: array of user id
	 function get_user_by_locationtag_item($data)
	 {
	   //todo:
	   $user_id_arr = $this->get_town_level_user($data);
	   if(empty($user_id_arr))
	   {
	     $user_id_arr = $this->get_city_level_user($data);
	     if(empty($user_id_arr))
	     {
	        $user_id_arr = $this->get_province_level_user($data);
		    if(empty($user_id_arr))
		    {
		       $user_id_arr = $this->get_country_level_user($data);
		       if(empty($user_id_arr))
		       {
		          $user_id_arr = $this->get_top_level_user($data);
		       }//country   
		    }//province
	     }//city
	   }//town
	   return $user_id_arr;
	 }
	 
	 //input: array('country_code','province_code','city_code','town_code')
	 //output: array of user id
	 function get_town_level_user($data)
	 {
	    if(count($data) < 4)
	    {
	      return array();
	    }
	    
	    $sql = "SELECT DISTINCT uId FROM user_location WHERE country_code = '{$data['country_code']}' and province_code = '{$data['province_code']}' and city_code = '{$data['city_code']}' and town_code = '{$data['town_code']}'";
	    $query = $this->db->query($sql);
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
	 
	 //input: array('country_code','province_code','city_code')
	 //output: array of user id
	 function get_city_level_user($data)
	 {
	    if(count($data) < 3)
	    {
	      return array();
	    }
	    
	    $sql = "SELECT DISTINCT uId FROM user_location WHERE country_code = '{$data['country_code']}' and province_code = '{$data['province_code']}' and city_code = '{$data['city_code']}'";
	    $query = $this->db->query($sql);
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
	 
	 //input: array('country_code','province_code')
	 //output: array of user id
	 function get_province_level_user($data)
	 {
	    if(count($data) < 2)
	    {
	      return array();
	    }
	    
	    $sql = "SELECT DISTINCT uId FROM user_location WHERE country_code = '{$data['country_code']}' and province_code = '{$data['province_code']}'";
	    $query = $this->db->query($sql);
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
	 
	 //input: array('country_code')
	 //output: array of user id
	 function get_country_level_user($data)
	 {
	    if(count($data) < 1)
	    {
	      return array();
	    }
	    
	    $sql = "SELECT DISTINCT uId FROM user_location WHERE country_code = '{$data['country_code']}'";
	    $query = $this->db->query($sql);
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
	 
	 //get top level user to answer the question
	 //output: array of user id
	 function get_top_level_user($data=array())
	 {
	    return array(1);   
	 }
  }

/*End of file*/
/*Location: ./system/appllication/model/q2a/send_user_select*/
