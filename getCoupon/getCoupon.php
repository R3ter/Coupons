<?php
include "../db/db.php";
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json; charset=utf-8');
    if (!isset($_POST["phone"]) || !isset($_POST["couponId"])) {
        echo json_encode(["status" => "error", "message" => "phone and couponId is required"]);
        exit();

    }
    $phone = $_POST["phone"];
    $couponId = $_POST["couponId"];
    if (empty($phone) || empty($couponId)) {
        echo json_encode(["status" => "error", "message" => "Phone and couponId is required"]);
        exit();
    }
    if (strlen($phone) != 10 || !preg_match('/^05/', $phone) || !ctype_digit($phone)) {
        echo json_encode(["status" => "error", "message" => "Phone number must be 10 digits and start with 05"]);
        exit();
    }

    $result = $conn->query("SELECT * FROM coupon WHERE phone = '$phone' AND couponId = '$couponId'");

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "phone already have this coupon"]);
    } else {
        $conn->query("INSERT INTO coupon (phone, couponId) VALUES ('$phone', '$couponId')");
        echo json_encode(["status" => "success", "message" => "coupon added successfully"]);
        
    }


} else {
    echo json_encode(["status" => "error", "message" => "method not allowed"]);
}

?>