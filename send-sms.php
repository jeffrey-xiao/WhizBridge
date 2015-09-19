<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 2015-09-19
 * Time: 1:00 AM
 */
require "twilio-php/services/Twilio.php";
// set your AccountSid and AuthToken from www.twilio.com/user/account
$AccountSid = "ACb821cce27750bb57b5726316b4e4a7e1";
$AuthToken = "32da8a446b9da43c0a3c7b426bf20c09";

$client = new Services_Twilio($AccountSid, $AuthToken);

$message = $client->account->messages->create(array(
    "From" => "+1 844-326-7428",
    "To" => "647-262-0171",
    "Body" => "Ben you can smd!",
));

// Display a confirmation message on the screen
echo "Sent message {$message->sid}";
?>