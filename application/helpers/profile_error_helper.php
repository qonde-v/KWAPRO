<?php 

 define("PROFILE_SUCCESS", 0);//check successed
 define("PROFILE_FAIL_PASSWORD", 1); //password change failed
 define("PROFILE_FAIL_PHOTO", 2); //photo upload failed
 define("PROFILE_FAIL_LOCAL", 3); //location setting failed,can't be empty
 define("PROFILE_FAIL_TAG", 4); //tag setting failed,not any tag selected
 
 define("PROFILE_FAIL_EMAIL_FORMAT", 5); //wrong email format
 define("PROFILE_FAIL_ACCOUNT_USED", 6); //account has been used
 
 define("PROFILE_FAIL_GMAIL_FORMAT", 7); //wrong gmail format
 define("PROFILE_FAIL_MSN_FORMAT", 8); //wrong hotmail format 
 define("PROFILE_FAIL_QQ_FORMAT", 9); //wrong qq format
 define("PROFILE_FAIL_SMS_FORMAT", 10); //wrong sms format
 define("PROFILE_FAIL_ACCOUNT_FORMAT", 11); //account has wrong format
 
 define("PROFILE_FAIL_BIRTHDAY", 12); //unvalid day selected
 
  /*End of file*/
  /*Location: ./system/appllication/libraries/profile_error.php*/