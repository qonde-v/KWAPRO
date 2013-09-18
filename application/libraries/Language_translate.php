<?php  
   if(!defined('BASEPATH')) exit('No direct script access allowed');
   
   class Language_translate
   {
	   function __construct()
	   {
	   }
	 
	   //check language type of input string
	   //return corresponding language code
	   function check($word)
		{
		   try
		   {
				//$url = "http://ajax.googleapis.com/ajax/services/language/detect?v=1.0&q=".urlencode($word);
				//$retJsonStr = file_get_contents($url);
				//return $this->check_parse($retJsonStr);	
				return $this->detect_bing(array('text'=>$word));	
		   }
		   catch(Exception $e)
		   {
				return $e->getMessage();
		   }
		}
		
		//bing language detect
	   //input: array('text')
	   //return: language type code
	   function detect_bing($data)
	   {
	   	    //
	   	    //print_r($data);
	   	    $api = 'F0DE0CCB37335B16E7EB0BD3FA2A3C9FD3543DE5';
	   	    
	   	    if(empty($data['text']))
		    { 
		        return ''; 
		    } 
		    		     
		    $url = "http://api.microsofttranslator.com/v2/Http.svc/Detect?appId=".$api."&text=".urlencode($data['text']); 
		    
		    //echo $url;
		    
		    if (function_exists('curl_init')) 
		    { 
		        $curl = curl_init(); 
		        curl_setopt($curl, CURLOPT_URL, $url); 
		        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		        $res = curl_exec($curl); 
		    } 
		    else 
		    { 
		        $res = @file_get_contents($url); 
		    }
		   		  
		    preg_match("~<string([^><]*?)>([\s\S]*?)<\/string>~i", $res, $ostr); 
		    //print_r($ostr);
		    if (empty($ostr[2])) 
		    { 
		        return ''; 
		    } 
		    else 
		    { 
		        $code_str = htmlspecialchars_decode($ostr[2]); 
		        $arr = explode("-",$code_str);
		        return (count($arr)>1) ? $arr[0] : $code_str;
		    }  
	   }
		
		
		//parse the return data of language check function by google
		function  check_parse($jsonStr)
		{
			if($jsonStr)
			{
			     $arr = json_decode($jsonStr,true);  
				  $langType = $arr['responseData']['language'];
				  $typeArr = explode("-",$langType);
				  
				  if(count($typeArr)>1)
					{
					   return $typeArr[0];
					}
				  else
					{
					   return $langType;
					}
			}
			return "";
		}
			   
	   //translate content by bing api
	   //input: array('text','orignal_type','local_type')
	   //return: translated text string
	   function translate_bing($data)
	   {
	   	    //
	   	    //print_r($data);
	   	    $api = 'F0DE0CCB37335B16E7EB0BD3FA2A3C9FD3543DE5';
	   	    
	   	    if(empty($data['text']))
		    { 
		        return ''; 
		    } 
		    
		    if($data['orignal_type'] == 'zh')
		    {
		    	$data['orignal_type'] = 'zh-CHS';
		    }
		    
		    if($data['local_type'] == 'zh')
		    {
		    	$data['local_type'] = 'zh-CHS';
		    }

		     
		    $url = "http://api.microsofttranslator.com/v2/Http.svc/Translate?appId=".$api."&text=".urlencode($data['text']) . "&from=" . $data['orignal_type'] . "&to=" . $data['local_type']; 
		    
		    //echo $url;
		    
		    if (function_exists('curl_init')) 
		    { 
		        $curl = curl_init(); 
		        curl_setopt($curl, CURLOPT_URL, $url); 
		        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		        $res = curl_exec($curl); 
		    } 
		    else 
		    { 
		        $res = @file_get_contents($url); 
		    }
		    
		    //echo $res;
		  
		    preg_match("~<string([^><]*?)>([\s\S]*?)<\/string>~i", $res, $ostr); 
		    //print_r($ostr);
		    if (empty($ostr[2])) 
		    { 
		        return ''; 
		    } 
		    else 
		    { 
		        return htmlspecialchars_decode($ostr[2]); 
		    }  
	   }
	   
	   
	   //language translation
	   //input: array('text','orignal_type','local_type')
	   //return: translated text string
	   function translate_google($data)
		{
			try
			{
				$text = $data['text'];
				$orignal_type = $data['orignal_type'];
				$local_type = $data['local_type'];
				
				$url =  "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=".urlencode($text)."&langpair=$orignal_type|$local_type";
				$retJsonStr = file_get_contents($url);
				
				return $this->translate_parse($retJsonStr);
			}
			catch(Exception $e)
			{
				return $e->getMessage();
			}
		}
		
		//parse the language tranlation result from google API
		function translate_parse($dataStr)
		{
		   if($dataStr)
		   {
			  $arr = json_decode($dataStr,true);  
				 return $arr['responseData']['translatedText'];
		   }
		   return "";
		}
		
		
		 //language translation
	   //input: array('text','orignal_type','local_type')
	   //return: translated text string
       function translate($data)
	   {
	   	  return $this->translate_bing($data);
	   }
		
   }



// END Language_translate class

/* End of file Language_translate.php */
/* Location: ./system/application/libraries/Language_translate.php */