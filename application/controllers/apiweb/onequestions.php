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
	 * ��ȡ�ش���Ϣ
	 * @param $id
	 * @param $answernum
	 * 	$retStr["username"]���û���
		$retStr["uId"]���û�ID
		$retStr["nId"]���ش�ID
		$retStr["text"]���ش�����
		$retStr["ntId"]��
		$retStr["langCode"]�����Ա���
		$retStr["time"]������ʱ��
		$retStr["sendType"]����������
		$retStr["sendPlace"]������λ��

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
