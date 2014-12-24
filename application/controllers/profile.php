<?php
  class Profile extends CI_Controller
  {
    function __construct()
	 {
	     parent::__construct();
		 $this->load->helper(array('form', 'url'));
		 $this->load->helper('url');
		 $this->load->database();
		 $this->load->library('session');
		 $this->load->model('q2a/User_profile');
		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Right_nav_data');
		 $this->load->model('q2a/User_data');
         $this->load->model('q2a/Load_common_label');
         $this->load->model('q2a/Ip_location');
         $this->load->model('q2a/User_privacy');
	 }

	function index()
	{
	   $base = $this->config->item('base_url');
	    //check if user has been login
	   $this->Auth->permission_check("login/");
       $language = $this->Ip_location->get_language();

	   $this->uId = $this->session->userdata('uId');
	   $data = $this->get_profile_data($this->uId);
	   $data['login'] = "login";
	   $data['base'] = $base;

	   //$data['language_options'] = form_dropdown('Language', $data['language_data'], $data['langCode'],'id="Language"');           
          // $data['category_data'] = $this->Load_common_label->load_category_data($language);
	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($this->uId);
       $label = $this->load_label($language);
	   $data = array_merge($right_data,$data,$label);
	   //print_r($data);
	   $this->load->view('q2a/setting',$data);
	}

	function avatar()
	{
	   $base = $this->config->item('base_url');
	    //check if user has been login
	   $this->Auth->permission_check("login/");

	   $this->uId = $this->session->userdata('uId');
	   $data = $this->get_profile_data($this->uId);
	   $data['login'] = "login";
	   $data['base'] = $base;

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($this->uId);
	   $data = array_merge($right_data,$data);

	   $this->load->view('q2a/setting_avatar',$data);
	}

	//
	function get_profile_data($uId)
	{
	   //get user's basic data include('username','email','passwd','gender','birthday')
	   $basic_data = $this->User_profile->get_user_basicdata($uId);

	   //get user's advance data include('langCode','location','tag','language_data')
	   $advance_data = $this->User_profile->get_user_advancedata($uId);
	   
	   //get according rss data
	   //$rss_data = $this->User_profile->get_user_rssdata(array('uId'=> $uId, 'langCode'=> $advance_data['langCode']));

	   $photo_data['userphoto_path'] = $this->User_data->get_user_headphotopath($uId);

	   $data = array_merge($basic_data,$advance_data,$photo_data);//
	   //$data['rss_data'] = $rss_data;
	   //$data['user_rss_save'] = $this->User_profile->get_user_rss_feed($uId);

	   //get user's interact data
	   //$data['sendtype_info'] = $this->User_profile->get_all_sendtype();
	   //$data['interact_data'] = $this->User_profile->get_user_methoddata($uId);

       //$data['privacy_data'] = $this->User_privacy->get_user_privacy($uId);

	   return $data;
	}

    function load_label($lang)
    {
        $profile_label = $this->load_profile_label($lang);
        $common_label = $this->Load_common_label->load_common_label($lang);
        $result = array_merge($profile_label,$common_label);
        return $result;
    }

    function load_profile_label($lang)
    {
		$lang_code = $this->config->item('language_code');
        $this->lang->load('profile',$lang);

        $data['profile_page_title'] = $this->lang->line('profile_page_title');
        //left category
        $data['profile_basic_data'] = $this->lang->line('profile_basic_data');
        $data['profile_advanced_data'] = $this->lang->line('profile_advanced_data');
        $data['profile_rss_setting'] = $this->lang->line('profile_rss_setting');
        $data['profile_interact_setting'] = $this->lang->line('profile_interact_setting');

        $data['profile_title_basic'] = $this->lang->line('profile_title_basic');
        $data['profile_title_advanced'] = $this->lang->line('profile_title_advanced');
        $data['profile_title_rss'] = $this->lang->line('profile_title_rss');
        $data['profile_title_data'] = $this->lang->line('profile_title_data');
        $data['profile_title_interact'] = $this->lang->line('profile_title_interact');
        $data['profile_title_setting'] = $this->lang->line('profile_title_setting');
        //basic data
        $data['profile_sub_basic_data'] = $this->lang->line('profile_sub_basic_data');
        $data['profile_user_name'] = $this->lang->line('profile_user_name');
        $data['profile_photo'] = $this->lang->line('profile_photo');
        $data['profile_photo_browse'] = $this->lang->line('profile_photo_browse');
        $data['profile_gender'] = $this->lang->line('profile_gender');
        $data['profile_gender_male'] = $this->lang->line('profile_gender_male');
        $data['profile_gender_female'] = $this->lang->line('profile_gender_female');
        $data['profile_birthday'] = $this->lang->line('profile_birthday');
        $data['profile_birthday_edit'] = $this->lang->line('profile_birthday_edit');
        $data['profile_old_password'] = $this->lang->line('profile_old_password');
        $data['profile_new_password'] = $this->lang->line('profile_new_password');
        $data['profile_password_confirm'] = $this->lang->line('profile_password_confirm');
		$data['profile_select_first'] = $this->lang->line('profile_select_first');
		$data['profile_crop_img_title'] = $this->lang->line('profile_crop_img_title');
        $data['profile_original_img'] = $this->lang->line('profile_original_img');
		$data['profile_thumb_preview'] = $this->lang->line('profile_thumb_preview');
		$data['profile_upload_wait'] = $this->lang->line('profile_upload_wait');
        //advanced data
        $data['profile_sub_advanced_data'] = $this->lang->line('profile_sub_advanced_data');
        $data['profile_language_type'] = $this->lang->line('profile_language_type');
        $data['profile_current_local'] = $this->lang->line('profile_current_local');
        $data['profile_local_edit'] = $this->lang->line('profile_local_edit');
        $data['profile_local_check'] = $this->lang->line('profile_local_check');
        $data['profile_local_close'] = $this->lang->line('profile_local_close');
		$data['profile_local_prompt'] = $this->lang->line('profile_local_prompt');
        $data['profile_tags'] = $this->lang->line('profile_tags');
        $data['profile_tags_title'] = $this->lang->line('profile_tags_title');
        $data['profile_tags_add'] = $this->lang->line('profile_tags_add');
        $data['profile_tags_delete'] = $this->lang->line('profile_tags_delete');
        $data['profile_tag_added'] = $this->lang->line('profile_tag_added');

        $data['profile_add_tag_title'] = $this->lang->line('profile_add_tag_title');
        $data['profile_input_tag'] = $this->lang->line('profile_input_tag');
        $data['profile_press_enter'] = $this->lang->line('profile_press_enter');
        $data['profile_tag_result'] = $this->lang->line('profile_tag_result');
        $data['profile_add_tag_prompt'] = $this->lang->line('profile_add_tag_prompt');
        $data['profile_add_sub_cate'] = $this->lang->line('profile_add_sub_cate');
        $data['profile_select_cate'] = $this->lang->line('profile_select_cate');
        $data['profile_select_subcate'] = $this->lang->line('profile_select_subcate');
        $data['profile_name_unvalid'] = $this->lang->line('profile_name_unvalid');
        $data['profile_add_sub_cate_label1'] = $this->lang->line('profile_add_sub_cate_label1');
        $data['profile_add_sub_cate_label2'] = $this->lang->line('profile_add_sub_cate_label2');
        $data['profile_add_tag_label1'] = $this->lang->line('profile_add_tag_label1');
        $data['profile_add_tag_label2'] = $this->lang->line('profile_add_tag_label2');
		$data['profile_filter_cate'] = $this->lang->line('profile_filter_cate');
        $data['profile_filter_subcate'] = $this->lang->line('profile_filter_subcate');
        $data['profile_filter_tag'] = $this->lang->line('profile_filter_tag');
        //rss
        $data['profile_sub_title_rss'] = $this->lang->line('profile_sub_title_rss');
        $data['profile_rcv_rss'] = $this->lang->line('profile_rcv_rss');
        $data['profile_rcv_rss_yes'] = $this->lang->line('profile_rcv_rss_yes');
        $data['profile_rcv_rss_no'] = $this->lang->line('profile_rcv_rss_no');
        $data['profile_add_rss'] = $this->lang->line('profile_add_rss');
        $data['profile_rss_empty'] = $this->lang->line('profile_rss_empty');
        $data['profile_unvalid_rss'] = $this->lang->line('profile_unvalid_rss');
        //private
        $data['profile_sub_private_setting'] = $this->lang->line('profile_sub_private_setting');
        $data['profile_private_setting'] = $this->lang->line('profile_private_setting');
        $data['profile_title_private'] = $this->lang->line('profile_title_private');
        $data['profile_private_gender'] = $this->lang->line('profile_private_gender');
        $data['profile_private_birthday'] = $this->lang->line('profile_private_birthday');
        $data['profile_private_email'] = $this->lang->line('profile_private_email');
        $data['profile_private_location'] = $this->lang->line('profile_private_location');


		//label added for adding sub category
        $data['profile_add_subcate'] = $this->lang->line('profile_add_subcate');
        $data['profile_add_button'] = $this->lang->line('profile_add_button');
        $data['profile_processing'] = $this->lang->line('profile_processing');

        //interact setting
        $data['profile_sub_interact_setting'] = $this->lang->line('profile_sub_interact_setting');
        $data['profile_check_public'] = $this->lang->line('profile_check_public');
        $data['profile_public'] = $this->lang->line('profile_public');
        $data['profile_private'] = $this->lang->line('profile_private');
        $data['profile_mostly_used'] = $this->lang->line('profile_mostly_used');
        $data['profile_email'] = $this->lang->line('profile_email');
        $data['profile_gtalk'] = $this->lang->line('profile_gtalk');
        $data['profile_sms'] = $this->lang->line('profile_sms');
        $data['profile_qq'] = $this->lang->line('profile_qq');
        $data['profile_msn'] = $this->lang->line('profile_msn');
        //all
        $data['profile_data_process'] = $this->lang->line('profile_data_process');
        $data['profile_save'] = $this->lang->line('profile_save');
        $data['update_success'] = $this->lang->line('profile_update_success');
        //jquery.boxy.js
        $data['profile_confirm'] = $this->lang->line('profile_confirm');
        $data['profile_ok_button'] = $this->lang->line('profile_ok_button');
        $data['profile_cancel_button'] = $this->lang->line('profile_cancel_button');
        $data['profile_your_choice'] = $this->lang->line('profile_your_choice');
        $data['profile_select_limit'] = $this->lang->line('profile_select_limit');
        $data['profile_caution'] = $this->lang->line('profile_caution');
		$data['profile_country'] = $this->lang->line('profile_country');
        $data['profile_region'] = $this->lang->line('profile_region');
        $data['profile_city'] = $this->lang->line('profile_city');
        $data['profile_city_content'] = $this->lang->line('profile_city_content');
        $data['profile_close'] = $this->lang->line('profile_close');

        $prefix = 'day_name_';
        $data['day_name'] = array();
        for($i=0;$i<7;$i++)
        {
            $key = $prefix.$i;
            array_push($data['day_name'],$this->lang->line($key));
        }

        $prefix = 'month_name_';
        $data['month_name'] = array();
        for($i=1;$i<=12;$i++)
        {
            $key = $prefix.$i;
            array_push($data['month_name'],$this->lang->line($key));
        }
		return $data;
    }

	function savepic(){
		$subpic=$_POST['subpic'];
		$uId = $this->session->userdata('uId');
		$this->User_profile->user_subpic_update(array('uId'=>$uId,'subpic'=>$subpic));
		echo 'OK';
	}
	function saveavatar(){
		$avatar=$_POST['avatar'];
		$uId = $this->session->userdata('uId');
		$this->User_profile->user_avatar_update(array('uId'=>$uId,'avatar'=>$avatar));
		echo '修改头像成功';
	}
 }

 /*End of file*/
  /*Location: ./system/appllication/controller/profile.php*/
