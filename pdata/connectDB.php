<?php
  //session_start();
	if(!isset($_SESSION)){
		session_start();
	}
	include("dbConfig.php");
	/////public
	function ConnectDB($host,$user,$pwd) {
		$conn=mysql_connect($host, $user ,$pwd);
		return  $conn;
	}
?>