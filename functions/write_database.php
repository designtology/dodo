<?php
// message that will be displayed when everything is OK :)
$okMessage = 'Der Kunde wurde erfolgreich angelegt!';

// If something goes wrong, we will display this message.
$errorMessage = 'Ups, da hat etwas nicht funktioniert.';

if(count($_POST) == 0) throw new \Exception('Form is empty');

$id = $_REQUEST['id'];
$company_name = $_REQUEST['company'];
$name = $_REQUEST['name'];
$surname = $_REQUEST['surname'];
$street = $_REQUEST['street'];
$street_ext = $_REQUEST['street_ext'];
$city = $_REQUEST['city'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];
$memos = $_REQUEST['memo'];
$new_customer = $_REQUEST['new_customer'];
$new_project = $_REQUEST['new_project'];
$project = $_REQUEST['form_project_name'];
$company = $_REQUEST['form_company'];
$start_date = $_REQUEST['form_start'];
$deadline = $_REQUEST['form_deadline'];
$hours = $_REQUEST['form_hours'];
$position_count = $_REQUEST['project_positions'];


for($i=1;$i<=$position_count;$i++){
    $position_id[$i]=$_REQUEST['position_id_'.$i];
    $position_name[$i]=$_REQUEST['position_name_'.$i];
    $position_hours[$i]=$_REQUEST['position_hours_'.$i];
    $worked_hours[$i]=$_REQUEST['hours_worked_'.$i];
    $form_status[$i] = $_REQUEST['form_status_'.$i];
    $priceclass[$i] =  $_REQUEST['form_priceclass_' . $i];
    $est_time[$i] =  $_REQUEST['form_est_hours_' . $i];
    $total_prices[$i] = $_REQUEST['total_price_' . $i];
    $delete_pos[$i] = $_REQUEST['delete_pos_' . $i];
    $total_price+=$total_prices[$i];
    $est_time_all += $est_time[$i];
}
$action = $_REQUEST['action'];


require_once '../database.php';

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}




if($new_customer == 'new'){
    $sql = "INSERT INTO kunden (company,name,surname,street,street_ext,city,email,phone,memos) VALUES ('{$company_name}','{$name}','{$surname}','{$street}','{$street_ext}','{$city}','{$email}','{$phone}','{$memos}')";
}if($new_project == 'new'){
    $sql = "INSERT INTO projects (active,project,company_id,start_date,deadline,hours,price,memos) VALUES ('true','{$project}','{$company}','{$start_date}','{$deadline}','{$est_time_all}','','{$memos}')";
}

switch($action){

    case "edit_project":

        $sql = "UPDATE projects SET
        hours = '{$est_time_all}',
        price = '{$total_price}',
        start_date = '{$start_date}',
        deadline = '{$deadline}',
        memos = '{$memos}' WHERE id = '{$id}'";
        mysqli_query($conn, $sql_positions);

        for($j=1;$j<=$position_count;$j++){
            $positions_sql ="UPDATE positions SET
            position_name = '{$position_name[$j]}',
            position_hours = '{$est_time[$j]}',
            priceclass = '{$priceclass[$j]}'
            WHERE id = {$position_id[$j]}";

            mysqli_query($conn, $positions_sql);

            require_once('calc_time_diff.php');

            if($form_status[$j] == 'true'){
                require_once('secondstohuman.php');

                $actual_hours = calc_time_diff($position_id[$j]);

                $today = time();
                $time_diff = $today + ($actual_hours - human2seconds($worked_hours[$j]));

                $timetable_sql = "INSERT INTO timetable (position_id, start_date, end_date) VALUES ('{$position_id[$j]}','{$time_diff}','{$today}')";
                mysqli_query($conn, $timetable_sql);                
            }

            if(isset($delete_pos[$j])){
                $sql_delete_pos = "DELETE FROM positions WHERE id='{$delete_pos[$j]}'";
                mysqli_query($conn, $sql_delete_pos);
            }

            if(isset($_REQUEST['new_position_counter']) && $j > $_REQUEST['new_position_counter']){
                $sql_add_new_pos = "INSERT INTO positions (project_id, position_name, priceclass, position_hours) VALUES ('{$id}','{$position_name[$j]}','{$priceclass[$j]}','{$est_time[$j]}')";
                mysqli_query($conn, $sql_add_new_pos);

            }
        }
        
    break;

    case "edit_customer":
            $sql = "UPDATE kunden SET
            company = '{$company_name}',
            name = '{$name}',
            surname = '{$surname}',
            street = '{$street}',
            street_ext = '{$street_ext}',
            city = '{$city}',
            email = '{$email}',
            phone = '{$phone}',
            memos = '{$memos}' WHERE id = '{$id}'";
    break;    

}


if (mysqli_query($conn, $sql)) {
    $responseArray = array('type' => 'success', 'message' => $okMessage);
} else {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


$new_id = $conn->insert_id;

if($new_project == 'new'){

    for($j=1;$j<=$position_count;$j++){
        $positions_sql ="INSERT INTO positions (project_id, position_name, priceclass, position_hours) VALUES ('{$new_id}','{$position_name[$j]}','{$priceclass[$j]}','{$est_time[$j]}')";
        mysqli_query($conn, $positions_sql);
    }

        $sql2 = "SELECT rate,priceclass,position_hours,project_id FROM priceclass,positions WHERE priceclass.id = positions.priceclass AND project_id = {$new_id}";
        $result = mysqli_query($conn, $sql2);

        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
            $price += $row[rate] * $row[position_hours];
            $project_id = $row[project_id];
            }
        }

        $sql_positions = "UPDATE projects SET price = '{$price}' WHERE id = {$project_id}";
        mysqli_query($conn, $sql_positions);
}



mysqli_close($conn);


// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];    
}
?>