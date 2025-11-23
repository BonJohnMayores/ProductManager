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

function findProducts($find){
    $conn = Connect();

    $query = "SELECT * FROM product WHERE p_descript LIKE '%$find%'";
    $result = $conn->query($query); 
    $data=[]; //data set
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    $conn->close();
    return $data;
}

function deleteProduct($pcode){
    $conn = Connect();

    $query = "DELETE FROM product WHERE p_code='$pcode'";
    $result = $conn->query($query); 
    $conn->close();
    if($result) return true; 
    
    return false;
}
function addProduct($pcode, $desc, $price, $stocks){
    $conn = Connect();

    $query = "INSERT INTO product
                (p_code, p_descript, p_qoh, p_price, v_code)
                VALUES
                ('$pcode','$desc', $price,$stocks, 24288)";
    $result = $conn->query($query); 
    $conn->close();
    if($result) return true; 
    
    return false;
}

function updateProduct($pcode, $desc, $price, $stocks) {
    $conn = Connect();

    $query = "UPDATE product 
              SET p_descript='$desc', 
                  p_price=$price, 
                  p_qoh=$stocks
              WHERE p_code='$pcode'";

    $result = $conn->query($query);
    $conn->close();

    return $result ? true : false;
}