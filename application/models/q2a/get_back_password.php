<?php
  class Get_back_password extends CI_Model
  {
     function __construct()
     {
        parent::__construct();
        $this->load->library('encrypt');
        $this->load->database();
        $this->load->model('q2a/User_profile');
        $this->load->model('q2a/Send_mail');
        $this->load->model('q2a/Ip_location');
     }

     //check if the username is matched with the email
     //input:array('username'=>,'email'=>)
     //if matched ,return uid
     //table--'user'
     function password_account_check($data)
     {
        $this->db->select('uId');
        $this->db->where($data);
        $query = $this->db->get('user');
        if($query->num_rows() > 0)
        {//match
            $row = $query->row();
            return $row->uId;
        }
        else
        {
            return '';
        }
     }

     //check if the username is matched with the email
     //input:array('username'=>,'email'=>)
     function get_password_check($data)
     {
        if(trim($data['username']) && trim($data['email']))
        {
            return true;
        }
        else
        {
            return false;
        }
     }

     //send email for user to get back password
     //input:array('uId'=>,'username'=>,'email'=>)
     function send_password_email($data)
     {
        $new_pswd = $this->generate_new_password();
        $this->User_profile->user_passwd_update(array('uId'=>$data['uId'],'passwd'=>$new_pswd));
        $data['passwd'] = $new_pswd;
        $email_data = $this->generate_email_data($data);
        $this->Send_mail->send_common_mail(array('account'=>$data['email'],'subject'=>$email_data['subject'],'text'=>$email_data['text']));
     }

     //genereate email data
     //input:array('username'=>,'email'=>,'passwd'=>)
     function generate_email_data($data)
     {
        $lang_data = $this->load_lang_data();
        $email_subject = $lang_data['get_password_email_subject'];
        $text = $lang_data['get_password_email_text'];
        $email_text = sprintf($text,$data['username'],$data['passwd']);
        return array('subject'=>$email_subject,'text'=>$email_text);
     }

     //generate a random string
     function generate_new_password()
     {
        $result = '';
        for($i=0;$i<8;$i++)
        {
            $num = rand(97,122);
            $result .= chr($num);
        }
        for($i=0;$i<4;$i++)
        {
            $num = rand(48,57);
            $result .= chr($num);
        }
        return $result;
     }

     function load_lang_data()
     {
        $language = $this->Ip_location->get_language();
        $this->lang->load('register',$language);

        $data['get_password_email_subject'] = $this->lang->line('get_password_email_subject');
        $data['get_password_email_text'] = $this->lang->line('get_password_email_text');
        return $data;
     }


  }