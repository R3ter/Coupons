<?php
include "../db/db.php";

header('Content-Type: application/json; charset=utf-8');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["code"]) || !isset($_POST["couponId"])) {
        echo json_encode(["status" => "error", "message" => "code and couponId is required"]);
        exit();
    }
    $code = $_POST["code"];
    $couponId = $_POST["couponId"];

    $sql = "SELECT * FROM coupon WHERE code = '$code' AND couponId = '$couponId' and isValid = 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        $sql = "UPDATE coupon SET isValid = 0 WHERE code = '$code' AND couponId = '$couponId'";
        $conn->query($sql);

        echo json_encode(["status" => "success", "message" => "code is valid"]);
        exit();

    } else {
        echo json_encode(["status" => "error", "message" => "code is not valid"]);
        exit();
    }


} else {
    echo json_encode(["status" => "error", "message" => "method not allowed"]);
}


?>