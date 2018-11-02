<?php
/**
 * Created by PhpStorm.
 * User: Daan Corporaal
 * Date: 2-11-2018
 * Time: 12:22
 * @param $postcode
 * @param $number
 */

// 100 usage Api Get adress data
function GetCoordinates($postcode,$number){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.postcodeapi.nu/v2/addresses/?postcode=" . $postcode . "&number=". $number ."",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/hal+json",
            "x-api-key: gdxqmErG3w1IgW322KmLiMIR2HZxrR75XfuU8Pd5"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo '<pre>';
        echo $response;
        echo '<pre />';
    }

    $json_a = json_decode($response, true);
    echo $json_a['_embedded']['addresses'][0]['geo']['center']['wgs84']['coordinates'][0];
    echo '<br />';
    echo $json_a['_embedded']['addresses'][0]['geo']['center']['wgs84']['coordinates'][1];
}

$postcode = "5345MR";
$number = "11";

GetCoordinates($postcode,$number);