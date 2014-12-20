<?php
  class Settings_check extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->helper('url');
		$this->load->helper('define');
		$this->load->helper('profile_error');

		$this->load->database();

		$this->load->library('session');
		$this->load->library('account_format_check');
        $this->load->helper('define');

		$this->load->model('q2a/Auth');
		$this->load->model('q2a/User_activity');
		$this->load->model('q2a/User_profile');
		$this->load->model('q2a/Tag_process');
		$this->load->model('q2a/Photo_upload');
	 }

	 //input: array('gender','birthday','old_password','new_password','new_passwordc')
	 function profile_basic_check($data)
     {
		   $msg_arr = array();
		   $pwsd_bool = $this->profile_password_check($data);
		   $birthday_bool = $this->birthday_valid_check($data);

		   if($pwsd_bool != PROFILE_SUCCESS)
		   {
			  $msg_arr['password'] = $pwsd_bool;
		   }

		   if($birthday_bool != PROFILE_SUCCESS)
		   {
			  $msg_arr['birthday'] = $birthday_bool;
		   }
		   return $msg_arr;
	 }

	 //input: array('gender','birthday','old_password','new_password','new_passwordc')
	 function birthday_valid_check($data)
	 {
	     $now_day = date("Y-m-d");

		 if($data['birthday'] > $now_day)
		 {
		    //return $data['birthday'] - $now_day;
		     return PROFILE_FAIL_BIRTHDAY;
		 }
		 else
		 {
		   return PROFILE_SUCCESS;
		 }
	 }

	 //input: array('uId','old_password','new_password','new_passwordc')
	 function profile_password_check($data)
     {
	   if((trim($data['old_password']) == "") && (trim($data['new_password']) == "") && (trim($data['new_passwordc']) == ""))
	   {
	      return PROFILE_SUCCESS;
	   }
	   else
	   {
		   if($this->User_activity->password_check(array('uId'=>$data['uId'], 'passwd'=>$data['old_password'])))
		   {
			   if(($data['new_password'] == $data['new_passwordc']) && trim($data['new_password']))
			   {
				  return PROFILE_SUCCESS;
			   }
		   }
		   return PROFILE_FAIL_PASSWORD;
	   }
	}

   //check the validation of the advance data
   function profile_advance_check($data)
   {
      $msg_arr = array();

	  //$local_bool = $this->profile_local_check($data['location']);
	  $tag_bool  = $this->profile_tag_check($data['tags']);

	  /*if($local_bool != PROFILE_SUCCESS)
	  {
	     $msg_arr['local'] = $local_bool;
	  }*/

	  if($tag_bool != PROFILE_SUCCESS)
	  {
	     $msg_arr['tag'] = $tag_bool;
	  }

	  return $msg_arr;
   }

   //
   function profile_local_check($location_str)
   {
      if(trim($location_str) == '|||')
	  {
	     return PROFILE_FAIL_LOCAL;
	  }
	  else
	  {
	    return PROFILE_SUCCESS;
	  }
   }

   //
   function profile_tag_check($tag_str)
   {
      if(trim($tag_str) == '')
	  {
	     return PROFILE_FAIL_TAG;
	  }
	  else
	  {
	     return PROFILE_SUCCESS;
	  }
   }

   //input:array(array('uId','account','stId','isselected'))
   function profile_interact_check($data)
   {
	   $check_ret = array();
	   $is_empty = FALSE;
	   $is_valid = FALSE;

      foreach($data as $item)
	   {
	      switch($item['stId'])
		  {
		     case EMAIL:
				 $is_valid = $this->account_format_check->valid_email($item['account']);
			    break;
			  case GTALK:
			    $is_valid = $this->account_format_check->gmail_check($item['account']);
			    break;
			  case SMS:
				$is_valid = $this->account_format_check->sms_check($item['account']);
			    break;
			  case QQ:
			    $is_valid = $this->account_format_check->qq_check($item['account']);
			    break;
			  case MSN:
			    $is_valid = $this->account_format_check->msn_check($item['account']);
			    break;
			  default:
			    break;
		  }

		  $trim_account = trim($item['account']);
		  $is_empty = empty($trim_account);
		  $bool = $this->account_logic_check(array('is_select'=>$item['isselected'],'is_empty'=>$is_empty,'is_valid'=>$is_valid,'account'=>$item['account'],'stId'=>$item['stId'],'uId'=>$item['uId']));

		  if($bool != PROFILE_SUCCESS)
		  {
		     $check_ret[$item['stId']] = $bool;
		  }
	   }//foreach
	   return $check_ret;
   }

   function generate_privacy_format_data($data)
   {
        $result = array();
        foreach($data as $key=>$value)
        {
            switch($key)
            {
                case 'gender_visible':array_push($result,array('privacy_type'=>GENDER,'visible'=>$value));break;
                case 'birthday_visible':array_push($result,array('privacy_type'=>BIRTHDAY,'visible'=>$value));break;
                case 'location_visible':array_push($result,array('privacy_type'=>CURRENT_LOCATION,'visible'=>$value));break;
                case 'Email_visible':array_push($result,array('privacy_type'=>EMAIL,'visible'=>$value));break;
                case 'Gtalk_visible':array_push($result,array('privacy_type'=>GTALK,'visible'=>$value));break;
                case 'SMS_visible':array_push($result,array('privacy_type'=>SMS,'visible'=>$value));break;
                case 'QQ_visible':array_push($result,array('privacy_type'=>QQ,'visible'=>$value));break;
                case 'MSN_visible':array_push($result,array('privacy_type'=>MSN,'visible'=>$value));break;
            }
        }
        return $result;
   }

	//logic check for the validation of the account data
	//input: array('uId','is_select','is_empty','is_valid','account','stId')
	//return msg type
	function account_logic_check_old($data)
	{
	   if($data['is_select'])
	   {
	      if($data['is_valid'])
		  {
		    if($this->User_activity->account_used_check(array('account'=>$data['account'],'stId'=>$data['stId'],'uId'=>$data['uId'])))
			{
			  return PROFILE_SUCCESS;
			}
			else
			{
			  return PROFILE_FAIL_ACCOUNT_USED;
			}
		  }
		  else
		  {
		     return PROFILE_FAIL_ACCOUNT_FORMAT;
		  }
	   }
	   else
	   {
	      if($data['is_valid'] || $data['is_empty'])
		  {
		     return PROFILE_SUCCESS;
		  }
		  else
		  {
		     return PROFILE_FAIL_ACCOUNT_FORMAT;
		  }
	   }
	}

    //logic check for the validation of the account data
	//input: array('uId','is_select','is_empty','is_valid','account','stId')
	//return msg type
	function account_logic_check($data)
	{
		if($data['is_empty'])
		{
			return PROFILE_SUCCESS;
		}

		if($data['is_valid'])
		{
			if($this->User_activity->account_used_check(array('account'=>$data['account'],'stId'=>$data['stId'],'uId'=>$data['uId'])))
			{
			  return PROFILE_SUCCESS;
			}
			else
			{
			  return PROFILE_FAIL_ACCOUNT_USED;
			}
	    }
		else
		{
		   return PROFILE_FAIL_ACCOUNT_FORMAT;
		}
	}



    //****************************Generate format data*********************************//
    //generate format basic data to store in DB
    //input: array('uId','gender','birthday','location','language_code','old_password','new_password','new_passwordc')
	//output: array('uId','birthday','passwd','gender','location','language_code')
    function generate_basic_format_data($post_data)
    {
	   $data = array();
	   $data['langCode'] = $post_data['language_code'];
	   $data['uId'] = $post_data['uId'];
	   $data['birthday'] = $post_data['birthday'];
	   $data['passwd'] = trim($post_data['new_password']);
	   $data['gender'] = $post_data['gender'];
	   $data['nickname'] = $post_data['nickname'];
	   $data['realname'] = $post_data['realname'];
	   $data['age'] = $post_data['age'];
	   $data['tel'] = $post_data['tel'];
	   $data['address'] = $post_data['address'];
	   $data['address_now'] = $post_data['address_now'];
	   $data['email'] = $post_data['email'];
	   $data['qq'] = $post_data['qq'];
	   $data['description'] = $post_data['description'];
	   $data['school'] = $post_data['school'];
	   $data['tag'] = $post_data['tag'];
	   //$data['location'] = $this->location_data_parse($post_data['location']);

	   return $data;
	}


    //generate format advance data to store in DB
	//input: array('uId','location','tags')
	//output: array('uId','langCode','tag')
	function generate_advance_format_data($post_data)
	{
       return array('uId'=>$post_data['uId'],'langCode'=>$_POST['language_code'], 'tag'=>$this->tag_data_parse($_POST['tags']));
	}

	//convert location string from web from which is fromatted
	//as '{country_code}_{province_code}_{city_code}_{town_code}'
	//to array of data
	//return array of location data
	function location_data_parse($location_str)
	{
	   //
	   $location_data = array();
	   $arr = explode('|',$location_str);

	   $location_data['country_code'] = isset($arr[0]) ? $arr[0] : '';
	   $location_data['province_code'] = isset($arr[1]) ? $arr[1] : '';
	   $location_data['city_code'] = isset($arr[2]) ? $arr[2] : '';
	   $location_data['town_code'] = isset($arr[3]) ? $arr[3] : '';

	   return $location_data;
	}

	//convert user tag string from web from which is fromatted
	//as '{category_id}_{sub_cate_id}_{tag_id}_{tag_name} | {category_id}_{sub_cate_id}_{tag_id}_{tag_name} | ...'
	//to array of data
	//return array of tag data
	function tag_data_parse($tag_str)
	{
		if($tag_str == '')
		{
			return array();
		}
	   $tag_data = array();
	   $line_arr = explode('|',$tag_str);

	   foreach($line_arr as $line)
	   {
		  $item = explode('_',$line);
	      array_push($tag_data,array('category_id'=> $item[0], 'sub_cate_id'=> $item[1], 'tag_id'=> $item[2], 'tag_name'=> $item[3]));
	   }

	   return $tag_data;
	}

    //generate interact format data to sotre in DB
	//input: array('email','gtalk','msn','qq','sms','selected_method_id')
	//ouput:array(array('uId','account','stId','isselected'))
    function generate_interact_format_data($user_id,$post_data)
    {
	   $interact_data = array();
	   $sendtype_info = $this->User_profile->get_all_sendtype();

	   foreach($sendtype_info as $id=>$text)
	   {
		  $is_selected = ($post_data['selected_method_id'] == $id) ? 1 : 0;
	      $item = array('uId'=>$user_id,'account'=>$post_data[$text],'stId'=>$id,'isselected'=>$is_selected);
		  array_push($interact_data, $item);
	   }

	   return $interact_data;
	}

  }//END OF CLASS
