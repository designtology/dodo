<?php
	include('database.php');

	$timestamp = time();
	$sql = "UPDATE timetable SET end_date = '{$timestamp}' WHERE position_id = {$_REQUEST['id']} AND end_date IS NULL";

	if (mysqli_query($conn, $sql)) {

	}
		
	echo $_REQUEST['id'];
?>
<script type="text/javascript">console.log("kik");</script>