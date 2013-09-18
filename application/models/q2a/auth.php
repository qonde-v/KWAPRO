<?php
  class Auth extends CI_Model
  {
	 function __construct()
	 {
	   parent::__construct();
		$this->load->library('session');
		$this->load->library('user_agent');

		$this->load->helper('define');
		$this->load->helper('url');
		$this->load->model('q2a/Session_process');
        $this->load->model('q2a/Question_data');
	 }

	 //check if current user has been login
	 //input: redirect url if user have not yet login
	 function permission_check($redirect_url)
	 {
		 if(!$this->login_check())
		 {
		    redirect($redirect_url);
		 }
	 }

	 function login_check()
	 {
	     $session_id = $this->session->userdata('session_id');
		 $sess_data = $this->Session_process->session_userdata($session_id);
		 if((isset($sess_data['status']) && ($sess_data['status'] == 'LOGIN')))
		 {
		    return TRUE;
		 }
		 else
		 {
		    return FALSE;
		 }
	 }

     //check if the user id of current user has login
	 //input: user id
	 //return true if not ever login, otherwise return false
	 function user_online_check($user_id)
	 {
	    return $this->Session_process->session_data_exist($user_id);
	 }

	 //
	 function _is_fun_access()
	 {
		 $is_browse = $this->agent->is_browser();
		 $is_robot = $this->agent->is_robot();

		 if($is_browse || $is_robot)
		 {
		    return FALSE;
		 }
		 else
		 {
		    return TRUE;
		 }
	 }

	 function _is_browse_access()
	 {
	    if($this->agent->is_browser())
		{
		   return TRUE;
		}
		else
		{
		  return FALSE;
		}
	 }

         function ie_browse_check()
         {
            /*$browser = $this->agent->browser();

            if(('MSIE' == $browser) ||('Internet Explorer' == $browser))
            {
              return TRUE;
            }
            else
            {
              return FALSE;
            }*/

            return FALSE;
         }

	 function _is_local_machine()
	 {
	    $ip_address = $this->session->userdata('ip_address');
	    return $this->_is_ip_allowed(array('127.0.0.1'),$ip_address);
	 }

	 function _is_ip_allowed($allowed_ip_arr,$visit_ip)
	 {
	     foreach($allowed_ip_arr as $ip_item)
		 {
		    if($ip_item == $visit_ip)
			{
			   return TRUE;
			}
		 }
		 return FALSE;
	 }

	 //check if the url of the request is valid request
	 //input: previous url that direct to current url
	 function request_access_check($pre_url="")
	 {
	    if($this->login_check() && $this->direct_check($pre_url))
		{
		   return TRUE;
		}
		else
		{
		   return FALSE;
		}
	 }

	 //
	 function direct_check($url)
	 {
	   if($url == "")
	   {
	      if(isset($_SERVER['HTTP_REFERER']))
		  {
		     return TRUE;
		  }
		  else
		  {
		     echo "permission denied.";
		     return FALSE;
		  }
	   }
	   else
	   {
	      if($_SERVER['HTTP_REFERER'] == $url)
		  {
		     return TRUE;
		  }
		  else
		  {
		     echo "permission denied.";
		     return FALSE;
		  }
	   }
	 }

         //check if current browser is IE
         function ie_browser_check()
{
	/*$browser = $this->agent->browser();

	if(($browser == 'MSIE')||($browser == 'Internet Explorer'))
	{
		return TRUE;
	}
	else */
	{
		return FALSE;
	}
}


	 //check if user has the permission to access the question page
	 //input: array('uId','nId');
	 function question_visible_check($data)
	 {
	     if($this->Question_data->check_node_question($data['nId']) && $this->request_access_check())
         {
            return true;
         }
         else
         {
            return false;
         }
	 }

  }//class


/*End of file*/
/*Location: ./system/appllication/model/auth.php*/
