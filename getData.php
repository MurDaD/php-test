<?php
// Show errors
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

// Parse request
$request = $_REQUEST;
$email = $request['email'];
$sum = $request['sum'];

// Check if request filds are not epty
if(!empty($email) && !empty($sum)) {
    // init curl
    $ch = curl_init();

    // set url
    $url = "http://localhost/php-test/transaction/$email/$sum/";
    curl_setopt($ch, CURLOPT_URL, $url);

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);

    // close curl resource to free up system resources
    curl_close($ch);

    $res = parse_output($output);
    switch ($res->status) {
        case 'accepted':
            show_success($res->message);
            break;
        case 'rejected':
            show_error($res->error_message);
            break;
        default:
            show_error('Wrong response data from API. Code:2');
            break;
    }
} else {
    // One of the request field is empty
    show_error('Data is empty');
}

/**
 * Parsing response data
 * @param $data
 * @return mixed
 */
function parse_output($data) {
    $data = json_decode($data);
    if(is_object($data)) {
        // Returning object
        return $data;
    } else {
        // If json data is not parsed show error
        show_error('Wrong response data from API. Code:1');
    }
}

/**
 * Shows regular response without prefix
 * @param $message
 */
function show_response($message) {
    die($message);
}

/**
 * Shows success response
 * @param $message
 */
function show_success($message) {
    die('Success: '.$message);
}

/**
 * Shows error response
 * @param $message
 */
function show_error($message) {
    die('Error: '.$message);
}
