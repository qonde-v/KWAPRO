<?php
  class Question_process extends CI_Model
  {
	function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
		$this->load->model('q2a/Question_data');
		$this->load->model('q2a/User_data');
		$this->load->model('q2a/Search');
		$this->load->model('q2a/User_privatetag_manage');
        $this->load->model('q2a/Recommend_process');
	 }

   /***********************************first degree*********************************/
	 //get user's asked question
	 //input:uId--user Id,$range = array('start'=>,'end'=>)
	 function get_user_asked($uId,$range = array())
	 {
	    //todo:
		$qnidArr = $this->get_asked_qnid($uId,$range);
		return $this->Question_data->get_question_data_arr($qnidArr);
	 }

	 //get user's answered question
	 //input:uId--user Id,$range = array('start'=>,'end'=>)
	 function get_user_answered($uId,$range = array())
	 {
	    //todo:
		$qnidArr = $this->get_answered_qnid($uId,$range);
		return $this->Question_data->get_question_data_arr($qnidArr);
	 }

     //get user's followed question
     //input:uId--user Id,$range = array('start'=>,'end'=>)
     function get_user_followed($uId,$range = array())
     {
        $qnidArr = $this->get_followed_qnid($uId,$range);
        return $this->Question_data->get_question_data_arr($qnidArr);
     }

	 //get question data by tag id
	 //input: array of tag id,range--array('start','end'), empty for default value
	 //ouput: array of structured question data
	 function get_question_data_by_tag_id($data,$range=array())
	 {
	    $qnidArr = $this->Search->search_Q_by_tagid($data,$range);
        return $this->Question_data->get_question_data_arr($qnidArr);
	 }

	 //get question number by tag id
     function get_Q_num_by_tag($tag_id)
	 {
	     $this->db->where('tag_id', $tag_id);
         $this->db->from('question_tag');
         return $this->db->count_all_results();
	 }

	 //get latest asked question for user
	 //(not include questions that asked by current user)
	 //input: user id, array('start','end')
	 //output: array of question data
	 function get_latest_asked_question($uId,$range=array())
	 {
	     $qnidArr = $this->get_latest_question_qnid($uId,$range);
             $data = $this->Question_data->get_question_data_arr($qnidArr);
             return $data;
	 }

    /*************************************Advance function**************************************/

     //change need: loading question data from recommendation table
	 //get question for user to answer
	 //input: array('uId')
	 function get_question_4user($uId,$range)
	 {
	    //todo:
		//$qnidArr = $this->get_question4user_qnid($uId);
        $qnidArr = $this->Recommend_process->get_recommend_question(array('uId'=>$uId,'range'=>$range));
		return $this->Question_data->get_question_data_arr($qnidArr);
	 }

	 //get related questions by tags
	 //$data = array of tags;
	 function get_question_bytags($data)
	 {
	    //todo:
	     $qnidArr = $this->get_tags_qnid($data);
		 return $this->Question_data->get_question_data_arr($qnidArr);
	 }

     //get related question node_id by matching tags and location with the given node_id of Q
     //input:  node id of quesiton
     //output: array of structured question data
     function get_related_Q_by_nid($node_id)
     {
     	 $qnidArr = $this->Search->search_Q_by_tag_location($node_id);
     	 return $this->Question_data->get_question_data_arr($qnidArr);
     }
	/************************************second degree*********************************/
	//get nId of question submitted by user
	//input:$uId--user Id,$range--array('start'=>,'end'=>)
	//if $range is empty,get all the nId, else get the corresponding range of nId
	//return array of nId
    //'table'--node
	function get_asked_qnid($uId,$range)
	{
       $this->db->select('nId');
       $this->db->where('uId',$uId);
       $this->db->where('ntId',QUESTION);
	   $this->db->order_by("time", "desc");
	   if(!empty($range))
	   {
		   $this->db->limit($range['end']-$range['start']+1,$range['start']);
	   }
       $query = $this->db->get('node');
       $data = array();
       if($query->num_rows() > 0)
       {
			foreach($query->result() as $row)
			{
				array_push($data,$row->nId);
			}
       }
       return $data;
	}

	//get user acitivity content number
	//input: uId---user id, ntId --- content type
	//output: content number
	function get_user_activity_num($uId,$ntId)
	{
	     $this->db->select('num');
	     $this->db->where('uId',$uId);
	     $this->db->where('ntId',$ntId);
		 $query = $this->db->get('useractivity');

		  if($query->num_rows() > 0)
		   {
				$data = $query->row_array();
				return $data['num'];
		   }
		   return 0;
	}


	//get nId of question answered by user
	//input:$uId--user Id,$range--array('start'=>,'end'=>)
	//if $range is empty,get all the nId, else get the corresponding range of nId
	//return array of nId
    //'table'--node,node_relation
	function get_answered_qnid($uId,$range)
	{
	    $this->db->select('nToId');
       $this->db->where('node.uId',$uId);
       $this->db->where('node.ntId',ANSWER);
       $this->db->join('node','node.nId = node_relation.nFromId');
       $this->db->distinct();
	   $this->db->order_by("node.time", "desc");
	   if(!empty($range))
	   {
		   $this->db->limit($range['end']-$range['start']+1,$range['start']);
	   }
       $query = $this->db->get('node_relation');
       $data = array();

       if($query->num_rows() > 0)
       {
			foreach($query->result() as $row)
			{
				array_push($data,$row->nToId);
			}
       }
       return $data;
	}

    //get nId of question followed by user
    //input:$uId--user Id,$range--array('start'=>,'end'=>)
	//if $range is empty,get all the nId, else get the corresponding range of nId
    //return array of nId
    //'table'--question_collect
    function get_followed_qnid($uId,$range)
    {
        $this->db->select('nId');
        $this->db->where('uId',$uId);
        $this->db->where('qctId',FOLLOW);
        $this->db->order_by('time','desc');
        if(!empty($range))
		{
			$this->db->limit($range['end']-$range['start']+1,$range['start']);
		}
        $query = $this->db->get('question_collect');
        $data = array();

        if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				array_push($data,$row->nId);
			}
		}
        return $data;
    }


	//get nId of question for user to answer
	//by user's tags and local information
	//return array of nId
	function get_question4user_qnid($uId)
	{
	  $quesiton_id_arr = $this->get_Qid_by_user_tag($uId);
	  $quesiton_id_arr1 = $this->get_Qid_by_user_location($uId);
	  //print_r($quesiton_id_arr1);
	  return array_values(array_unique(array_merge($quesiton_id_arr,$quesiton_id_arr1)));
	}

	//get recommendation question number of user
	//input: user id
	//output: question number
    function get_recommendation_Q_num($user_id)
	{
	    //$data = $this->get_question4user_qnid($user_id);
		return $this->Recommend_process->get_recommend_Q_num($user_id);
	}

	//get question id by matching user's tag id information
	//in table 'user_private_tag'
	//input: user id
	//output: array of question id
	function get_Qid_by_user_tag($uId)
	{
	   $quesiton_id_arr = $this->get_Qid_by_user_private_tag($uId);

	   if(empty($quesiton_id_arr))
	   {
	     $quesiton_id_arr = $this->get_Qid_by_user_cate($uId);
	   }
	   return $quesiton_id_arr;
	}


	//get question id by matching user's private tag id information
	//in table 'user_private_tag'
	//input: user id
	//output: array of question id
	function get_Qid_by_user_private_tag($uId)
	{
	   $tag_info =  $this->User_privatetag_manage->load_privatetag_by_user_id($uId);
	   return $this->Search->search_Q_by_tagid($tag_info['tag']);
	}

	//get question id by matching user's location information
	//input: user id
	//output: array of question id
	function get_Qid_by_user_location($uId)
	{
	   //todo:
	   $location_data = $this->User_data->get_user_location_id_info($uId);
	   return $this->Search->search_Q_by_location_data($location_data);
	}

	//get question id by matching user's category id information
	//in table 'user_tag'
	//input: user id
	//output: array of question id
	function get_Qid_by_user_cate($uId)
	{
	    //todo:
	   $user_tag_data = $this->User_data->get_user_tags($uId);
	   $cate_data = $this->re_generate_cate_data($user_tag_data);
	   //print_r($cate_data);
	   return $this->Search->search_by_cate_data($cate_data);
	}


    //re structure the user category-tag data
	//input:  array of array('category_id', 'sub_cate_id','sub_cate_name')
	//output: array('cate'=>, 'sub_cate'=>)
	function re_generate_cate_data($data)
	{
	   $cate_arr = array();
	   $sub_cate_arr = array();

	   foreach($data as $item)
	   {
	      array_push($sub_cate_arr,$item['sub_cate_id']);
		  array_push($cate_arr,$item['category_id']);
	   }

	   $cate_arr = array_values(array_unique($cate_arr));
	   return array('sub_cate'=>$sub_cate_arr, 'cate'=>$cate_arr);
	}

	//get nId of question which is related with the Tags
	//$data = array of tags
	//return array of nId
	function get_tags_qnid($data)
	{
	    //todo:
	    return $this->Search->search_by_tagname($data);
	}


	//get question node id  that the corresponding question has not been answered
	//input:  array of nId
    //output: array of nId
    function get_question_unanswered($data)
    {
        $result = array();
        foreach($data as $row)
        {
            if($this->Question_data->get_answer_num($row) == 0)
            {
                array_push($result,$row);
            }
        }
        return $result;
    }

	//get latest n question items by time
	//exclude question that asked user itself
	//input: user id, array('start','end')
	function get_latest_question_qnid($uId,$range)
	{
	   //$sql = "SELECT nId FROM node WHERE ntId = ".QUESTION."  ORDER BY time DESC LIMIT {$n}";
	   //$query = $this->db->query($sql);

	   $this->db->select('nId');
	   $this->db->where('ntId',QUESTION);
       $this->db->order_by("time", "desc");
	   if(!empty($range))
	   {
		   $this->db->limit($range['end']-$range['start']+1,$range['start']);
	   }

	   $query = $this->db->get('node');

	   $q_node_id_arr = array();

	   if($query->num_rows() > 0)
	   {
	      foreach($query->result() as $row)
		  {
		    array_push($q_node_id_arr,$row->nId);
		  }
	   }
	   return $q_node_id_arr;
	}

    //update answer number of question by node id of the answer
	//input:node id of answer
	function update_Q_answer_num($answer_nid)
	{
	   $q_node_id = $this->get_Q_nid_by_A_nid($answer_nid);

	   if($q_node_id)
	   {
	      $this->db->where('nId',$q_node_id);
	      $this->db->set('question_answer_num','question_answer_num+1',false);
          $this->db->update('question');
	   }
	   return $q_node_id;
	}

	//get question node id by answer node id
	//input: node id of answer
	//output: node id of question
	function get_Q_nid_by_A_nid($nFromId)
	{
	   $this->db->select('nToId');
	   $this->db->where('nFromId',$nFromId);
	   $query = $this->db->get('node_relation');

	   if($query->num_rows() > 0)
	   {
		  $row = $query->row();
		  return $row->nToId;
	   }
	   return '';
	}

    //update answer numbers of a question
    //input:a question nId
    //table--'question'
    function update_answer_num($nId)
    {
        $answer_num = $this->get_answer_num($nId);

        $this->db->set('question_answer_num',$answer_num);
        $this->db->where('nId',$nId);
        $this->db->update('question');
    }

    //get answer numbers of a question
    //input:a question nId
    //table--'node_relation'
    function get_answer_num($nId)
    {
        $this->db->select('nrId');
        $this->db->where('ntId',ANSWER);
        $this->db->where('nToId',$nId);
        $query = $this->db->get('node_relation');
        return $query->num_rows();
    }

    //get all question number
	function get_all_question_number()
	{
         $this->db->from('question');
         return $this->db->count_all_results();
	}

        
     /*******************************get question by topic************************************/
        
      //input: category id and item selected range array('start','end')
      function get_question_by_category($category_id, $range)
      {
          $qnidArr = $this->get_question_nid_by_topic('category_id', $category_id, $range);
          //$qnidArr = array(7,10,11,12,13,16,20);
          return $this->Question_data->get_question_data_arr($qnidArr);
      }
      
      //input: sub category id and item selected range array('start','end')
      function get_question_by_sub_cate($sub_cate_id, $range)
      {
          $qnidArr = $this->get_question_nid_by_topic('sub_cate_id', $sub_cate_id, $range);
          return $this->Question_data->get_question_data_arr($qnidArr);
      }
      
      //
      function get_question_nid_by_topic($topic_type, $category_id, $range)
      {
           $this->db->distinct();
           $this->db->select('nId');
	   $this->db->where($topic_type, $category_id);
	   
           if(!empty($range))
	   {
		   $this->db->limit($range['end']-$range['start']+1,$range['start']);
	   }

	   $query = $this->db->get('question_tag');

	   $q_node_id_arr = array();

	   if($query->num_rows() > 0)
	   {
	      foreach($query->result() as $row)
		  {
		    array_push($q_node_id_arr,$row->nId);
		  }
	   }
	   return $q_node_id_arr;
      }
        
      //get question num that in the specif category
      function get_question_number_by_cate($c_id)
      {
           return $this->get_question_number_by_topic(array('type'=>'category_id','value'=>$c_id));
      }

      //get question num that in the specif sub category
      function get_question_number_by_scate($sc_id)
      {
           return $this->get_question_number_by_topic(array('type'=>'sub_cate_id','value'=>$sc_id));
      }
      
      //input: array('type','value')
      function get_question_number_by_topic($para_data)
      {
            $this->db->distinct();
            $this->db->select('nId');
            $this->db->where($para_data['type'],$para_data['value']);
            $query = $this->db->get('question_tag');
            return $query->num_rows();
      }
      
        
  }//END OF CLASS

  /*End of file*/
  /*Location: ./system/appllication/model/question_process.php*/
