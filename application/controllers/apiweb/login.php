<?php
  class Login extends CI_Controller
  {

   var $base = '';
	function __construct()
	 {
	     parent::__construct();
		 $this->load->database();
	 }
	/**
	 * ��ȡ�û���Ϣ
	 * @param $user
	 * @param $pwd
	 * 	$info["uid"]���û�id
		$info["email"]������
		$info["langCode"]��ʹ������
		$info["gender"]���Ա�
		$info["birthday"]������
	 */ 
	function index()
	{
		$user = trim($_POST["user"]);
		$pwd = trim($_POST["pwd"]);
		if (!isset($user) || !isset($pwd) || $user == "" || $pwd == "")
			echo 0;
		else{
			$this->db->select('*');
	        $this->db->where('uId',$user);
	        $this->db->where('passwd',MD5($pwd));
			$this->db->from('user');
			$query = $this->db->get();
			$info = array();
			$row = $query->result();
			if($row){
				$row=$row[0];	
				$info["uid"] = $row->uId;
				$info["email"] = $row->email;
				$info["langCode"] = $row->langCode;
				if($row->gender==1){
					$info["gender"] = '��';
				}elseif($row['gender']==0){
					$info["gender"] = 'Ů';
				}else{
					$info["gender"] = '';
				}
				$info["birthday"] = $row->birthday;
			}
			echo json_encode($info);
		}
	}
 }
