<?php
include('htaccess/dbconnection.php');
if (isset($_POST['delete'])) {
    $deleteQuery = "DELETE FROM seminar_event WHERE Seminar_ID='" . $_POST['seminarID'] . "';";
    if (isset($conn)) {
        $error = $conn->query($deleteQuery);
    }
    header('Location: admin.php');
    exit;
}