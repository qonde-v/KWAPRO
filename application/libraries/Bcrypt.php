<?php  
   if(!defined('BASEPATH')) exit('No direct script access allowed');
   
   class Bcrypt
   {
	   function __construct()
	   {
	   }
	   
	   function _bcrypt_passwd($passwd,$salt_factor=22,$bcrypt_selector='2a',$work_factor=12)
	   {
	   	  $salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, $salt_factor);
	   	  $hash = crypt($passwd, '$'.$bcrypt_selector.'$'.$work_factor.'$'.$salt);
	   	  return $hash;
	   }
	   
	   
   }

// END Bcrypt class

/* End of file Bcrypt.php */
/* Location: ./system/application/libraries/Bcrypt.php */