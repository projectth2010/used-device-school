<?php
 define('HOST','localhost');         //hostname
 define('USER','smart_pos');     //username
 define('PASS','#######');        //user password
 define('DB','smart_pos');  //database name
 
 $con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect');

?>