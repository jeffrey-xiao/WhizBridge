
<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 2015-09-19
 * Time: 9:30 PM
 */
//echo 'Derp';
$content = "TestTest123";
//require_once ("twilio-php/services/Twilio.php");
// set your AccountSid and AuthToken from www.twilio.com/user/account
/*$AccountSid = "ACb821cce27750bb57b5726316b4e4a7e1";
$AuthToken = "32da8a446b9da43c0a3c7b426bf20c09";

$client = new Services_Twilio($AccountSid, $AuthToken);

foreach($client->account->messages as $message) {
    echo $message->body;



}*/
$msg = $_REQUEST['Body'];
$msg = strtolower($msg);
if ($msg == 'escape') {
    //cancelWhizJob(getJobIdForPhonenumber($message->from));
    $content = "Job cancelled.";
} else if ($msg == 'complete') {
    //completeWhizJob(getJobIdForPhonenumber($message->from));
    $content = "Job completed.";
} else if ($msg == 'tech') {
    $content = "Please enter your: Name, Problem description, Address, and Price.";
}
    else if(substr($msg, 0, 5) == 'david')
    {
        $content = "Job submitted, payment processing.";
    }
    else if(substr($msg, 0, 7) == 'jeffrey')
    {
        $content = "Job submitted, payment processing.";
    }
    else if(substr($msg, 0, 6) == 'george')
    {
        $content = "Job submitted, payment processing.";
    }
    else if(substr($msg, 0, 3) == 'ben')
    {
        $content = "Job submitted, payment processing.";
    }
else {
    $content = "Unknown WhizBridge text, please try again.";
}


?>

<Response>
    <Message><?php echo $content ?></Message>
</Response>
