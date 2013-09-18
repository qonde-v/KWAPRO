<?php

//node type
 define("QUESTION", 1);
 define("ANSWER", 2);
 define("BLOG", 3);
 define("COMMENT", 4);
 define("MESSAGE", 5);
 define("MESSAGE_REPLY", 6);

 //question send type
 define("ONLINE", 11);
 define("EMAIL", 12);
 define("GTALK", 13);
 define("SMS", 14);
 define("QQ", 15);
 define("MSN", 16);

//question collect type
define("FOLLOW", 111);

//event type
define("EVENT_TYPE_CONTENT", 1);
define("EVENT_TYPE_SEND", 2);

//message type
define("USER_MESSAGE", 1);
define("SYSTEM_MESSAGE", 2);

//message read stat
define("UN_READ", 0);
define("READ", 1);

//username match type
define("MATCH_BEGIN", 1);
define("MATCH_INCLUDE", 2);

//event process machine type
define("LOCAL", 1);
define("SERVER", 2);

//account visible type
define("ACCOUNT_PRIVATE", 0);
define("ACCOUNT_PUBLIC", 1);

//message sort type
define("SORT_BY_READ", 1);
define("SORT_BY_DATE", 2);
define("SORT_BY_USERNAME", 3);

//topic type
define("SEARCH_BY_CATEGORY", 1);
define("SEARCH_BY_SUB_CATE", 2);

//answer process type
define("USE_VOTE",1);
define("NO_USE_VOTE",2);

//recommend friend type
define("LOCATION",1);
define("TAG",2);
define("FRIEND",3);

//privacy type
define("GENDER",1);
define("BIRTHDAY",2);
define("CURRENT_LOCATION",3);
//account
/*
 define("EMAIL", 12);
 define("GTALK", 13);
 define("SMS", 14);
 define("QQ", 15);
 define("MSN", 16);
*/


/*End of file*/
/*Location: ./system/appllication/libraries/define.php*/