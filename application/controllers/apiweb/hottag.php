<?php
  class Hottag extends CI_Controller
  {

   var $base = '';
	function __construct()
	 {
	     parent::__construct();
		 $this->load->database();
		 $this->load->model('q2a/Tag_process');
	 }
	 
	 
	/**
	 * 获取热门标签信息
	 * @param $start
	 * @param $end
	 * @param $lang_code
	 * 	$retStr["tag_name"]：标签名
		$retStr["tag_id"]：标签ID
		$retStr["count"]：数量
	 */ 
	function index()
	{
		$uId ='';
		$start = trim($_POST["start"]);
		$end = trim($_POST["end"]);
		$lang_code = trim($_POST["lang_code"]);
	   $data = $this->Tag_process->get_hot_tags(array('startnum'=>$start,'num'=>$end,'lang_code'=>$lang_code));
	   echo json_encode($data);

	}
 }
