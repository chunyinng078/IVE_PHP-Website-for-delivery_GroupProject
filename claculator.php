<?php
function calculate($accountCreationDate){
    // libcurl — transfer library that sends HTTP requests
// check if library curl is enabled
    if (!extension_loaded("curl")) {
        die("enable library curl first");
    }

    $createDate = $accountCreationDate;
    $url = "http://127.0.0.1:8080/api/discountCalculator/$createDate";   # URL is to make GET request to Python RESTful API

// Initializes a new cURL session
    $curl = curl_init($url);   # Initialize a cURL session
// to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);   # Perform a cURL session
    curl_close($curl);

// Assume response data is in JSON format
    $rate = json_decode($response, true);
    $rate = $rate['discountRate'];      //$rate will store in here

    //var_dump($rate);
    return $rate;
}

?>
