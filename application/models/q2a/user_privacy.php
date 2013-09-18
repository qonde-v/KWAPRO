<?php
  class User_privacy extends CI_Model
  {
     function __construct()
     {
        parent::__construct();
        $this->load->helper('define');
     }

     //initialize user's privacy information
     //input:array('uId'=>,'visible'=>)
     //table--'user_privacy'
     function init_user_privacy($data)
     {
        $privacy_type = array(GENDER,BIRTHDAY,CURRENT_LOCATION,EMAIL,GTALK,SMS,QQ,MSN);
        foreach($privacy_type as $value)
        {
            $this->db->set('uId',$data['uId']);
            $this->db->set('ptId',$value);
            $this->db->set('visible',$data['visible']);
            $this->db->insert('user_privacy');
        }
     }

     //update user's privacy information
     //input:array('uId'=>,'privacy_info'=>array(array('privacy_type'=>,'visible'=>)))
     //table--'user_privacy'
     function update_user_privacy($data)
     {
        $privacy_info = $data['privacy_info'];
        foreach($privacy_info as $value)
        {
            $this->db->where('uId',$data['uId']);
            $this->db->where('ptId',$value['privacy_type']);
            $this->db->set('visible',$value['visible']);
            $this->db->update('user_privacy');
        }
     }

     //get user's privacy information
     //input:$uId
     //table--'user_privacy'
     function get_user_privacy($uId)
     {
        $this->db->select('ptId,visible');
        $this->db->where('uId',$uId);
        $query = $this->db->get('user_privacy');
        $result = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                //array_push($result,array('privacy_type'=>$row->ptId,'visible'=>$row->visible));
                $result[$row->ptId] = $row->visible;
            }
        }
        return $result;
     }
  }