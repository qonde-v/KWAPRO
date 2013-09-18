<?php
  class Quick_answer extends CI_Model
  {
     function __construct()
     {
        parent::__construct();
     }

     //insert quick answer data into DB
     //input: array('url'=>,'title'=>,'description'=>,'node_id'=>)
     //table--'question_quick_answer'
     function insert_quick_answer($data)
     {
        $this->db->set($data);
        $this->db->insert('question_quick_answer');
     }

     //get quick answer data of a question
     //input:question nId
     //table--'question_quick_answer'
     function get_quick_answer($nId)
     {
        $this->db->select('url,title,description');
        $this->db->where('nId',$nId);
        $query = $this->db->get('question_quick_answer');
        $result = array();
        if($query->num_rows() > 0)
        {
        		foreach($query->result_array() as $row)
        		{
        				array_push($result,$row);
        		}
        		return $result;
        }
        else
        {
            return '';
        }
     }

  }