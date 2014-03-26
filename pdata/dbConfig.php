<?php
  if(!isset($_SESSION)){
    session_start();
  }
  
  //$_SESSION['dbConnect']['host']="172.18.12.19";
  $_SESSION['dbConnect']['host']="localhost";
  $_SESSION['dbConnect']['user']="kwapro_user";
  $_SESSION['dbConnect']['pwd']="kwaprokendi851212";
  $_SESSION['dbConnect']['dbName'] = "kwaproQ2A";
  $_SESSION['pageItemNum'] = 10;
  
  //
  $_SESSION['alignLong'] = 600;
  $_SESSION['valignLong'] = 310;
  $_SESSION['alignStart'] = 50;
  $_SESSION['valueRate'] = 0.8;
  $_SESSION['vailgnNum'] = 5;
?>