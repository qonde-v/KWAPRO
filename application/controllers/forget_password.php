<?php
  class Forget_password extends CI_Controller
  {

   var $base = '';
    function __construct()
     {
         parent::__construct();
         $this->load->helper('url');
         $this->load->database();
         $this->load->library('session');
         $this->load->model('q2a/Auth');
         $this->load->model('q2a/Right_nav_data');
         $this->load->model('q2a/Load_common_label');
         $this->load->model('q2a/Check_process');
         $this->load->model('q2a/Get_back_password');
         $this->load->model('q2a/Ip_location');
     }

    function index()
    {
        $base = $this->config->item('base_url');
        $language = $this->Ip_location->get_language();
        //$data= array('username'=> $_POST['username'],'email'=> $_POST['email']);
        //if(!$this->get_password_check($data))
        {
          $data['base'] = $base;
          $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id="");
          $label = $this->load_label($language);
          $data = array_merge($data,$right_data,$label);
          $data['css_name'] = $this->Auth->ie_browser_check() ? $this->config->item('css4ie') : 'css';
          $this->load->view('q2a/forget_password',$data);
        }
    }

    //get back user's password
    function get_back_password()
    {
        foreach($_POST as $key => $value)
		{
		    $post_value = $this->input->post($key,TRUE);
			$post_arr[$key] = $post_value;
		}
        if($this->Get_back_password->get_password_check($post_arr))
        {
            $uId = $this->Get_back_password->password_account_check($post_arr);
            if($uId)
            {
                $this->Get_back_password->send_password_email(array('uId'=>$uId,'username'=>$post_arr['username'],'email'=>$post_arr['email']));
                echo $this->Check_process->get_prompt_msg(array('pre'=>'get_password','code'=> EMAIL_SENT));
            }
            else
            {
                echo $this->Check_process->get_prompt_msg(array('pre'=>'get_password','code'=> USERNAME_EMAIL_NOT_MATCH));;
            }
        }
        else
        {
            echo $this->Check_process->get_prompt_msg(array('pre'=>'get_password','code'=> CONTENT_NOT_FINISHED));
        }
    }

    function load_label($lang)
    {
        $label = $this->load_get_pswd_label($lang);
        $common_label = $this->Load_common_label->load_common_label($lang);
        $result = array_merge($label,$common_label);
        return $result;
    }

    function load_get_pswd_label($lang)
    {
        $this->lang->load('register',$lang);
        $data['get_password_title'] = $this->lang->line('get_password_title');
        $data['get_password_label'] = $this->lang->line('get_password_label');
        $data['get_password_username'] = $this->lang->line('get_password_username');
        $data['get_password_email'] = $this->lang->line('get_password_email');
        $data['get_password_submit_button'] = $this->lang->line('get_password_submit_button');
        $data['get_password_wait'] = $this->lang->line('get_password_wait');
        return $data;
    }
 }

 /*End of file*/
  /*Location: ./system/appllication/controller/forget_password.php*/
