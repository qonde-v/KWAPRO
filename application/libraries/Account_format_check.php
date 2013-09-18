<?php
   if(!defined('BASEPATH')) exit('No direct script access allowed');

   class Account_format_check
   {
	   function __construct()
	   {
	   }

	   //check the format of email
	   //input: array of email
	   function email_format_check($email_arr)
	   {
	      foreach($email_arr as $email)
		  {
		     if(!$this->valid_email($email))
			 {
			    return FALSE;
			 }
		  }
		  return TRUE;
	   }

	   function valid_username_check($username)
	   {
	   	  if(preg_match('/^[a-zA-Z0-9]{1,}$/', $username))
		  {
                     $common = strtolower($username);
		     if(!preg_match('/kwapro/i',$common))
                     {
                        return TRUE;
                     }
                     else
                     {
                        return FALSE;
                     }
		  }
		  else
		  {
		     return FALSE;
		  }
	   }

       function username_length_check($username)
       {
            if(strlen($username)>=4 && strlen($username)<=10)
            {
                return true;
            }
            else
            {
                return false;
            }
       }

       function valid_password($password)
       {
            if(strlen($password)>=6)
            {
                return true;
            }
            else
            {
                return false;
            }
       }

	   function valid_email($email)
	   {
			return (! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
	   }

	   //
	   function gmail_check($email)
	   {
		  if($this->valid_email($email))
		  {
			  return $this->specify_email_check($email,'gmail');
		  }
		  else
		  {
			  return FALSE;
		  }
	   }

	   function msn_check($email)
	   {
		  if($this->valid_email($email))
		  {
			  return $this->specify_email_check($email,'hotmail');
		  }
		  else
		  {
			  return FALSE;
		  }
	   }

	   function specify_email_check($email,$token)
	   {
			return (! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@{$token}\.[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
	   }

	   function qq_check($account)
	   {
			//todo:
			$account = trim($account);

			if(empty($account))
			{
			   return FALSE;
			}

			if(!preg_match("/^[0-9]{1,}$/",$account))
			{
			   return FALSE;
			}
			else
			{
			   return TRUE;
			}
	   }

	   //
	   function sms_check($account)
	   {
			$account = trim($account);

			if(empty($account))
			{
			   return FALSE;
			}

			if(!preg_match("/^1[0-9]{10}$/",$account))
			{
			   return FALSE;
			}
			else
			{
			   return TRUE;
			}
	   }
   }
// END Language_translate class

/* End of file Account_format_check.php */
/* Location: ./system/application/libraries/Account_format_check.php */
