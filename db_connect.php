<?php
define('HOST', 'localhost');         //hostname
define('USER', 'yasupada_usedtv');     //username
define('PASS', 'usedtv123456');        //user password
define('DB', 'yasupada_usedtv');  //database name

$con = mysqli_connect(HOST, USER, PASS, DB) or die('Unable to Connect');
