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
	 * 用户注册信息
	 * @param $userid  用户ID

	 * 	$info["username"]：用户名
		$info["email"]：邮箱
		$info["passwd"]密码
		$info["langCode"]：使用语言
		$info["gender"]：性别
		$info["birthday"]：生日
		$info['location']: 地理位置
		$info['location']['country_code']: 国家
		$info['location']['province_code']: 省邮编
		$info['location']['city_code']: 市邮编
		$info['location']['town_code']: 县邮编
		$info['location']['town_name']: 地区名称
		$info['interact_data']: 交互数据
		$info['privacy_data']: 隐私设置
	 */ 
	function index()
	{
		$uId = trim($_POST["userid"]);
		$data = array();
	    
		//用户信息表
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
