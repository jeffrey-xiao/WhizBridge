<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 2015-09-19
 * Time: 9:30 PM
 */
require ('controller.php');
require ('model.php');
$AccountSid = "ACb821cce27750bb57b5726316b4e4a7e1";
$AuthToken = "32da8a446b9da43c0a3c7b426bf20c09";

$client = new Services_Twilio($AccountSid, $AuthToken);

foreach($client->account->messages as $message) {
    //echo $message->body;
    $msg = strtolower($message->body);
    $content = "";
    if($msg == 'cancel' && getJobIdForPhonenumber($message->from) != false) {
        cancelWhizJob(getJobIdForPhonenumber($message->from));
        $content = "Job cancelled.";
    }
    else if($msg == 'complete' && getJobIdForPhonenumber($message->from) != false) {
        completeWhizJob(getJobIdForPhonenumber($message->from));
        $content = "Job completed.";
    }
    else if($msg == 'tech') {
        $content = "Please enter your: Name, Problem description, Address, and Price.";
    }
    else {
        if(!getJobIdForPhonenumber($message->from)) {
            sendSMS($message->from, "Unknown WhizBridge text, please try again.");
        }
        else {
            //Process job
        }
    }

    header("content-type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
}

?>

<Response>
    <Message><?php echo $content ?></Message>
</Response>
