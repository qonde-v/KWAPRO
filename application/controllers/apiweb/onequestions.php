<?php
  class Onequestions extends CI_Controller
  {

   var $base = '';
	function __construct()
	 {
	     parent::__construct();
		 $this->load->database();
		 $this->load->model('q2a/Question_process');
		 $this->load->model('q2a/Question_data');
	 }
	 
	 
	/**
	 * 获取回答信息
	 * @param $id
	 * @param $answernum
	 * 	$retStr["username"]：用户名
		$retStr["uId"]：用户ID
		$retStr["nId"]：回答ID
		$retStr["text"]：回答内容
		$retStr["ntId"]：
		$retStr["langCode"]：语言编码
		$retStr["time"]：发布时间
		$retStr["sendType"]：发布类型
		$retStr["sendPlace"]：地理位置

	 */ 
	function index()
	{
		$nid = trim($_POST["id"]);
		$answernum = trim($_POST["answernum"]);
		$answerdata = $this->Question_data->get_question_related_data($nid);
		if($answernum!=0){
			$retStr = array_slice($answerdata,0,$answernum,true);
		}else{
			$retStr = $answerdata;
		}
	   echo json_encode($retStr);

	}
 }
