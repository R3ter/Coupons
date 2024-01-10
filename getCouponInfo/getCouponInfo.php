<?php
function get_coupon_info($listingID)
{
    $url = 'https://www.maqdisiapp.com/wp-json/downtown/app/listing-detial';

    header('Content-Type: application/json; charset=utf-8');
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-type: application/json\r\n" .
                "Purchase-Code: c4b55c2c-d66e-4ec7-963c-c81068e247da\r\n" .
                "Custom-Security: 20152020\r\n",
            'content' => '{"listing_id":' . $listingID . '}'
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === false) {
        return json_encode(["status" => "error", "message" => "Error fetching coupon information"]);
    }

    $response = json_decode($result);

    $coupon_details = $response->data->listing_detial->coupon_details;
    $hasCoupon = $response->data->listing_detial->listing_has_coupon;


    return ["coupon_details" => $coupon_details, "hasCoupon" => $hasCoupon];

}
?>