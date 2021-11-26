<?php

require_once 'database.php';
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$id = $_REQUEST['id'];

echo $id;

$sql = "DELETE FROM kunden WHERE id='{$id}'";


if (mysqli_query($conn, $sql)) {
    echo "deleted";
} else {
    echo "not deleted";
}

mysqli_close($conn);

?>