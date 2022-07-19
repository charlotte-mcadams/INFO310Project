<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="htaccess/css/styleCSIS.css">
    <title>Admin</title>
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
<h2> Admin </h2>
<main>
    <h3>Upcoming seminars: </h3>
    <?php
    include('htaccess/dbconnection.php');


    $sql = "SELECT * FROM seminar_event";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        echo "<table>
 
            <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Date</th>
            <th>Send Reminder</th>
            <th>Remove Seminar</th>
            </tr>";
        while ($row = mysqli_fetch_assoc($result)) {

            echo "<form action = deleteSeminar.php method=post>";
            echo '<input type ="hidden" name="seminarID" value=' . $row['Seminar_ID'] . '>';
            echo "<tr>";
            echo "<td>" . $row['Seminar_ID'] . "</td>";
            echo "<td>" . $row['Title'] . "</td>";
            echo "<td>" . $row['DateandTime'] . "</td>";
            echo "<td>" . " <a class='btn btn-primary btn-lg'  href = 'sendEmail.php?name=" . $row['Speaker_Name'] . "&date=" . $row['DateandTime'] . "&bio=" . $row['Speaker_Bio'] . "&title=" . $row['Title'] . "&abstract=" . $row['Abstract'] . "&dep=" . $row['Dep'] . "&mode=" . $row['Seminar_Type'] . "&zoom=" . $row['Zoom_Information'] . "&length=" . $row['Length'] . "' > Send</a ></td>";
            echo "<td>" . " <input type = 'submit' id = 'speakers' name = delete  value = " . 'delete' . " > </td>";
            echo "</form>";
        }
    } else {
        echo "0 results";
    }

    ?>

    <div class="logo">
        <img src="htaccess/css/CSISSeminarsLogoLightGreyZoomed.png" alt="CSIS Logo">
    </div>
</main>
</body>

</html>
