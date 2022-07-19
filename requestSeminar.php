<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="htaccess/css/styleCSIS.css">
    <title>Request a Seminar</title>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('htaccess/header.php');
    ?>
</div>
<main>
    <?php
    $formOk = true;
    $nameErr = $departmentErr = $bioErr = $descriptionErr = $emailErr = "";
    $name = $department = $bio = $description = $email = "";
    $gmailResult = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $formOk = false;
            $nameErr = "Name is required";
        } else {
            $name = input_data($_POST["name"]);
        }

        if (empty($_POST["bio"])) {
            $formOk = false;
            $bioErr = "Speaker bio is required";
        } else {
            $bio = input_data($_POST["bio"]);
        }
        if (empty($_POST["department"])) {
            $formOk = false;
            $bioErr = "Department is required";
        } else {
            $department = input_data($_POST["department"]);
        }

        if (empty($_POST["description"])) {
            $formOk = false;
            $descriptionErr = "Description is required";
        } else {
            $description = input_data($_POST["description"]);
        }

        if (empty($_POST["email"])) {
            $formOk = false;
            $emailErr = "Email is required";
        } else {
            $email = input_data($_POST["email"]);
        }
    }

    function input_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST["requestSeminar"])) {
        if ($formOk) {

            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';

            $gmail_mail = new PHPMailer;
            $gmail_mail->SMTPDebug = 0;
            $gmail_mail->IsSMTP();
            // Send email using gmail SMTP server
            $gmail_mail->Host = "ssl://smtp.gmail.com";
            // port for Send email
            $gmail_mail->Port = 465;
            $gmail_mail->SMTPAuth = true;
            $gmail_mail->SMTPSecure = "tls";
            $gmail_mail->Username = 'csisseminars@gmail.com';
            $gmail_mail->Password = 'Info310!';

            $gmail_mail->From = 'CSISSeminars@gmail.com';
            $gmail_mail->FromName = 'CSISSeminars';// frome name
            $gmail_mail->AddAddress('CSISSeminars@gmail.com', 'Request');  // Add a recipient  to name
            //$gmail_mail->AddAddress('to-gmail-address@gmail.com');  // Name is optional

            $gmail_mail->IsHTML(true); // Set email format to HTML

            $gmail_mail->Subject = 'Request for a CS/IS Seminar';
            $gmail_mail->Body = '
            <p>A new request has been made for a CS/IS Seminar.</p>
            <strong>Name: ' . $name . '</strong>
            <br>
            <strong>Department:</strong>
            <p>' . $department . '</p>
            <strong>Description:</strong>
            <p>' . $description . '</p>
            <strong>Bio:</strong>
            <p>' . $bio . '</p>
            <strong>Email Address:</strong>
            <p>' . $email . '</p>';

            if (!$gmail_mail->Send()) {
                $gmailResult = "     Could not send email please resubmit";

                exit;
            } else {
                $gmailResult = "      Request submitted!";
            }
        }
    }
    ?>

    <div class="logo">
        <img src="htaccess/css/CSISSeminarsLogoLightGreyZoomed.png" alt="CSIS Logo">
    </div>

    <div class="container">

        <div class="requestForm">

            <h1>Request a Seminar</h1>
            <br><br>


            <form id="requestForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <p><span class="error"></span><?php echo $gmailResult ?></p>

                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $name; ?>">
                <span class="error">* <?php echo $nameErr; ?></span>
                <br>

                <label for="department">Department:</label>
                <select name="department" id="department">
                    <option value="IS"> Information Science</option>
                    <option value="CS"> Computer Science</option>
                    <option value="Other"> Other</option>
                </select><br><br>

                <label for="bio">Bio:</label>
                <textarea type="text" name="bio" id="bio" value="<?php echo $bio; ?>"></textarea>
                <span class="error">* <?php echo $bioErr; ?></span>
                <br>

                <label for="description">Seminar Description:</label>
                <textarea id="description" name="description" value="<?php echo $description; ?>"></textarea>
                <span class="error">* <?php echo $descriptionErr; ?></span>
                <br>

                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="<?php echo $email; ?>">
                <span class="error">* <?php echo $emailErr; ?></span>
                <br><br>

                <input type="submit" name="requestSeminar" value="Request Seminar">
            </form>

        </div>
    </div>
</main>
</body>

</html>
