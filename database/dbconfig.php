<?php

$db_server = 'localhost';
$db_name = 'university_platform';
$db_username = 'root';
$db_password = 'root';

function get_new_connection(){
    global  $db_server, $db_name, $db_username, $db_password;
    $connection = new mysqli($db_server, $db_username, $db_password, $db_name);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}