<?php
  class Generate_left_view extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
	    $this->load->helper('define');
	    $this->load->helper('url');
		$this->load->model('q2a/Session_process');
		$this->load->model('q2a/User_data');
	 }
	 
	 //generate html view of 'user information' part
	 function get_user_information_view($user_id)
	 {
	    $data = $this->User_data->get_user_info_data($user_id);
	    return $this->load->view('q2a/userInformation',$data,true);
	 }
	 
	 //generate html view of 'user online friend' part
	 function get_user_onlinefriend_view($user_id)
	 {
	    $data = $this->User_data->();	 
	    return $this->load->view('q2a/onlineFriends',$data,true);
	 }
	 
	 //generate html view of 'hot tags' part
	 function get_hot_tags_view($user_id)
	 {
	    $data = $this->User_data->();	 
	    return $this->load->view('q2a/hotTags',$data,true);
	 }
	 
	 //generate html view of left part 
	 function get_left_view($user_id)
	 {
	    $user_info_html = $this->get_user_information_view($user_id);
	    $user_onlinefriend_html = $this->get_user_onlinefriend_view($user_id);
	    $user_hottag_html = $this->get_hot_tags_view($user_id);
	    return array('user_info'=>$user_info_html, 'user_onlinefriend'=>$user_onlinefriend_html, 'user_hottag'=>$user_hottag_html); 
	 }
	 
  }//end of class
/*End of file*/
/*Location: ./system/appllication/model/q2a/generate_left_view.php*/