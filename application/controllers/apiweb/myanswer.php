<?php
  class Myanswer extends CI_Controller
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
	 * 获取当前用回答的问题列表
	 * @param $userid
	 * @param $start
	 * @param $end
	 * 	$data["username"]：用户名
		$data["uId"]：用户ID
		$data["nId"]：问题ID
		$data["text"]：问题内容
		$data["ntId"]：
		$data["langCode"]：语言编码
		$data["time"]：发布时间
		$data["sendType"]：发布类型
		$data["sendPlace"]：地理位置
		$data["question_score"]：KP积分
4		$data["question_view_num"]：浏览次数
		$data["question_follow_num"]：关注次数
		$data["question_answer_num"]：回答次数
		$data["question_participant_num"]：参与人次
		$data["question_expire_time"]：
		$data["question_stat_id"]：
		$data["tags"]：标签
	 */ 
	function index()
	{
		$uId =trim($_POST["uId"]);
		$start = trim($_POST["start"]);
		$end = trim($_POST["end"]);
	    $range = array('start'=>$start, 'end'=>$end);
		
	   $data = $this->Question_process->get_user_answered($uId, $range);
		echo json_encode($data);
	}
 }
