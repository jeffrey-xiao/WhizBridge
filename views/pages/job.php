<?php
echo $job->job_id."<br>";
echo $job->job_description."<br>";
echo $job->job_price."<br>";
?>
<form action = "completeJob" method="post"><input type = "hidden" name = "job_id" value = "<?php echo $job->job_id ?>"><input type = "submit" value = "Complete Job"></form>
<form action = "cancelJob" method="post"><input type = "hidden" name = "job_id" value = "<?php echo $job->job_id ?>"><input type = "submit" value = "Cancel Job"></form>
