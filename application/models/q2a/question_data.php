<?php
  class Question_data extends CI_Model
  {
	function __construct()
	 {
	    parent::__construct();
			$this->load->helper('define');
      $this->load->model('q2a/User_vote');
      $this->load->model('q2a/User_data');
      $this->load->model('q2a/Quick_answer');
	 }

	//get the question,answer and comment content by question nId
	//input: nId -- question nId
	//return: array('q','related')
	function get_dialogue_data($qnId)
	{
	  //todo:
	  	$question_data = $this->get_question_data($qnId);
	  	$related_data =  $this->get_question_related_data($qnId);
      $quick_answer = $this->Quick_answer->get_quick_answer($qnId);
	  	return array('q'=> $question_data, 'related'=> $related_data , 'quick_answer'=>$quick_answer);
	}


	//get the question data: basic data and the tags data
	//table: user, node, question ,questiontags
	function get_question_data($nId)
	{

        $sql = "select user.username,user.uId,
                        node.text,node.ntId,node.langCode,date(node.time) as time,node.stId,node.sendPlace,                  
                        question.question_score,question.question_view_num,question.question_follow_num,question.question_answer_num,question.question_participant_num,question.question_expire_time,question.question_stat_id
                from user,node,question
                where   node.nId=$nId and
                        user.uId=node.uId and
                        node.nId=question.nId";

		 $query = $this->db->query($sql);
        $data = array();

        if($query->num_rows() > 0)
        {
			$row = $query->row();
            $data = array('username' => $row->username,
				               'uId' => $row->uId,
				               'nId' => $nId,
                              'text' => $row->text,
                              'ntId' => $row->ntId,
                          'langCode' => $row->langCode,
                              'time' => $row->time,
                          'sendType' => $this->sendtype_map($row->stId),
                         'sendPlace' => $row->sendPlace,
                    'question_score' => $row->question_score,
                 'question_view_num' => $row->question_view_num,
               'question_follow_num' => $row->question_follow_num,
               'question_answer_num' => $row->question_answer_num,
          'question_participant_num' => $row->question_participant_num,
              'question_expire_time' => $row->question_expire_time,
                  'question_stat_id' => $row->question_stat_id,
                              'tags' => '');
        }

        $tags = $this->get_question_tags($nId);
        if($tags != '')
        {
            $data['tags'] = $tags;
        }    

		return $data;

	}

	//table: user, node, node_relation
	function get_answer_data($nId)
	{

       $sql = "select user.username,user.uId,
                        node.text,node.ntId,node.langCode,node.time,node.stId,node.sendPlace
                from user,node,node_relation
                where   node.nId=$nId and
                        user.uId=node.uId ";
        $query = $this->db->query($sql);
        $data = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $data = array('username' => $row->username,
				                  'uId' => $row->uId,
									 'nId' => $nId,
                                'text' => $row->text,
                                'ntId' => $row->ntId,
                                'langCode' => $row->langCode,
                                'time' => $row->time,
                                'sendType' => $this->sendtype_map($row->stId),
                                'sendPlace' => $row->sendPlace,
                                'use_num' => 0,
                                'no_use_num' => 0);
            }
        }

        $answer_score = $this->User_vote->get_answer_score($nId);
        if(!empty($answer_score))
        {
            $data['use_num'] = $answer_score['use_num'];
            $data['no_use_num'] = $answer_score['no_use_num'];
        }
        return $data;
	}

	//table: user,node
	function get_comment_data($nId)
	{
       $sql = "select user.username, user.uId,node.nId,
                        node.text,node.ntId,node.langCode,node.time,node.stId,node.sendPlace
                from user,node
                where   node.nId=$nId and
                        user.uId=node.uId";
        $query = $this->db->query($sql);
        $data = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $data = array('username' => $row->username,
				                  'uId' => $row->uId,
									 'nId' => $row->nId,
                                'text' => $row->text,
                                'ntId' => $row->ntId,
                                'langCode' => $row->langCode,
                                'time' => $row->time,
                                'sendType' => $this->sendtype_map($row->stId),
                                'sendPlace' => $row->sendPlace);
            }
        }
        return $data;
	}

	//get the answer of the question and the corresponding comment
	function get_question_related_data($qnId)
	{
	   $retArr = array();
	   $answerIdArr = $this->get_question_answerId($qnId);

	   foreach($answerIdArr as $answerId)
	   {
	       if($answerId)
		   {//skip if answerId is 0
			   $answerData = $this->get_answer_data($answerId);
			   if($answerData)
			   {
				   $commentData = $this->get_answer_comment($answerId);
				   $item = array('answer'=> $answerData,'comment'=> $commentData);
				   array_push($retArr,$item);
			   }
			}
	   }

	   return $retArr;
	}

	//get all the answer nId for the given nId of the question
	//return array of nId
    //'table'--node_relation
	function get_question_answerId($qnId)
	{
        return $this->get_answer_or_comment_Id($qnId,ANSWER);
	}

	//get all the comment id for the given nId
    //'table'--node_relation
	function get_commentId($nId)
	{
        return $this->get_answer_or_comment_Id($nId,COMMENT);
	}


	//get all the answer nId of a question or all the comment nId for a given answer, and sort by time
	//'table'--node_relation,node
	function get_answer_or_comment_Id($nId,$type)
	{
		$this->db->select('nFromId');
		$this->db->where('nToId',$nId);
		$this->db->where('node_relation.ntId',$type);
		$this->db->order_by('node.time','asc');
		$this->db->from('node_relation');
		$this->db->join('node','node_relation.nFromId = node.nId');
		$query = $this->db->get();
		$data = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($data,$row->nFromId);
            }
        }
        return $data;
	}

	//get all comment for the answer
	function get_answer_comment($anId)
	{
	   $retArr = array();
	   $this->get_comment_recursive($anId,$retArr);
	   return $retArr;
	}

	//get comment recursive
	function get_comment_recursive($nId, & $retArr)
	{
	   $commentIdArr = $this->get_commentId($nId);

	   foreach($commentIdArr as $cnId)
	   {
	       $comment_item = $this->get_comment_data($cnId);
		   if($comment_item)
		   {
		       array_push($retArr,$comment_item);
		       $this->get_comment_recursive($cnId,$retArr);
		   }
	   }
	}

	//
	function get_question_data_arr($data)
	{
	   $retArr = array();
	   foreach($data as $qnId)
	   {
	      $item = $this->get_question_data($qnId);

		  if($item)
		  {
		    array_push($retArr,$item);
		  }
		}
		return $retArr;
	}

	//
	function get_original_text4reply($node_id)
	{
	   $sql = "SELECT node.text FROM node,node_relation WHERE node_relation.nToId = node.nId AND node_relation.nFromId = {$node_id}";
	   $query = $this->db->query($sql);

	   if($query->num_rows() > 0)
	   {
            foreach($query->result() as $row)
            {
			   return $row->text;
            }
	   }
	   return '';
	}

	//get tag id for the question specified by node id
	//from table 'question_tag'
	//output: array of tag id
	function get_question_keytag_data($node_id)
	{
	   //todo:
	   $sql = "SELECT DISTINCT tag_id FROM question_tag WHERE nId = {$node_id}";
	   $query = $this->db->query($sql);
	   $data = array();

	   if($query->num_rows() > 0)
	   {
            foreach($query->result() as $row)
            {
			     array_push($data,$row->tag_id);
            }
	   }
	   return $data;
	}

	//get category id and sub category id for the question specified by node id
	//from table 'question_tag'
	//output: array('tag'--array of tag id,'sub_cate'--array of sub category id,'cate'--array of category id)
	function get_quesiton_cate_id_info($node_id)
	{
	   $sql = "SELECT DISTINCT tag_id,sub_cate_id,category_id FROM question_tag WHERE nId = {$node_id}";
	   $query = $this->db->query($sql);

       $tag_data = array();
	   $sub_cate_data = array();
	   $cate_data = array();

	   if($query->num_rows() > 0)
	   {
		       foreach($query->result() as $row)
			   {
				   array_push($tag_data,$row->tag_id);
			       array_push($sub_cate_data, $row->sub_cate_id);
			       array_push($cate_data, $row->category_id);
			   }
	   }

	   $sub_cate_data = array_values(array_unique($sub_cate_data));
	   $cate_data = array_values(array_unique($cate_data));

	   $return_data = array('tag'=>$tag_data, 'sub_cate'=>$sub_cate_data, 'cate'=>$cate_data);

	   /*echo "+++++++++++++++++++++++++++\n";
	   print_r($return_data);
	   echo "+++++++++++++++++++++++++++\n";*/

	   return $return_data;
	}

	//
	function get_question_locationtag_data($node_id)
	{
	   //todo:
	   $sql = "SELECT country_code,province_code,city_code,town_code FROM question_location WHERE nId = {$node_id}";
	   $query = $this->db->query($sql);
	   $data = array();

	   if($query->num_rows() > 0)
	   {
            foreach($query->result() as $row)
            {
			     $item = array();
			     if($row->town_code)
				 {
				   $item['town_code'] = $row->town_code;
				 }

				 if($row->city_code)
				 {
				   $item['city_code'] = $row->city_code;
				 }

				 if($row->province_code)
				 {
				   $item['province_code'] = $row->province_code;
				 }

				 if($row->country_code)
				 {
				   $item['country_code'] = $row->country_code;
				 }

				 array_push($data,$item);
            }//for
	   }
	   return $data;
	}

	//mapping send type id to send type name
	function sendtype_map($id)
	{
	    $sql = "SELECT stText FROM sendtype WHERE stId = {$id}";
		$query = $this->db->query($sql);

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
			   return $row->stText;
            }
        }
	}

	//get the number of answers for a given question
    //'table'--node_relation
    function get_answer_num($qnId)
    {
        $this->db->select('nFromId');
        $this->db->where('nToId',$qnId);
        $this->db->where('ntId',ANSWER);
        $query = $this->db->get('node_relation');
        return $query->num_rows();
    }

    //get tags of a question
    //table--'questiontags'
    function get_question_tags($nId)
    {
        $this->db->select('tags');
        $this->db->where('nId',$nId);
        $tags_query = $this->db->get('questiontags');
        if($tags_query->num_rows() > 0)
        {
			$row = $tags_query->first_row();
			return $row->tags;
		}
        else
        {
            return '';
        }
    }

    //check if a node is a question or not
    //table--'node'
    //if the node is a question node, return true
    function check_node_question($nId)
    {
        $this->db->select('nId');
        $this->db->where('ntId',QUESTION);
        $this->db->where('nId',$nId);
        $query = $this->db->get('node');
        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    //get all followers of a certain question
    //input: question nid
    //output: array(array('uId'=>,'username'=>,'headphoto_path'))
    //table--'question_collect'
    function get_question_follower($nId)
    {
    		$this->db->select('uId');
    		$this->db->where('nId',$nId);
    		$this->db->where('qctId',FOLLOW);
    		$query = $this->db->get('question_collect');
    		$result = array();
    		if($query->num_rows() > 0)
    		{
    				foreach($query->result() as $row)
    				{
    						$uId = $row->uId;
    						$username = $this->User_data->get_username(array('uId' => $uId));
    						$headphoto_path = $this->User_data->get_user_headphotopath($uId);
    						$item = array('uId'=> $uId,'username'=> $username,'headphoto_path'=> $headphoto_path);
    						array_push($result,$item);
    				}
    		}
    		return $result;
    }
    
    //get text and node id from question table by question id
    //input: array of question node id
    //output: array of array('text','id', 'time')
    function  get_question_text_id($id_arr)
    {
       $this->db->select('nId as id, text,time');
       $this->db->where_in('nId',$id_arr);
       $query = $this->db->get('node');
       if($query->num_rows() > 0)
       {
           return $query->result_array();
       }
       return array();
    }
  }
/*End of file*/
/*Location: ./system/appllication/model/question_data.php*/
