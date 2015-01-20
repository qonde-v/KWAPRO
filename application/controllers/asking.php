<?php

class Asking extends CI_Controller
{        
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('q2a/Ip_location');
		$this->load->model('q2a/Auth');
		$this->load->model('q2a/Load_common_label');
		$this->load->model('q2a/Mashup_search');
		$this->load->model('q2a/Right_nav_data');
                $this->load->model('q2a/Expert_finder');
                $this->load->driver('cache');
	}
	
	function index()
	{
		$this->Auth->permission_check("login/");
		$lang = $this->Ip_location->get_language();
		$data = array();
		$data['login'] = "login";
		$data['base'] = $this->config->item('base_url');
                $uId = $this->session->userdata('uId');
		$label = $this->load_asking_label($lang);
		$common_label = $this->Load_common_label->load_common_label($lang);
		$data = array_merge($data,$label,$common_label);
		$right_data = $this->Right_nav_data->get_rgiht_nav_data($uId);
	   $data = array_merge($right_data,$data);

		$data['keyword'] = $this->input->get('search',TRUE);
		
		if(!empty ($data['keyword']))
		{
			$data['mashup_data'] = $this->search_data_request(array('uId'=>$uId,'base'=>$data['base'],'keyword'=>$data['keyword']));
			$data['expert_data'] = $this->Expert_finder->get_expert_by_topic($data['mashup_data']['tags'], $uId);

			$url="http://58.42.228.230:3307/api/web_data.php?kw=".$data['keyword'];
			$net_data = array();
			$ret=file_get_contents($url);
			$net_data=json_decode($ret,true);
			$data['net_data'] = $net_data;

		}
		$this->load->view('q2a/asking',$data);
	}
	
        //get mashup data
        //input: $para_data = array('uId','base','keyword')
        function search_data_request($para_data)
        {
            $ret_data = array();
            //if($this->Auth->request_access_check())
            {
                $uId = $para_data['uId'];
                $base = $para_data['base'];
                $keyword = $para_data['keyword'];
                
                $final_data = array();
                $ret_data = array();
                //$mashup_data = $this->cache->memcached->get($keyword);
                //if(empty($mashup_data))
                //{
                    $mashup_data = $this->Mashup_search->kwapro_box_search(array('text'=>$keyword, 'uId'=>$uId),5);
                    //$this->cache->memcached->save($keyword,$mashup_data,600);
                //}
                
                if(!empty ($mashup_data))
                {
                    $final_data['tags'] = $mashup_data['T'];
                    foreach($mashup_data['search_result'] as $key=>$data)
                    {
                        $final_data[$key] = $data['is_more'];
                        if(!empty ($data) && !empty ($data['data']))
                        {
                            foreach($data['data'] as $item)
                            {
                                $ret_data[] = array('type_string'=>$key,'desc'=>$item['text'],'time'=>$item['time'],'url'=>$base.$data['url_term'].$item['id']);
                            }
                        }
                    }
                }
				
                
            }//permission check
            $final_data['data'] = $ret_data;
            return $final_data;

        }
        
        
        //
	function load_asking_label($lang)
	{
		$this->lang->load('asking',$lang);
		
		$data['asking_page_title'] = $this->lang->line('asking_page_title');
		$data['asking_question_label'] = $this->lang->line('asking_question_label');
                $data['asking_ask_label'] = $this->lang->line('asking_ask_label');
                $data['asking_related_question'] = $this->lang->line('asking_related_question');
                $data['asking_search_result'] = $this->lang->line('asking_search_result');
                $data['asking_rss_news'] = $this->lang->line('asking_rss_news');
                $data['asking_collect_notes'] = $this->lang->line('asking_collect_notes');
                $data['asking_expert_label'] = $this->lang->line('asking_expert_label');
		$data['asking_view_more'] = $this->lang->line('asking_view_more');
		$data['asking_area_label'] = $this->lang->line('asking_area_label');
		$data['asking_no_expert_found'] = $this->lang->line('asking_no_expert_found');
		$data['asking_cant_search'] = $this->lang->line('asking_cant_search');
		$data['asking_finish_tip'] = $this->lang->line('asking_finish_tip');
		$data['asking_ask_button_title'] = $this->lang->line('asking_ask_button_title');
		
		return $data;
	}
}