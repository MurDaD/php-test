<?php
header('Content-Type: application/json');
$params = addslashes(htmlspecialchars($_REQUEST['params']));
$params = array_filter(explode('/', $params));

$email = $params[0];
$sum = (float)str_replace('.', ',', $params[1]);

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if(is_numeric($sum)) {
        if($sum <= 0) {
            throw_error('Wrong sum');
        }
        // All validation passed

        // Response status array (random will be chosen)
        $response_status = [
            1 => 'accepted',
            2 => 'rejected'
        ];
        // Rejected array (random will be chosen)
        $rejected_response = [
            'Fraud detected!',
            'Invalid user',
            'Not enough cash',
            'User status forbidden',
            'Bank is closed'
        ];

        // Choosing random response status
        $status = array_rand($response_status);
        if($status == 2) {      // rejected
            // Choosing random rejected response message
            $message = array_rand($rejected_response);
            throw_error($rejected_response[$message]);
        } elseif($status == 1) {                // accepted
            $message = 'Operation success';
            throw_response($message);
        } else {
            throw_error('There was some error, please try again later');
        }
    } else {
        // Sum is not correct
        throw_error('Sum is not correct');
    }
} else {
    // email is not correct
    throw_error('Email is not correct');
}

/**
 * Sending success json response
 * @param $message
 */
function throw_response($message) {
    die(json_encode([
            'status'=> 'accepted',
            'message' => $message
        ]
    ));
}

/**
 * Sending error json response
 * @param $message
 */
function throw_error($message) {
    die(json_encode([
        'status'=> 'rejected',
        'error_message' => $message
        ]
    ));
}

