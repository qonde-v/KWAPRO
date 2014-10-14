<?php
  class Mysearch extends CI_Controller
  {

   var $base = '';
	function __construct()
	 {
	     parent::__construct();
		 $this->load->database();
         $this->load->driver('cache');
		$this->load->model('q2a/Mashup_search');
		 $this->load->model('q2a/Question_data');

	 }
	 
	 
	/**
	 * 获取当前关键词的搜索结果
	 * @param $userid
	 * @param $keyword

	 */ 
	function index()
	{
		$keyword =trim($_POST["keyword"]);
 		$uId =trim($_POST["userid"]);
 		$base = $this->config->item('base_url');
        $final_data = array();
        $ret_data = array();
        $mashup_data = $this->cache->memcached->get($keyword);
        if(empty($mashup_data))
        {
			$mashup_data = $this->Mashup_search->kwapro_box_search(array('text'=>$keyword, 'uId'=>$uId),5);
            $this->cache->memcached->save($keyword,$mashup_data,600);
        }
                
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
						$answerdata = $this->Question_data->get_question_related_data($item['id']);

						$ret_data[] = array('type_string'=>$key,'desc'=>$item['text'],'url'=>$base.$data['url_term'].$item['id'],'answer'=>$answerdata);
					}
                }
            }
        }
		$final_data['data'] = $ret_data;
		echo json_encode($final_data);
	}
 }
