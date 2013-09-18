<?php

class Note extends CI_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		
		$this->load->model('q2a/Auth');
		$this->load->model('q2a/Right_nav_data');
		$this->load->model('q2a/Load_common_label');
		$this->load->model('q2a/Check_process');
		$this->load->model('q2a/Ip_location');
		$this->load->model('q2a/Note_manage');
	}
	
	function index()
	{
	}
	
	function detail()
	{
		$base = $this->config->item('base_url');
       	$language = $this->Ip_location->get_language();
		$segs = $this->uri->segment_array();
		$data['noteId'] = $segs[2];

	   	//check if user has been login
	   	$this->Auth->permission_check("login/");
	   	$user_id = $this->session->userdata('uId');
	   	$data['base'] = $base;
	   	$data['login'] = "login";
		$data['user_id'] = $user_id;
		$note_data = $this->Note_manage->get_note_data($data['noteId']);

	   	$right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
       	$label = $this->load_label($language);
	   	$data = array_merge($right_data,$data,$label,$note_data);
		$data['content'] = str_ireplace(array("\n"),array("<br/>"),$data['content']);

	   	$this->load->view('q2a/note',$data);
	}
	
	function note_edit()
	{
		$base = $this->config->item('base_url');
       	$language = $this->Ip_location->get_language();
		$segs = $this->uri->segment_array();
		$data['noteId'] = $segs[3];

	   	//check if user has been login
	   	$this->Auth->permission_check("login/");
	   	$user_id = $this->session->userdata('uId');
	   	$data['base'] = $base;
	   	$data['login'] = "login";
		$data['user_id'] = $user_id;
		$note_data = $this->Note_manage->get_note_data($data['noteId']);

	   	$right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
       	$label = $this->load_label($language);
	   	$data = array_merge($right_data,$data,$label,$note_data);
		$data['tags'] = implode(',',explode('|',$data['tags']));

	   	$this->load->view('q2a/note_edit',$data);
	}
	
	function load_label($lang)
	{
		$this->lang->load('notes',$lang);
		
		$data['note_detail_page_title'] = $this->lang->line('note_detail_page_title');
		$data['note_edit_page_title'] = $this->lang->line('note_edit_page_title');
		$data['notes_edit_button'] = $this->lang->line('notes_edit_button');
		$data['notes_delete_button'] = $this->lang->line('notes_delete_button');
		$data['notes_return_button'] = $this->lang->line('notes_return_button');
		$data['notes_delete_confirm_one'] = $this->lang->line('notes_delete_confirm_one');
		$data['notes_edit_label'] = $this->lang->line('notes_edit_label');
		$data['notes_create_subject'] = $this->lang->line('notes_create_subject');
		$data['notes_create_tag'] = $this->lang->line('notes_create_tag');
		$data['notes_create_content'] = $this->lang->line('notes_create_content');
		$data['notes_create_ok_button'] = $this->lang->line('notes_create_ok_button');
		$common_label = $this->Load_common_label->load_common_label($lang);
		return array_merge($data,$common_label);
	}
}
