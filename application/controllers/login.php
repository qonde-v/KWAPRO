<?php
  class Login extends CI_Controller
  {

   var $base = '';
	function __construct()
	 {
	     parent::__construct();
		 $this->load->helper('url');
		 $this->load->database();
		 $this->load->library('session');
		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/User_activity');
		 $this->load->model('q2a/Right_nav_data');
         $this->load->model('q2a/Load_common_label');
		 $this->load->model('q2a/Ip_location');
         $this->load->model('q2a/Check_process');
         $this->load->model('q2a/Session_process');
	 }

	function index()
	{
	    $base = $this->config->item('base_url');
        $language = $this->Ip_location->get_language();
	    if(!$this->login_check())
	    {
	      /*$data['base'] = $base;
		  $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id="");
          $label = $this->load_label($language);
          $data = array_merge($data,$right_data,$label);
		  $data['css_name'] = $this->Auth->ie_browser_check() ? $this->config->item('css4ie') : 'css';
		  $this->load->view('q2a/login',$data);*/
		  if(form_error('username') != '')
		  {
		  	echo form_error('username');
		  }
		  else
		  {
		  	echo form_error('password');
		  }		  
		}
		else
		{
		   $data = array('username'=>$_POST['username'],'passwd'=>$_POST['password']);
		   $this->login_process($data);
		  // $this->base = $base;
		  // redirect($this->base);
           //$new_url = str_replace(array('login','register/','document/'),'',$_SERVER['HTTP_REFERER']);
		   //redirect($new_url);
		   echo("login_success");
		}
	}

	//
	function login_check()
	{
	    $this->load->helper(array('form', 'url'));
	    $this->load->library('form_validation');

        $lang = $this->Ip_location->get_language();
        $this->lang->load('login',$lang);

	    $this->form_validation->set_rules('username', 'lang:username', 'required|callback_login_account_check');
	    $this->form_validation->set_rules('password', 'lang:password', 'required');
	    return $this->form_validation->run();
	}

	//check if the login username matches the password
	function login_account_check()
	{
	   $uId = $this->User_activity->login_check(array('username'=>$_POST['username'],'passwd'=>$_POST['password']));

	   if($uId)
	   {
		  if(!$this->Auth->user_online_check($uId))
		  {
		    //$this->form_validation->set_message('login_account_check', $this->Check_process->get_prompt_msg(array('pre'=>'login','code'=> ACCOUNT_ALREADY_LOGIN)));
	        //return false;
            $this->Session_process->user_online_clear($uId);
		  }
          return true;
	   }
	   else
	   {
	      $this->form_validation->set_message('login_account_check',$this->Check_process->get_prompt_msg(array('pre'=>'login','code'=> PASSWORD_NOT_MATCH)));
		   return false;
	   }
	}

	//store the user login data
	//$data = array('username','passwd');
	function login_process($data)
	{
	   $uId = $this->User_activity->login_check($data);
	   $location_city = $this->Ip_location->get_location_city();
           $language = $this->Ip_location->get_language('',$uId);
           $hot_tags = $this->Right_nav_data->get_hot_tags();
	   $this->login_session_process(array('uId'=>$uId,'location_city'=>$location_city,'language'=>$language,'hot_tags'=> $hot_tags));
	}

	//$data = array('uId','location_city');
	function login_session_process($data)
	{
	    $data['status'] = 'LOGIN';
		$data['site']='WebSite';
        $this->session->set_userdata($data);
	}

	function logout()
	{
	   $this->session->sess_destroy();
	   redirect($this->base);
	}

    function load_label($lang)
    {
        $login_label = $this->load_login_label($lang);
        $common_label = $this->Load_common_label->load_common_label($lang);
        $result = array_merge($login_label,$common_label);
        return $result;
    }

    function load_login_label($lang)
    {
        $this->lang->load('login',$lang);
        $data['login_page_title'] = $this->lang->line('login_page_title');
        $data['login_check'] = $this->lang->line('login_check');
        $data['login_create_new'] = $this->lang->line('login_create_new');
        $data['login_account'] = $this->lang->line('login_account');
        $data['login_password'] = $this->lang->line('login_password');
        $data['login_forget_password'] = $this->lang->line('login_forget_password');
        $data['login_remember_me'] = $this->lang->line('login_remember_me');
        $data['login_login'] = $this->lang->line('login_login');
        $data['login_other_account'] = $this->lang->line('login_other_account');
        return $data;
    }
 }

 /*End of file*/
  /*Location: ./system/appllication/controller/login.php*/
