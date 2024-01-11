<?php

function send_message()
{
    $body = array(
        "messaging_product" => "whatsapp",
        "recipient_type" => "individual",
        "to" => "+972524161800", // Replace with recipient's WhatsApp phone number
        "type" => "image",
        "image" => array(
            "caption" => "Your text message here", // Replace with your text message
            "url" => "https://example.com/image.jpg" // Replace with the image URL
        )
    );

    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(

            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: EAAPCmakMNjABO6qBSVt1G5AVaA5avwVL0VsDmJkpTyXgn5mBM3lYHVRDNLYLBUPFzX9W0cp3RTVvq4ofx7W0lbuFL1xxZCZAsvsfxJtiYvM5JCeksyNKdWkc2ZB8o2ALEjFAXLohRTGURn9b6plB44aNSwXvWV4d6rur6fIZB3fuW8wAS6Jbpe0vQ9QrHTEis7W36L1mIN9B78ZA81q0ZD' // Replace with your token
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($body)
        )
    );

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

?>