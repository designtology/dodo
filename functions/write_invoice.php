<?php


	function write_invoice_database($invoice_number, $price_all){
		include ("../database.php");

		$id = $_GET['id'];

		$sql_pos = "SELECT * FROM positions WHERE project_id = 1";
		$result_pos = mysqli_query($conn, $sql_pos);

		if(mysqli_num_rows($result_pos) > 0){
		  while($row1 = mysqli_fetch_assoc($result_pos)){

		  	$sql_timetable = "SELECT * FROM timetable WHERE position_id = {$row1[id]} AND invoice_id IS NULL";
		  	$result_invoice = mysqli_query($conn, $sql_timetable);

			if(mysqli_num_rows($result_invoice) > 0){
			  while($row2 = mysqli_fetch_assoc($result_invoice)){

                $timetable_sql = "UPDATE timetable SET invoice_id = {$invoice_number} WHERE id = $row2[id]";
                mysqli_query($conn, $timetable_sql);  

			  }
			}

		  }
		}

        $sql_invoices ="INSERT INTO invoices (project_id, summe, rn) VALUES ('{$id}','{$price_all}','{$invoice_number}')";
        mysqli_query($conn, $sql_invoices);
		
	}

?>