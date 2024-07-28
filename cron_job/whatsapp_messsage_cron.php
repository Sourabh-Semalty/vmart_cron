<?php

require '../database.php';       // Database configuration
require '../models/ContactModel.php';    // Model class

$contactModel = new ContactModel($pdo);

function sendWhatsAppMessage($phone, $messageData)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://rcmapi.instaalerts.zone/services/rcm/sendMessage',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($messageData),
        CURLOPT_HTTPHEADER => array(
            'Authentication: Bearer NGMG0Bmpqzvcxk40p1OSbQ==',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}



$contacts = $contactModel->getAllNotSentContacts();

foreach ($contacts as $contact) {
    // Prepare the message data
    $messageData = array(
        "message" => array(
            "channel" => "WABA",
            "content" => array(
                "preview_url" => false,
                "type" => "TEMPLATE",
                "template" => array(
                    "templateId" => "testtemp",
                    "parameterValues" => array()
                )
            ),
            "recipient" => array(
                "to" => $contact['phone'],
                "recipient_type" => "individual",
                "reference" => array(
                    "cust_ref" => "Some Customer Ref",
                    "messageTag1" => "Message Tag Val1",
                    "conversationId" => "Some Optional Conversation ID"
                )
            ),
            "sender" => array(
                "from" => "918886646352"
            ),
            "preferences" => array(
                "webHookDNId" => "1001"
            )
        ),
        "metaData" => array(
            "version" => "v1.0.9"
        )
    );
    $response = sendWhatsAppMessage($contact['phone'], $messageData);
    $responseData = json_decode($response, true);

    echo $responseData;
}



?>