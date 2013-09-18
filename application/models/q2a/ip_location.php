<?php
  class Ip_location extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->library('language_translate');
		$this->load->library('ip2location');
                $this->load->library('session');
                $this->load->model('q2a/User_data');
	 }

	 //get location city name of login place
	 //input: array('lang_code','ip')
	 //return specif language type of location name
	 function get_location_city($data=array())
	 {
	    if(isset($data['lang_code']))
		{
		   $lang_code = $data['lang_code'];
		}
		else
		{
		   $lang_code = $this->config->item('language_code');
		}

		$host_ip = isset($data['ip']) ? $data['ip'] : $_SERVER["REMOTE_ADDR"];
		$location_city = $this->ip2location->get_city_name_from_ip($host_ip);
		$local_name = '';
		if($location_city)
		{
		   $local_name = $this->language_translate->translate(array('text'=>$location_city,'orignal_type'=>'en','local_type'=>$lang_code));
		}

		return (empty($local_name)) ? $location_city : strtolower($local_name);
	 }

         
    //
    function  get_language_by_code($langCode,$default_lang='')
    {
        $language = '';
        switch($langCode)
        {
            case 'zh':
            case 'CHN':
               $language = 'chinese';
               break;
           
            case 'de':
            case 'DEU':
               $language = 'german';
               break;
           
            case 'it':
            case 'ITA':
               $language = 'italian';
               break;
            case 'en':
                $language = 'english';
                break;
            default :
                $language = $default_lang;
        }
        return $language;
    }
         
    //
    function get_code_by_language($language)
    {
        $code = '';
        switch($language)
        {
            case 'chinese':
                $code = 'zh';
                break;
            case 'german':
                $code = 'de';
                break;
            case 'english':
                $code = 'en';
                break;
            case 'italian':
                $code = 'it';
                break;
            default :
                $code = 'zh';
                break;
        }
        return $code;
    }
    
    //     
    function get_language_by_setting($user_id)
    {
        $language = '';
        if($user_id)
        {
            $langCode = $this->User_data->get_user_langcode($user_id);
            $language = (!empty ($langCode)) ? $this->get_language_by_code($langCode):'';
        }
        return $language;
    }
     
    //
    function get_language_by_session()
    {
        $language = $this->session->userdata('language');
        return $language;
    }
    
    //
    function get_language_by_config()
    {
        $language = $this->config->item('language'); 
        return $language;
    }
    
    //
    function get_language_by_ip($host_ip='')
    {
        $language = '';
        $host_ip = ($host_ip=='') ? $_SERVER["REMOTE_ADDR"] : $host_ip;
        if($host_ip=='127.0.0.1')
        {
            $language = $this->get_language_by_config();
        }
        else
        {
            $ip = sprintf("%u",ip2long($host_ip));
            $this->db->select('country');
            $this->db->where('ip_start <=',$ip);
            $this->db->where('ip_end >=',$ip);
            $query = $this->db->get('ip_address_range');
            if($query->num_rows() > 0)
            {
            		$row = $query->row();
                        $language = $this->get_language_by_code($row->country,'english');
            }            
        }
        return $language;
    }
    
    
    
     //get language type of login place
     //input: $host_ip
     //return language type
     function get_language($host_ip='',$user_id='')
     {
        $language = '';
        $language = $this->get_language_by_session();
        
        if(empty ($language))
        {
            if(!empty ($user_id))
            {//get user's language setting for the login event
                $language = $this->get_language_by_setting($user_id);
            }
            
            if(empty ($language))
            {//get the language version by ip location for anonymous
                $language = $this->get_language_by_ip($host_ip);
            }
        }
        
        if(empty ($language))
        {//if nothing works for the language catching, then get it from config
            $language = $this->get_language_by_config();
        }
        
        return $language;
     }
   }
   //END OF CLASS