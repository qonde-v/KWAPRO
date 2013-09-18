<?php
  class User_vote extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
        $this->load->helper('define');
	 }

	 //user vote for an answer
	 //input:array('uId','nId','vote_type')	,nId--answer node Id
	 //output: 1--success, 0--failure
	 function user_vote($data)
	 {
		 if(!$this->check_vote_itself($data))
		 {//the answer is not submitted by the user
			if(!$this->check_have_voted($data))
			{//the user has not voted for the answer
				if(!$this->check_time_limit($data['uId']))
				{//the user has not voted twice in the lastest five minutes
					$this->user_vote_insert($data);
					$this->answer_score_process($data);
					return TRUE;
				}
			}
		 }
		 return FALSE;
	 }

	 //insert node of user vote into table 'user_vote'
	 //input:array('uId'=>,'nId'=>)	,nId--answer node Id
	 //table:'user_vote'
	 function user_vote_insert($data)
	 {
		 $this->db->set('uId',$data['uId']);
		 $this->db->set('nId',$data['nId']);
		 $time = time();
		 $this->db->set('time',date('Y-m-d H:i:s',$time));
		 $this->db->insert('user_vote');
	 }


	 //check if an answer belongs to a user
	 //input:array('uId'=>,'nId'=>)	,nId--answer node Id
	 //table:'node'
	 //return true if the answer is submitted by the user
	 function check_vote_itself($data)
	 {
		 $this->db->select('nId');
		 $this->db->where('uId',$data['uId']);
		 $this->db->where('nId',$data['nId']);
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

	 //check if the user has voted for a certain answer because someone can't vote for an answer twice
	 //input:array('uId'=>,'nId'=>)	,nId--answer node Id
	 //table:'user_vote'
	 //return true if the user has voted for the answer
	 function check_have_voted($data)
	 {
		 $this->db->select('uvId');
		 $this->db->where('uId',$data['uId']);
		 $this->db->where('nId',$data['nId']);
		 $query = $this->db->get('user_vote');
		 if($query->num_rows() > 0)
		 {
			 return true;
		 }
		 else
		 {
			 return false;
		 }
	 }

	 //check if the user has voted twice in the lastest five minutes
	 //input:uId--user Id
	 //table:'user_vote'
	 //return true the user has voted twice in the lastest five minutes
	 function check_time_limit($uId)
	 {
		 $this->db->select('UNIX_TIMESTAMP(time)');
		 $this->db->where('uId',$uId);
		 $this->db->order_by('time','desc');
		 $this->db->limit(2,0);
		 $query = $this->db->get('user_vote');


		 if($query->num_rows() == 2)
		 {//the user has voted not less than twice
			 $row = $query->row_array(1);
			 $data = $row['UNIX_TIMESTAMP(time)'];

			 $now = time();

			 $diff = $now - $data;
			 $diffhour  = (int)($diff/3600);
			 $diffminute = (int)(($diff-$diffhour*3600)/60);

			 if($diffminute < 5)
			 {//the user has voted twice in the lastest five minutes
				 return true;
			 }
			 else
			 {//the user has not voted twice in the lastest five minutes
				 return false;
			 }
		 }
		 else
		 {//the user has voted less than twice
			 return false;
		 }
	 }


     //vote for an answer or say no use of an answer
     //input:array('nId'=>,'vote_type'=>)
     //attribute can be USE or NO_USE
     //table--'answer_score'
     function answer_score_process($data)
     {
        if($this->answer_score_exist($data))
        {
            $this->answer_score_update($data);
        }
        else
        {
            $this->answer_score_insert($data);
        }
     }

     //check if there exist an record of an answer score
     //input:array('nId'=>,'vote_type'=>)
     //table--'answer_score'
     function answer_score_exist($data)
     {
        $this->db->select('nId');
        $this->db->where('nId',$data['nId']);
        $query = $this->db->get('answer_score');
        if($query->num_rows() > 0)
        {//exist
            return true;
        }
        else
        {//not exist
            return false;
        }
     }

     //update an answer's score
     //input:array('nId'=>,'attribute'=>)
     //table--'answer_score'
     function answer_score_update($data)
     {
        $this->db->where('nId',$data['nId']);
        if($data['vote_type'] == USE_VOTE)
        {
            $this->db->set('use_num','use_num+1',false);
        }
        if($data['vote_type'] == NO_USE_VOTE)
        {
            $this->db->set('no_use_num','no_use_num+1',false);
        }
        $this->db->update('answer_score');
     }

     //insert an answer's score
     //input:array('nId'=>,'vote_type'=>)
     //table--'answer_score'
     function answer_score_insert($data)
     {
        $this->db->set('nId',$data['nId']);
        if($data['vote_type'] == USE_VOTE)
        {
            $this->db->set('use_num',1);
            $this->db->set('no_use_num',0);
        }
        if($data['vote_type'] == NO_USE_VOTE)
        {
            $this->db->set('use_num',0);
            $this->db->set('no_use_num',1);
        }
        $this->db->insert('answer_score');
     }


     //get the number of vote and no_use of an answer
     //input:nId of an answer
     //output:array('nId'=>,'use_num'=>,'no_use_num'=>)
     //table--'answer_score'
     function get_answer_score($nId)
     {
        $this->db->select('nId,use_num,no_use_num');
        $this->db->where('nId',$nId);
        $query = $this->db->get('answer_score');
        $result = array();
        if($query->num_rows() > 0)
        {
            $result = $query->row_array();
        }
        return $result;
     }

 }
