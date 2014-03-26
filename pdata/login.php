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
	 * 获取用户信息
	 * @param $user
	 * @param $pwd
	 * 	$info["uid"]：用户id
		$info["permission"]：用户权限1管理人员，2基地用户
		$info["companyCode"]：基地代码
		$info["companyName"]：基地名称
		$info["lawPerson"]：基地法人
		$info["tel"]：法人联系电话
		$info["address"]：基地地址
		$info["annualOutput"]：基地出栏量
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
				$info["gender"] = '男';
			}elseif($row['gender']==0){
				$info["gender"] = '女';
			}else{
				$info["gender"] = '';
			}
			$info["birthday"] = $row['birthday'];
		}
		return $info;
	}
  
?>

