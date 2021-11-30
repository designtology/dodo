<div id="timer_container">
</div>

<div class="container">
  <div class="wrapper" id="projects_table">




<table id="projects" class="table table-striped table-bordered table-dark dataTable no-footer" role="grid" aria-describedby="animalsTable_info">
  <thead>
    <tr role="row">
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="company" style="width: 250px;">Firma</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="project" style="width: 250px;">Projekt</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="date" style="width: 150px;">Annahmedatum</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="deadline" style="width: 150px;">Abgabedatum</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="hours" style="width: 120px;">Stunden</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="priceclass" style="width: 80px;">Preisklasse</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="hours_worked" style="width: 80px;">Geleistet</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="price" style="width: 80px;">Gesamtpreis</td>
      <td></td>
    </tr>
  </thead>

  <tbody>


<?php
include "database.php";
require_once('secondstohuman.php');
include('calc_time_diff.php');

//$sql = "SELECT * FROM projects ORDER BY id DESC";
$sql = "SELECT project,rate,priceclass_name,company_id,position_name,company,start_date,deadline,hours,position_hours,priceclass,hours_worked,price,active,positions.id FROM priceclass,positions,kunden,projects WHERE projects.company_id = kunden.id AND positions.project_id = projects.id AND priceclass.id = positions.priceclass AND active = 'true' ORDER BY projects.id";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){

    $id = $row[id];
    if($row[company_id] != $temp){

      $start_date_row = strtotime( $row[start_date] );
      $start_date_formated = date( 'd.m.Y', $start_date_row );
      $deadline_row = strtotime( $row[deadline] );
      $deadline_formated = date( 'd.m.Y', $deadline_row );

      ?>
      <tr role="row">
        <td><a href="index.php?page=kunden_view&id=<?php echo $row[company_id]; ?>"><?php echo $row[company]; ?></a></td>
        <td><u><b><a href="index.php?page=project_edit&id=<?php echo $row[id]; ?>"><?php echo $row[project]; ?></a></b></u></td>
        <td><b><?php echo $start_date_formated; ?><b></td>
        <td><b><?php echo $deadline_formated; ?></b></td>
        <td><b>Gesamt: <?php echo $row[hours]; ?> Std</b></td>
        <td></td>
        <td><?php echo $row[hours_worked]; ?></td>
        <td><b><?php echo number_format($row[price],2,',','.'); ?> €</b></td>
        <td></td>
      </tr>

        <?php
        $temp = $row[company_id] ;
      }
        ?>


    <tr role="row positions">
      <td></td>
      <td><?php echo $row[position_name]; ?></td>
      <td></td>
      <td></td>
      <td><?php echo $row[position_hours]; ?> Std</td>
      <td><?php echo $row[priceclass_name]; ?></td>
      <td><?php echo seconds2human(calc_time_diff($id)); ?></td>
      <td><?php echo number_format($row[position_hours] * $row[rate],2,',','.'); ?> €</td>
      <td><btn style="margin: 0; height: 13px;" id="start_timer_<?php echo $id; ?>" value="<?php echo $id; ?>" data-button="<?php echo "id=" . $id . "&project=" . $row[position_name] . "&company=" . $row[company]; ?>">START</btn>
        <btn style="margin: 0; height: 13px;" id="stop_timer_<?php echo $id; ?>" value="<?php echo $id; ?>" data-button="<?php echo "id=" . $id; ?>">STOP</btn></td>
    </tr>

    <?php


  }
}else{
  echo "<tr role='row'>no data received</tr>";
}


$sql = "SELECT * FROM timetable";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
    if($row[start_date] && !$row[end_date]){
      echo "<div style='display:none;' id='db_start_time' data-id='" . $row[position_id] . "'>";
    }
  }
}

mysqli_close($conn);

?>


      </tbody>

    </table>
    <div class="container ">
      <div class="wrapper">
        <div class="row">
          <a href="index.php?page=project_new"><btn class="btn" value="Send message">Neues Projekt</btn></a>
        </div>
      </div>
    </div>

  </div>
</div>  