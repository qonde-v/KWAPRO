<?php
  class Db_event_operate extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
	    $this->load->helper('define');
	 }
	 
	 //data: array('nId','event_type')
	 function event_insert($data)
	 {
	    //todo:
	    $this->db->insert('event',$data);
		 return $this->db->insert_id(); 
	 }
	 
	 //update event_type value
	 //data: array('event_id','event_type')
	 function event_update($data)
	 {
	    //todo:
	    $sql = "UPDATE event SET event_type = {$data['event_type']} WHERE event_id = {$data['event_id']}";
	    $this->db->query($sql);
	 }
	 
	 //delete event item by event id
	 //data: array('event_id')
	 function event_delete($data)
	 {
	    //todo:
	    $sql = "DELETE FROM event WHERE event_id = {$data['event_id']}";
	    $this->db->query($sql);
	 }
	 
	 //get event item by the value 
	 //of specified column
	 //input:array(column_name=>column_value)
	 //return: array('nId','event_id','event_type');
	 function event_get($data)
	 {
	    //todo:
		 $this->db->select('*');
        $this->db->where($data);
        $query = $this->db->get('event');

		 if($query->num_rows() > 0)
        {
		    return $query->row_array();
        }
		 return array();
	 }
	 
  }//end of class
  
/*End of file*/
/*Location: ./system/appllication/model/q2a/db_event_operate.php*/
	 