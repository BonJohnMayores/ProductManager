<?php
require_once 'connectdb.php';

function addOrder($cus_code, $inv_subtotal, $inv_tax, $inv_total) {
    global $mysqli;

    $stmt = $mysqli->prepare("
        INSERT INTO invoice (cus_code, inv_date, inv_subtotal, inv_tax, inv_total)
        VALUES (?, NOW(), ?, ?, ?)
    ");

    if (!$stmt) return false;

    $stmt->bind_param("sddd", $cus_code, $inv_subtotal, $inv_tax, $inv_total);

    return $stmt->execute();
}

function getAllOrders() {
    global $mysqli;

    $sql = "SELECT 
                i.inv_number,
                i.cus_code,
                c.cus_fname,
                c.cus_lname,
                i.inv_date,
                i.inv_subtotal,
                i.inv_tax,
                i.inv_total
            FROM invoice i
            LEFT JOIN customer c ON i.cus_code = c.cus_code
            ORDER BY i.inv_date DESC, i.inv_number DESC";

    $result = $mysqli->query($sql);
    $orders = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }
    return $orders;
}