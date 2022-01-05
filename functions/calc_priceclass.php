<?php
    $id = $_REQUEST['id'];
    include ($_SERVER['DOCUMENT_ROOT'] . '/dodo/database.php');

    $sql2 = "SELECT * FROM priceclass WHERE id = '{$id}'";
    $result2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($result2) > 0){
        while($row = mysqli_fetch_assoc($result2)){
                echo $row[rate];
            }
        }
?>
