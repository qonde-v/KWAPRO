<?php
  class Demand_management extends CI_Model
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
	     
     //delete demand item by demand id
	 //input: array of array('id','uId')
	 function demand_delete($data)
	 {
	    foreach($data as $item)
	    {
	    	$this->db->delete('demand', $item);
	    }
	 }
	 
     
     
     //insert demand reocrd to db
     //input: array('uId','title',....)
     function demand_record_insert($data)
     {
     	$this->db->set($data);
		$this->db->insert('demand');
     }
     
	 
	 //get user's messages
	 //input: array('uId','sort_attr','sort_type','range')
	 
	 //get number of demands for a user
	 //input: user_id
	 //table--'demand'
	 function get_inbox_num($uId)
	 {
	 	$this->db->select('id');
		$this->db->where('uId',$uId);
		$query = $this->db->get('demand');
		return $query->num_rows();
	 }
	 
	 //load message data
	 //input: message_id
	 //table--'demand'
	 function get_similar_data($condition)
	 {
	 	$this->db->select('*');
		$this->db->where($condition);
		$this->db->limit(1,0);
		$query = $this->db->get('demand');
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

	//get user's demands
	 //input: $id
	 function get_user_demand($id)
	 {
	 	$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('demand');
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

  }
  
  
  