<?php  
   if(!defined('BASEPATH')) exit('No direct script access allowed');
   
   class Tag_extract
   {
	   function __construct()
	   {
	      
	   }
	   
	   /***********************************************************/
	   /************GET TAGS FOR ENGLISH*******************/
	   /***********************************************************/
	   
	   //retrieve tags for english text
	   //input: text
	   //return array of tags
	   function retrieve_en($text)
	   {
	      return $this->retrieve_by_textwise($text);
	   }
	   
	   //get tags by api provided by textwise
	   //input: text--question string , num--max tag numbers will be retrieved  
	   //return array of tags
	   function retrieve_by_textwise($text,$num=5)
	   {
	       $retArr = array();
			$uri = "http://api.semantichacker.com/97i5bw/concept?content=".urlencode($text);
			$file_str = file_get_contents($uri);
			
			$doc = new DOMDocument();
			$doc->loadXML($file_str);
			
			if($doc)
			{
				$nodeArr = $doc->getElementsByTagName("concept");
				$count = 0;
				
				foreach($nodeArr as $node)
				{
					  if($count < $num)
					  {
						 array_push($retArr,$node->getAttribute('label'));
						 $count++;
					  }
					  else
					  {
						 break;
					  }
				} 
			}
			return $retArr;
	   }
	   

	   /***********************************************************/
	   /************GET TAGS FOR CHINESE*******************/
	   /***********************************************************/
	   
	   //retrieve tags for chinese text
	   //input: text
	   //return array of tags
	   function retrieve_zh($text)
	   {
	      return $this->retrieve_by_splitword($text);
	   }
	   
	   //get tags by open source:SplitWord
	   //input: array('text')
	   //return array of tags
	   function retrieve_by_splitword($text)
	   {
		   $zh_words = $this->textsplit($text);
		   $zh_words = $this->trim_token($zh_words);
		   $zh_words = $this->trim_commonwords($zh_words);
		   return $zh_words;
	   }
	   
	   //split text to array of tags by SplitWord
	   //input: text
	   //return array of tags
	   function textsplit($text)
	   {
		    @header('Content-Type: text/html; charset=utf-8'); 
			//$text = iconv('utf-8','gb2312',$text);
			$text = urlencode($text);
			$result = file_get_contents("http://121.12.175.16:3030/content?text=".$text);
			//$result = iconv('gb2312','utf-8',$result);
			$retArr = explode('  ',trim($result));
			return $retArr;
	   }
	   
	   //retrieve name entity from given tags
	   //input: array of tags
	   //output: array(@entity_type=>array of entity)
	   function name_entity_retrieve($data)
	   {
	   	   $ret_data = array();
	   	   if(!empty($data))
	   	   {
			  foreach($data as $item)
			  {
			     if(!empty($item))
				 {
				    $item_arr = explode('/',$item);
					if((count($item_arr) == 2)&&(preg_match('/n/i',$item_arr[1])))
					{
					   if(!isset($ret_data[$item_arr[1]]))
					   {
					   	   $ret_data[$item_arr[1]] = array();
					   }
					   array_push($ret_data[$item_arr[1]],$item_arr[0]);
					}//if
				 }//if
			  }//foreach
			  
			  //get rid of duplicated tag
			  if(!empty($ret_data))
			  {
			     foreach($ret_data as $key=>$value)
				 {
				    $ret_data[$key] = array_unique($value);
				 }
			  }
	   	   }//if
	   	   return $ret_data;
	   }
	   
	   //trim common words from the orignal tags
	   //input: array of orignal tags
	   //return array of tags which have been trimed
	   function trim_commonwords($data)
	   {
		   $commonWords = $this->get_commonwords();
		   return $this->trim_specify_word($data,$commonWords); 
	   }
	   
	   //
	   function trim_token($data)
	   {
	      $token_arr = $this->get_token();
		   return $this->trim_specify_word($data,$token_arr); 
	   }
	   
	   //trim word item in array of $data which appears in
	   //$trim_arr,and return array of trimed data
	   function trim_specify_word($data,$trim_arr)
	   {
		   $retArr = array();
		   foreach($data as $item)
		   {
			   if(!in_array($item,$trim_arr))
			   {
			     array_push($retArr,$item);
			   }
		   }
		   return $retArr;
	   }
	   
	   //
	   function get_commonwords()
	   {
	      //for test
	      return array("的","吗","么","啊","说","对","在","和","是","被","最","所","可以","那","这","有","将","会","与","於","于","他","她","它","您","为","什么","什么地方","是什么","为什么","哪里","你","我","大家");
	   }
	   
	   //
	   function get_token()
	   {
	      //for test
		   return array("。","？","！","；","“");
	   }
	   
   }



// END Tag_extract class

/* End of file Tag_extract.php */
/* Location: ./system/application/libraries/Tag_extract.php */
