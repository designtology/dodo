<?php

require_once '../database.php';
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$id = $_REQUEST['id'];

$sql = "DELETE FROM projects WHERE id='{$id}'";


if (mysqli_query($conn, $sql)) {
    echo "deleted";
} else {
    echo "not deleted";
}


$sql2 = "DELETE FROM positions WHERE project_id='{$id}'";


if (mysqli_query($conn, $sql2)) {
    echo "deleted";
} else {
    echo "not deleted";
}

mysqli_close($conn);

?>