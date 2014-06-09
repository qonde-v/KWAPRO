<?php
  class Questions extends CI_Controller
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
	 * 获取问题信息
	 * @param $start
	 * @param $end
	 * 	$retStr["username"]：用户名
		$retStr["uId"]：用户ID
		$retStr["nId"]：问题ID
		$retStr["text"]：问题内容
		$retStr["ntId"]：
		$retStr["langCode"]：语言编码
		$retStr["time"]：发布时间
		$retStr["sendType"]：发布类型
		$retStr["sendPlace"]：地理位置
		$retStr["question_score"]：KP积分
4		$retStr["question_view_num"]：浏览次数
		$retStr["question_follow_num"]：关注次数
		$retStr["question_answer_num"]：回答次数
		$retStr["question_participant_num"]：参与人次
		$retStr["question_expire_time"]：
		$retStr["question_stat_id"]：
		$retStr["tags"]：标签
		$retStr["answerdata"]：回答信息
	 */ 
	function index()
	{
		$uId ='';
		$start = trim($_POST["start"]);
		$end = trim($_POST["end"]);
		$answernum = trim($_POST["answernum"]);
	   $data = $this->Question_process->get_latest_asked_question($uId,array('start'=>$start,'end'=>$end));
	   $retStr = array();
	   foreach($data as $item)
	   {
	        $item['question_answer_num'] = $this->Question_data->get_answer_num($item['nId']);
			$item['text'] = iconv_substr($item['text'],0,30,"UTF-8");
			$answerdata = $this->Question_data->get_question_related_data($item['nId']);
			if($answernum!=0){
				$item['answerdata'] = array_slice($answerdata,0,$answernum,true);
			}else{
				$item['answerdata'] = $answerdata;
			}
			$retStr[]=$item;
	   }
	   echo json_encode($retStr);

	}
 }
