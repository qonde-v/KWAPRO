<?php
header("Content-type: text/html; charset=utf-8");
class Home extends CI_Controller{
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('q2a/Auth');
		$this->load->model('admin/Core_user');
	}
	function index() {
		$data=array();
		$user_id="";
		$roleId=$this->session->userdata('roleId');
		$data['nickname']=$this->Core_user->getNicknameById($this->session->userdata('user_id'));
		$data['roleId'] = $roleId;
		
		if($this->Auth->login_check()) {
			if($this->session->userdata('site')=='MainSite'){
				$user_id = $this->session->userdata('user_id');
				$data['login'] = "login";
				$data['user_id'] = $user_id;
			}
		}
		$data['user_id'] = 'admin';
		$data['base'] = $this->config->item('base_url');

		//$this->load->view('admin/news',$data);
		redirect($data['base'].'admin/news');
	}
}
?>