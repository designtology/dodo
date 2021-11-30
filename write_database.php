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

$project_count = $_REQUEST['project_positions'];



for($i=1;$i<=$project_count;$i++){
   $position[$i] =  $_REQUEST['form_position_' . $i];
   $priceclass[$i] =  $_REQUEST['form_priceclass_' . $i];
   $est_time[$i] =  $_REQUEST['form_est_hours_' . $i];

   $est_time_all += $est_time[$i];
}

$est_time_all += $est_time_1;

include 'database.php';

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


if($new_customer == 'new'){
    $sql = "INSERT INTO kunden (company,name,surname,street,street_ext,city,email,phone,memos) VALUES ('{$company_name}','{$name}','{$surname}','{$street}','{$street_ext}','{$city}','{$email}','{$phone}','{$memos}')";
}if($new_project == 'new'){
    $sql = "INSERT INTO projects (project,company_id,start_date,deadline,hours,price,memos) VALUES ('{$project}','{$company}','{$start_date}','{$deadline}','{$est_time_all}','','{$memos}')";
}else{
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
}

if (mysqli_query($conn, $sql)) {
    $responseArray = array('type' => 'success', 'message' => $okMessage);
} else {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

$new_id = $conn->insert_id;

if($new_project == 'new'){

    for($j=1;$j<=$project_count;$j++){
        $positions_sql ="INSERT INTO positions (project_id, position_name, priceclass, position_hours) VALUES ('{$new_id}','{$position[$j]}','{$priceclass[$j]}','{$est_time[$j]}')";
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