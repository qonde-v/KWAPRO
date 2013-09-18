<?php

//content process

//controller:user_activity_process
define("USER_FOLLOW_SUCCESS",1);
define("USER_EVER_FOLLOW",2);

//js:question_send_event
define("QUESTION_SENT",3);
define("USER_UNLOGIN",4);
define("FORGET_INPUT_QUESTION",5);
define("NOT_QUESTION_MATCH",6);
define("CONTENT_VALID",7);

define("QUESTION_DETAIL",8);
define("CONTENT_UNVALID",9);

define("INVITE_ANSWER_SEND",10);



//message

//controller:messages_request
define("MESSAGE_SEND_SUCCESS",1);
define("STAT_CHANGE_SUCCESS",2);
define("DELETE_SUCCESS",3);
define("NO_MESSAGE",4);

//js:message_event
define("CHECK_SELECT_READ",5);
define("SELECT_MESSAGE_FIRST",6);

define("MESSAGE_REPLY_FAILED",7);
define("MESSAGE_REPLY_SUCCESSED",8);

define("MESSAGE_DELETE_CHECK",9);
define("USERNAME_NOT_EXIST",10);

//friends

//controller:friends_request
define("INVITE_PROCESSED",1);
define("WRONG_EMAIL_FORMAT",2);
define("NO_USER_MATCH",3);
define("REQUEST_SENT",4);
define("ALREADY_ADDED",5);
define("ADD_SUCCESS",11);
define("INVITE_SENT_ALREADY",12);

//js:friends_event
define("SENDING_WAIT",6);
define("SAME_EMAIL_EXIST",7);
define("SEARCHING_WAIT",8);
define("REQUEST_PROCESSING_WAIT",9);
define("NO_USER_SELECT",10);

//profile

 define("UPDATE_SUCCESS", 0);//check successed
 define("FAIL_PASSWORD", 1); //password change failed
 define("FAIL_PHOTO", 2); //photo upload failed
 define("FAIL_LOCAL", 3); //location setting failed,can't be empty
 define("FAIL_TAG", 4); //tag setting failed,not any tag selected

 define("FAIL_EMAIL_FORMAT", 5); //wrong email format
 define("FAIL_ACCOUNT_USED", 6); //account has been used

 define("FAIL_GMAIL_FORMAT", 7); //wrong gmail format
 define("FAIL_MSN_FORMAT", 8); //wrong hotmail format
 define("FAIL_QQ_FORMAT", 9); //wrong qq format
 define("FAIL_SMS_FORMAT", 10); //wrong sms format
 define("FAIL_ACCOUNT_FORMAT", 11); //account has wrong format
 define("FAIL_BIRTHDAY", 12); //unvalid day selected

 define("UPDATE_FAIL",13);//update failed
 define("SUB_CATE_EXIST",14);//subcategory existed

 //login

 define("ACCOUNT_ALREADY_LOGIN",1);
 define("PASSWORD_NOT_MATCH",2);

//get password
define("EMAIL_SENT",1);
define("USERNAME_EMAIL_NOT_MATCH",2);
define("CONTENT_NOT_FINISHED",3);

//question search
define("NO_RESULT",1);

//common

//messages_request & friends_request & content_submit_process
define("PERMISSON_DENIED",21);
//controller:friends_request   js: message_event &  friends_event
define("NOTHING_INPUT",22);
define("PROCESS_SUCCESS",23);