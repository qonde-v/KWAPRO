<?php
  class Myprofile extends CI_Controller
  {

   var $base = '';
	function __construct()
	 {
	     parent::__construct();
		 $this->load->database();
		 $this->load->model('q2a/User_profile');
		 $this->load->model('q2a/User_data');
         $this->load->model('q2a/User_privacy');
	 }
	/**
	 * �û�ע����Ϣ
	 * @param $userid  �û�ID

	 * 	$info["username"]���û���
		$info["email"]������
		$info["passwd"]����
		$info["langCode"]��ʹ������
		$info["gender"]���Ա�
		$info["birthday"]������
		$info['location']: ����λ��
		$info['location']['country_code']: ����
		$info['location']['province_code']: ʡ�ʱ�
		$info['location']['city_code']: ���ʱ�
		$info['location']['town_code']: ���ʱ�
		$info['location']['town_name']: ��������
		$info['interact_data']: ��������
		$info['privacy_data']: ��˽����
	 */ 
	function index()
	{
		$uId = trim($_POST["userid"]);
		$data = array();
	    
		//�û���Ϣ��
	   //get user's basic data include('username','email','passwd','gender','birthday')
	   $basic_data = $this->User_profile->get_user_basicdata($uId);

	   //get user's advance data include('langCode','location','tag','language_data')
	   $advance_data = $this->User_profile->get_user_advancedata($uId);
	   
	   //get according rss data
	   $rss_data = $this->User_profile->get_user_rssdata(array('uId'=> $uId, 'langCode'=> $advance_data['langCode']));

	   $photo_data['userphoto_path'] = $this->User_data->get_user_headphotopath($uId);

	   $data = array_merge($basic_data,$advance_data,$photo_data);

	   $data['interact_data'] = $this->User_profile->get_user_methoddata($uId);

       $data['privacy_data'] = $this->User_privacy->get_user_privacy($uId);
		echo json_encode($data);
	}
 }
