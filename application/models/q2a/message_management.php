<?php
  class Message_management extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
		$this->load->library('session');
		$this->load->library('language_translate');
		$this->load->model('q2a/User_data');
		$this->load->model('q2a/Ip_location');
	 }
	     
     //delete message item by message id
	 //input: array of array('message_id','from_uId','to_uId')
	 function message_delete($data)
	 {
	    foreach($data as $item)
	    {
	    	$this->db->delete('message_manage', $item);
			$this->db->delete('message_data', $item);
	    }
	 }
	 
	 
	 //update the stat of the message(s) in the array
	 //input:'stat', 'message_id'=>array of ('message_id','from_uId','to_uId'))
	 function message_stat_update($stat,$msg_info_arr)
	 {
		$update_data = array('is_read'=>$stat);
		foreach($msg_info_arr as $item)
		{
			$this->_message_column_update($update_data,$item);
		}
	 }


     //update the last activity time for the specified message
     //input:'time' , 'message_id'=>array of ('message_id','from_uId','to_uId')) 
	 function message_time_update($time, $msg_info_arr)
	 {
		$update_data = array('time'=>$time);
		foreach($msg_info_arr as $item)
		{
			$this->_message_column_update($update_data,$item);
		}
	 }
     
     //update the column value of the specified column where message id
     //in the message id array
     //input: @update_data -- array('key','value'),@msg_info_arr -- array('message_id','from_uId','to_uId')
     function _message_column_update($update_data,$msg_info_arr)
     {
     	if(!empty($msg_info_arr))
		{
           $this->db->where($msg_info_arr);
           $this->db->set($update_data);
           $this->db->update('message_manage');
		}
     }

	 //check if there is an message record from @from_uId to @to_uId
     //input: array('message_id','from_uId','to_uId')
     function is_message_record_exist($data)
     {
	 	$this->db->select('mm_id');
     	$this->db->where($data);
		$query = $this->db->get('message_manage');
		if($query->num_rows() > 0)
		{
			//exist
			return TRUE;
		}
		else
		{
			//not exist
			return FALSE;
		}
     }
     
     
     //insert message reocrd to db
     //input: array('message_id','from_uId','to_uId','time','title','is_read')
     function message_record_insert($data)
     {
     	$this->db->set($data);
		$this->db->insert('message_manage');
     }
     
     
     //process the replied message data
     //input: array('message_id','from_uId','to_uId','content','title','time','stId','sendPlace')
     function message_reply($data)
     {
     	 $msg_info_arr = array('message_id'=>$data['message_id'],'from_uId'=>$data['from_uId'],'to_uId'=>$data['to_uId']);
         if(!$this->is_message_record_exist($msg_info_arr))
         {
         	$m_record_data = $msg_info_arr;
         	$m_record_data['time'] = $data['time'];
			$m_record_data['is_read'] = UN_READ;
			$m_record_data['title'] = $data['title'];
         	$this->message_record_insert($m_record_data);
         }
         
         $source_data = $data;
		 unset($source_data['title']);
         $this->message_source_store($source_data);	
         
         //read stat update
         $this->message_stat_update(UN_READ, array($msg_info_arr));
         //time update
         $this->message_time_update($data['time'], array($msg_info_arr));
     }
	 
	 //store message source
	 //input: array('message_id','from_uId','to_uId','content','time','stId','sendPlace')
	 //table--'message_data'
	 function message_source_store($data)
	 {
	 	$this->db->set($data);
		$this->db->insert('message_data');
	 }
	 
	 
	 //store new message data
	 //input: array('from_uId','to_uId','title','content')
	 function new_message_store($data)
	 {
	 	$time = time();
		$message_id = $time.'_'.$data['from_uId'].'_'.$data['to_uId'];
		$data['message_id'] = $message_id;
		$data['time'] = date("Y-m-d H:i:s", $time);
		
	 	$message_record = $data;
		unset($message_record['content']);
		$message_record['is_read'] = 0;
		$this->message_record_insert($message_record);
		
		$message_source = $data;
		unset($message_source['title']);
		$message_source['stId'] = ONLINE;
		$message_source['sendPlace'] = '';
		$this->message_source_store($message_source);
		
		return $message_id;
	 }
	 
	 //get user's messages
	 //input: array('uId','sort_attr','sort_type','range')
	 function get_user_messages($data)
	 {
	 	$sort_type = ($data['sort_type'] == 0) ? 'desc' : 'asc';
		$range = $data['range'];
	 	$this->db->select('message_id,from_uId,time,is_read,title,user.username');
		$this->db->where('to_uId',$data['uId']);
		$this->db->join('user','user.uId = message_manage.from_uId');
		if($data['sort_attr'] == 'time')
		{
			$this->db->order_by('time',$sort_type);
		}
		else
		{			
			$this->db->order_by('user.username',$sort_type);
		}
		if(!empty($range))
		{
			$this->db->limit($range['end']-$range['start']+1,$range['start']);
		}
		$query = $this->db->get('message_manage');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				array_push($result,$row);
			}
		}
		return $result;
	 }

	  function get_related_messages($data)
	 {
	 	$sort_type = ($data['sort_type'] == 0) ? 'desc' : 'asc';
	 	$this->db->select('md_Id,message_id,from_uId,time,content,user.username');
		$this->db->where('to_uId',$data['uId']);
		$this->db->where('related_id',$data['related_id']);
		$this->db->where('p_md_Id',$data['p_md_Id']);
		$this->db->join('user','user.uId = message_data.from_uId');
		if($data['sort_attr'] == 'time')
		{
			$this->db->order_by('time',$sort_type);
		}
		else
		{			
			$this->db->order_by('user.username',$sort_type);
		}
		$query = $this->db->get('message_data');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				array_push($result,$row);
			}
		}
		return $result;
	 }
	 
	 //get number of messages for a user
	 //input: user_id
	 //table--'message_manage'
	 function get_inbox_msg_num($uId)
	 {
	 	$this->db->select('mm_Id');
		$this->db->where('to_uId',$uId);
		$query = $this->db->get('message_manage');
		return $query->num_rows();
	 }
	 
	 //load message data
	 //input: message_id
	 //output: array(array('content','time','sendPlace','stId','from_uId','to_uId'))
	 //table--'message_data'
	 function load_message_data($message_id)
	 {
	 	$this->db->select('content,time,sendPlace,stId,from_uId,to_uId');
		$this->db->order_by('time','asc');
		$this->db->where('message_id',$message_id);
		$query = $this->db->get('message_data');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				array_push($result,$row);
			}
		}
		return $result;
	 }
	 
	 //load message manage data
	 //input: array('message_id','to_uId')
	 //output: array('title','from_uId','to_uId','is_read')
	 //table--'message_manage'
	 function load_message_manage_data($data)
	 {
	 	$this->db->select('title,from_uId,to_uId,is_read');
		$this->db->where($data);
		$query = $this->db->get('message_manage');
		if($query->num_rows() > 0)
		{
			$data = $query->row_array();
			return $data;
		}
		return array();
	 }
	 
	//generate invite answer messages to friends
	//input: array('f_uId_str','nId','uId','q_text')
	function invite_answer_message($data)
	{
		$uId_arr = array_unique(explode(',',$data['f_uId_str']));
		$username = $this->User_data->get_username(array('uId'=>$data['uId']));
		
		$send_data = array('uId'=>$data['uId'],'username'=>$username,'f_uId_arr'=>$uId_arr,'nId'=>$data['nId'],'q_text'=>$data['q_text']);
		$this->invite_answer_message_send($send_data);
	}
	
	//send invite answer messages to friends
	//input:array('uId','username','f_uId_arr','nId','q_text')
	function invite_answer_message_send($data)
	{
		$message_data = $this->invite_answer_message_data();
		$base = $this->config->item('base_url');
		$q_link = $base.'question/'.$data['nId'];
		foreach($data['f_uId_arr'] as $f_uId)
		{
			$send_data = array('title'=>$message_data['subject']);
			$f_username = $this->User_data->get_username(array('uId'=>$f_uId));
			$send_data['from_uId'] = 0;// system admin
			$send_data['to_uId'] = $f_uId;
			$send_data['time'] = date("Y-m-d H:i:s", time());
			$send_data['message_id'] = time().'_0_'.$f_uId;
			$send_data['is_read'] = 0;
			$this->message_record_insert($send_data);
			
			$send_data['content'] = sprintf($message_data['content'],$f_username,$data['username'],$q_link,$data['q_text']);
			$send_data['stId'] = ONLINE;
			$send_data['sendPlace'] = '';
			unset($send_data['title']);
			unset($send_data['is_read']);
			$this->message_source_store($send_data);
		}
	}
	
	//get message format for inviting answer
	function invite_answer_message_data()
	{
		$lang = $this->Ip_location->get_language();
		$this->lang->load('messages',$lang);
		$subject = $this->lang->line('invite_answer_msg_subject');
		$content = $this->lang->line('invite_answer_msg_content');
		return array('subject'=>$subject,'content'=>$content);
	}
	
	//get user's number unread messages
	//input: user id
	//table--'message_manage'
	function get_unread_msg_num($uId)
	{
		$this->db->select('mm_Id');
		$this->db->where('to_uId',$uId);
		$this->db->where('is_read',UN_READ);
		$query = $this->db->get('message_manage');
		return $query->num_rows();
	}
  }
  
  
  