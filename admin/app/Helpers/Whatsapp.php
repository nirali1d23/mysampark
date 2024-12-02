<?php
 namespace App\Helpers;
 use Illuminate\Support\Facades\Http;

class Whatsapp
{
 
    public static function sendmessage($to,$url)
    {

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer OQW891APcEuT47TnB4ml0w',
            'apikey' => 'e2ce29d7-82f9-11ef-ad4f-92672d2d0c2d'
        ])->post('https://cloudapi.wbbox.in/api/v1.0/messages/send-template/918849987778', [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" =>$to,
            "type" => "template",
            "template" => [
                "name" => "image_delivery_update", // Template name
                "language" => [
                    "code" => "en" // Language code
                ],
                "components" => [
                    [
                        "type" => "header",
                        "parameters" => [
                            [
                                "type" => "image",
                                "image" => [
                                    "id" => null,
                                    "link" => $url,
                                    "caption" => null
                                ]
                            ]
                        ]
                    ],
                    [
                        "type" => "body",
                        "parameters" => [
                            [
                                "type" => "text",
                                "text" =>"Happy Diwali" // Use the variable $text for the body content, e.g., "Maha Navmi"
                            ]
                        ]
                    ]
                ]
            ]
        ]);
       
        return $response;



    }

    public static function sendotp($to,$otp)
    {



// $data = [
//     "messaging_product" => "whatsapp",
//     "recipient_type" => "individual",
//     "to" => $to,
//     "type" => "template",
//     "template" => [
//         "name" => "verification_wp",
//         "language" => [
//             "code" => "en_US"
//         ],
//         "components" => [
//             [
//                 "type" => "body",
//                 "parameters" => [
//                     [
//                         "type" => "text",
//                         "text" => $otp
//                     ]
//                 ]
//             ],
//             [
//                 "type" => "button",
//                 "parameters" => [
//                     [
//                         "type" => "text",
//                         "text" => $otp // Ensure this button text is what you want
//                     ]
//                 ],
//                 "sub_type" => "url",
//                 "index" => "0"
//             ]
//         ]
//     ]
// ];


// $ch = curl_init('https://cloudapi.wbbox.in/api/v1.0/messages/send-template/918849987778');

// // Set the options
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
// curl_setopt($ch, CURLOPT_POST, true); // Set request method to POST
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     'Content-Type: application/json',
//     'Authorization: Bearer OQW891APcEuT47TnB4ml0w',
// ]);
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Set the POST data

// // Execute the cURL request
// $response = curl_exec($ch);
// // dd($response);

// // Check for errors
// // if (curl_errno($ch)) {
// //     $errorMessage = 'cURL error: ' . curl_error($ch);
// //     curl_close($ch);
// //     return response()->json(['error' => $errorMessage], 500); // Handle the error as needed
// // }

// // Close the cURL session
// curl_close($ch);

// // Return the response
// return $response;










$domainUrl = 'https://cloudapi.wbbox.in/';
$wabaNumber = '918849987778';
$apiKey = 'OQW891APcEuT47TnB4ml0w';
$recipientPhoneNumber = $to;
$logFile = 'api_log.txt';

    $url = "$domainUrl/api/v1.0/messages/send-template/$wabaNumber";
    $data = [
        "messaging_product" => "whatsapp",
        "recipient_type" => "individual",
        "to" => "91$recipientPhoneNumber",
        "type" => "template",
        "template" => [
            "name" => "verification_wp",
            "language" => [
                "code" => "en_US"
            ],
            "components" => [
                [
                    "type" => "body",
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => $otp
                        ]
                    ]
                ],
                [
                    "type" => "button",
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => $otp
                        ]
                    ],
                    "sub_type" => "url",
                    "index" => "0"
                ]
            ]
        ]
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    // if ($response === false) {
    //     $error = 'Curl error: ' . curl_error($ch);
    //     echo $error . "\n";
    //     file_put_contents($logFile, date('Y-m-d H:i:s') . " - Error: $error\n", FILE_APPEND);
    // } else {
    //     echo 'Response: ' . $response . "\n";
    //     file_put_contents($logFile, date('Y-m-d H:i:s') . " - Response: $response\n", FILE_APPEND);
    // }
    // curl_close($ch);


 return $response;

 }
}

?>