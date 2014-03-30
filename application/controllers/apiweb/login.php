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
	 * 获取用户信息
	 * @param $user
	 * @param $pwd
	 * 	$info["uid"]：用户id
		$info["email"]：邮箱
		$info["langCode"]：使用语言
		$info["gender"]：性别
		$info["birthday"]：生日
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
					$info["gender"] = '男';
				}elseif($row['gender']==0){
					$info["gender"] = '女';
				}else{
					$info["gender"] = '';
				}
				$info["birthday"] = $row->birthday;
			}
			echo json_encode($info);
		}
	}
 }
