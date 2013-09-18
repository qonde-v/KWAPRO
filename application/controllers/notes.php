<?php

class Notes extends CI_Controller
{
	var $pre_msg_num;

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
		$base = $this->config->item('base_url');
       	$language = $this->Ip_location->get_language();

	   	//check if user has been login
	   	$this->Auth->permission_check("login/");
	   	$user_id = $this->session->userdata('uId');
	   	$data['base'] = $base;
	   	$data['login'] = "login";
		$data['user_id'] = $user_id;
		
		$data['pre_note_num'] = $this->config->item('pre_note_num');
		$data['note_num'] = $this->Note_manage->get_user_notes_num($user_id);
		$data['is_split'] = ($data['note_num'] > $data['pre_note_num']) ? TRUE : FALSE;
		$data['page_num'] = ($data['note_num'] == 0) ? 1 : ceil($data['note_num'] / $data['pre_note_num']);

	   	$data['view'] = $this->notes_view_load(array('uId'=>$user_id,'index'=>1,'sort_type'=>0));

	   	$right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
       	$label = $this->load_label($language);
	   	$data = array_merge($right_data,$data,$label);

	   	$this->load->view('q2a/notes',$data);
	}
	
	function call_notes_load()
	{
		$index = $this->input->post('index',TRUE);
		$sort_type = $this->input->post('sort_type',TRUE);
        $uId = $this->session->userdata('uId');
	   	echo $this->notes_view_load(array('uId'=>$uId,'index'=>$index,'sort_type'=>$sort_type));
	}
	
	function notes_view_load($data)
	{
		$index = $data['index'];
		$pre_note_num = $this->config->item('pre_note_num');
	    $range = array('start'=>($index-1)*$pre_note_num, 'end'=>$index*$pre_note_num-1);
		
		$notes_data = $this->Note_manage->get_user_notes($data['uId'],$range,$data['sort_type']);
		$view = '';
		if(!empty($notes_data))
		{
			foreach($notes_data as $note)
			{
				$view .= $this->gen_note_item_view($note);
			}
		}
		return $view;
	}
	
	//input: array('noteId','subject','tags','content','time')
	function gen_note_item_view($data)
	{
		$data['base'] = $this->config->item('base_url');
		$lang = $this->Ip_location->get_language();
		$data = array_merge($data,$this->load_note_detail_label($lang));
		return $this->load->view('q2a/mainleft/note_item',$data,TRUE);
	}
	
	function new_note()
	{
		if($this->Auth->request_access_check())
		{
			$language = $this->Ip_location->get_language();
			$data = array();
		  	$data['base'] = $this->config->item('base_url');
	      	$label = $this->load_new_note_label($language);
		  	$data = array_merge($data,$label);
			echo $this->load->view('q2a/mainleft/new_note',$data,true);
		}
		else
		{
			echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
		}
	}
	
	function save_note()
	{
		if($this->Auth->request_access_check())
		{
			$post_arr = array();

		   	foreach($_POST as $key => $value)
		   	{
		   		$post_value = $this->input->post($key,TRUE);
		   		$post_arr[$key] = $post_value ? $post_value : '';
		   	}
			$uId = $this->session->userdata('uId');
			$data = array('uId'=>$uId);
			$data = array_merge($post_arr,$data);
			$data['noteId'] = $this->Note_manage->new_note_save($data);
			
			$data['tags'] = implode('|',explode(',',$data['tags']));
			$data['content'] = str_replace("\n","<br/>",$data['content']);
			$time = time();
			$data['time'] = date('Y-m-d H:i:s',$time);
			$new_note_item_view = $this->gen_note_item_view($data);
			
			$msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PROCESS_SUCCESS));
			echo $msg."##".$new_note_item_view;
		}
		else
		{
			echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
		}
	}
	
	function delete_notes()
	{
		if($this->Auth->request_access_check())
		{
			$noteId_str = $this->input->post('noteId');
			$noteId_arr = explode('_',$noteId_str);
			$this->Note_manage->notes_delete($noteId_arr);
			echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PROCESS_SUCCESS));
		}
		else
		{
			echo "##".$this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
		}
	}
	
	function edit_note()
	{
		if($this->Auth->request_access_check())
		{
			$noteId = $this->input->post('noteId');
			$data = $this->Note_manage->get_note_data($noteId);
			$data['base'] = $this->config->item('base_url');
			$data['tags'] = implode(',',explode('|',$data['tags']));
			$data['content'] = str_ireplace(array("<br/>","<br>"),array("\n"),$data['content']);
			$data['noteId'] = $noteId;
			$lang = $this->Ip_location->get_language();
			$label = $this->load_edit_note_label($lang);
			$data = array_merge($data,$label);
			echo $this->load->view('q2a/mainleft/note_edit',$data,true);
		}
		else
		{
			echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
		}
	}
	
	function save_edit_note()
	{
		if($this->Auth->request_access_check())
		{
			$data = array();

		   	foreach($_POST as $key => $value)
		   	{
		   		$post_value = $this->input->post($key,TRUE);
		   		$data[$key] = $post_value ? $post_value : '';
		   	}
			$data['tags'] = implode('|',explode(',',$data['tags']));
			$data['content'] = str_replace("\n","<br/>",$data['content']);
			$time = time();
			$data['time'] = date('Y-m-d H:i:s',$time);
			$this->Note_manage->edit_note_save($data);
			
			$msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PROCESS_SUCCESS));
			echo $msg."##".$data['time'];
		}
		else
		{
			echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
		}
	}
	
	function note_store()
	{
		if($this->Auth->request_access_check())
		{
			$data = array();

		   	foreach($_POST as $key => $value)
		   	{
		   		$post_value = $this->input->post($key,TRUE);
		   		$data[$key] = $post_value ? $post_value : '';
		   	}
			$data['content'] = str_replace("\n","<br/>",$data['content']);
			$data['uId'] = $this->session->userdata('uId');
			
			$this->Note_manage->note_store($data);
			
			$msg = $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PROCESS_SUCCESS));
			echo $msg;
		}
		else
		{
			echo $this->Check_process->get_prompt_msg(array('pre'=>'common','code'=> PERMISSON_DENIED));
		}
	}
	
	function load_label($lang)
	{
		$common_label = $this->Load_common_label->load_common_label($lang);
		$notes_label = $this->load_notes_label($lang);
		return array_merge($common_label,$notes_label);
	}
	
	function load_new_note_label($lang)
	{
		$this->lang->load('notes',$lang);
		$data['notes_create_subject'] = $this->lang->line('notes_create_subject');
		$data['notes_create_tag'] = $this->lang->line('notes_create_tag');
		$data['notes_create_content'] = $this->lang->line('notes_create_content');
		$data['notes_create_ok_button'] = $this->lang->line('notes_create_ok_button');
		return $data;
	}
	
	function load_notes_label($lang)
	{
		$this->lang->load('notes',$lang);
		$data['notes_page_title'] = $this->lang->line('notes_page_title');
		$data['notes_create_new_button'] = $this->lang->line('notes_create_new_button');
		$data['notes_create_title'] = $this->lang->line('notes_create_title');
		$data['notes_create_close'] = $this->lang->line('notes_create_close');
		$data['notes_create_subject_empty'] = $this->lang->line('notes_create_subject_empty');
		$data['notes_create_content_empty'] = $this->lang->line('notes_create_content_empty');
		
		$data['notes_title'] = $this->lang->line('notes_title');
		$data['notes_date'] = $this->lang->line('notes_date');
		$data['notes_operation'] = $this->lang->line('notes_operation');
		
		$data['notes_edit_button'] = $this->lang->line('notes_edit_button');
		$data['notes_delete_button'] = $this->lang->line('notes_delete_button');
		$data['notes_return_button'] = $this->lang->line('notes_return_button');
		
		$data['notes_create_subject'] = $this->lang->line('notes_create_subject');
		$data['notes_create_tag'] = $this->lang->line('notes_create_tag');
		$data['notes_create_content'] = $this->lang->line('notes_create_content');
		$data['notes_create_ok_button'] = $this->lang->line('notes_create_ok_button');
		$data['notes_wait'] = $this->lang->line('notes_wait');
		$data['notes_check_empty'] = $this->lang->line('notes_check_empty');
		return $data;
	}
	
	function load_note_detail_label($lang)
	{
		$this->lang->load('notes',$lang);
		
		$data['notes_edit_button'] = $this->lang->line('notes_edit_button');
		$data['notes_delete_button'] = $this->lang->line('notes_delete_button');
		$data['notes_return_button'] = $this->lang->line('notes_return_button');
		$data['notes_delete_confirm_one'] = $this->lang->line('notes_delete_confirm_one');
		return $data;
	}
	
	function load_edit_note_label($lang)
	{
		$this->lang->load('notes',$lang);		
		$data['notes_return_button'] = $this->lang->line('notes_return_button');
		$data['notes_save_button'] = $this->lang->line('notes_save_button');
		
		$data['notes_create_subject'] = $this->lang->line('notes_create_subject');
		$data['notes_create_tag'] = $this->lang->line('notes_create_tag');
		$data['notes_create_content'] = $this->lang->line('notes_create_content');
		$data['notes_create_subject_empty'] = $this->lang->line('notes_create_subject_empty');
		$data['notes_create_content_empty'] = $this->lang->line('notes_create_content_empty');
		return $data;
	}

 }

 /*End of file*/
  /*Location: ./system/appllication/controller/notes.php*/
