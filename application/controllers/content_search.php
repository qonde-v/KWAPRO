<?php
  class Content_search extends CI_Controller
  {
     function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('prompt');

		 $this->load->library('session');
		 $this->load->model('q2a/Search');
		 $this->load->model('q2a/Mashup_search');
		 $this->load->model('q2a/Auth');
                 $this->load->driver('cache');
	 }
     
     //match the keyword user input from tag table
     //output: json format of tag data
     function tag_match()
     {
         if($this->Auth->request_access_check())
	     {
            $keyword = $this->input->post('search',TRUE);
        
            if(!empty($keyword))
            {
			    $json_data = array();
                $tag_data = $this->Search->tag_match(array('keyword'=>$keyword, 'num'=>5));
				foreach($tag_data as $item)
				{
				    $json_data[] = array($item['tag_name'].'_'.$item['tag_id'],$item['tag_name'],null, $item['tag_name']." X ".$item['count']);
				}
				header('Content-type: application/json');
                echo json_encode($json_data);
            }
        }
     }  
	 
	 //mashup data search
	 function mashup_data_search()
	 {echo 11;
	 	if($this->Auth->request_access_check())
	 	{
	 		$keyword = $this->input->get('q',TRUE);
	 		//echo $keyword."-------";
                        $uId = $this->session->userdata('uId');
			$base = $this->config->item('base_url');
        
                        if(!empty($keyword))
                        {
                                    $json_data = array();
                                    $mashup_data = $this->Mashup_search->kwapro_box_search(array('text'=>$keyword, 'uId'=>$uId),5);
                                    if(!empty ($mashup_data))
                                    {
                                        foreach($mashup_data['search_result'] as $key=>$data)
                                        {
                                            if(!empty ($data) && !empty ($data['data']))
                                            {
                                                foreach ($data['data'] as $item)
                                                {
                                                    $json_data[] = array('type_string'=>$key.':','desc'=>$item['text'],'url'=>$base.$data['url_term'].$item['id']);
                                                    //$json_string ='{"type_string":"'.$key.'","desc":"'.$desc.'","url":"'.$data['url_term'].$item['id'].'"}';                                                   
                                                }
                                            }
                                        }
                                    }
                                    $this->cache->memcached->save($keyword, $mashup_data, 60);
                                    //echo '['.implode(',',$json_arr).']';
                                    header('Content-type: application/json');
                                    echo json_encode($json_data);
                                    
                                    

                        }
	 	}
	 }
	 
	 
	 //match user's friend
	 function friend_match()
	 {
	 	if($this->Auth->request_access_check())
	     {
            $keyword = $this->input->post('search',TRUE);
			$uId = $this->session->userdata('uId');
			$base = $this->config->item('base_url');
        
            if(!empty($keyword))
            {
			    $json_data = array();
                $friend_data = $this->Search->friend_match(array('keyword'=>$keyword,'uId'=>$uId));
				foreach($friend_data as $item)
				{
				    $json_data[] = array($item['uId'],$item['username'],null, $item['username'],$base.$item['photo_path']);
				}
				header('Content-type: application/json');
                echo json_encode($json_data);
            }
        }
	 }
     
   }//END OF CLASS