<?php
  class Invite_data_process extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->library('encrypt');
		$this->load->database();
        $this->load->model('q2a/Ip_location');
	 }

	 //
	 function generate_invite_code()
	 {
	    $code = FLOOR((RAND()%2147483647));
		// echo $code."<br>";
	    return md5($code);
	 }

	 //
	 function decode_invite_code($encrypt_code)
	 {
	    return $this->encrypt->decode($encrypt_code);
	 }

	 //create invite code data for the invition
	 //input: array('account','user_id')
	 function create_invite_data($data)
	 {
	    $invite_code = $this->generate_invite_code();
	    $this->invite_code_save(array('account'=>$data['account'], 'invite_code'=>$invite_code,'user_id'=>$data['user_id']));
		return $invite_code;
	 }

	 //input: array('account','invite_code','user_id')
	 function invite_code_save($data)
	 {
	    if(!$this->is_account_exist($data['account']))
		{
		  $this->db->insert('invite_code_data',$data);
		}
		else
		{
		  $this->invite_account_update($data);
		}
	 }

	 //input: array('account','invite_code')
	 function invite_account_update($data)
	 {
		$sql = "UPDATE invite_code_data SET invite_code = '{$data['invite_code']}' WHERE account = '{$data['account']}'";
		$this->db->query($sql);
	 }

	 //check if invite code has been sent to the account
	 function is_account_exist($account)
	 {
	    $sql = "SELECT invite_id FROM invite_code_data WHERE account = '{$account}'";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
		    return TRUE;
		}
		return FALSE;
	 }

	 //check the valid of invite code with the account
	 //input: array('account','invite_code')
	 function invite_data_certification($data)
	 {
	    return $this->invite_data_check($data);
	 }

	 //
	 function invite_data_check($data)
	 {
	     $sql = "SELECT invite_id FROM invite_code_data WHERE account= '{$data['account']}' AND invite_code = '{$data['invite_code']}'";
		 $query = $this->db->query($sql);

		 if($query->num_rows() > 0)
		 {
		    return TRUE;
		 }
		 return FALSE;
	 }

	 //input: array('account')
	 function get_invite_user_id($data)
	 {
	    $sql = "SELECT user_id FROM invite_code_data WHERE account = '{$data['account']}'";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
		    foreach($query->result() as $row)
            {
                return $row->user_id;
            }
		}
		return 0;
	 }

	 //input: array('account')
	 function invite_data_delete($data)
	 {
	     $sql = "DELETE FROM invite_code_data WHERE account= '{$data['account']}'";
	     $this->db->query($sql);
	 }

	 //create invite email data: subject and email body text
	 //input: array('invite_code','username','url','account')
	 //output: array('subject','text')
	 function generate_invite_email($data)
	 {
        $lang_data = $this->load_lang_data();
	    $subject = $lang_data['friends_email_subject'];
        //$text = "hello, your friend ".$data['username']." invite you to join in kwapro,the following is your invite code:\n ".$data['invite_code']." \n Welcome to be a kwapro-er by visiting ".$data['url'];
		$text = sprintf($lang_data['friends_email_text'],$data['username'],$data['url'],$data['account'],$data['invite_code'],$data['url'],$data['account'],$data['invite_code'],$data['username'],$data['url'],$data['account'],$data['invite_code'],$data['url'],$data['account'],$data['invite_code']);
        $label = array('subject'=>$subject, 'text'=>$text);
		return $label;
	 }

 /*    function load_lang_data()
     {
        //$lang = $this->Ip_location->get_language();
        $this->lang->load('friends','chinese');

        $data['friends_email_subject'] = $this->lang->line('friends_email_subject');
        $data['friends_email_text'] = $this->lang->line('friends_email_text');
		
		$this->lang->load('friends','english');
		$data['friends_email_subject'] .= ' '.$this->lang->line('friends_email_subject');
		$data['friends_email_text'] .= ' '.$this->lang->line('friends_email_text');
        return $data;
     }*/
     
     function load_lang_data()
     {
     	//$zh_data = $this->load_lang_data_langCode('chinese');
     	//$en_data = $this->load_lang_data_langCode('english');
     	
     	$subject = "Kwapro注册邀请".'('."Kwapro register invite".')';
     	$text = "您好，<br/><br/>您的朋友 %s 邀请您到Kwapro.com来，和我们一起进行一段求索和传播的航程，在途中我们将帮助彼此寻求答案，碰撞新的观念，并充满乐趣。<br/><br/>点击以下链接进行注册:<a href=\"%sindex/%s/%s\">%sindex/%s/%s</a><br/><br/>感谢并欢迎您的到来。<br/><br/>夸普小组。".'<br/>('."Hi,<br/><br/>Your friend %s invites you to meet us at kwapro.com<http://kwapro.com>, where we help each other to find answers, discover new ideas and have fun. It’s a journey of chasing and disseminating.<br/><br/>To register an kwapro account, please visit <a href=\"%sindex/%s/%s\">%sindex/%s/%s</a><br/><br/>Thank you and welcome.<br/><br/>The Kwapro team.".')';
     	return array('friends_email_subject'=>$subject,'friends_email_text'=>$text);
     }
     
     //
     function load_lang_data_langCode($language)
     {
     	$this->lang->load('friends',$language);
     	$data = array();
        $data['friends_email_subject'] = $this->lang->line('friends_email_subject');
        $data['friends_email_text'] = $this->lang->line('friends_email_text');
        return $data;
     }

  }//END OF CLASS

