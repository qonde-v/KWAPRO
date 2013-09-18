<?php
  class document extends CI_Controller
  {
    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->database();
		 $this->load->library('session');

		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/User_data');
		 $this->load->model('q2a/Question_process');
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

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);
	   $data['base'] = $this->config->item('base_url');
       $data['lang'] = $language;
	   $label = $this->load_label($language);
       $data = array_merge($data,$label);
	   $this->load->view('q2a/document',$data);
	}

	//
	function load_label($lang)
    {
        $document_label = $this->load_document_label($lang);
        $common_label = $this->Load_common_label->load_common_label($lang);
		$content = $this->load_document_content($lang);
        $result = array_merge($document_label,$common_label,$content);
        return $result;
    }

    function load_document_label($lang)
    {
	    $this->lang->load('document',$lang);
        $data['document_page_title'] = $this->lang->line('document_page_title');
        $data['document_title_about'] = $this->lang->line('document_title_about');
         $data['document_title_help'] = $this->lang->line('document_title_help');
         $data['document_title_terms'] = $this->lang->line('document_title_terms');
         $data['document_title_privacy'] = $this->lang->line('document_title_privacy');
         $data['document_title_contact_us'] = $this->lang->line('document_title_contact_us');
         $data['document_title_faq'] = $this->lang->line('document_title_faq');
         $data['document_title_activity_blog'] = $this->lang->line('document_title_activity_blog');
         $data['document_find_people_kwapro'] = $this->lang->line('document_find_people_kwapro');
         $data['document_about_us'] = $this->lang->line('document_about_us');
        return $data;
    }

    function load_document_content($lang)
	{
	     $this->lang->load('document',$lang);
         $data['document_content_about'] = $this->lang->line('document_content_about');
         $data['document_content_help'] = $this->lang->line('document_content_help');
         $data['document_content_terms'] = $this->lang->line('document_content_terms');
         $data['document_content_privacy'] = $this->lang->line('document_content_privacy');
         $data['document_content_contact_us'] = $this->lang->line('document_content_contact_us');
         $data['document_content_faq'] = $this->lang->line('document_content_faq');
         $data['document_content_activity_blog'] = $this->lang->line('document_content_activity_blog');
         return $data;
	}

 }//END OF CLASS

 /*End of file*/
  /*Location: ./system/appllication/controller/document.php*/
