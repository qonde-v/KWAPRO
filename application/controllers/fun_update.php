<?php
  class fun_update extends CI_Controller
  {
    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->database();
		 $this->load->library('session');

		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Right_nav_data');
         $this->load->model('q2a/Load_common_label');
         $this->load->model('q2a/Ip_location');
	 }

	function index()
	{
	   $data = array();
	   $user_id = "";
       $language = $this->Ip_location->get_language();

	   if($this->Auth->login_check())
	   {
	     $user_id = $this->session->userdata('uId');
		 $data['login'] = "login";
	   }

	   $data['base'] = $this->config->item('base_url');
       $data['lang'] = $language;
	   $label = $this->load_label($language);
       $data = array_merge($data,$label);
	   $this->load->view('q2a/fun_update',$data);
	}

	//
	function load_label($lang)
    {
        $common_label = $this->Load_common_label->load_common_label($lang);
        $result = $common_label;
        return $result;
    }


 }//END OF CLASS

 /*End of file*/
  /*Location: ./system/appllication/controller/document.php*/
