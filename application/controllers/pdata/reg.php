<?php
  class Reg extends CI_Controller
  {

   var $base = '';
	function __construct()
	 {
	     parent::__construct();
		 $this->load->database();
		 $this->load->model('q2a/Invite_data_process');
		 $this->load->model('q2a/User_profile');
		 $this->load->model('q2a/Friend_manage');
		 $this->load->model('q2a/Kpc_manage');
		 $this->load->model('q2a/User_activity');
         $this->load->model('q2a/User_privacy');
	 }
	/**
	 * �û�ע����Ϣ
	 * @param $user  �û���
	 * @param $pwd  ����
	 * @param $email  ����
	 * @param $invite_code ������
	 * 	$info["uid"]���û�id
		$info["email"]������
		$info["langCode"]��ʹ������
		$info["gender"]���Ա�
		$info["birthday"]������
	 */ 
	function index()
	{
		$user = trim($_POST["user"]);
		$pwd = trim($_POST["pwd"]);
		$email = trim($_POST["email"]);
		$invite_code = trim($_POST["invite_code"]);
		$info = array();

		if (!isset($user) || !isset($pwd) || !isset($email) || !isset($invite_code) || $user == "" || $pwd == "" || $email == "" || $invite_code == "")
			//û�����뷵��
			echo 0;
		else{
		   if(!$this->Invite_data_process->invite_data_certification(array('account'=>$email,'invite_code'=>$invite_code)))
		   {
		   	   //����������䲻��Ӧ����
	          echo 1;
		   }
           else{
           	   //�û���Ϣ
				$info["username"] = $user;
				$info["email"] = $email;
			 	$info['permission'] = 0;
			    $info['passwd'] = MD5($pwd);
			    
				//�û���Ϣ��
				$uId = $this->User_activity->user_register_process($info);

				//user sendtype data init
				$this->User_profile->user_account_insert(array('uId'=> $uId, 'account'=> $info['email'],'stId'=> EMAIL, 'is_visible'=>ACCOUNT_PUBLIC));
				$this->User_profile->user_sendtype_insert(array('stId'=>EMAIL, 'uId'=>$uId));
				$this->User_profile->user_rss_insert(array('rcv_rss'=> 1, 'uId'=>$uId));
	 			
				//process the friendship between register user and the user who send the invite email
				$send_invite_uId = $this->Invite_data_process->get_invite_user_id(array('account'=>$info['email']));
				$this->Invite_data_process->invite_data_delete(array('account'=>$info['email']));
				$this->Friend_manage->add_as_freind_process($uId,array($send_invite_uId));

				//init user's kpc data
				$this->Kpc_manage->kpc_init_process(array('uId'=>$uId));
				$this->Kpc_manage->kpc_update_process(array('uId'=>$send_invite_uId,'kpc_value'=>KPC_VALUE_INVITE_FINISHED,'kpc_type'=>KPC_TYPE_INVITE_FINISHED));

		        //init user's privacy setting
		        $this->User_privacy->init_user_privacy(array('uId'=>$uId,'visible'=>1));
				echo json_encode($info);
			}
		}
	}
 }
