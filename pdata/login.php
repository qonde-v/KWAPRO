<?php
	if(!isset($_SESSION)){
	    session_start();
	}
	include_once("connectDB.php");
	include_once("dbConfig.php");
  
//	$user = $_GET["user"];
//	$pwd = $_GET["pwd"];
	
	$user = $_POST["user"];
	$pwd = $_POST["pwd"];
  
	if (!isset($user) || !isset($pwd) || $user == "" || $pwd == "")
		echo 0;
	else{
		$info = login_process($user, $pwd);
		echo json_encode($info);
	}
	/**
	 * ��ȡ�û���Ϣ
	 * @param $user
	 * @param $pwd
	 * 	$info["uid"]���û�id
		$info["permission"]���û�Ȩ��1������Ա��2�����û�
		$info["companyCode"]�����ش���
		$info["companyName"]����������
		$info["lawPerson"]�����ط���
		$info["tel"]��������ϵ�绰
		$info["address"]�����ص�ַ
		$info["annualOutput"]�����س�����
	 */ 

	function login_process($user, $pwd){
		$sql = "SELECT * from `user` where username='".$user."' and passwd='".MD5($pwd)."'";
		$dbLink = ConnectDB($_SESSION['dbConnect']['host'],$_SESSION['dbConnect']['user'],$_SESSION['dbConnect']['pwd']);
		mysql_query("set names utf8");
		mysql_select_db($_SESSION['dbConnect']['dbName'],$dbLink);
		$result = mysql_query($sql,$dbLink) or   die(mysql_error());
		$info = array();
		if($result && $row = mysql_fetch_array($result)){	
			$info["uid"] = $row['uId'];
			$info["email"] = $row['email'];
			$info["langCode"] = $row['langCode'];
			if($row['gender']==1){
				$info["gender"] = '��';
			}elseif($row['gender']==0){
				$info["gender"] = 'Ů';
			}else{
				$info["gender"] = '';
			}
			$info["birthday"] = $row['birthday'];
		}
		return $info;
	}
  
?>

