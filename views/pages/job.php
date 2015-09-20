<?php
echo "Job Name: " . $job->job_name."<br>";
echo "Job Description: " . $job->job_description."<br>";
echo "Job Price: " . $job->job_price."<br>";
?>
<form action = "completeJob" method="post"><input type = "hidden" name = "job_id" value = "<?php echo $job->job_id ?>"><input type = "submit" value = "Complete Job"></form><br>
<form action = "cancelJob" method="post"><input type = "hidden" name = "job_id" value = "<?php echo $job->job_id ?>"><input type = "submit" value = "Cancel Job"></form>
