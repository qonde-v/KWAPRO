<?php
  class Myfriends extends CI_Controller
  {

   var $base = '';
	function __construct()
	 {
	     parent::__construct();
		 $this->load->database();
		 $this->load->model('q2a/User_data');
	 }
	 
	 
	/**
	 * 获取当前用回答的问题列表
	 * @param $userid
	 * 	$data["username"]：用户名
		$data["user_id"]：用户ID
		$data["headphoto_path"]：头像地址
		$data["kpc"]：KP积分
		$data["ask_num"]：提问数量
		$data["answer_num"]：回答数量
		$data["location"]：地理位置
	 */ 
	function index()
	{
		$user_id =trim($_POST["userid"]);
	
	   $data = $this->User_data->get_user_friends($user_id);
		echo json_encode($data);
	}
 }
