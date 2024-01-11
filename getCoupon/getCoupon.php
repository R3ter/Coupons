<?php

include "../db/db.php";
include "./../getCouponInfo/getCouponInfo.php";
include "./../sendMassege/sendMassage.php"
    ?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json; charset=utf-8');
    if (!isset($_POST["phone"]) || !isset($_POST["coupon_code"]) || !isset($_POST["listingId"])) {
        echo json_encode(["status" => "error", "message" => "phone, listingId and couponId are required"]);
        exit();

    }
    $phone = $_POST["phone"];
    $listingId = $_POST["listingId"];
    $coupon_code = $_POST["coupon_code"];
    if (empty($phone) || empty($coupon_code)) {
        echo json_encode(["status" => "error", "message" => "Phone and couponId are required"]);
        exit();
    }
    if (strlen($phone) != 10 || !preg_match('/^05/', $phone) || !ctype_digit($phone)) {
        echo json_encode(["status" => "error", "message" => "Phone number must be 10 digits and start with 05"]);
        exit();
    }

    $result = $conn->query("SELECT * FROM coupon WHERE phone = '$phone' AND coupon_code = '$coupon_code'");

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "phone already have this coupon"]);
    } else {

        $couponInfo = get_coupon_info($listingId);

        if (!$couponInfo["hasCoupon"] || new DateTime() > new DateTime($couponInfo["coupon_details"]->expiry_date)) {
            echo json_encode(["status" => "error", "message" => "Coupon is invalid"]);
            exit();
        }


        $result = $conn->query("SELECT * FROM couponData WHERE id = '$coupon_code'");


        if ($result->num_rows == 0) {
            preg_match('/\((\d+)\)/', $couponInfo['coupon_details']->desc, $matches);
            $count = $matches[1];
            $conn->query("INSERT INTO couponData (id, count)" .
                "VALUES ('$coupon_code', '$count'); ");
        } else {

            $conn->query("UPDATE couponData SET count = count - 1 WHERE id = '$coupon_code' AND count > 0");

            if ($conn->affected_rows === 0) {
                echo json_encode(["status" => "error", "message" => "Coupon has been fully redeemed"]);
                exit();
            }
        }

        $query = "INSERT INTO coupon (phone, coupon_code,isValid) VALUES ('$phone', '$coupon_code',1)";
        $conn->query($query);
        echo json_encode(["status" => "success", "message" => "coupon added successfully"]);

    }


} else {
    send_message();
    echo json_encode(["status" => "error", "message" => "method not allowed"]);
}

?>