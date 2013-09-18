<?php
  class User_activity extends CI_Model
  {
	function __construct()
	 {
	    parent::__construct();
        $this->load->helper('define');
	 }


	  //user password check
     //$data = array('uId','passwd')
	  //return true,otherwise return false
     //'table'--user
     function password_check($data)
	  {
	      //todo:
		 $this->db->select('username');
        $this->db->where('uId',$data['uId']);
        $this->db->where('passwd',MD5($data['passwd']));
        $query = $this->db->get('user');

		 if($query->num_rows() > 0)
        {
             return TRUE;
        }
        else
        {
        //condition dosenot match
             return FALSE;
        }
	  }

	 //user login check
    //$data = array('username','passwd')
	 //return uId if condition match,otherwise return empty string
     //'table'--user
	 function login_check($data)
	 {
	    //todo:
		 $this->db->select('uId');
        $this->db->where('username',$data['username']);
        $this->db->where('passwd',MD5($data['passwd']));
        $query = $this->db->get('user');
        if($query->num_rows() > 0)
        {
        //condition match
            foreach($query->result() as $row)
            {
                return $row->uId;
            }
        }
        else
        {
        //condition dosenot match
            return '';
        }
    }


	 //$data = array('username','email','passwd');
	 //'table'--user
	 function user_register_process($data)
	 {
	 	$data['permission'] = 0;
	    $data['passwd'] = MD5($data['passwd']);
	    $this->db->insert('user',$data);
		 return $this->db->insert_id();
	 }

	 //$data = array('uId','time','place','type');
	 //'table'--useronline
	 function user_online_process($data)
	 {
	 		$this->db->insert('useronline',$data);
	 }

	 //$data = array('uId')
	 //'table'--useronline
	 function user_offline_process($data)
	 {
	    $this->db->delete('useronline',array('uId' => $data['uId']));
	 }

	 //$data = array('uid','nid');
	 function user_follow_process($data)
	 {
	    //todo:

	 }

	 //$data = array('uid','type');
	 function user_kpc_process($data)
	 {
	    //todo:

	 }


	 //$data = array('from_uid','to_uid','msg');
	 function user_sendmessage_process($data)
	 {
	    //todo:

	 }

	 //check if username has been used
	 //'table'--user
	 function username_used_check($username="")
	 {
	    $this->db->select('username');
	    $this->db->where('username',$username);
	    $query = $this->db->get('user');
	    if($query->num_rows() > 0)
	    {
	    	return TRUE;
	    }
	    else
		{
	    	return FALSE;
		}
	 }

	 //check if account has been used
	 //'table'--useraccount
	 //input:array('account','stId','uId')
	 //return true if not used,otherwise return false
	 function account_used_check($data)
	 {
	   $is_used = FALSE;
	   switch($data['stId'])
		{
		   case QQ:
		   case SMS:
                $is_used = $this->digital_account_used_check($data);
                break;
		   case EMAIL:
		   case GTALK:
		   case MSN:
                $is_used = $this->email_account_used_check($data);
                break;
			default:
			      break;
		}
		return $is_used ? FALSE : TRUE;
	 }

	 //input:array('account','stId','uId')
     function digital_account_used_check($data)
     {
        $this->db->select('uaId');
        $this->db->where('account',$data['account']);
        $this->db->where('stId',$data['stId']);
        $this->db->where('uId != ',$data['uId']);
        $query = $this->db->get('useraccount');

		if($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
     }

	 //input:array('account','stId','uId')
     function email_account_used_check($data)
     {
        $this->db->select('uaId');
        $this->db->where('account',$data['account']);
        $this->db->where('uId != ',$data['uId']);
        $query = $this->db->get('useraccount');

		if($query->num_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
     }

	 //uodate user's actvity content numnber: asked, answered and followed question number
	 //input:array('uId','ntId')
	 function user_activity_content_update($data)
	 {
	    //todo:
		if($this->user_activity_exist($data))
		{
		   $this->user_activity_update($data);
		}
		else
		{
		   $this->user_activity_insert($data);
		}
	 }

	 //
	 function user_activity_exist($data)
	 {
	    $sql = "SELECT num FROM useractivity WHERE uId = {$data['uId']} AND ntId = {$data['ntId']}";
		$query = $this->db->query($sql);

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
	 function user_activity_update($data)
	 {
	    $sql = "UPDATE useractivity SET num = num+1 WHERE uId = {$data['uId']} AND ntId = {$data['ntId']}";
		$this->db->query($sql);
	 }

	 //
	 function user_activity_insert($data)
	 {
	    $data['num'] = 1;
		$this->db->insert('useractivity',$data);
	 }
}
  /*End of file*/
  /*Location: ./system/appllication/model/q2a/user_activity.php*/
