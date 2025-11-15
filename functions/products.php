<?php

include 'connectdb.php';

function getAllProducts(){
    $conn = Connect();

    $query = 'SELECT * FROM product';
    $result = $conn->query($query); 
    $data=[]; //data set
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    $conn->close();
    return $data;
}

