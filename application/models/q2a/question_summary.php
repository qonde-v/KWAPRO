<?php
  class Question_summary extends CI_Model
  {
     function __construct()
     {
        parent::__construct();
     }

     //add question summary
     //input: array('uId'=>,'nId'=>,'text'=>,'time'=>,'langCode'=>)
     //table--'question_summary'
     function add_question_summary($data)
     {
        $this->db->set($data);
        $this->db->set('score',0);
        $this->db->insert('question_summary');
        return $this->db->insert_id();
     }

     //delete question summary
     //input: array('uId'=>,'nId'=>)
     //table--'question_summary'
     function delete_question_summary($data)
     {
        $this->db->where($data);
        $this->db->delete('question_summary');
     }

     //update question summary
     //input: array('uId'=>,'nId'=>,'text'=>,'langCode'=>)
     //table--'question_summary'
     function update_question_summary($data)
     {
        $this->db->where('nId',$data['nId']);
        $this->db->where('uId',$data['uId']);
        $this->db->where('langCode',$data['langCode']);
        $this->db->set('text',$data['text']);
        $this->db->update('question_summary');
     }

     //get question summary with the highest score
     //input: array('nId'=>,'langCode'=>)
     //table--'question_summary'
     function get_question_summary($data)
     {
        $this->db->select('text');
        $this->db->where($data);
        $this->db->order_by('score','desc');
        $this->db->limit(1);
        $query = $this->db->get('question_summary');
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->text;
        }
        else
        {
            return '';
        }
     }

  }