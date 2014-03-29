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
	 * ��ȡ������Ϣ
	 * @param $start
	 * @param $end
	 * 	$retStr["username"]���û���
		$retStr["uId"]���û�ID
		$retStr["nId"]������ID
		$retStr["text"]����������
		$retStr["ntId"]��
		$retStr["langCode"]�����Ա���
		$retStr["time"]������ʱ��
		$retStr["sendType"]����������
		$retStr["sendPlace"]������λ��
		$retStr["question_score"]��KP����
4		$retStr["question_view_num"]���������
		$retStr["question_follow_num"]����ע����
		$retStr["question_answer_num"]���ش����
		$retStr["question_participant_num"]�������˴�
		$retStr["question_expire_time"]��
		$retStr["question_stat_id"]��
		$retStr["tags"]����ǩ
	 */ 
	function index()
	{
		$uId ='';
		$start = trim($_POST["start"]);
		$end = trim($_POST["end"]);
	   $data = $this->Question_process->get_latest_asked_question($uId,array('start'=>$start,'end'=>$end));
	   $retStr = array();
	   foreach($data as $item)
	   {
	        $item['question_answer_num'] = $this->Question_data->get_answer_num($item['nId']);
			if(iconv_strlen($item['text'],"UTF-8") > 30)
			{
		   		$item['text'] = iconv_substr($item['text'],0,30,"UTF-8")."...";
			}
			else
			{
				$item['text'] = iconv_substr($item['text'],0,30,"UTF-8");
			}
			$retStr[]=$item;

	   }
	   echo json_encode($retStr);

	}
 }