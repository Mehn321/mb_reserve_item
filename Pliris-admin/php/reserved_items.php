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

    // function retrieve($column, $table, $where){
    //     $conn=connect();
    //     $sql="SELECT $column FROM $table WHERE $where";
    //     $result=$conn->query($sql);
    //     return $result;
    // }
    include("database.php");

    if(isset($_POST["submit"])){
        $reserve_id = $_POST["reserve_id"];
        $conn=connect();
        
        // $sql = "SELECT * FROM reserved WHERE reserve_id='$reserve_id'";
        // $result = $conn->query($sql);
        // $result=retrieve("","reserved","reserve_id='$reserve_id'");

        // if($result->num_rows > 0) {
            // $update_query = "UPDATE reserved SET reservation_status='pending_return' WHERE reserve_id='$reserve_id'";
            // $insert_query = "INSERT INTO returned(`reserve_id`) values('$reserve_id')";
            // $conn->query($update_query);
            // $conn->query($insert_query);
        $reservation_status=$_POST["reservation_status"];
        if($reservation_status=="disapproved"){
            update('reserved',"reservation_status='pending_return'","reserve_id='$reserve_id'");
            // update("reserved","reservation_status='pending_return","'$reserve_id'");
            
            header("Location:reserved_items.php");
        }
        else{
            update('reserved',"reservation_status='pending_return'","reserve_id='$reserve_id'");
            insert("returned","`reserve_id`","'$reserve_id'");
            header("Location:reserved_items.php");
        }
            
        // }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserved Items</title>
    <link rel="stylesheet" href="../css/items_records_reserved_returned.css">
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

            <h2>All Items Reserved</h2>

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
                <th>Borrower</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reserved</th>
                <th>Remaining</th>
                <th>Action</th>
            </tr>
            <?php
                // $reserved=retrieve("*","reserved"," reservation_status='borrowing'");
                // while($row=$reserved->fetch_assoc()){
                //     $reserve_id=$row['reserve_id'];
                //     $quantity_reserved = $row['quantity_reserved'];
                //     $scheduled_reserve_datetime = $row['scheduled_reserve_datetime'];
                //     $scheduled_return_datetime = $row['scheduled_return_datetime'];
                //     $item_id = $row['item_id'];
                //     $id_num = $row['id_number'];
                //     $items = retrieve("item_name","items","item_id=$item_id");
                //     $reservation_status=$row['reservation_status'];
                //     $row = $items->fetch_assoc();
                //     $itemname = $row['item_name'];
                //     $accounts=retrieve('first_name', 'accounts',"id_number='$id_num'");
                //     $row_users=$accounts->fetch_assoc();
                //     $first_name=$row_users['first_name'];
                $sql="
                    SELECT reserved.*, items.item_name, accounts.first_name 
                    FROM reserved 
                    JOIN items ON reserved.item_id = items.item_id 
                    JOIN accounts ON reserved.id_number = accounts.id_number 
                    WHERE reserved.reservation_status = 'borrowing' OR reserved.reservation_status = 'disapproved' 
                ";
                $reserved = $conn->query($sql);
                while($row = $reserved->fetch_assoc()){
                    $reserve_id = $row['reserve_id'];
                    $quantity_reserved = $row['quantity_reserved'];
                    $scheduled_reserve_datetime = $row['scheduled_reserve_datetime'];
                    $scheduled_return_datetime = $row['scheduled_return_datetime'];
                    $itemname = $row['item_name'];
                    $first_name = $row['first_name'];
                    echo "
                    <tr class='row-border'>
                        <td>$first_name</td>
                        <td>$itemname </td>
                        <td>$quantity_reserved</td>
                        <td>$scheduled_reserve_datetime</td>
                        <td>$scheduled_return_datetime</td>
                        <form action='reserved_items.php' method='post'>
                        <td>
                            <input type='hidden' name='reserve_id' value=$reserve_id>
                            <input type='submit' name='submit' value='return'>
                        </td>
                        </form>
                    </tr>
                    ";
                    }
            ?>
        </table>
    </div>

</body>
</html>

<?php

?>
