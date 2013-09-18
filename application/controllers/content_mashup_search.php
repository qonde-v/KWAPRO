<?php
  class Content_mashup_search extends CI_Controller
  {

	 var $pre_question_num = 0;

         function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->library('session');
		 $this->load->model('q2a/Question_process');
		 $this->load->model('q2a/Question_data');
                 $this->load->model('q2a/Mashup_search');
		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Right_nav_data');
                 $this->load->model('q2a/Load_common_label');
                 $this->load->model('q2a/Ip_location');
	 }
         
         //
         function index()
         {
               $base = $this->config->item('base_url');
               $language = $this->Ip_location->get_language();
               //login permission check
               $this->Auth->permission_check("login/");

               //get current login user id
               $user_id = $this->session->userdata('uId');

               $data = array('base'=>$base);
               $data['login'] = "login";
               $data['language'] = $language;
               
               //generate question view data
               $type = $this->input->get('type',TRUE);
               $kw_str = $this->input->get('kw',TRUE);
               $index = $this->input->get('index',TRUE);
               
               $data['content_data'] = $this->generate_search_view(array('type'=>$type,'kw'=>$kw_str,'index'=>$index,'uId'=>$user_id));
              
               
               $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
               $label = $this->load_label($language);
               $data = array_merge($right_data,$data,$label);
               $this->load->view('q2a/mashup_content_more_temp',$data);  
         }
         
         
         //input: array('type','kw','index','uId')
         //output: array('data'=>('id','text','time'),'total','url_prex','start','end')
         function generate_search_view($data)
         {
            //
             $kw_arr = array(); 
             if(isset($data['kw']))
             {
                $buffer =  explode('+',$data['kw']);
                foreach ($buffer as $item)
                {
                   $kw_arr[] = urldecode($item);
                }
             }
            
             // 
             $index = empty($data['index']) ? 1 : $data['index'];
             if($data['index']<0)
             {
                 return array('total'=>0);
             }
             
             //get the content number that will display in page
             $pre_num = $this->get_display_content_num($data['type']);
             $range = array('start'=>($index-1)*$pre_num,'end'=>($index*$pre_num-1));

             //
             $search_data = $this->generate_search_data(array('type'=>$data['type'],'kw'=>$kw_arr,'index'=>$index,'uId'=>$data['uId']),$range);             
             

             //get the pagination number display in the footer of the page
             $display_num = $this->config->item('pre_pagination_num');
             $total = $this->page_num_calculate($search_data['total'],$pre_num);
             $pagination_data = $this->get_page_data(array('index'=>$index,'total'=>$total,'display_num'=>$display_num));
             list($start,$end) = $pagination_data;
             
             $result = $search_data;
             $result['total'] = $total;
             $result['start'] = $start;
             $result['end'] = $end;
             
             return $result;
         }
         
         //
         //
         function page_num_calculate($total,$pre_num)
         {
            if($total == 0)
            {
                return 1;
            }
            return ($total % $pre_num == 0) ? ($total/$pre_num) : (floor($total/$pre_num)+1);
         }
         
         //
         function get_display_content_num($content_type)
         {
             return $this->config->item('pre_view_more_num');
         }
         
         
         //input: 
         //     @data:array('type','kw','index','uId')
         //     @range: array('start','end')
         //output: array('data','total')
         function generate_search_data($data,$range)
         {
            $result = array('data'=>array(),'total'=>0,'url_prex'=>'');
            if(isset($data['type']))
            {
                switch($data['type'])
                {
                    case 'Q':                        
                        $result = $this->Mashup_search->kwapro_Question_range_search($data['kw'],$range);
                        break;
                    case 'R':
                        $result = $this->Mashup_search->kwapro_RSS_range_search($data['kw'],$range);
                        break;
                    case 'N':
                        $result = $this->Mashup_search->kwapro_Note_range_search($data['kw'],$data['uId'],$range);
                        break;
                    default :
                        break;
                }
            }
            return $result;
         }
         
         //input: array('index','total','display_num');
         //output: array(start_val,end_val)
         function get_page_data($data)
         {
             $start = 1;
             $end = $data['display_num'];
             
             if($data['total'] < $data['display_num'])
             {
                 $end = $data['total'];
             }
             else
             {
                 $half_dis = floor($data['display_num']/2);
                 $start = $data['index'] - $half_dis;
                 $end = $data['index'] + $half_dis;
                 
                 if($end>$data['total'])
                 {
                     $end = $data['total'];
                     $start = $data['total']-$data['display_num']+1;
                 }
                 else
                 {
                     if($start<1)
                     {
                         $start = 1;
                         $end = $data['display_num'];
                     }
                 }
             }
             return array($start,$end);
         }
         
         //
         function load_label($lang)
         {
             $ms_label = $this->load_mashup_search_label($lang);
             $common_label = $this->Load_common_label->load_common_label($lang);
             $result = array_merge($ms_label, $common_label);
             return $result;
         }
         
         function load_mashup_search_label($lang)
         {             
             return array();
         }
  }
  /*End of file*/
  /*Location: ./system/appllication/controller/question_filter.php*/