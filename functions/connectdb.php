<?php

// ========================
//  DATABASE CONFIG
// ========================
const HOST   = 'localhost';   // Server host
const USER   = 'root';        // MySQL username
const PWD    = '1234';        // MySQL password
const DBNAME = 'salecodb';    // Your DB name (salecodb.sql)

// ========================
//  MAIN DB CONNECTION FUNCTION
// ========================
function Connect()
{
    
    $mysqli = new mysqli(HOST, USER, PWD, DBNAME);

    
    if ($mysqli->connect_errno) {
        die('Database Connection Failed: ' . $mysqli->connect_error);
    }

    
    $mysqli->set_charset("utf8");

    return $mysqli;
}

// ========================
//  GLOBAL CONNECTION INSTANCE
// ========================
$mysqli = Connect();

?>