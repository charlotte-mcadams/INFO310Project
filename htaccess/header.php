<?php
if (session_id() === "") {
    session_start();
}
$_SESSION['lastPage'] = $_SERVER['PHP_SELF'];
?>
<head>
    <link rel="stylesheet" href="htaccess/font-awesome-4.7.0/css/font-awesome.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="../navigation.js"></script>
    <title></title>
</head>
<nav class="sidebar-navigation">
    <ul>
        <a id="link" href='index.php'>
            <li<?php if ($currentPage === 'index.php') {
                echo ' class="active"';
            } ?>>
                <i class="fa fa-home"></i>
                <span class="tooltip">Home</span>
            </li>
        </a>
        <a id="link" href="calendar.php">
            <li<?php if ($currentPage === 'calendar.php') {
                echo ' class="active"';
            } ?>>
                <i class="fa fa-calendar"></i>
                <span style="opacity: 1" class="tooltip"> Calendar</span>
            </li>
        </a>
        <a id='link' href="requestSeminar.php">
            <li<?php if ($currentPage === 'requestSeminar.php') {
                echo ' class="active"';
            } ?>>
                <i class="fa fa-comment"></i>
                <span class="tooltip">Request a Seminar</span>
            </li>
        </a>
        <?php
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {

            echo "<a id='link' href='admin.php'>
                    <li";
            if ($currentPage === 'admin.php') {
                echo ' class="active"';
            }
            echo ">
                                <i class='fa fa-user'></i>
                                <span class='tooltip'>Admin</span>
                            </li>
                             </a>
                             <a id='link' href='addSpeaker.php'>
                            <li";
            if ($currentPage === 'addSpeaker.php') {
                echo ' class="active"';
            }
            echo ">
                                <i class='fa fa-plus'></i>
                                <span class='tooltip'>Add a Seminar</span> 
                            </li>
                              </a>
                            ";
        } ?>
    </ul>
</nav>

<div id="user">
    <?php if (isset($_SESSION['authenticatedUser'])) { ?>
        <div id="signOut">
            <p>Welcome, <?php echo $_SESSION['authenticatedUser']; ?> <span id="logoutUser"></span></p>
            <a href="logout.php"> <i class="fa fa-sign-out"></i><span class="tooltip"> Sign Out</a>
        </div>
    <?php } else { ?>
    <div id="signIn">
        <a href="loginPage.php"> <i class="fa fa-sign-in"></i><span class="tooltip"> Sign in</a>
        <?php } ?>
    </div>
</div>