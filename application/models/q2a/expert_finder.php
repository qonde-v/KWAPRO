<?php
  class Expert_finder extends CI_Model
  {
         
	 function __construct()
	 {
	    parent::__construct();
            $this->load->helper('define');
            $this->load->model('q2a/Tag_process');
            $this->load->model('q2a/User_data');
            $this->load->model('q2a/Expert_manage');
            $this->load->driver('cache');
         }
         
         //get expert data by tags
         //input: array of tag string
         //output: array of array($subcate_id => array('expert_data','subcate_name'))
         //(expert_data = array of ('uId','username','expertise'))
         function get_expert_by_topic($tag_data,$user_id)
         {
             $topic_id_info = $this->get_tags_field_info($tag_data);
             $expert_data = $this->_get_expert_by_topic_info($topic_id_info,$user_id);
             return $expert_data;
         }
         
         
         //
         function get_tags_field_info($tag_data)
         {
             $id_info = $this->Tag_process->get_id_by_text($tag_data);
             return $id_info;
         }
         
         //
         function _get_expert_by_topic_info($topic_id_info,$user_id)
         {
             $result = array();
             if(!empty ($topic_id_info))
             {
                 $langCode = $this->get_user_langcode($user_id);
                 foreach($topic_id_info as $item)
                 {
                     list($c_id,$s_id,$tag_id,$tag_name) = $item;
                     $uid_arr = $this->_get_expert_topicId_info(array('sub_cate_id'=>$s_id));
                     $user_info_data = $this->get_expert_info_data($uid_arr);
                     $sub_cate_name = $this->Tag_process->get_subcatename_by_id(array('sub_cate_id'=>$s_id,'langCode'=>$langCode));
                     $result[$s_id] = array('expert_data'=>$user_info_data,'subcate_name'=>$sub_cate_name);
                 }
             }
             return $result;
         }
         
         //get user's language code by user id
         function get_user_langcode($user_id)
         {
             $user_data = $this->cache->memcached->get('user_profile_data_'.$user_id);
             if(empty ($user_data) || !isset ($user_data['langCode']))
             {
                $user_data = empty($user_data) ? array() : $user_data;
                $langCode = $this->User_data->get_user_langcode($user_id);
                $user_data = array_merge($user_data, array('langCode'=>$langCode));
                $this->cache->memcached->save('user_profile_data_'.$user_id, $user_data, 3600);
             }
             
             return $user_data['langCode'];
         }
         
         //
         function get_expert_info_data($uid_arr)
         {
             return $this->Expert_manage->get_expert_profile_data($uid_arr);
         }
         
         
         //
         function _get_expert_topicId_info($id_info)
         {
             $exper_id_arr = $this->cache->memcached->get('expert_topic_'.$id_info['sub_cate_id']);
             if(empty ($exper_id_arr))
             {
                 $exper_id_arr = $this->_get_expert_topicId_infoDB($id_info);
                 $this->cache->memcached->save('expert_topic_'.$id_info['sub_cate_id'], $exper_id_arr, 3600);
             }
             return $exper_id_arr;
             
         }
         
         function _get_expert_topicId_infoDB($id_info)
         {
             $this->db->select("uId");
             $this->db->where("sub_cate_id",$id_info['sub_cate_id']);
             $query = $this->db->get("expert_topic");
             $result = array();
             
             if($query->num_rows() > 0)
             {
                    foreach($query->result() as $row)
                    {
                        array_push($result,$row->uId);
                    }
             }
             return $result;
         }
         
         
         
  }//class
/*End of file*/
/*Location: ./system/appllication/model/q2a/expert_finder.php*/