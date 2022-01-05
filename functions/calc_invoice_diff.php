<?php


function calc_invoice_diff($id){
    include '../database.php';

        $sql2 = "SELECT * FROM timetable WHERE position_id = {$id} AND invoice_id IS NULL";
        $result2 = mysqli_query($conn, $sql2);
        $worked_hours = 0;

        if(mysqli_num_rows($result2) > 0){
            while($row = mysqli_fetch_assoc($result2)){
                if($row[end_date]){
                            $worked_hours += $row[end_date] - $row[start_date];
                }else{
                $today =  time();
                $worked_hours = $today - $row[start_date];
                }
            }
        }


        return $worked_hours;
}

?>
