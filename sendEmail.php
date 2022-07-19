<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$name = $_GET["name"];
$title = $_GET["title"];
$date = $_GET["date"];
$length = $_GET["length"];
$abstract = $_GET["abstract"];
$bio = $_GET["bio"];
$dep = $_GET["dep"];
$zoom = $_GET["zoom"];
$mode = $_GET["mode"];

$month = date("F", strtotime($date));
$day = date('d', strtotime($date));
$time = date('ga', strtotime($date));

$info = '';

if ($mode === 'online') {
    $info = '<p>' . $day . ' ' . $month . ' at ' . $time . ', online only Via Zoom link below.</p>';
} else if ($mode === 'in-online') {
    $info = '<p>' . $day . ' ' . $month . ' at ' . $time . ', via Zoom link below and in person.</p>';
} else {
    $info = '<p>' . $day . ' ' . $month . ' at ' . $time . ', in person only.</p>';
}


$gmail_mail = new PHPMailer;

$gmail_mail->IsSMTP();
// Send email using gmail SMTP server
$gmail_mail->Host = "ssl://smtp.gmail.com";
// port for Send email
$gmail_mail->Port = 465;
$gmail_mail->SMTPDebug = 0;
$gmail_mail->SMTPAuth = true;
$gmail_mail->SMTPSecure = "tls";
$gmail_mail->Username = 'csisseminars@gmail.com';
$gmail_mail->Password = 'Info310!';

$gmail_mail->From = 'CSISSemianrs@gmail.com';
$gmail_mail->FromName = 'CSISSeminars';// frome name
$gmail_mail->AddAddress('roysa235@student.otago.ac.nz', 'Sam Royal');  // Add a recipient  to name
//$gmail_mail->AddAddress('to-gmail-address@gmail.com');  // Name is optional

$gmail_mail->IsHTML(true); // Set email format to HTML

$gmail_mail->Subject = 'CS/IS Seminars, ' . $title . ' at ' . $time;
$gmail_mail->Body = '
<p>kia ora koutou! We have another CS/IS seminar this week.</p>
<strong>Title: ' . $title . '</strong>
<br>
<strong>Time and Venue:</strong>
<p>' . $info . '</p>
<strong>Speaker:</strong>
<p>' . $name . '</p>
<strong>Abstract:</strong>
<p>' . $abstract . '</p>
<strong>Bio:</strong>
<p>' . $bio . '</p>
<strong>Zoom Invite:</strong>
<p>' . $zoom . '</p>';

$gmail_mail->AltBody = 'test';

if (!$gmail_mail->Send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $gmail_mail->ErrorInfo;
    exit;
} else {
    echo 'Message of Send email using gmail SMTP server has been sent';
    header('Location: admin.php');
    echo "<p> EMAIL SENT </p>";
}
?>