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
	 * ��ȡ��ǰ�ûش�������б�
	 * @param $userid
	 * @param $start
	 * @param $end
	 * 	$data["username"]���û���
		$data["uId"]���û�ID
		$data["nId"]������ID
		$data["text"]����������
		$data["ntId"]��
		$data["langCode"]�����Ա���
		$data["time"]������ʱ��
		$data["sendType"]����������
		$data["sendPlace"]������λ��
		$data["question_score"]��KP����
4		$data["question_view_num"]���������
		$data["question_follow_num"]����ע����
		$data["question_answer_num"]���ش����
		$data["question_participant_num"]�������˴�
		$data["question_expire_time"]��
		$data["question_stat_id"]��
		$data["tags"]����ǩ
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
