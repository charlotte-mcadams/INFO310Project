<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="htaccess/css/styleCSIS.css">
    <title>Calendar</title>
    <meta charset="utf-8">
    <script>
        function popup(id) {
            var popup = document.getElementById(id);
            popup.classList.toggle('show');
        }
    </script>
</head>
<body>
<div>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('htaccess/header.php');
    ?>
</div>

<main></main>
<?php
include 'calendarObject.php';
$calendar = new Calendar();
echo $calendar->show();
?>
</main>
</body>
</html>
