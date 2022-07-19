<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="htaccess/css/styleCSIS.css">

    <title>Add a Seminar</title>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function showZoomInfo() {
            var selectedType = $("#seminarType option:selected").val();
            if (selectedType === 'online' || selectedType === 'in-online') {
                $(".zoomInformation").show();
            }
            if (selectedType === 'in') {
                $(".zoomInformation").hide();
            }
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
<main>
    <?php
    $formOk = true;
    $titleErr = $timeErr = $dateErr = $speakerErr = $abstractErr = $speakerBioErr = $departmentErr = $seminarTypeErr = $zoomInformationErr = "";
    $title = $time = $date = $speaker = $abstract = $speakerBio = $department = $seminarType = $zoomInformation = "";


    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        if (empty($_POST["title"])) {
            $formOk = false;
            $titleErr = "Title is required";
        } else {
            $title = input_data($_POST["title"]);
        }


        if (empty($_POST["time"])) {
            $formOk = false;
            $timeErr = "Time is required";
        } else {
            $time = input_data($_POST["time"]);
        }

        if (empty($_POST["date"])) {
            $formOk = false;
            $dateErr = "Date is required";
        } else {
            $date = input_data($_POST["date"]);
        }

        if (empty($_POST["speaker"])) {
            $formOk = false;
            $speakerErr = "Speaker is required";
        } else {
            $speaker = input_data($_POST["speaker"]);
            if (!preg_match("/^[a-zA-Z ]*$/", $speaker)) {
                $formOk = false;
                $speakerErr = "Only letters and white space are allowed";
            }
        }


        if (empty($_POST["abstract"])) {
            $formOk = false;
            $abstractErr = "Seminar abstract is required";
        } else {
            $abstract = input_data($_POST["abstract"]);
        }

        if (empty($_POST["speakerBio"])) {
            $formOk = false;
            $speakerBioErr = "Speaker Bio is required";
        } else {
            $speakerBio = input_data($_POST["speakerBio"]);
        }
        if (isset($_POST["seminarType"]) && ($_POST['seminarType'] == 'online' || $_POST['seminarType'] == 'in-online')) {
            if (empty($_POST["zoomInformation"])) {
                $formOk = false;
                $zoomInformationErr = "A zoom link is required";
            } else {
                $zoomInformation = input_data($_POST["zoomInformation"]);
                if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $zoomInformation)) {
                    $formOk = false;
                    $zoomInformationErr = "Invalid URL";
                }
            }
        }
    }
    function input_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if (isset($_POST['addSpeaker'])) {
        if ($formOk) {
            $title = $_POST['title'];
            $dateandtime = $_POST['date'] . " " . $_POST['time'] . ":00";
            $length = $_POST['length'];
            $speakername = $_POST['speaker'];
            $description = $_POST['abstract'];
            $speakerBio = $_POST['speakerBio'];
            $seminarType = $_POST['seminarType'];
            $dep = $_POST['department'];
            echo $seminarType;
            if ($seminarType == 'online' || $seminarType == 'in-online') {
                $zoomLink = $_POST['zoomInformation'];
            } else {
                $zoomLink = null;
            }
            $query = "INSERT INTO seminar_event(Title,DateandTime,Length,Speaker_Name,Dep,Abstract,Speaker_Bio,Zoom_Information,Seminar_Type)
          VALUES (" . "'" . $title . "'" . "," . "'" . $dateandtime . "'" . "," . "'" . $length . "'" . "," . "'" . $speakername . "'" . "," . "'" . $dep . "'" . "," . "'" . $description . "'" . "," . "'" . $speakerBio . "'" . "," . "'" . $zoomLink . "'" . "," . "'" . $seminarType . "'" . ");";


            include('htaccess/dbconnection.php');
            if (isset($conn)) {
                $error = $conn->query($query);
            }
            echo '<p>Seminar Submitted</p>';
            header('Location: calendar.php');
            exit;

        }
    }


    ?>

    <div class="logo">
        <img src="htaccess/css/CSISSeminarsLogoLightGreyZoomed.png" alt="CSIS Logo">
    </div>

    <div class="container">

        <div class="addForm">

            <h1>Add a Speaker</h1>
            <br><br>

            <form id="speakerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <p><span class="error"></span></p>

                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $title; ?>">
                <span class="error">* <?php echo $titleErr; ?></span>
                <br>

                <label for="time">Time:</label>
                <input type="time" name="time" id="time" value="<?php echo $time; ?>">
                <span class="error">* <?php echo $timeErr; ?></span>
                <br>

                <label for="date">Date:</label>
                <input type="date" name="date" id="date" value="<?php echo $date; ?>">
                <span class="error">* <?php echo $dateErr; ?></span>
                <br>

                <label for="length">Length:</label>
                <select name="length" id="length">
                    <option value="15 Mins"> 15 Minutes</option>
                    <option value="30 Mins"> 30 Minutes</option>
                    <option value="45 mins"> 45 Minutes</option>
                    <option value="1 Hour"> 1 Hour</option>
                    <option value="1 Hour 15 Mins"> 1 Hour 15 Minutes</option>
                    <option value="1 Hour 30 Mins"> 1 Hour 30 Minutes</option>
                    <option value="1 Hour 45 Mins"> 1 Hour 45 Minutes</option>
                    <option value="2 Hours"> 2 Hours</option>
                </select><br>
                <br>

                <label for="speaker">Speaker:</label>
                <input type="text" name="speaker" id="speaker"<?php echo $speaker; ?>>
                <span class="error">* <?php echo $speakerErr; ?></span>
                <br>

                <label for="abstract">Abstract:</label>
                <textarea id="abstract" name="abstract"><?php echo $abstract; ?></textarea>
                <span class="error">* <?php echo $abstractErr; ?></span>
                <br>

                <label for="speakerBio">Speaker Bio:</label>
                <textarea id="speakerBio" name="speakerBio"><?php echo $speakerBio; ?></textarea>
                <span class="error">* <?php echo $speakerBioErr; ?></span>
                <br>

                <label for="department">Department:</label>
                <select name="department" id="department">
                    <option value="IS"> Information Science</option>
                    <option value="CS"> Computer Science</option>
                    <option value="Other"> Other</option>
                </select><br>


                <label for="seminarType">Seminar Delivery:</label>
                <select name="seminarType" id="seminarType" onchange="showZoomInfo()">
                    <option value="online"> Online</option>
                    <option value="in-online"> In Person and Online</option>
                    <option value="in"> In Person</option>
                </select>
                <br>


                <label for="zoomInformation" class="zoomInformation">Zoom Link:</label>
                <input id="zoomInformation" type="text" name="zoomInformation" class="zoomInformation"
                       value="<?php echo $zoomInformation; ?>">
                <span class="zoomInformation" style="color: red">* <?php echo $zoomInformationErr; ?></span>
                <br><br>

                <input type="submit" name="addSpeaker" value="Add Speaker">

            </form>

        </div>
</main>

</body>

</html>
