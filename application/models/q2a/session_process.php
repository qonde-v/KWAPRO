<?php
  class Session_process extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->library('session');
	 }

	 //get all online user
	 //return uId of all online user
	 function session_online_user_id()
	 {
	    $sql = "SELECT user_id FROM ci_sessions WHERE user_id != 0";
	    $query = $this->db->query($sql);
	    $data = array();

	    if($query->num_rows > 0)
	    {
	        foreach($query->result() as $row)
            {
				array_push($data,$row->user_id);
            }
	    }
		return $data;
	 }

	 //
	 function session_activitytime_check()
	 {
		 $this->session->_sess_gc();
	 }

	 //get user session data
	 function session_userdata($session_id)
	 {
	    $sql = "SELECT user_data FROM ci_sessions WHERE session_id = '{$session_id}'";
	    $query = $this->db->query($sql);

	    if($query->num_rows > 0)
	    {
	        foreach($query->result() as $row)
            {
				  return $this->session->_unserialize($row->user_data);
            }
	    }
		else
		{
		  return array();
		}
	 }

     //check if the session data of a user Id exist
	 //input: user id
	 //return true if not ever login, otherwise return false
	 function session_data_exist($user_id)
	 {

		$this->db->select('user_id');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get('ci_sessions');

	    if($query->num_rows > 0)
	    {
	       return FALSE;
	    }
		else
		{
		   return TRUE;
		}
	 }

     //clear the online state of a user
     //input: user Id
     //table--'ci_sessions'
     function user_online_clear($uId)
     {
        $this->db->where('user_id',$uId);
        //$this->db->set('user_id',0);
        $this->db->delete('ci_sessions');
     }

  }//class

  /*End of file*/
  /*Location: ./system/appllication/model/session_process.php*/