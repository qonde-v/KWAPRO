<?php
  class Content_process extends CI_Model
  {
	function __construct()
	 {
	    parent::__construct();
	    $this->load->helper('define');
	 }
	 
	 function content_insert($data)
	 {
	   $node_id = 0;
	   switch($data['ntId'])
	   {
		   case QUESTION:
		     $node_id = $this->question_insert($data);
		     break;
		   case ANSWER:
		     $node_id = $this->answer_insert($data);
		     break;
		   case COMMENT:
		     $node_id = $this->comment_insert($data);
		     break;
		   case MESSAGE:
		     $node_id = $this->node_insert($data);
		     break;
		  case MESSAGE_REPLY:
		     $node_id = $this->reply_insert($data);
		     break;
		   default:
		     $node_id = $this->node_insert($data);
		     break;
	   }
	   return $node_id;
	 }
	 //
	 function question_insert($data)
	 {
	    //todo:
		$nId = $this->node_insert($data);
		$this->question_tab_insert(array('nId'=> $nId));
		return $nId;
	 }
	 
	 //
	 function answer_insert($data)
	 {
	    //todo:
	    return $this->reply_insert($data);
	 }
	 
	 //
	 function comment_insert($data)
	 {
	    //todo:
		return $this->reply_insert($data);
	 }
	 
	 //
	 function reply_insert($data)
	 {
	    //todo:
		$nId = $this->node_insert($data);
	    $this->node_relation_insert(array('from_nid'=>$nId, 'to_nid'=>$data['to_nId'] ,'ntId'=>$data['ntId']));
	    return $nId;	
	 }
	 
	 //content node insert: quesiton,answer or comment node
  	 //return nid of the inserted node 
	 function node_insert($data)
	 {
	    //todo:
		$node_data = $data;
		if(isset($node_data['to_nId']))
		{
		  unset($node_data['to_nId']);
		}
		$this->db->insert('node',$node_data);
		return $this->db->insert_id(); 
	 }
	
	 //update the value of column specified by the key of
	 //the input data to the value of the corresponding key
	 //input: array(key=>value)
	 function node_update($data)
	 {
            $this->db->where('nId', $data['nId']);
            $this->db->update('node', $data); 
	 }
	 
         
         //get modify time of text by node id
         //input: array('nId');
         //output: time stmp of modify 
         function get_text_modify_time($data)
         {
             $this->db->select('modify_time');
             $this->db->where($data);
             $query = $this->db->get('node');

             if($query->num_rows() > 0)
             {
                $row = $query->row_array();
		return $row['modify_time'];
             }
             
             return 0;
         }
         
	 //
	 function get_nodedata_by_id($node_id)
	 {
	    //$sql = "SELECT * FROM node WHERE nId = {$node_id}";
	    //$query = $this->db->query($sql);
	    
	    $this->db->where('nId',$node_id);
		$query = $this->db->get('node');
	    
	    if($query->num_rows() > 0)
	    {
		   return $query->row_array();
	    }
	    return array();
	 }
	 
	 //
	 function node_data_trim($data)
	 {
	    $node_data = array();
		 foreach($data as $key=>$value)
		 {
		    if($key != 'to_nId')
			{
			   $node_data[$key] = $value;
			}
		 }
		 return $node_data;
	 }
	 
	  //insert nid of the question to 'question' table
	  //$data = array('nId');
	  //'table'--question
	  function question_tab_insert($data)
	  {
	     $this->db->insert('question',$data);
	  }
	  
	  //insert the relation data of answer and question or comment and answer
	  //$data = array('from_nid','to_nid','ntId')
	  //'table'--node_relation
	  function node_relation_insert($data)
	  {
	     $this->db->set('nFromId',$data['from_nid']);
	     $this->db->set('nToId',$data['to_nid']);
	     $this->db->set('ntId',$data['ntId']);
	     $this->db->insert('node_relation');		 
	  }
	  
	  //insert tags of quesiton  
	  //$data = array('nId','text');
	  //table--'questiontags'
	  function question_tag_insert($data)
	  {
	     $this->db->set('nId',$data['nId']);
		 $this->db->set('tags',$data['text']);
		 $this->db->insert('questiontags');
	  }
	  
	  //edit tags for question
	  //table--'questiontags'
	  function question_tag_update($data)
	  {
	  	if($this->check_q_tag_exist($data['nId']))
		{
			$this->db->where('nId',$data['nId']);
			$this->db->set('tags',$data['text']);
			$this->db->update('questiontags');
		}
		else
		{
			$this->question_tag_insert($data);
		}
	  }
	  
	  //check if tags for question exist
	  //table--'questiontags'
	  function check_q_tag_exist($nId)
	  {
	  	$this->db->select('qtId');
		$this->db->where('nId',$nId);
		$query = $this->db->get('questiontags');
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	  }
  }
  
  
  
  
  
  
  
  /*End of file*/
  /*Location: ./system/appllication/model/content_process.php*/
