<?php
    session_start();
    $id_number=$_SESSION['id_number'];
    if (!isset($_SESSION['id_number'])) {
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/notification.css">
</head>
<body>
    <?php
        include("sidebar.php");
    ?>
    <header class="header">
        <nav class="navbar">
            <button class="menu" onclick=showsidebar()>
                <img src="../images/menuwhite.png" alt="menu"height="40px" width="45" >
            </button>
            <img src="../images/ustplogo.png" alt="">
            <ul>
                
                <li> NOTIFICATIONS </li>
            </ul>
            <div class="logout-container">
                <button>Log Out</button>
            </div>
        </nav>
    </header>

    <div class="container">
        
        <h3>Reminder! please return the____</h>
    </div>
</body>
</html>