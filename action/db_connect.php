<?php
 $db_server = "localhost";
 $db_user_name = "cs332a37";
 $db_pass = "shoonang";
 $db_name = "cs332a37";

 $output = "default";
 $db_conn = new mysqli($db_server, $db_user_name, $db_pass, $db_name);

if($db_conn->connect_error)
{
 die("Failed to connect to database: " . $db_conn->connect_error);
}


?>
