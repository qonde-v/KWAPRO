<?php
  class Kpc_manage extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
		$this->load->helper('kpc_define');
	 }

	 //process the kpc update
	 //input: array('uId','kpc_value','kpc_type')
	 function kpc_update_process($user_item)
	 {
		$this->kpc_update(array('uId'=>$user_item['uId'],'kpc_value'=>$user_item['kpc_value']));
		$this->kpc_log_update($user_item);
	 }

	 //kpc value update for user
	 //input: array('uId','kpc_value')
	 function kpc_update($data)
	 {
	    $sql = "UPDATE user_score SET score=score+{$data['kpc_value']} WHERE uId = {$data['uId']}";
		$this->db->query($sql);
	 }

	 //kpc activity log update for user
	 //input: array('uId','kpc_value','kpc_type')
	 function kpc_log_update($data)
	 {
	    $time = date("Y-m-d H:i:s", time());
	    $score_left = $this->get_user_kpc_score($data['uId']);

		$insert_data = array('uId'=>$data['uId'], 'event'=>$data['kpc_type'], 'score_left'=>$score_left, 'score_changed'=>$data['kpc_value'], 'time'=>$time);
	    $this->db->insert('user_score_log', $insert_data);
	 }

	 //get user's kpc score
	 //input: user id
	 //output: user's kpc score
	 function get_user_kpc_score($user_id)
	 {
	     $sql = "SELECT score FROM user_score WHERE uId = {$user_id}";
		 $query = $this->db->query($sql);

		 if($query->num_rows() > 0)
	     {
            $row = $query->row_array();
			return $row['score'];
	    }
	    return 0;
	 }


	 //init related kpc table for new user
	 //input: array('uId')
	 function kpc_init_process($data)
	 {
	    $data['score'] = KPC_VALUE_REGISTER;
	    $this->db->insert('user_score',$data);
		$this->kpc_log_update(array('uId'=>$data['uId'],'kpc_value'=>KPC_VALUE_REGISTER,'kpc_type'=>KPC_TYPE_REGISTER));
	 }

     //get user's log according to a time range
     //input:array('uId'=>,'start_time'=>,'end_time'=>)
     //output:array(array('uId'=>,'event'=>,'score_changed'=>,'score_left'=>,'time'=>))
     //table:'user_score_log'
     function get_log_by_time($data)
     {
        $this->db->select('uId,event,score_changed,score_left,time');
        $this->db->where('uId',$data['uId']);
        $this->db->where('time >=',$data['start_time']);
        $this->db->where('time <=',$data['end_time']);
        $query = $this->db->get('user_score_log');
        $result = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                array_push($result,$row);
            }
        }
        return $result;
     }

     //get a certain number of a user's log
     //input: array('uId'), array('start','end')
     //output:array(array('uId'=>,'event'=>,'score_changed'=>,'score_left'=>,'time'=>))
     //table:'user_score_log'
     function get_log_by_num($data,$range=array())
     {
        $this->db->select('uId,event,score_changed,score_left,time');
        $this->db->where('uId',$data['uId']);
        $this->db->order_by('time','desc');

		if(!empty($range))
		{
          $this->db->limit($range['end']-$range['start']+1,$range['start']-1);
		}

        $query = $this->db->get('user_score_log');
        $result = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row)
            {
                array_push($result,$row);
            }
        }
        return $result;
     }

	 //get the total number of the log rows
	 //input: user id, array('start','end')
	 //output: total number
	 function get_log_num($user_id,$range=array())
	 {
	    $this->db->where('uId',$user_id);
        $this->db->from('user_score_log');
        return $this->db->count_all_results();
	 }
  }