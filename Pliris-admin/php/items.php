<?php   
    session_start();
    $id_number=$_SESSION['id_admin'];
    if (!isset($_SESSION['id_admin'])) {
        header("Location: ../index.php");
        exit;
    }
    if(isset($_POST['logout'])) {
        unset($_SESSION['id_admin']);
        header("Location: ../index.php");
        exit;
    }

    // function connect(){
    //     $server="localhost";
    //     $username = "root";
    //     $password="";
    //     $db_name="pliris";
    //     $conn = mysqli_connect($server,$username,$password,$db_name);
    //     return $conn;
    // }
    // function retrieve($column, $table){
    //     $conn=connect();
    //     $sql="SELECT $column FROM $table";
    //     $result=$conn->query($sql);
    //     return $result;
    // }

    include("database.php");
    $items=retrieve("*","items",true);
    
    if(isset($_POST["submit"])){
        $conn=connect();
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $id = $_POST['id'];
        if(!empty($_POST["itemname"])){
            $itemname=$_POST['itemname'];
            // $sql="UPDATE `items` SET name='$itemname' WHERE id='$id'";    
            // $conn->query($sql);
            update("`items`","name='$itemname'","id='$id'");
        }
        if(!empty($_POST["quantity"])){
            $quantity=$_POST['quantity'];
            // $sql="UPDATE `items` SET `quantity`='$quantity' WHERE id='$id'";
            // $conn->query($sql);
            update("`items`","quantity='$quantity'","id='$id'");
        }
    
        mysqli_close($conn);
        header("Location:items.php");
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/items.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
            <h2>All Items</h2>
        <div class="logout-container">
            <form action="" method="post">
            <button name="logout" value="logout">Log Out</button>
            </form>
        </div>
        </nav>

    </header>
    <div class="container">
    <table>
            <tr class="row-border">
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reserved</th>
                <th>Remaining</th>
                <th>Action</th>
            </tr>
            <?php
                while($row=$items->fetch_assoc()){
                    $itemname = $row['name'];
                    $quantity = $row['quantity'];
                    $borrowed = $row['borrowed'];
                    $remaining = $quantity - $borrowed;
                    $id = $row['id'];
                    if(isset($_POST["$id"])){
                        echo "
                        <tr class='row-border'>
                            <form action='items.php' method='post'>
                            <td>$itemname
                            <input type='text' name='itemname'>
                            </td>
                            <td>
                                $quantity <br>
                                <input type='number' name='quantity'>
                            </td>
                            <td>
                                $borrowed
                            </td>
                            <td>
                                $remaining
                            </td>
                            <td>
                                <input type='submit' name='submit'>
                            </td>
                                <input type='hidden' name='id' value='$id'>
                            </form>
                        </tr>
                        ";
                    }
                    elseif(isset($_POST["$id"])==false){
                    echo "
                    <tr class='row-border'>
                        <td>$itemname </td>
                        <td>$quantity</td>
                        <td>$borrowed</td>
                        <td>$remaining</td>
                        <form action='items.php' method='post'>
                        <td>
                            <input type='submit' name='$id' value='edit'>
                        </td>
                        </form>
                    </tr>
                    ";
                    }
                }
            ?>
        </table>
    </div>

</body>
</html>

<?php

?>
