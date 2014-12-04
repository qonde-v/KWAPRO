<?php
header("Content-type: text/html; charset=utf-8");
  class Login extends CI_Controller
  {
    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->database();
		 $this->load->library('session');

		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Question_process');
		 $this->load->model('q2a/Right_nav_data');
         $this->load->model('q2a/Load_common_label');
         $this->load->model('q2a/Ip_location');
		 $this->load->model('q2a/News_data');
		 $this->load->model('admin/Core_user');
	 }

	function index()
	{
	  // $this->output->enable_profiler(TRUE);
	   $data = array();
	   $base = $this->config->item('base_url');
	   $data['base'] = $base;	

		if(!$this->login_check()){
			//return login in page
			$this->load->view('admin/index',$data);
		}
		else{
			//process the login process
			$data=array('userCode'=>$_POST['userCode'],'pwd'=>$_POST['pwd']);
			$this->login_process($data);
			$this->base=$base;
			$user_id=$this->Core_user->login_check($data);
			echo "user_id=".$user_id;
			$roleId=$this->Core_user->getRoleById($user_id);
			echo "roleId=".$roleId;
			if($roleId==1){
				redirect($this->base.'admin/news');
			}else{
				redirect($this->base.'admin/news');
			}
		}
	}
	//check if user input all information
	//input null
	//return ture or false
	function login_check(){
		$this->load->helper(array('form','url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('userCode', '用户名', 'required|callback_login_account_check');
		$this->form_validation->set_rules('pwd', '密码', 'required');
		//$this->form_validation->set_rules('organization','Organization','required');
		return $this->form_validation->run();
	}

	//check if the login username matches the password
	//input null
	//return true or false
	function login_account_check(){
		//check username and password
		//check if the user has logined
		$uId = $this->Core_user->login_check(array('userCode'=>$_POST['userCode'],'pwd'=>$_POST['pwd']));
		
		if($uId){
			if(!$this->Auth->user_online_check($uId)){
				//$this->form_validation->set_message('login_account_check', '该用户已经登录.'.$uId);
				//return false;
				$this->Session_process->user_online_clear($uId);
			}else{
				return true;
			}
		}else {
			$this->form_validation->set_message('login_account_check', '用户名或密码错误.');
			return false;
		}
	}

	//store the user data, including user id, user permission, user organization
	//input user data
	//return null
	function login_process($data){
		//check username and password
		//store user information in session
		$user_id=$this->Core_user->login_check($data);
		$roleId = $this->Core_user->getRoleById($user_id);
		$nickname = $this->Core_user->getNicknameById($user_id);
		$info=array('user_id'=>$user_id,'roleId'=>$roleId, 'userCode'=>$data["userCode"], 'nickname'=>$nickname);
		$this->login_session_process($info);
	}

	//store the user data and user status(Login or Logout) in session
	//input user data
	//return null
	function login_session_process($data){
		$data['status']='LOGIN';
		$data['site']='MainSite';
		$this->session->set_userdata($data);
	}

	//logout of system
	function logout()
	{
		$this->base = $this->config->item('base_url');
		$this->session->sess_destroy();
		redirect($this->base.'admin/login');
	}

	

 }//END OF CLASS

 /*End of file*/
