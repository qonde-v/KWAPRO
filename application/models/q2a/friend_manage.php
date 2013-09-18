<?php
  class Friend_manage extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
        $this->load->helper('define');
		$this->load->helper('friend');
        $this->load->helper('prompt');
        $this->load->model('q2a/User_data');
        $this->load->model('q2a/Check_process');
        $this->load->model('q2a/Friend_invite');

	 }

	 //input: array of array(f_uid,error_code)
	 function error_print($data)
	 {
	    $error_string = "";
	    foreach($data as $item)
		{
		   list($f_uid,$code) = $item;
           $user_name = $this->User_data->get_username(array('uId'=> $f_uid));
           $msg = $this->Check_process->get_prompt_msg(array('pre'=>'friend','code'=> ALREADY_ADDED ));
		   $error_string .= $user_name." ".$msg."<br/>";
		}
		return $error_string;
	 }


     //add user as friend
	 //input: user_id--current user, friend_candidates-- array of user id to be friend
	 function add_as_freind_process($user_id,$friend_candidates)
	 {
		$msg_arr = array();
		if(count($friend_candidates))
		{
		   foreach($friend_candidates as $friend_user_id)
		   {
		       $code = $this->user_be_friend($user_id,$friend_user_id);

			   if($code != SUCCESS)
			   {
			      array_push($msg_arr,array($friend_user_id,$code));
			   }
		   }
		}
		return $msg_arr;
	 }

	 //to be friend relationship between two users
	 function user_be_friend($user_id,$friend_user_id)
	 {
	    if($this->user_be_friend_check($user_id,$friend_user_id))
		{
		   $this->db->insert('user_friends',array('uId'=>$user_id,'friend_uId'=>$friend_user_id));
		   $this->db->insert('user_friends',array('uId'=>$friend_user_id,'friend_uId'=>$user_id));
		   return SUCCESS;
		}
		else
		{
		   return FRIENDSHIP_EXIST;
		}
	 }

	 //check if it is valid to be friendship
	 function user_be_friend_check($user_id,$friend_user_id)
	 {
	    $data = array('uId'=>$user_id, 'friend_uId'=>$friend_user_id);
	    $bool1 = $this->is_friendship_exist($data);
		$data = array('uId'=>$friend_user_id, 'friend_uId'=>$user_id);
		$bool2 = $this->is_friendship_exist($data);

		return  !($bool1||$bool2);
	 }

	 //check if friendship between the two uids of user exist.
	 //input: array('uId','friend_uId')
	 function is_friendship_exist($data)
	 {
	    $this->db->select('ufId');
	    $this->db->where($data);
	    $query = $this->db->get('user_friends');

		if($query->num_rows() > 0)
	    {
		   return TRUE;
		}
		else
		{
		   return FALSE;
		}
	 }
	 
	 
	 //
	 function friend_request_update($user_id,$friend_candidates)
	 {
	 	$msg_arr = array();
		if(count($friend_candidates))
		{
		   foreach($friend_candidates as $friend_user_id)
		   {
		       $bool = $this->user_be_friend_check($user_id,$friend_user_id);
               $code = $bool ? SUCCESS : FRIENDSHIP_EXIST;
			   
			   if($code != SUCCESS)
			   {
			      array_push($msg_arr,array($friend_user_id,$code));
			   }
			   else
			   {
			   		$data = array('from_uId'=>$user_id,'to_uId'=>$friend_user_id);
			   		if(!$this->Friend_invite->invite_exist_check($data))
			   	 	{
			   	 		$this->Friend_invite->invite_node_insert(array('from_uId'=>$user_id,'to_uId'=>$friend_user_id));
			   	 	}
			   }
		   }
		}
		return $msg_arr;

	 }
	 

  }//END OF CLASS

/*End of file*/
/*Location: ./system/appllication/model/q2a/friend_manage.php*/

