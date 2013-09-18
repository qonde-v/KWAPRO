<?php
  class Node_translation_manage extends CI_Model
  {
	    function __construct()
	    {
			parent::__construct();
			$this->load->helper('define');
			$this->load->library('language_translate');
                        $this->load->model('q2a/Content_process');
	    }

	    //get translate text from DB if exist, otherwise from google API
	    //input: $data = array('text', 'orignal_type', 'local_type','nId','uId')
	    //
         function get_node_translate_text($data)
         {
            $translated_text = '';
            $translated_text_data = $this->db_get_translate_text_data(array('langCode'=>$data['local_type'],'nId'=>$data['nId']));
            
            if(!empty($translated_text_data))
            {
                //text that translated keep the last version 
                if(!$this->translate_Is_text_update(array('nId'=>$data['nId'],'t_time'=>$translated_text_data['time'])))
                {
                    $translated_text = $translated_text_data['text'];                
                }
                else
                {
                    //update the translate text and time
                    $this->db_delete_translate_data(array('nId'=>$data['nId']));
                }
            }
            
            if(empty($translated_text))
            {
                $translated_text = $this->language_translate->translate($data);
                $this->db_insert_translated_text(array('text'=>$translated_text,'langCode'=>$data['local_type'], 'nId'=>$data['nId'], 'time'=>time(),'uId'=>$data['uId']));
            }
            
            return $translated_text;
         }

         //check if the text in 'node' is update
         //input: array('nId','t_time');
         function translate_Is_text_update($data)
         {
             $modity_time = $this->Content_process->get_text_modify_time(array('nId'=>$data['nId']));
             return ($modity_time>$data['t_time']) ? true:false;
         }
         
         //delete record of text translation by node id
         //input: array('nId')
         function db_delete_translate_data($data)
         {
             $this->db->delete('node_translation', $data);
         }
         
         
         //get translated data from table: node_translation
         //input: array('langCode','nId')
         //output: array('text','time')
         function db_get_translate_text_data($data)
         {
             $this->db->select('text,time');
             $this->db->where($data);
             $query = $this->db->get('node_translation');
             $result = array();
             if($query->num_rows() > 0)
             {
                $row = $query->row_array();
		$result = $row;
             }
             
             return $result;
             
         }
  
         //insert translated text of node into db
         //input: array('text','langCode', 'nId', 'time','uId')
         function db_insert_translated_text($data)
         {
                $this->db->insert('node_translation',$data);
         }

  }//END OF CLASS