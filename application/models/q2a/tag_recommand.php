<?php
  class Tag_recommand extends CI_Model
  {
	function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
		$this->load->model('q2a/Tag_process');
		$this->load->model('q2a/User_data');
	 }
	 
	 //recommand tags for user by user id
	 //input: user id
	 //output: 
	 function recommand_tag4user($user_id)
	 {
	    //todo
		$user_cate_data = $this->User_data->get_user_tags($user_id);
	 }
  }//END OF CLASS
  