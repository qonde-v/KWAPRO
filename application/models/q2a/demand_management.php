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
		return $this->db->insert_id();
     }

	 //insert information reocrd to db
     function information_record_insert($data)
     {
     	$this->db->set($data);
		$this->db->insert('information');
     }
     
     //insert design reocrd to db
     //input: array('uId','title',....)
     function design_record_insert($data)
     {
     	$this->db->set($data);
		$this->db->insert('design');
		return $this->db->insert_id();
     }
	 //insert order reocrd to db
     //input: array('uId','username',....)
     function order_record_insert($data)
     {
     	$this->db->set($data);
		$this->db->insert('orders');
     }
	 
	 function designpic_record_insert($data)
     {
		$this->db->set($data);
		$this->db->insert('design_pic');
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
	 
	 //table--'demand'
	 function get_similar_data($map)
	 {
		$condition =  'strength between '.($map['strength']-0.1).' and '.($map['strength']+0.1);
		$condition .=  ' and sporttime between '.($map['sporttime']-0.1).' and '.($map['sporttime']+0.1);
		$condition .=  ' and temperature between '.($map['temperature']-1).' and '.($map['temperature']+1);
		$condition .=  ' and humidity between '.($map['humidity']-1).' and '.($map['humidity']+1);
		$condition .=  ' and proficiency between '.($map['proficiency']-1).' and '.($map['proficiency']+1);
		$condition .=  ' and age between '.($map['age']-1).' and '.($map['age']+1);
		$condition .=  ' and weight between '.($map['weight']-1).' and '.($map['weight']+1);
		$condition .=  ' and id <> '.$map['id'];
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


	  //table--'design_pic'
	 function get_similar_design($map)
	 {
		$condition =  'strength between '.($map['strength']-0.1).' and '.($map['strength']+0.1);
		$condition .=  ' and sporttime between '.($map['sporttime']-0.1).' and '.($map['sporttime']+0.1);
		$condition .=  ' and temperature between '.($map['temperature']-1).' and '.($map['temperature']+1);
		$condition .=  ' and humidity between '.($map['humidity']-1).' and '.($map['humidity']+1);
		$condition .=  ' and proficiency between '.($map['proficiency']-1).' and '.($map['proficiency']+1);
		$condition .=  ' and age between '.($map['age']-1).' and '.($map['age']+1);
		$condition .=  ' and weight between '.($map['weight']-1).' and '.($map['weight']+1);
	 	$this->db->select('design.id,design.design_pic');
		$this->db->from('demand');
		$this->db->join('design','design.demand_id=demand.id');
		$this->db->where($condition);
		$this->db->limit(6);
		$query = $this->db->get();
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

	 //get user's design
	 //input: $id
	 function get_user_design($id)
	 {
	 	$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('design');
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


	 //get user's fabric
	 //input: $id
	 function get_fabric($id)
	 {
	 	$this->db->select('*');
		$this->db->where('id',$id);
		$query = $this->db->get('fabrics');
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

     function update_designnum($demand_id)
     {
     	//if(!empty($demand_id))
		//{
           $this->db->where('id',$demand_id);
           $this->db->set('designnum', 'designnum+1', FALSE);
           $this->db->update('demand');
		//}
     }

	 function update_messnum($id,$type)
     {
     	//if(!empty($demand_id))
		//{
           $this->db->where('id',$id);
           $this->db->set('messnum', 'messnum+1', FALSE);
		   if($type==1){
			   $this->db->update('demand');
		   }else{
			   $this->db->update('design');
		   }
		//}
     }
		
	 //update viewnum
	 function update_viewnum($id,$type)
     {
     	//if(!empty($demand_id))
		//{
           $this->db->where('id',$id);
           $this->db->set('viewnum', 'viewnum+1', FALSE);
		   if($type==1){
			   $this->db->update('demand');
		   }else{
			   $this->db->update('design');
		   }
		//}
     }

	 function update_status($demand_id,$status)
     {
           $this->db->where('id',$demand_id);
           $this->db->set('status', $status);
           $this->db->update('demand');
     }

	 function update_designstatus($design_id,$status)
     {
           $this->db->where('id',$design_id);
           $this->db->set('status', $status);
           $this->db->update('design');
     }


	 
	//check if title of demand exist or not
	function demand_title_exist($title)
	{
		$this->db->select('title');
		$this->db->where('title',$title);
		$query = $this->db->get('demand');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	//check if title of design exist or not
	function design_title_exist($title)
	{
		$this->db->select('title');
		$this->db->where('title',$title);
		$query = $this->db->get('design');
		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

  }
  
  
  