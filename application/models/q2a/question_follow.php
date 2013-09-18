<?php
    class Question_follow extends CI_Model
    {
        function __construct()
        {
            parent::__construct();
            $this->load->helper('define');
			 $this->load->model('q2a/User_activity');
        }

        //insert a record of question follow
        //input:array(nId,uId,time,qctId)
        //teble:'question_collect'
        function question_follow_insert($data)
        {
            if(!$this->question_follow_exist($data))
            {//not exist in db,insert
                $this->db->insert('question_collect',$data);
                return $this->db->insert_id();
            }
            else
            {
                return '';
            }
        }

        //check if question follow exists
        //input:array(nId,uId,time,qctId)
        //table:'quesiton_collect'
        function question_follow_exist($data)
        {
            $this->db->select('qcId');
            $this->db->where('nId',$data['nId']);
            $this->db->where('uId',$data['uId']);
            $this->db->where('qctId',$data['qctId']);
            $query = $this->db->get('question_collect');
            if($query->num_rows() > 0)
            {
                //exist
                return true;
            }
            else
            {
                return false;
            }
        }

        //delete a record of question follow
        //input:array(nId,uId,stId)
        //table:'question_collect'
        function question_follow_delete($data)
        {
            $this->db->where($data);
            $this->db->delete('question_collect');
        }

        //update follow number of a question when a user follow that question
        //input:a question nId
        //table--'question'
        function update_Q_follow_num($nId)
        {
            $this->db->where('nId',$nId);
            $this->db->set('question_follow_num','question_follow_num+1',false);
            $this->db->update('question');
        }

        //update follow numbers of a question
        //input:a question nId
        //table--'question'
        function update_follow_num($nId)
        {
            $follow_num = $this->get_follow_num($nId);

            $this->db->set('question_follow_num',$follow_num);
            $this->db->where('nId',$nId);
            $this->db->update('question');
        }

        //get follow numbers of a question
        //input:a question nId
        //table--'question_collect'
        //return follow numbers of a question
        function get_follow_num($nId)
        {
            $this->db->select('qcId');
            $this->db->where('nId',$nId);
            $query = $this->db->get('question_collect');
            return $query->num_rows();
        }
    }