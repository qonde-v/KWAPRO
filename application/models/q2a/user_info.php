<?php
  class User_info extends CI_Model
  {
     function __construct()
     {
        parent::__construct();
        $this->load->helper('define');
        $this->load->model('q2a/User_privacy');
        $this->load->model('q2a/User_data');
        $this->load->model('q2a/User_profile');
        $this->load->model('q2a/Question_process');
        $this->load->library('session');
     }

     //------------------------friend information-----------------------

     //get a friend's information
     //input:$uId
     function get_friend_info($uId)
     {
        $result = array();
        $profile_info = $this->get_friend_profile_info($uId);
        $activity_info = $this->get_user_activity_info($uId);
        $result = array_merge($profile_info,$activity_info);
        $result['friends'] = $this->get_user_friends($uId);
        return $result;
     }

     //get a user's information
     //input:$uId
     function get_user_info($uId)
     {
        $result = array();
        $profile_info = $this->get_user_profile_info($uId);
        $activity_info = $this->get_user_activity_info($uId);
        $result = array_merge($profile_info,$activity_info);
        $user_id = $this->session->userdata('uId');
        $result['friends'] = $this->get_common_friend(array('uId1'=>$uId,'uId2'=>$user_id));
        return $result;
     }

     //----------------friend profile information------------------------

     //get friend's profile information
     //input:$uId
     function get_friend_profile_info($uId)
     {
        $result = $this->get_basic_info($uId);
        $result['photo'] = $this->User_data->get_user_headphotopath($uId);
        $result['kpc'] = $this->User_data->get_user_kpc($uId);

        $location = $this->User_data->get_user_location($uId);
        $result['location'] = $location['town_name'];

        $result['tag'] = $this->User_data->get_user_private_tag_data($uId);

        $account = $this->get_account_data($uId);
        $result['account'] = $account;

        return $result;
     }

     //get user's basic info(username,gender,birthday,
     //input:$uId
     //output:array('username'=>,'gender'=>,'birthday'=>)
     //table--'user'
     function get_basic_info($uId)
     {
        $this->db->select('username,gender,birthday');
        $this->db->where('uId',$uId);
        $query = $this->db->get('user');

		if($query->num_rows() > 0)
        {
            $row = $query->row();
            return array('username'=>$row->username,'gender'=>$row->gender,'birthday'=>$row->birthday);
        }
        return array();
     }

     //get user's account data
     //input:$uId
     function get_account_data($uId)
     {
        $this->db->select('stId,account');
        $this->db->where('uId',$uId);
        $query = $this->db->get('useraccount');
        $result = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $result[$row->stId] = $row->account;
            }
        }
        return $result;
     }

     //--------------------user profile information-----------------------

     //get a user's profile information who is not a friend
     //input:$uId
     function get_user_profile_info($uId)
     {
        $result['username'] = $this->User_data->get_username(array('uId'=>$uId));
        $result['photo'] = $this->User_data->get_user_headphotopath($uId);
        $result['kpc'] = $this->User_data->get_user_kpc($uId);
        $location = $this->User_data->get_user_location($uId);
        $result['location'] = $location['town_name'];
        $result['tag'] = $this->User_data->get_user_private_tag_data($uId);
        $result['langCode'] = $this->User_data->get_user_langcode($uId);
        return $result;
     }

     //--------------------user activity information-----------------------

     //get a user's activity information, content number & latest activity data
     //input:$uId
     function get_user_activity_info($uId)
     {
        $result = array_merge($this->get_user_content_number($uId),$this->get_user_activity_data($uId));
        return $result;
     }

     //get a user's activity content number
     //input:$uId
     function get_user_content_number($uId)
     {
         $data = $this->User_data->get_user_content_num($uId);
         if(isset($data[QUESTION]))
         {
            $result['ask_num'] = $data[QUESTION];
         }
         else
         {
            $result['ask_num'] = 0;
         }
         if(isset($data[ANSWER]))
         {
            $result['answer_num'] = $data[ANSWER];
         }
         else
         {
            $result['answer_num'] = 0;
         }
         if(isset($data[FOLLOW]))
         {
            $result['follow_num'] = $data[FOLLOW];
         }
         else
         {
            $result['follow_num'] = 0;
         }
         return $result;
     }

     //get a user's latest activity data
     //input:$uId
     function get_user_activity_data($uId)
     {
        $range = array('start'=>0,'end'=>0);
        $result['ask_data'] = $this->Question_process->get_user_asked($uId,$range);
        $result['answer_data'] = $this->Question_process->get_user_answered($uId,$range);
        $result['follow_data'] = $this->Question_process->get_user_followed($uId,$range);
        return $result;
     }

     //--------------------user's friend information-----------------------

     //get a user's friend
     //input:$uId
     function get_user_friends($uId)
     {
        return $this->User_data->get_user_friends($uId,array('start'=>0,'end'=>6));
     }

     //get two users' common friends
     //input:array('uId1'=>,'uId2'=>)
     function get_common_friend($data)
     {
        $common_fid = $this->get_common_friend_id($data);
        $result = array();
        foreach($common_fid as $fid)
        {
            $item = $this->User_data->get_user_basic_data($fid);
			array_push($result,array('user_id'=>$fid, 'username'=>$item['username'], 'headphoto_path'=>$item['headphoto_path']));
        }
        return $result;
     }

     //get two users' common friends id
     //input:array('uId1'=>,'uId2'=>)
     function get_common_friend_id($data)
     {
        $friend1 = $this->User_data->get_user_friend_id_data($data['uId1'],'');
        $friend2 = $this->User_data->get_user_friend_id_data($data['uId2'],'');
        $common_friend = array_intersect($friend1,$friend2);
        if(count($common_friend) > 8)
        {
            return array_slice($common_friend,0,8);
        }
        else
        {
            return $common_friend;
        }
     }
  }