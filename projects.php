<div class="title"><h2>Projekte</h2></div>

<div id="timer_container">
</div>

<div class="container">
  <div class="wrapper" id="projects_table">




<table id="projects" class="table table-striped table-bordered table-dark dataTable no-footer table_projects" role="grid" aria-describedby="animalsTable_info">
  <thead>
    <tr role="row">
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="project" style="width: 250px;">Projekt</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="date" style="width: 150px;">Annahmedatum</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="deadline" style="width: 150px;">Abgabedatum</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="priceclass" style="width: 80px;">Preisklasse</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="hours" style="width: 135px;">Stunden</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="price" style="width: 80px;">Gesamtpreis</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="hours_worked" style="width: 80px;">Geleistet</td>
      <td class="sorting" data-order="desc" tabindex="0" rowspan="1" colspan="1" aria-label="hours_worked" style="width: 80px;">Status</td>      
      <td>Timer</td>
    </tr>
  </thead>

  <tbody>


<?php
include "database.php";
require_once('functions/secondstohuman.php');
include('functions/calc_time_diff.php');

//$sql = "SELECT * FROM projects ORDER BY id DESC";
$sql = "SELECT project_id,project,rate,priceclass_name,company_id,position_name,company,start_date,deadline,hours,position_hours,priceclass,hours_worked,price,active,positions.id,projects.id as projects_id FROM priceclass,positions,kunden,projects WHERE projects.company_id = kunden.id AND positions.project_id = projects.id AND priceclass.id = positions.priceclass AND active = 'true' ORDER BY projects.id";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
    $id = $row[id];
    $worked_hours = calc_time_diff($id);


    if($row[project_id] != $temp){
      $start_date_row = strtotime( $row[start_date] );
      $start_date_formated = date( 'd.m.Y', $start_date_row );
      $deadline_row = strtotime( $row[deadline] );
      $deadline_formated = date( 'd.m.Y', $deadline_row );

      if(isset($price)){
      ?>

        <tr role="row" class="table_row_new_line">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td><b><?php echo $hours; ?> Std</b></td>
          <td><b><?php echo number_format($price,2,',','.'); ?> €</b></td>
          <td><b><?php echo seconds2human($worked_hours_full); ?></b></td>
          <td><b><?php  ?> %</b></td>
          <td><a href="functions/generate_pdf.php?id=<?php echo $project_id; ?>">KV</a></td>
        </tr>

      <?php
      $worked_hours_full = 0;
      }
      ?>

      <tr role="row" class="table_row_first_line">
        <td>(<a href="index.php?page=kunden_view&id=<?php echo $row[company_id]; ?>"><?php echo $row[company]; ?></a>)<br><b><a href="index.php?page=project_view&id=<?php echo $row[project_id]; ?>"><?php echo $row[project]; ?></a></td>
        <td><?php echo $start_date_formated; ?><b></td>
        <td<?php if(strtotime("now") >= $deadline_row){ echo " class='red_font'"; } ?>><b><?php echo $deadline_formated; ?></b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

        <?php
        $temp = $row[project_id] ;
        $price = 0;
        $worked_hours_full = 0;
      }
        ?>


    <tr role="row positions">
      <td><?php echo $row[position_name]; ?></td>
      <td></td>
      <td></td>
      <td><?php echo $row[priceclass_name]; ?></td>
      <td><?php echo $row[position_hours]; ?> Std</td>
      <td><?php echo number_format($row[position_hours] * $row[rate],2,',','.'); ?> €</td>
      <td><?php echo seconds2human($worked_hours); ?></td>
      <td><?php echo number_format($worked_hours / human2seconds("00:".$row[position_hours] . ":00:00") * 100,0,'',''); ?> %<br><?php echo number_format($worked_hours/3600 * $row[rate],2,',','.'); ?> €</td>
      <td><btn style="margin: 0; height: 13px;" id="start_timer_<?php echo $id; ?>" value="<?php echo $id; ?>" data-button="<?php echo "id=" . $id . "&project=" . $row[position_name] . "&company=" . $row[company]; ?>">START</btn>
        <btn style="margin: 0; height: 13px;" id="stop_timer_<?php echo $id; ?>" value="<?php echo $id; ?>" data-button="<?php echo "id=" . $id; ?>">STOP</btn></td>
    </tr>

<?php
    $hours = $row[hours];
    $price = $row[price];
    $worked_hours_full += $worked_hours;
    $project_id = $row[projects_id];

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

      <tr role="row" class="table_row_new_line">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><b><?php echo $hours; ?> Std</b></td>
        <td><b><?php echo number_format($price,2,',','.'); ?> €</b></td>
        <td><b><?php echo seconds2human($worked_hours_full); ?></b></td>
        <td>%</td>        
        <td><a href="functions/generate_pdf.php?id=<?php echo $project_id; ?>">KV</a></td>
      </tr>


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