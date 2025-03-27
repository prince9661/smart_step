<?php
$to="prince966160@gmail.com";
$subject="verification code";
$message="This is a test mail";
$from="prince1p100@gmail.com";
$headers="From: $from";
$check=mail($to,$subject,$message,$headers);
if($check)
{
    echo "Mail Sent";
}
else
{
    echo "Mail Not Sent";
}
?>