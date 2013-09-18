<?php

  class Question_pool_manage extends CI_Model
  {
    function __construct()
    {
        parent::__construct();
        $this->load->model('q2a/Question_data');
		$this->load->helper('define');
    }


	//get top n questions from question pool by a certain attribute
    //input: array('attr','type'), range--array('start','end')
	//attribute--the attribute that questions are sorted by,num--number of questions want to get
	//attribute can be 'question_score','question_answer_num','question_view_num','question_follow_num','question_expire_time'
	//return array of question nId
	function get_question_sort_nid($data,$range=array())
    {
		$this->db->select('nId');
		$sort_type = ($data['type'] == 0) ? 'desc' : 'asc';
		$this->db->order_by($data['attr'], $sort_type);
		
		if(!empty($range))
	    {
		   $this->db->limit($range['end']-$range['start']+1,$range['start']);
	    }
		
		if($data['attr'] == 'time')
		{
			$this->db->where('ntId',QUESTION);
			$query = $this->db->get('node');
		}
		else
		{
			$query = $this->db->get('question');
		}
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				array_push($result,$row->nId);
			}
		}
		return $result;
	}
	
	function get_sorted_question_data($data,$range)
	{
		$q_nid_arr = $this->get_question_sort_nid($data,$range);
		return $this->Question_data->get_question_data_arr($q_nid_arr);
	}

   }
