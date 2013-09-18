<?php
  class Sphinx_search extends CI_Model
  {
	 function __construct()
	 {
	     parent::__construct();
		 $this->load->library('sphinxclient');
		 $this->load->helper('define');
	 }
	 
	 //
	 function sphinx_basic_setting($range=array('start'=>0,'end'=>100))
	 {
	 	$this->sphinxclient->SetServer('127.0.0.1',9312);
                $this->sphinxclient->SetConnectTimeout(1);
                $this->sphinxclient->SetMatchMode(SPH_MATCH_ANY);
                $this->sphinxclient->SetArrayResult(TRUE);
                $this->sphinxclient->SetLimits($range['start'], $range['end']-$range['start']+1);
	 }
	 
	 //parse the sphinx searching result
	 //input: array of sphinx searched resut object
	 //output: array('id_arr', 'total')
	 function sphinx_result_parse($res)
         {
            $id_arr = array();
                    $total = $res['total'];
                    if(!empty($res['matches']))
                    {
                            foreach($res['matches'] as $item)
                            {
                                    array_push($id_arr, $item['id']);
                            }
                    }	 	
                    return array('id_arr'=>$id_arr, 'total'=>$total);
         }
	 
	 
	 //
	 function question_search($keyword_arr, $range=array('start'=>0,'end'=>100))
	 {
	 	$this->sphinx_basic_setting($range);
	 	$kw_str = implode(' ', $keyword_arr);
                $this->sphinxclient->ResetFilters();
	 	$this->sphinxclient->SetFilter('ntId',array(QUESTION));
	 	$res = $this->sphinxclient->Query($kw_str ,'node_main;node_delta');
	 	return $this->sphinx_result_parse($res);
	 }
	 
	 //
	 function message_search($keyword_arr, $range=array('start'=>0,'end'=>100))
	 {
	 	$this->sphinx_basic_setting($range);
	 	$kw_str = implode(' ', $keyword_arr);
	 	//todo:
	 } 
	 
	 //
	 function rss_search($keyword_arr, $range=array('start'=>0,'end'=>100))
	 {
	 	$this->sphinx_basic_setting($range);
	 	$this->sphinxclient->SetWeights(array(5,1));
	 	$kw_str = implode(' ', $keyword_arr);
                $this->sphinxclient->ResetFilters();
	 	$res = $this->sphinxclient->Query($kw_str ,'rss_main;rss_delta');
	 	return $this->sphinx_result_parse($res);
	 }
	 
	 //
	 function note_search($keyword_arr, $user_id, $range=array('start'=>0,'end'=>100))
	 {
	 	$this->sphinx_basic_setting($range);
	 	$this->sphinxclient->SetWeights(array(5,1));
	 	$kw_str = implode(' ', $keyword_arr);
                $this->sphinxclient->ResetFilters();
	 	$this->sphinxclient->SetFilter('uId',array($user_id));
	 	$res = $this->sphinxclient->Query($kw_str ,'user_note_main;user_note_delta');
	 	return $this->sphinx_result_parse($res);
	 }
	 
         /***********************************KW***********************************************/
         function sphinx_build_keyword($text)
         {
                $this->sphinx_basic_setting();
                $this->sphinxclient->SetMatchMode(SPH_MATCH_ALL);
                $this->sphinxclient->ResetFilters();
	 	$res = $this->sphinxclient->Query($text ,'node_main');
	 	return $this->sphinx_KW_parse($res);
         }
         
         //
         function sphinx_KW_parse($result)
         {
             $kw_data = array();
             if(!empty($result))
             {
                 if((isset($result['words']))&&(!empty($result['words'])))
                 {
                     foreach($result['words'] as $key=>$value)
                     {
                         array_push($kw_data, $key);
                     }
                 }
             }
             return $kw_data;
         }
         
  }//classs
  