<?php
  class Mashup_search extends CI_Model
  {
         var $is_question_more = 0;
		 var $is_news_more = 0;
		 var $is_demand_more = 0;
         var $is_rss_more = 0;
         var $is_note_more = 0;
         var $is_user_more = 0;
         
         var $question_url_prex = 'question/';
         var $rss_url_prex = 'rss_message/article_detail/';
         var $note_url_prex = 'note/';
         var $user_url_prex = 'user_information/index/';
         
	 function __construct()
	 {
	    parent::__construct();
            $this->load->helper('define');
	    $this->load->model('q2a/Text_parse');
	    $this->load->model('q2a/Sphinx_search');
            $this->load->model('q2a/Tag_process');
            $this->load->model('q2a/Question_data');
			$this->load->model('q2a/News_data');
			$this->load->model('q2a/Demand_management');
            $this->load->model('q2a/Rss_manage');            
            $this->load->model('q2a/Note_manage');
            $this->load->model('q2a/Search');
         }
	 
         function init_para()
         {
             $this->is_question_more = 0;
			 $this->is_news_more = 0;
			 $this->is_demand_more = 0;
             $this->is_rss_more = 0;
             $this->is_note_more = 0;
             $this->is_user_more = 0;
         }
         
	 //search mashup data for input content in search-box
	 //input: array('text','uId')
	 //output: (array('Q','R','N','U'),'T')
	 function kwapro_box_search($data,$num=5)
	 {
                $this->init_para();
                //retrieve keyword from given text string
                $tag_data = $this->kwapro_KW_retrieve($data['text']);
                
                if(empty($tag_data))
                {
                    $tag_data = array($data['text']);
                }
                
                //retrieve mashup data from Q,R,N,U part
                $question_data = $this->kwapro_Question_search($tag_data,$num);
                $question_data = array('data'=>$question_data,'url_term'=>'question/','is_more'=>$this->is_question_more);

				$news_data = $this->kwapro_News_search($tag_data,$num);
                $news_data = array('data'=>$news_data,'url_term'=>'news/news_detail?id=','is_more'=>$this->is_news_more);

				$demand_data = $this->kwapro_Demand_search($tag_data,$num);
                $demand_data = array('data'=>$demand_data,'url_term'=>'demand/demand_detail?id=','is_more'=>$this->is_demand_more);

				$design_data = $this->kwapro_Design_search($tag_data,$num);
                $design_data = array('data'=>$design_data,'url_term'=>'design/design_detail?id=','is_more'=>$this->is_design_more);
                
                $rss_data = $this->kwapro_RSS_search($tag_data,$num);
                $rss_data = array('data'=>$rss_data, 'url_term'=>'rss_message/article_detail/','is_more'=>$this->is_rss_more);
                
                $note_data = $this->kwapro_Note_search($tag_data,$data['uId'],$num);
                $note_data = array('data'=>$note_data, 'url_term'=>'note/','is_more'=>$this->is_note_more);
                
                $user_data = $this->kwapro_User_search($data['text'],$num);
                $user_data = array('data'=>$user_data,'url_term'=>'user_information/index/','is_more'=>$this->is_user_more);
                
                //return mashup data as search result
                $mashup_data = array('Q'=>$question_data, 'D'=>$demand_data, 'N'=>$news_data, 'S'=>$design_data);
                return array('search_result'=>$mashup_data,'T'=>$tag_data);
               
	 }
         
         
         //get keyword from given text
	 //input: text
	 //output:array of tags
         function kwapro_KW_retrieve($text)
         {
             $tag_data = $this->Sphinx_search->sphinx_build_keyword($text);
             $new_tag_data = $this->kwapro_KW_Freq($tag_data);
             return $this->kwapro_KW_filter($new_tag_data,4);
         }
         
         //get frequency of tag in DB
         //input: array of tag data
         //output: array('lto'=>array,'sto'=>array)
         function kwapro_KW_Freq($tag_data)
         {
             $lto_array = array();
             $sto_array = array();
             
             foreach($tag_data as $tag)
             {
                $count = $this->Tag_process->get_tag_frequency($tag);
                if($count<0)
                {
                    $sto_array[$tag] = $count;
                }
                else
                {
                    $lto_array[$tag] = $count;                    
                }
             }
             return array('lto'=>$lto_array, 'sto'=>$sto_array);
         }
         
         function kwapro_KW_retrieve_info($tag_data)
         {
             $tag_info_arr = $this->Tag_process->get_id_by_text($tag_data);
             
         }
         
         
         //
         function kwapro_KW_filter($data,$num=4)
         {
             $tag_data = array();
             if(!empty($data))
             {
                 if(isset($data['lto']) && !empty($data['lto']))
                 {
                     arsort($data['lto']);
                     foreach ($data['lto'] as $key => $value) 
                     {
                         if(count($tag_data)<$num)
                         {
                             array_push($tag_data, $key);
                         }
                     }
                 }
             }
             return $tag_data;
         }
         
         
	 //search question data for input content in search-box
	 //input: array of tags
	 //output:array(array('id','text'))
	 function kwapro_Question_search($data,$num)
	 {
                $ret_data = array();
	 	$res = $this->Sphinx_search->question_search($data);
                if(!empty($res) && isset($res['id_arr']))
                {
                    $total = isset($res['total']) ? $res['total'] : 0;
                    $this->is_question_more = ($total>$num) ? 1:0;
                    $total = ($total>$num) ? $num : $total; 
                            
                    $qid_data = array_slice($res['id_arr'],0, $total);
                    if(!empty($qid_data))
                    {

                        $ret_data = $this->Question_data->get_question_text_id($qid_data);
                    }
                }
                return $ret_data;
	 }	

	 function kwapro_News_search($data,$num)
	 {
                $ret_data = array();
	 			$res = $this->Sphinx_search->news_search($data);
                if(!empty($res) && isset($res['id_arr']))
                {
                    $total = isset($res['total']) ? $res['total'] : 0;
                    $this->is_news_more = ($total>$num) ? 1:0;
                    $total = ($total>$num) ? $num : $total; 
                            
                    $qid_data = array_slice($res['id_arr'],0, $total);
                    if(!empty($qid_data))
                    {

                        $ret_data = $this->News_data->get_news_text_id($qid_data);
                    }
                }
                return $ret_data;
	 }
	 function kwapro_Demand_search($data,$num)
	 {
                $ret_data = array();
	 			$res = $this->Sphinx_search->demand_search($data);
                if(!empty($res) && isset($res['id_arr']))
                {
                    $total = isset($res['total']) ? $res['total'] : 0;
                    $this->is_demand_more = ($total>$num) ? 1:0;
                    $total = ($total>$num) ? $num : $total; 
                            
                    $qid_data = array_slice($res['id_arr'],0, $total);
                    if(!empty($qid_data))
                    {

                        $ret_data = $this->Demand_management->get_demand_text_id($qid_data);
                    }
                }
                return $ret_data;
	 }	
	 function kwapro_Design_search($data,$num)
	 {
                $ret_data = array();
	 			$res = $this->Sphinx_search->design_search($data);
                if(!empty($res) && isset($res['id_arr']))
                {
                    $total = isset($res['total']) ? $res['total'] : 0;
                    $this->is_design_more = ($total>$num) ? 1:0;
                    $total = ($total>$num) ? $num : $total; 
                            
                    $qid_data = array_slice($res['id_arr'],0, $total);
                    if(!empty($qid_data))
                    {

                        $ret_data = $this->Demand_management->get_design_text_id($qid_data);
                    }
                }
                return $ret_data;
	 }	
         
         
         //search question data for 'more' operation
	 //input: array of tags, array('start','end')
	 //output:array('data'=>('id','text','time'),'total','url_prex')
	 function kwapro_Question_range_search($data,$range)
	 {
                $ret_data = array();
                $total = 0;
	 	$res = $this->Sphinx_search->question_search($data,$range);
                
                if(!empty($res) && isset($res['id_arr']))
                {
                    $total = isset($res['total']) ? $res['total'] : 0;
                    if(!empty ($res['id_arr']))
                    {
                        $ret_data = $this->Question_data->get_question_text_id($res['id_arr']);
                    }
                }
                return array('url_prex'=>$this->question_url_prex, 'data'=>$ret_data, 'total'=>$total);
	 }	

         
         //search RSS data for input content in search-box
	 //input: array of tags
	 //output:array(array('id','text'))
	 function kwapro_RSS_search($data,$num)
	 {
                $ret_data = array();
	 	$res = $this->Sphinx_search->rss_search($data);
                if(!empty($res) && isset($res['id_arr']))
                {
                    $total = isset($res['total']) ? $res['total'] : 0;
                    $this->is_rss_more = ($total>$num) ? 1:0;
                    $total = ($total>$num) ? $num : $total; 
                    
                    $rid_data = array_slice($res['id_arr'],0, $total);
                    if(!empty($rid_data))
                    {
                        $ret_data = $this->Rss_manage->get_rss_text_id($rid_data);
                    }
                }
                return $ret_data;
	 }	
	 
         //search RSS data for 'more' operation
	 //input: array of tags, array('start','end')
	 //output:array('data'=>('id','text','time'),'total','url_prex')
	 function kwapro_RSS_range_search($data,$range)
	 {
                $ret_data = array();
                $total = 0;
	 	$res = $this->Sphinx_search->rss_search($data,$range);
                if(!empty($res) && isset($res['id_arr']))
                {
                    $total = isset($res['total']) ? $res['total'] : 0;
                    $ret_data = array();
                    if(!empty ($res['id_arr']))
                    {
                        $ret_data = $this->Rss_manage->get_rss_text_id($res['id_arr']);                   
                
                    }
                }
                return array('url_prex'=>$this->rss_url_prex,'data'=>$ret_data,'total'=>$total);
	 }	
         
	 //search note data for input content in search-box
	 //input: array of tags, user id
	 //output:array(array('id','text'))
	 function kwapro_Note_search($data,$user_id,$num)
	 {
                $ret_data = array();
	 	$res = $this->Sphinx_search->note_search($data,$user_id);
                if(!empty($res) && isset($res['id_arr']))
                {
                    $total = isset($res['total']) ? $res['total'] : 0;
                    $this->is_note_more = ($total>$num) ? 1:0;
                    $total = ($total>$num) ? $num : $total; 
                    
                    $noteid_data = array_slice($res['id_arr'],0,$total);
                    if(!empty($noteid_data))
                    {
                        $ret_data = $this->Note_manage->get_note_text_id($noteid_data);
                
                    }
                }
                return $ret_data;
	 }	
         
         //search Note data for 'more' operation
	 //input: array of tags, user id, array('start','end')
	 //output:array('data'=>('id','text','time'),'total','url_prex')
	 function kwapro_Note_range_search($data,$user_id,$range)
	 {
                $ret_data = array();
                $total = 0;
	 	$res = $this->Sphinx_search->note_search($data, $user_id, $range);
                if(!empty($res) && isset($res['id_arr']))
                {
                    $total = isset($res['total']) ? $res['total'] : 0;
                    $ret_data = array();
                    if(!empty ($res['id_arr']))
                    {
                        $ret_data = $this->Note_manage->get_note_text_id($res['id_arr']);                                  
                    }
                }
                return array('url_prex'=>$this->note_url_prex, 'data'=>$ret_data, 'total'=>$total);
	 }	
         
         
         //search user data for input content in search-box
	 //input: username string
	 //output:array(array('id','text'))
	 function kwapro_User_search($text,$num)
	 {
             $ret_data = array();
             $user_data = $this->Search->search_username(array('match_str'=>$text,'match_type'=>MATCH_BEGIN));
             $total = count($user_data);
             $this->is_question_more = ($total>$num) ? 1:0;

             if(!empty ($user_data))
             {
                 $count = 0;
                 foreach($user_data as $key=>$value)
                 {
                     if($count<$num)
                     {
                        array_push($ret_data, array('id'=>$key,'text'=>$value));
                        $count++;
                     }
                 }
             }
             return $ret_data;
	 }	
         
	 
  }//class
/*End of file*/
/*Location: ./system/appllication/model/q2a/mashup_search.php*/
