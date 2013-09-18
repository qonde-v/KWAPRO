<?php
  class Expert_manage extends CI_Model
  {
         
	 function __construct()
	 {
	    parent::__construct();
            $this->load->helper('define');
            $this->load->model('q2a/User_data');
            $this->load->model('q2a/Message_management');
            $this->load->driver('cache');
         }
         
         //
         function get_expert_profile_data($uid_arr)
         {
             $result = array();
             if(!empty ($uid_arr))
             {
                 foreach($uid_arr as $uid)
                 {
                     $expert_info = $this->cache->memcached->get('expert_info_'.$uid);
                     if(empty ($expert_info))
                     {
                          $expert_info = $this->_get_expert_info_DB($uid);
                          $this->cache->memcached->save('expert_info_'.$uid, $expert_info, 3600);
                     }
                     $expert_info['uId'] = $uid;
                     $result[] = $expert_info;
                 }
             }
             return $result;
         }
         
         //
         function _get_expert_info_DB($uid)
         {
             $this->db->select("username,expertise,language,real_uId");
             $this->db->where("uId",$uid);
             $query = $this->db->get("expert");
             $result = array();
             
             if($query->num_rows() > 0)
             {
                    $result = $query->row_array();
             }
             return $result;
         }
         
         //store data of questions that send to experts
         //input: array('nId','expert_id_arr','time');
         function question2expert_store($data)
         {
             //
             if(!empty ($data))
             {
                 if(isset($data['expert_id_arr'])&& !empty ($data['expert_id_arr']))
                 {
                     foreach($data['expert_id_arr'] as $expert_id)
                     {
                         $item = array('nId'=>$data['nId'], 'uId'=>$expert_id, 'time'=>$data['time']);
                         $this->db->insert('question2expert',$item);
                         
                     }
                 }
             }
         }
         
         function message_notifi4expert($data,$base_url,$uId)
         {
             $url = $base_url."question/".$data['nId'];
             
             $e_data = $this->get_expert_profile_data($data['expert_id_arr']);
             
             if(!empty ($e_data))
             {
                 foreach($e_data as $e_item)
                 {
                     if($e_item['real_uId'])
                     {
                         $this->message_notifi2expert($e_item,$url,$uId);
                         
                     }
                     else
                     {
                         $this->simu_reply2user($e_item,$uId);
                     }
                 }
             }
         }
         
         
         //
         function simu_reply2user($e_item, $user_id)
         {
                 $ret = "";
                 $title = "";
                 $langCode = $this->User_data->get_user_langcode($user_id);
                 switch($langCode)
                 {
                     case 'zh':
                         $title = "专家回复";
                         $ret = "尊敬的用户，您好，专家'".$e_item['username']."' 是一个虚拟用户，用来做功能测试，给您带来的不便，敬请谅解！";
                         break;
                     case 'en':
                         $title = "expert reply";
                         $ret = "hello, the expert ".$e_item['username']." is not a real human being, it is just used for test.";
                         break;
                     default:
                         $title = "专家回复";
                         $ret = "尊敬的用户，您好，专家'".$e_item['username']."' 是一个虚拟用户，用来做功能测试，给您带来的不便，敬请谅解！";
                         break;
                 }
                 
                 $time = time();
                 $message_id= $time.'_0_'.$user_id;
                 $time = date("Y-m-d H:i:s", $time);
                 $stId = 12;
                 $m_data = array('message_id'=>$message_id,'from_uId'=>0,'to_uId'=>$user_id,'content'=>$ret,'title'=>$title,'time'=>$time,'stId'=>$stId,'sendPlace'=>"");
                 $this->Message_management->message_reply($m_data);

         }
         
         //
         function message_notifi2expert($e_item,$url,$uId)
         {
             $ret = "";
             $title = "";
             $langcode = $e_item['language'];
             
             switch($langcode)
             {
                 case 'zh':
                     $title = "问题求助";
                     $ret = "你好，".$e_item['username'].",这里有个问题也许您可以帮的上忙,<br/><a style='color:#0C7EAC' href=".$url.">点击这里查看问题</a>";
                     break;
                 case 'en':
                     $title = "question help";
                     $ret = "hello ".$e_item['username'].",there is question maybe you can provide helpful answer, <br/><a style='color:#0C7EAC' href=".$url.">click here to check the question.</a>";
                     break;
                 default:
                     $title = "问题求助";
                     $ret = "你好，".$e_item['username'].",这里有个问题也许您可以帮的上忙,<br/><a style='color:#0C7EAC' href=".$url.">点击这里查看问题</a>";
                     break;
             }
             
             $time = time();
	     $message_id= $time.'_0_'.$e_item['real_uId'];
             $time = date("Y-m-d H:i:s", $time);
             $stId = 12;
             $m_data = array('message_id'=>$message_id,'from_uId'=>0,'to_uId'=>$e_item['real_uId'],'content'=>$ret,'title'=>$title,'time'=>$time,'stId'=>$stId,'sendPlace'=>"");
             $this->Message_management->message_reply($m_data);
         }
         
         
         
  }//class
/*End of file*/
/*Location: ./system/appllication/model/q2a/expert_manage.php*/