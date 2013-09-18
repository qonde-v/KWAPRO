<?php
  class User_activity_process extends CI_Controller
  {
     function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('kpc_define');

		 $this->load->library('session');
		 $this->load->library('language_translate');

		 $this->load->model('q2a/Node_translation_manage');
		 $this->load->model('q2a/User_vote');

		 $this->load->model('q2a/Question_follow');
		 $this->load->model('q2a/Search');
		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/User_activity');
		 $this->load->model('q2a/Kpc_manage');
         $this->load->model('q2a/Check_process');
	 }

	 //process the activity:vote for answer
	 function activity_vote_answer()
	 {
	    if($this->Auth->request_access_check())
		{
             $nId = $this->input->post('nId',TRUE);
             $vote_type = $this->input->post('vote_type',TRUE);

	        $user_id = $this->session->userdata('uId');
	        $bool = $this->User_vote->user_vote(array('nId'=>$nId,'uId'=>$user_id,'vote_type'=>$vote_type));

	        echo $bool ? 1 : '';
		}
	 }

	 //prcoess the activity: follow question
	 function activity_follow_question()
	 {
	    if($this->Auth->request_access_check())
		{
			$time = date("Y-m-d H:i:s", time());
            $nId = $this->input->post('nId',TRUE);
            $uId = $this->input->post('uId',TRUE);
            $qctId = $this->input->post('qctId',TRUE);
			$data = array('nId'=>$nId,'uId'=>$uId,'time'=>$time,'qctId'=>$qctId);

			if($this->Question_follow->question_follow_insert($data))
			{
			   $this->User_activity->user_activity_content_update(array('uId'=>$uId,'ntId'=>FOLLOW));
			   $this->Question_follow->update_Q_follow_num($nId);
			   echo $this->Check_process->get_prompt_msg(array('pre'=>'content_process','code'=> USER_FOLLOW_SUCCESS));
			}
			else
			{
			   echo "##".$this->Check_process->get_prompt_msg(array('pre'=>'content_process','code'=> USER_EVER_FOLLOW));
			}
		}
	 }

	 //prcoess the activity: content translate
	 function activity_translate()
	 {
                if($this->Auth->request_access_check())
		{
		    $user_id = $this->session->userdata('uId');
                    $text = $this->input->post('text',TRUE);
                    $orignal_type = $this->input->post('orignal_type',TRUE);
                    $local_type = $this->input->post('local_type',TRUE);
                    $nId = $this->input->post('nId',TRUE);
                    $data = array('text'=>$text, 'orignal_type'=>$orignal_type, 'local_type'=>$local_type,'nId'=>$nId,'uId'=>0);
                    echo $this->Node_translation_manage->get_node_translate_text($data);
		}
                else
                {
                    echo "permission denied.";
                }
	 }
  }//END OF CLASS