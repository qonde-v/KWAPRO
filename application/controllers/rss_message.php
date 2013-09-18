<?php
  class Rss_message extends CI_Controller
  {
     function __construct()
	 {
	    parent::__construct();
		$this->load->helper('url');
		$this->load->helper('define');

		$this->load->library('session');
		$this->load->library('language_translate');

		$this->load->model('q2a/Ip_location');
		$this->load->model('q2a/Auth');
		$this->load->model('q2a/Rss_manage');
		$this->load->model('q2a/Load_common_label');
		$this->load->model('q2a/Right_nav_data');
		$this->load->model('q2a/User_profile');
		$this->tag = '';
	 }
	 	
	 function index()
	 {
	 	$base = $this->config->item('base_url');
       	$language = $this->Ip_location->get_language();
		
		$post_arr = array();	   
		foreach($_POST as $key => $value)
		{
			$post_value = $this->input->post($key,TRUE);
			$post_arr[$key] = $post_value ? $post_value : 0;
		}
		
		if(!empty($post_arr))
		{
			if($post_arr['sub_category'] != 0)
			{
				$data = array('type'=>'sub_cate','id'=>$post_arr['sub_category']);
				$data['cate_name'] = $this->Rss_manage->get_cate_name(array('table'=>'sub_category','attr'=>'sub_cate','id'=>$post_arr['sub_category'],'lang'=>$language));
			}
			else if($post_arr['category'] != 0)
			{
				$data = array('type'=>'category','id'=>$post_arr['category']);
				$data['cate_name'] = $this->Rss_manage->get_cate_name(array('table'=>'category','attr'=>'category','id'=>$post_arr['category'],'lang'=>$language));
			}
			else
			{
				$data = array('type'=>'','id'=>0);
				$data['cate_name'] = '';
			}
		}
		else
		{
			$data = array('type'=>'','id'=>0);
			$data['cate_name'] = '';
		}		
       	
       	$this->Auth->permission_check("login/");
	   	$user_id = $this->session->userdata('uId');
	   	$data['base'] = $base;
	   	$data['uId'] = $user_id;
	   	$data['login'] = "login";
		$data['language'] = $language;
	   		
	   	$pre_msg_num = 6;

		$data['rcv_rss'] = $this->User_profile->get_rcv_rss($user_id);
	   	$data['rss_view'] = $this->load_article_data(array('type'=>$data['type'],'id'=>$data['id'],'index'=>1));
	   	$rss_item_num = $this->Rss_manage->rss_data_num(array('type'=>$data['type'],'id'=>$data['id'],'uId'=>$user_id));
	   	$data['page_num'] = ($rss_item_num == 0) ? 1 : ceil($rss_item_num/$pre_msg_num);
		$data['category_data'] = $this->Load_common_label->load_category_data($language);
	   		
	   	$label = $this->load_label($language);
	   		
	   	$right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   	$data = array_merge($right_data,$data,$label);
	   		
	   	$this->load->view('q2a/message_rss',$data);
	 }
	 
	 function tag_rss_message($tag)
	 {
	 	$base = $this->config->item('base_url');
       	$language = $this->Ip_location->get_language();	
		$tag = urldecode($tag);
       	
       	$this->Auth->permission_check("login/");
	   	$user_id = $this->session->userdata('uId');
	   	$data['base'] = $base;
	   	$data['uId'] = $user_id;
	   	$data['login'] = "login";
	   		
	   	$pre_msg_num = 6;
		$total_num = $this->Rss_manage->tag_rss_article_count(array($tag),array('start'=>0,'end'=>100));
		$data['page_num'] = ($total_num == 0) ? 1 : ceil($total_num/$pre_msg_num);
		//echo($total_num);
		
		$this->tag = $tag;
		$data['tag'] = $tag;
		$data['rss_view'] = $this->load_tag_rss_article($tag);
		
		$label = $this->load_tag_rss_label($language);
	   		
	   	$right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
		
	   	$data = array_merge($right_data,$data,$label);
	   		
	   	$this->load->view('q2a/tag_rss_article',$data);
	 }
	 
	 function load_tag_rss_article($tag)
	 {
	 	$index = isset($_POST['index']) ? $_POST['index'] : 1;
		$pre_msg_num = 5;
		$range = array('start'=>($index-1)*$pre_msg_num, 'end'=>$index*$pre_msg_num-1);
		//$range = array('start'=>0,'end'=>100);
		$data = $this->Rss_manage->load_tag_rss_article(array($tag),$range);
		//print_r($range);
		$html_str = $this->generate_rss_view($data);
	 	return $html_str;
	 }
	 	
	 function load_article_data($data)
	 {
	 	$index = $data['index'];
	 	$uId = $this->session->userdata('uId');
	 	$pre_msg_num = 6;
	 	$range = array('start'=>($index-1)*$pre_msg_num, 'end'=>$index*$pre_msg_num-1);
	 	$data = $this->Rss_manage->get_rss_4user(array('uId'=>$uId,'range'=>$range,'type'=>$data['type'],'id'=>$data['id']));
	 	$html_str = $this->generate_rss_view($data);
	 	return $html_str;
	 }
	 
	 function call_tag_rss_load($tag)
	 {	
		echo $this->load_tag_rss_article($tag);
	 }
	 	
	 function call_rss_data_load()
	 {
       	$post_arr = array();	   
		foreach($_POST as $key => $value)
		{
			$post_value = $this->input->post($key,TRUE);
			$post_arr[$key] = $post_value;
		}
	   	echo $this->load_article_data($post_arr);
	}
	 	
	 function generate_rss_view($data)
	 {
	 	$html_str = '';
	 	if(count($data))
	 	{
	 		foreach($data as $item)
	 		{
				//$item['description'] = 
	 			$html_str .= $this->generate_rss_item_view($item);
	 		}
	 	}
	 	return $html_str;
	 }
	 	
	 function generate_rss_item_view($data)
	 {
	 	return $this->load->view('q2a/mainleft/rss_message_item',$data,true);
	 }
	 	
	 function load_label($lang)
	 {
	 	$rss_message_label = $this->load_rss_message_label($lang);
        $common_label = $this->Load_common_label->load_common_label($lang);
        $result = array_merge($rss_message_label,$common_label);
        return $result;
	}
	 	
	 function load_rss_message_label($lang)
	 {
	 	$this->lang->load('messages',$lang);
	 	$data['rss_message_title'] = $this->lang->line('rss_message_title');
        $data['rss_message_label'] = $this->lang->line('rss_message_label');
		$data['rss_message_filter_btn'] = $this->lang->line('rss_message_filter_btn');
        $data['rss_message_empty'] = $this->lang->line('rss_message_empty');
		$data['messages_wait'] = $this->lang->line('messages_wait');
		$data['rss_message_not_rcv'] = $this->lang->line('rss_message_not_rcv');
		$data['rss_message_cate_label1'] = $this->lang->line('rss_message_cate_label1');
		$data['rss_message_cate_label2'] = $this->lang->line('rss_message_cate_label2');
        return $data;
	 }	 	
	 
	 function load_tag_rss_label($lang)
	 {
	 	$common_label = $this->Load_common_label->load_common_label($lang);
	 	$this->lang->load('messages',$lang);
		$data['tag_rss_title'] = $this->lang->line('tag_rss_title');
        $data['tag_rss_label1'] = $this->lang->line('tag_rss_label1');
        $data['tag_rss_label2'] = $this->lang->line('tag_rss_label2');
		$data['tag_rss_empty'] = $this->lang->line('tag_rss_empty');
        return array_merge($common_label,$data);
	 }
	 
	 function get_feed_by_subcate()
	 {
	 	if($this->Auth->request_access_check())
		{
			$langCode = $this->input->post('langCode');
			$subcate_id = $this->input->post('subcate_id');
			$data = array('langCode'=>$langCode,'sub_cate_id'=>$subcate_id);
			$result = $this->Rss_manage->get_rss_feed_by_subcate($data);
			if(!empty($result))
			{
				$arr = array();
				foreach($result as $item)
				{
					array_push($arr,$item['rss_feed_id'].'#'.$item['title']);
				}
				echo implode('@',$arr);
			}
			else
			{
				echo '';
			}
		}
	 }
	 
	 function article_detail()
	 {
	 	$segs = $this->uri->segment_array();
		$article_id = $segs[3];
	 	$link = $this->Rss_manage->get_article_link($article_id);
		redirect($link);
	 }

  }//END OF CLASS