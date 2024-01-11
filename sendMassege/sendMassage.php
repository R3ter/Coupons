<?php

function send_massege($number)
{
    $curl = curl_init();

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => 'https://graph.facebook.com/v17.0/219355181250875/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "messaging_product": "whatsapp",
            "recipient_type":"individual",
            "to": ' . $number . ',
            "type": "image",
            "image":{
                
                "link":"https://www.maqdisiapp.com/wp-content/uploads/2018/02/logomaqdisi113134.png"
            }
        }
        ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer EAAPCmakMNjABO2qYjunT4wfDL7WOP4m0ADWKTabLAl82n6zVM3e4L1ZAd7EZAaWSU6JffJGU1XOr7B4dajxa22pgGsDiQhaFdZCZBziWVmi0gL636empL0pHZA2LMCyUZAJZAJw1rnLo6lPeubDbvtFhEskv3p2LjqyHm0AD4zi0t581PrtzRhhD1Ua2FVFdZB5ZCa2kz3HmxogG8R2Y4LZBcZD'
            ),
        )
    );

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}
?>