<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'ttuser');
   define('DB_PASSWORD', 'password');
   define('DB_DATABASE', 'tticketdb');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   
   if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
