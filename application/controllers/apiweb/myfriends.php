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
	 * ��ȡ��ǰ�ûش�������б�
	 * @param $userid
	 * 	$data["username"]���û���
		$data["user_id"]���û�ID
		$data["headphoto_path"]��ͷ���ַ
		$data["kpc"]��KP����
		$data["ask_num"]����������
		$data["answer_num"]���ش�����
		$data["location"]������λ��
	 */ 
	function index()
	{
		$user_id =trim($_POST["userid"]);
	
	   $data = $this->User_data->get_user_friends($user_id);
		echo json_encode($data);
	}
 }
