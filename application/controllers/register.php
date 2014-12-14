<?php
  class Register extends CI_Controller
  {
    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('kpc_define');

		 $this->load->database();
		 $this->load->library('session');
		 $this->load->model('q2a/User_activity');
		 $this->load->model('q2a/Auth');
		 $this->load->library('account_format_check');

                 $this->load->model('q2a/User_profile');
		 $this->load->model('q2a/Right_nav_data');
		 $this->load->model('q2a/Invite_data_process');
         $this->load->model('q2a/Load_common_label');
		 $this->load->model('q2a/Friend_manage');
		 $this->load->model('q2a/Kpc_manage');
         $this->load->model('q2a/Ip_location');
         $this->load->model('q2a/User_privacy');
	 }

	function index($email='',$invite_code='')
	{
       if($this->register_check())
	   {
	      $data= array('username'=> $_POST['username'],'email'=> $_POST['email'],'passwd'=> $_POST['password'],'qq'=> $_POST['qq'],'weibo'=> $_POST['weibo']);
	      $user_id = $this->register_process($data);
		  //login data store in session
		  $newdata = array('status' => 'LOGIN','uId'=> $user_id,'site'=>'WebSite');
		  $this->session->set_userdata($newdata);

		  $base = $this->config->item('base_url');
		  redirect($base);
	   }
		else
		{
			$data['email'] = $email;
			$data['invite_code'] = $invite_code;
			$data['base'] = $this->config->item('base_url');
		    $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id="");
            $language = $this->Ip_location->get_language();
            $label = $this->load_label($language);
		    $data = array_merge($right_data,$data,$label);
			$this->load->view('q2a/register',$data);
		}
	}

	//check user register data
	//$_POST = array('username','email','passwd');
	function register_check($data=array())
	{
	    $this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');

        $lang = $this->Ip_location->get_language();
        $this->lang->load('register',$lang);

	    $this->form_validation->set_rules('username', 'lang:username', 'required|callback_username_exist_check|callback_username_valid_check|callback_username_length_check');
	    $this->form_validation->set_rules('password', 'lang:password', 'required|callback_pswd_length_check');
	    $this->form_validation->set_rules('passwordc', 'lang:password_confirmation', 'required|callback_passwd_check');
	    $this->form_validation->set_rules('email', 'lang:email', 'required|callback_email_valid_check|callback_email_used_check');
	    //$this->form_validation->set_rules('invite_code', 'lang:invite_code', 'required|callback_invite_code_check');

		return $this->form_validation->run();
	}

	/**************************form data check*****************************/
	//check if username is duplicated from database
	function username_exist_check($username)
	{
		  if(!$this->User_activity->username_used_check($username))
		  {
			  return true;
		  }
		  else
		  {
			 return false;
		  }
	}

    //check if username is valid
    function username_valid_check($username)
    {
        if($this->account_format_check->valid_username_check($username))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function username_length_check($username)
    {
        if($this->account_format_check->username_length_check($username))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //check if the length of password is not less than 6
    function pswd_length_check($password)
    {
        if($this->account_format_check->valid_password($password))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	//check if password confirm same with password, and both of them are not empty
	function passwd_check($passwd_conf)
	{
	   //todo:
	   $passwd_conf = trim($passwd_conf);
	   $passwd = trim($_POST['password']);

	   if($passwd_conf == $passwd)
	   {
	     return true;
	   }
	   else
	   {
		  return false;
	   }
	}

	//check if the string is a valid email string, and whether the email has been used
	function email_valid_check($email)
	{
	   //todo:
	   $this->load->helper('email');

	   if(valid_email($email))
	   {
		   return true;
		}
		else
		{
			 return false;
		}
	}

    //check if the email has been used
    function email_used_check($email)
    {
        $this->load->helper('email');
        if($this->User_activity->account_used_check(array('account'=>$email, 'stId'=>EMAIL,'uId'=>'')))
		{
		    return true;
		}
		else
		{
			return false;
		}
    }

	//
	function invite_code_check()
	{
	   $invite_code = trim($_POST['invite_code']);
	   $email = trim($_POST['email']);
	   if(!$this->Invite_data_process->invite_data_certification(array('account'=>$email,'invite_code'=>$invite_code)))
	   {
          return false;
	   }
       return true;
	}

	/********************************************************************************/

	//$data= array('username','email','passwd');
    function register_process($data)
	 {
		$uId = $this->User_activity->user_register_process($data);

		//user sendtype data init
		$this->User_profile->user_account_insert(array('uId'=> $uId, 'account'=> $data['email'],'stId'=> EMAIL, 'is_visible'=>ACCOUNT_PUBLIC));
		$this->User_profile->user_sendtype_insert(array('stId'=>EMAIL, 'uId'=>$uId));
		$this->User_profile->user_rss_insert(array('rcv_rss'=> 1, 'uId'=>$uId));

		//process the friendship between register user and the user who send the invite email
		$send_invite_uId = $this->Invite_data_process->get_invite_user_id(array('account'=>$data['email']));
		$this->Invite_data_process->invite_data_delete(array('account'=>$data['email']));
		$this->Friend_manage->add_as_freind_process($uId,array($send_invite_uId));

		//init user's kpc data
		$this->Kpc_manage->kpc_init_process(array('uId'=>$uId));
		$this->Kpc_manage->kpc_update_process(array('uId'=>$send_invite_uId,'kpc_value'=>KPC_VALUE_INVITE_FINISHED,'kpc_type'=>KPC_TYPE_INVITE_FINISHED));

        //init user's privacy setting
        $this->User_privacy->init_user_privacy(array('uId'=>$uId,'visible'=>1));

		return $uId;
	 }

     function load_label($lang)
     {
         $register_label = $this->load_register_label($lang);
         $common_label = $this->Load_common_label->load_common_label($lang);
         $result = array_merge($register_label,$common_label);
         return $result;
     }

     function load_register_label($lang)
     {
         $this->lang->load('register',$lang);
         $data['register_page_title'] = $this->lang->line('register_page_title');
         $data['register_title'] = $this->lang->line('register_title');
         $data['register_username'] = $this->lang->line('register_username');
         $data['register_email'] = $this->lang->line('register_email');
         $data['register_password'] = $this->lang->line('register_password');
         $data['register_confirm_password'] = $this->lang->line('register_confirm_password');
         $data['register_invite_code'] = $this->lang->line('register_invite_code');
         $data['register_register_button'] = $this->lang->line('register_register_button');
		 $data['register_reset_button'] = $this->lang->line('register_reset_button');
         $data['register_username_suggestion'] = $this->lang->line('register_username_suggestion');
         $data['register_password_suggestion'] = $this->lang->line('register_password_suggestion');
		 
		 $data['register_username_holder'] = $this->lang->line('register_username_holder');
         $data['register_password_holder'] = $this->lang->line('register_password_holder');
		 $data['register_confirm_holder'] = $this->lang->line('register_confirm_holder');
         $data['register_email_holder'] = $this->lang->line('register_email_holder');
         $data['register_code_holder'] = $this->lang->line('register_code_holder');
		 
		 $data['register_intro_text'] = $this->lang->line('register_intro_text');
         return $data;
     }
 }

 /*End of file*/
  /*Location: ./system/appllication/controller/register.php*/
