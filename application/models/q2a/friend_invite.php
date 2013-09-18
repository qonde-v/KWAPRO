<?php
  class Friend_invite extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
        $this->load->helper('define');
		$this->load->model('q2a/User_data');
	 }
	 
	 
	 //get friend inviting requests for a user not including the out-date requests
	 //input:$data = array('uId'=>,'time'=>array('day'=>,'hour'=>,'minute'=>,'second'=>))
	 //requests for that user earlier than $data['time'] will be deleted
	 //table--'friends_invite'
	 //return array of uId
	 function get_invite_request($data)
	 {
		 $now = time();
		 
		 $time = $data['time'];
		 //compute the number of seconds
		 $diff_time = (($time['day']*24 + $time['hour']) * 60 + $time['minute']) * 60 + $time['second'];

		 $this->db->select('from_uId,UNIX_TIMESTAMP(time)');
		 $this->db->where('to_uId',$data['uId']);
		 $query = $this->db->get('friends_invite');
		 
		 $result = array();
		 if($query->num_rows() > 0)
		 {
			 foreach($query->result_array() as $row)
			 {
				 if($now - $row['UNIX_TIMESTAMP(time)'] < $diff_time)
				 {//the record is not out-date, get it
					 array_push($result,$row['from_uId']);
				 }
				 else
				 {//the record is out-date, delete it
					 $del_node = array('from_uId'=>$row['from_uId'],'to_uId'=>$data['uId']);
					 $this->invite_node_delete($del_node);
				 }
			 }
		 }
		 return $result;
	 }
	 
	 //delete a friend inviting record
	 //input:$data=array('from_uId'=>,'to_uId'=>)
	 //table--'friends_invite'
	 function invite_node_delete($data)
	 {
		 $this->db->where('from_uId',$data['from_uId']);
		 $this->db->where('to_uId',$data['to_uId']);
		 $this->db->delete('friends_invite');
	 }
	 
	 //batch delete friend inviting records
	 //input:$data=array('from_uId'=>array of user id ,'to_uId'=>)
	 //table--'friends_invite'
	 function batch_delete_invite_request($data)
	 {
	 	 $this->db->where_in('from_uId',$data['from_uId']);
		 $this->db->where('to_uId',$data['to_uId']);
		 $this->db->delete('friends_invite');
	 }
	 
	 
	 //check if a record of friend inviting exist
	 //input:$data=array('from_uId'=>,'to_uId'=>)
	 //table--'friends_invite'
	 function invite_exist_check($data)
	 {
		 $this->db->select('fiId');
		 $this->db->where('from_uId',$data['from_uId']);
		 $this->db->where('to_uId',$data['to_uId']);
		 $query = $this->db->get('friends_invite');
		 if($query->num_rows() > 0)
		 {//exist
			 return true;
		 }
		 else
		 {
			 return false;
		 }
	 }
	 
	 //insert a record of friend inviting
	 //input:$data=array('from_uId'=>,'to_uId'=>)
	 //table--'friends_invite'
	 function invite_node_insert($data)
	 {
		 $this->db->set('from_uId',$data['from_uId']);
		 $this->db->set('to_uId',$data['to_uId']);
		 $time = time();
		 $this->db->set('time',date('Y-m-d H:i:s',$time));
		 $this->db->insert('friends_invite');
	 }
 }
