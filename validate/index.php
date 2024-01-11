<?php

include "../db/db.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["code"]) || !isset($_POST["phone"])) {
        echo json_encode(["status" => "error", "message" => "code, and phone are required"]);
        exit();
    }

    $code = $_POST["code"];
    $phone = $_POST["phone"];

    $stmt = $conn->prepare("SELECT * FROM coupon WHERE coupon_code = ? AND phone = ? AND isValid = 1");
    $stmt->bind_param("ss", $code, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usedResult = $conn->query("SELECT * FROM coupon WHERE coupon_code = '$code' AND phone = '$phone' AND isValid = 0");

        if ($usedResult->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Coupon has already been used"]);
            exit();
        }

        $stmt = $conn->prepare("UPDATE coupon SET isValid = 0 WHERE coupon_code = ? AND phone = ?");
        $stmt->bind_param("ss", $code, $phone);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Code is valid"]);
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Code is not valid"]);
        exit();
    }
} else {
    include './header.html';
    ?>

    <?php
}

?>