<?php
  class Local_tag_retrieve extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->library('language_translate');
	 }
	 
	 //get local tags from DB
	 //input: array('country_code','tag'--array of tags)
	 //output: array of local tags
	 function get_local_tags($data)
	 {
	     $local_arr = array();
	     $country_code = $data['country_code'];
		 
		 foreach($data['tag'] as $tag)
		 {
		    $is_localtag = $this->local_tag_check(array('country_code'=>$country_code, 'tag'=>$tag));
		    
			if($is_localtag)
			{
			   array_push($local_arr,$tag);
			}
		 }
		 return $local_arr;
	 }
	 
	 //get local tag by matching if current tag is 
	 //a local tag,return all the matched tags in DB
	 //input: array('country_code','tag'--tag item)
	 function local_tag_check($data)
	 {
		  $country_code = $data['country_code'];
		  $tag = $data['tag'];
		  
		  $sql="SELECT town_name FROM town_table WHERE country_code='{$country_code}' and town_name like '%{$tag}%'";
		  $query = $this->db->query($sql);
	
		  if($query->num_rows() > 0)
		  {
		     return true;
		  }
		  return false;
	 }
	 
	 //get local tags from DB
	 //input: array('country_code','tag'--array of tags)
	 //output: array of local tags
	 function get_location_tags($data)
	 {
	     $local_id_arr = array();
	     $local_tag_arr = array();
	     $country_code = $data['country_code'];
		 
		 foreach($data['tag'] as $tag)
		 {
		    $location_data = $this->location_detect_multilingual(array('country_code'=>$country_code, 'tag'=>$tag));
		    
			if(!empty($location_data))
			{
			   array_push($local_id_arr,$location_data);
			   array_push($local_tag_arr,$tag);
			}
		 }
		 return array('id'=>$local_id_arr,'tag'=>$local_tag_arr);
	 }

     //check if the tag is a location tag by matching it
	 //with other types of language
	 //input: array('tag','country_code')
	 function location_detect_multilingual($data)
	 {
	    $location_data = $this->location_tag_detect($data);
		
		//check if current tag is a location tag that input by other language
		if(empty($location_data))
		{
			$multilingual_code = $this->get_multilingual_code();
			foreach($multilingual_code as $country_code)
			{
			   if($country_code != $data['country_code'])
			   {
			      $new_tag = $this->language_translate->translate(array('text'=>$data['tag'],'orignal_type'=>$data['country_code'],'local_type'=>$country_code));
				  $location_data = $this->location_tag_detect(array('tag'=>$new_tag,'country_code'=>$country_code));
				  
				  //location tag matched
				  if(!empty($location_data))
				  {
				     break;
				  }
			   }
			}
	    }
		return $location_data;
	 }
     
	 //input: array('tag','country_code')
	 function location_tag_detect($data)
	 {
	   $tag = $data['tag'];
	   $location_data = $this->country_tag_detect($tag);
	   if(empty($location_data))
	   {
	      $location_data = $this->province_tag_detect($data);
	      if(empty($location_data))
	      {
	         $location_data = $this->city_tag_detect($data);
	         if(empty($location_data))
	         {
	            $location_data = $this->town_tag_detect($data);
	         }
	      }
	   }
	   return $location_data;
	 }
	 
	 //detect country code
	 function country_tag_detect($tag)
	 {
	   return array();
	 }
	 
	 //detect if current tag is a province-level tag
	 //input: array('tag','country_code')
	 //output: province structure data
	 function province_tag_detect($data)
	 {
	    $sql = "SELECT DISTINCT country_code,province_code FROM province_table WHERE province_name like '%{$data['tag']}%'";
	    $query = $this->db->query($sql);
	    $province_data = array();
	    
	    if($query->num_rows() > 0)
		{
		       foreach($query->result() as $row)
			   {
			       array_push($province_data, array('country_code'=>$row->country_code, 'province_code'=>$row->province_code));
			   }
		}
		return $province_data;
	 }
	 
	 //
	 function city_tag_detect($data)
	 {
	    $sql = "SELECT DISTINCT country_code,province_code,city_code FROM city_table WHERE  city_name like '%{$data['tag']}%'";
	    $query = $this->db->query($sql);
	    $city_data = array();
	    
	    if($query->num_rows() > 0)
		{
		       foreach($query->result() as $row)
			   {
			       array_push($city_data, array('country_code'=>$row->country_code, 'province_code'=>$row->province_code, 'city_code'=>$row->city_code));
			   }
		}
		return $city_data;
	 }
	 
	 //
	 function town_tag_detect($data)
	 {
	    $sql = "SELECT DISTINCT country_code,province_code,city_code,town_code FROM town_table WHERE town_name like '%{$data['tag']}%'";
	    $query = $this->db->query($sql);
	    $town_data = array();
	    
	    if($query->num_rows() > 0)
		{
		       foreach($query->result() as $row)
			   {
			       array_push($town_data, array('country_code'=>$row->country_code, 'province_code'=>$row->province_code, 'city_code'=>$row->city_code,'town_code'=>$row->town_code));
			   }
		}
		return $town_data;
	 }
	 
	 //get language code that will be used to check the location tag
	 function get_multilingual_code()
	 {
	    return array('zh','en');
	 }
  }//end of class
  
/*End of file*/
/*Location: ./system/appllication/model/local_tag_retrieve.php*/