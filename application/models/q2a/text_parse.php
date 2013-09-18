<?php
  class Text_parse extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
		$this->load->library('language_translate');
		$this->load->library('tag_extract');
		$this->load->model('q2a/Local_tag_retrieve');
		$this->load->model('q2a/Question_data');		
		$this->load->model('q2a/Keyphrase_retrieve');
		$this->load->model('q2a/Tag_process');
	 }
	 
	 //retrieve name-entity tags and location tags from init processed array of tags
	 //input: array of tags while each tag with the format '@tag/@entity_type'
	 //output: array('tag'=>array of name tags,'location'=>array of location tags)
	 function re_generate_chinese_tags($tag_arr)
	 {
	 	$result_data = array(); 
	 	$pre_tag_data = $this->tag_extract->name_entity_retrieve($tag_arr);
	 	$result_data['location'] = isset($pre_tag_data['ns']) ? $pre_tag_data['ns'] : array();
	 	$result_data['tag'] = array();
	 	
	 	foreach($pre_tag_data as $key=>$item)
	 	{//merge all the name tags together, exclude 'ns'(location tags)
	 		if('ns' != $key)
	 		{
	 			$result_data['tag'] = array_merge($result_data['tag'], $item);
	 		} 
	 	}
	 	return $result_data;
	 }

        //get question tags
	 //input: array('text','lang_code');
	 function question_tag_get($data)
	 {
	 	$tags_arr = $this->retrieve_tags($data);
	 	
	 	if($data['lang_code'] == 'zh')
                {
        	    $processed_tags = $this->re_generate_chinese_tags($tags_arr);
        	    $location_tag = $processed_tags['location'];
        	    $tags_arr = $processed_tags['tag'];
        	
        	    $tags_arr = array_merge($location_tag, $tags_arr);
                 }
                 return $tags_arr;
	 }

	 
	 //parse the input question text in the front-end
	 //input: array('text','lang_code','nId')
	 //return array('tag','local','keyphrase')
	 function parse($data)
	 {
	 	$location_tag = array();
        $tags_arr = $this->retrieve_tags($data);
        
        if($data['lang_code'] == 'zh')
        {
        	$processed_tags = $this->re_generate_chinese_tags($tags_arr);
        	$location_tag = $processed_tags['location'];
        	$tags_arr = $processed_tags['tag'];
        }
        
        $tags_arr = $this->get_keyphrases(array('lang_code'=>$data['lang_code'], 'tag'=>$tags_arr));
	    
	    $tags_arr = array_merge($tags_arr,$location_tag);
	    $this->Tag_process->tag_store4question(array('nId'=>$data['nId'],'tag'=>$tags_arr));
		return $tags_arr;
	 }
	 
	 //parse the submitted question in backend
	 //input: array('text','lang_code','nId')
	 //return array('tag','location')
	 function engine_question_parse($data)
	 {
	    $q_tags = $this->Question_data->get_question_tags($data['nId']);
		
		if(empty($q_tags))
		{
		   $this->re_parse($data);
		}
		else
		{
		    $tags_arr = explode('|',$q_tags);
			$location_arr = $this->location_tag_process(array('country_code'=>$data['lang_code'], 'tag'=>$tags_arr, 'nId'=>$data['nId']));
			$tags_arr = $this->trim_localtags($tags_arr,$location_arr);
			$key_arr = $this->key_tag_process(array('lang_code'=>$data['lang_code'], 'tag'=>$tags_arr, 'nId'=>$data['nId']));
		}
	 }
	 
	 
	 //re-process the tags for question from 
	 //table 'questiontags'
	 //input: array('text','lang_code','nId')
	 //return array('tag','location')
	 function re_parse($data)
	 {
                print_r($data);
	 	if($data['lang_code'] == 'zh')
	 	{
	 		return $this->re_parse_zh($data);
	 	}
	 	else
	 	{
	 		return $this->re_parse_not_zh($data);
	 	}
	 }
	 
	 
	 //re-process the tags for question from 
	 //table 'questiontags' for not chinese
	 //input: array('text','lang_code','nId')
	 //return array('tag','location')
	 function re_parse_not_zh($data)
	 {
	    $tags_arr = $this->retrieve_tags($data);
		
	    $location_arr = $this->location_tag_process(array('country_code'=>$data['lang_code'], 'tag'=>$tags_arr, 'nId'=>$data['nId']));
	    $tags_arr = $this->trim_localtags($tags_arr,$location_arr);
	    $key_arr = $this->key_tag_process(array('lang_code'=>$data['lang_code'], 'tag'=>$tags_arr, 'nId'=>$data['nId']));
	    $this->Tag_process->tag_store4question(array('nId'=>$data['nId'],'tag'=>array_merge($key_arr,$location_arr)));
	   
	    return array('key'=>$key_arr,'location'=>$location_arr);
	 }
	 
	 //re-process the tags for question from 
	 //table 'questiontags' for chinese
	 //input: array('text','lang_code','nId')
	 //return array('tag','location')
	 function re_parse_zh($data)
	 {
	 	        $tags_arr = $this->retrieve_tags($data);
	 	        $processed_tags = $this->re_generate_chinese_tags($tags_arr);
                $location_data = $processed_tags['location'];
                $tags_arr = $processed_tags['tag'];
        
                $location_arr = $this->location_tag_process(array('country_code'=>$data['lang_code'], 'tag'=>$location_data, 'nId'=>$data['nId']));
        
                $key_arr = $this->key_tag_process(array('lang_code'=>$data['lang_code'], 'tag'=>$tags_arr, 'nId'=>$data['nId']));
                $this->Tag_process->tag_store4question(array('nId'=>$data['nId'],'tag'=>array_merge($key_arr,$location_arr))); 
                $result_data = array('key'=>$key_arr,'location'=>$location_arr);
                
                echo '----------------TAG RESULT--------------------\n';
                     print_r($result_data);
                echo '----------------------------------------------\n';
        
                return $result_data;
	 }

	 //input: array(country_code,tag,nId)
	 //output: array of tags
	 function location_tag_process($data)
	 {
	    $location_data = $this->Local_tag_retrieve->get_location_tags($data);
		 //print_r($location_data)."<br/>";
	    $this->location_tagid_db_save(array('data_id'=>$location_data['id'],'node_id'=>$data['nId']));
	    return $location_data['tag'];
	 }
	 
	 //store location id to database
	 //array(data_id,node_id)
	 function location_tagid_db_save($data)
	 {
	    foreach($data['data_id'] as $key=>$location_items)
	    {
		   foreach($location_items as $location_item)
		   {
	         $location_item['nId'] = $data['node_id'];
			  print_r($location_item)."<br/>";
	         $this->db->insert('question_location',$location_item);
			}
	    }
	 }
	 
	 
	 //input: array(lang_code,tag,nId)
	 //output: array of tags
	 function key_tag_process($data)
	 {
	   $key_tag_arr = $this->get_keyphrases($data);
	   
	   $cate_data_arr = $this->get_keytagid_data($key_tag_arr);
	   $this->key_tagid_db_save(array('key_id'=>$cate_data_arr,'node_id'=>$data['nId']));
	   
	   $key_id_arr = $this->get_tagid_from_cate($cate_data_arr);
	   $this->key_tag_frequence_update($key_id_arr);
	   
	   return $key_tag_arr;
	 }
	 
	 //get tag id from (category_id,sub_cate_id,tag_id,tag_name)
	 //input: array of (category_id,sub_cate_id,tag_id,tag_name)
	 //output: array of tag id
	 function get_tagid_from_cate($cate_data)
	 {
	    $tag_id_arr = array();
		foreach($cate_data as $key_item)
		{
	       list($category_id,$sub_cate_id,$tag_id,$tag_name) = $key_item;
		   array_push($tag_id_arr,$tag_id);
		}
		return $tag_id_arr;
	 }
	 
	 //update the count number of tags
	 //input: array of tag id
	 function key_tag_frequence_update($data)
	 {
	   $this->Tag_process->tag_frequence_update($data);
	 }
	 
	 //get tag id for the text
	 //input: array of tag text
	 //return array of (category_id, sub_cate_id,tag_id)
	 function get_keytagid_data($data)
	 {
	   return $this->Tag_process->get_id_by_text($data);
	 }
	 
	 //array('key_id'--key_id_arr,'node_id')
	 function key_tagid_db_save($data)
	 {
	    foreach($data['key_id'] as $key_item)
	    {
		   list($category_id,$sub_cate_id,$tag_id,$tag_name) = $key_item;
		   $this->db->insert('question_tag',array('nId'=>$data['node_id'], 'tag_name'=>$tag_name, 'tag_id'=>$tag_id,'category_id'=>$category_id,'sub_cate_id'=>$sub_cate_id));
	    }
	 }
	 
	 
	 //retrieve tags from question
	 //input: array('text','lang_code')
	 //output: array of tags
	 function retrieve_tags($data)
	 {
		  $text = $data['text'];
		  $lang_code = $data['lang_code'] ? $data['lang_code']:$this->language_translate->check($text);
		  $retArr = array();  
		  
		  switch($lang_code)
		  {
		    case 'zh':
             $retArr = $this->tag_extract->retrieve_zh($text);
             break;
           case 'en':
             $retArr = $this->tag_extract->retrieve_en($text);
             break;
           default:
		     $retArr = $this->tag_extract->retrieve_en($text);
             break;
		  }//switch
		  return $retArr;
	 }
	 
	 //retrieve local tags from the given tags
	 //input: array('lang_code','tag')
	 //return array of local tags
	 function get_local_tags($data)
	 {
	    //todo:
		 return $this->Local_tag_retrieve->get_location_tags($data);
	 }
	 
	 //trim local tags in array of orignal tags
	 function trim_localtags($tags_arr,$localtag_arr)
	 {
	    return array_diff($tags_arr,$localtag_arr);
	 }
	 
	 //mapping from tags retrieved in question to 
	 //tags in database
	 //input: array of tags from question 
	 //output: array of tags mapped from question to DB
	 function tagsmap_question2DB($data)
	 {
	    //todo:
		//for test
		return $data;
	 }
	 
	 
	 //get the top n tags that represent the question
	 //input: array('lang_code','tag')
	 //return array('tags')
	 function get_keyphrases($data)
	 {
	   $kp_arr = array();
		switch($data['lang_code'])
		{
		   case 'zh':
		     $kp_arr = $this->Keyphrase_retrieve->calculate($data['tag']);
		     break;
		   case 'en':
		     $kp_arr = $data['tag'];
			  break;
			default:
			  $kp_arr = $data['tag'];
			  break;
		}
		return $kp_arr;
	 }
  }

/*End of file*/
/*Location: ./system/appllication/model/q2a/text_parse.php*/
