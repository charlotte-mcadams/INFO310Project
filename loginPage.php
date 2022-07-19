<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="htaccess/css/loginCSS.css">
    <title>Login</title>
    <meta charset="utf-8">
</head>
<body>

<div id="container">
    <div id="login">
        <div class="logo">
            <img src="htaccess/css/CSISSeminarsLogoDarkZoomed.png" alt="CSIS Logo">
        </div>
        <h1>Log In</h1>

        <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="loginUser">Username:</label><br><br>
            <input type="text" name="loginUser" id="loginUser"><br>
            <label for="loginPassword">Password:</label><br><br>
            <input type="password" name="loginPassword" id="loginPassword"><br><br>
            <input id="button" type="submit" id="loginSubmit" value="Login">
        </form>
    </div>
</div>
</body>
<html>

<?php

session_start();
error_reporting(E_ERROR | E_PARSE);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['lastPage'] != null) {
        $lastPage = $_SESSION['lastPage'];
    } else {
        $lastPage = 'index.php';
    }
    include('htaccess/logindbconnection.php');
    $password = $_POST['loginPassword'];
    $username = $_POST['loginUser'];
    $query = "SELECT * FROM logininfo WHERE username = '$username'";
    $result = $conn->query($query);
    if ($result->num_rows === 1) {
        $query = "SELECT * FROM logininfo WHERE password = '$password'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $role = $row['role'];
        if ($result->num_rows === 1) {
            $_SESSION['authenticatedUser'] = $username;
            $_SESSION['role'] = $role;
            print($_SESSION['authenticatedUser'] = $username);
        } else {
            echo '<p>Incorrect Password</p>';
            exit;
        }
    } else {
        echo '<p>Incorrect Username</p>';
        exit;
    }

    header('Location:' . $lastPage);
    exit;
}
