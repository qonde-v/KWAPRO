<?php
  class Send_mail extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
	    $this->load->helper('define');
	    $this->load->library('email');
	 }

	 //input: array('account','text','nId','ntId')
	 function send($data)
	 {
	   $subject = $this->generate_email_subject($data);
	   $config = $this->_get_mail_configure();
	   $this->load->library('email',$config);

		$this->email->from('kwaproq2a@gmail.com', 'kwapro');
		$this->email->to($data['account']);

		$this->email->subject($subject);
		$this->email->message($data['text']);

		$this->email->send();

		//echo $this->email->print_debugger();
	 }

	 //send email
	 //input: array('account','subject','text')
	 function send_common_mail($data)
	 {
	    $config = $this->_get_mail_configure();
	    $this->email->initialize($config);
	    $this->load->library('email');
	    
		//$this->email->mailtype = 'html';
		$this->email->from('kwaproq2a@gmail.com', 'kwapro');
		$this->email->to($data['account']);

		$this->email->subject($data['subject']);
		$this->email->message($data['text']);
        //print_r($data);
		$this->email->send();
		//echo $this->email->print_debugger();
	 }

	 //
	 function generate_email_subject($data)
	 {
	    $subject = '';
	    switch($data['ntId'])
		{
		   case QUESTION:
			  $subject = '#Q_'.$data['nId'].'#';
			  break;
		   case ANSWER:
		   case COMMENT:
			  $subject = '#R_'.$data['nId'].'#';
			  break;
		   default:
			  break;
		}
		return $subject;
	 }

	 //
	 function _get_mail_configure()
	 {
      //for test
	   $config = array();

        //$config['protocol']  = 'smtp';
		//$config['smtp_host'] = 'imap.gmail.com'; //or ssl://smtp.googlemail.com*/
		$config['smtp_user'] = 'kwaproq2a@gmail.com';
		$config['smtp_pass'] = '851212840607';
		$config['smtp_port'] = 25;
        $config['mailtype'] = 'html';
	   return $config;
	 }


  }//end of class
/*End of file*/
/*Location: ./system/appllication/model/q2a/send_mail.php*/
