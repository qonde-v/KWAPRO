<?php
  class Keyphrase_retrieve extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->model('q2a/Tag_process');
	 }
	
	 //get the most important tags 
	 //from the given tags
	 //input: array of tags, n--top n tags
	 //return array of calculated tags
	 function calculate($data,$n=3)
	 {
	    //consider the frequency as the factor currently
	    $cal_arr = $this->calculate_by_frequency($data);
		 return $this->get_top_tags(array('n'=>$n,'tag'=>$cal_arr));
	 }
	 
	 function calculate_by_frequency($data)
	 {
	    $arr = array();
		
	    foreach($data as $tag)
	    {
		   $num = $this->Tag_process->get_tag_frequency($tag);
		   
		   if($num > -1)
		   {
		     $arr[$tag] = $num;
		   }
	    }
		 arsort($arr);
		 return $arr;
	 }
	 
	 function get_top_tags($data)
	 {
	    $kp_arr = array();
	    $arr = array_slice($data['tag'],0,$data['n']);
		 foreach($arr as $key=>$num)
		 {
		    array_push($kp_arr,$key);
		 }
		 return $kp_arr;
	 }
	 
  }
  
/*End of file*/
/*Location: ./system/appllication/model/Keyphrase_retrieve.php*/
	 