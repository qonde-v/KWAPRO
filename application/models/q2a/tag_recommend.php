<?php

  class Tag_recommend extends CI_Model
  {
    function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
		$this->load->model('q2a/User_data');
	 }
     
     //recommend sub_cate for user by given questions
     //input: $nId_arr: array of nId--question id; $uId
     //output: array of sub_cate_id
     function get_subcate4user($nId_arr,$uId,$top_n=3)
     {
        $user_subcate = $this->get_user_subcate($uId);
        $question_subcateid_arr = $this->get_question_subcateid_arr($nId_arr);
        $subcateid_arr_all = array_diff($question_subcateid_arr,$user_subcate);
        $subcateid_arr_recommend = $this->get_frequent_subcateid($subcateid_arr_all,$top_n);
        return $subcateid_arr_recommend;
     }
     
     //get user's sub_cate
     //input: $uId
     //output: array of sub_cate_id
     //table--'user_tag'
     function get_user_subcate($uId)
     {
        $result = array();
        $cate_data = $this->User_data->get_user_tags($uId);
        foreach($cate_data as $row)
        {
            array_push($result,$row['sub_cate_id']);
        }
        return $result;
     }
     
     //get array of sub_cate_id for a given array of question
     //input:array of nId--question id
     //output:array of sub_cate_id
     function get_question_subcateid_arr($nId_arr)
     {
        $result = array();
        foreach($nId_arr as $row)
        {
            $sub_cate_id_arr = $this->get_question_subcateid($row);
            $result = array_merge($result,$sub_cate_id_arr);
        }
        return $result;
     }
     
     //get sub_cate_id for a given question
     //input:nId--question id
     //output:sub_cate_id
     function get_question_subcateid($nId)
     {
         $this->db->select('sub_cate_id');
         $this->db->where('nId',$nId);
         $query = $this->db->get('question_tag');
         $result = array();
         if($query->num_rows() > 0)
         {
            foreach($query->result() as $row)
            {
                array_push($result,$row->sub_cate_id);
            }
         }
         return $result;
     }
     
     //get the most frequent sub_cate_id array
     //input: array of sub_cate_id
     //output: array of sub_cate_id
     function get_frequent_subcateid($data,$top_num)
     {
        $arr = array_count_values($data);
        asort($arr);
        $arr = array_reverse($arr,true);
        $result = array_slice($arr,0,$top_num,true);
        return array_keys($result);
     }
  }
