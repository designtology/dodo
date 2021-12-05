


<div class="container ">
  <div class="wrapper">

      <form id="contact-form" method="post" action="project_edit_send.php" role="form" novalidate="true">

          <div class="messages"></div>

          <div class="controls">
          <div class="section_title">Kunde</div>


<?php

include "database.php";
require_once('secondstohuman.php');
include('calc_time_diff.php');

$id = $_GET['id'];

$sql = "SELECT projects.memos,project,rate,priceclass_name,company_id,position_name,company,start_date,deadline,hours,position_hours,priceclass,hours_worked,price,active,positions.id FROM priceclass,positions,kunden,projects WHERE projects.company_id = kunden.id AND positions.project_id = projects.id AND priceclass.id = positions.priceclass AND projects.id = {$_GET['id']} AND active = 'true'";
$result = mysqli_query($conn, $sql);
$show_title = true;
$hours_all = 0;
$hours_worked_all = 0;
$price_all = 0;
$counter = 0;
if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
  $positions_id = $row[id];
  $counter++;

if($show_title){
?>

          <div class="form_company">

            <div class="form-group">
              <label for="form_company">Firma</label>
              <input id="form_company" type="text" name="company" value="<?php echo $row[company] ?>" class="form-control disabled" data-error="Company is required.">
              <div class="help-block with-errors"></div>
            </div>

          </div>

          <div class="form_names">

            <div class="form-group">
              <label for="form_name">Start Date</label>
              <input id="form_name" type="date" name="form_start" value="<?php echo $row[start_date] ?>" class="form-control" required="required" data-error="Start date is required.">
              <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
              <label for="form_lastname">Deadline</label>
              <input id="form_lastname" type="date" name="form_deadline" value="<?php echo $row[deadline] ?>" class="form-control"  data-error="Deadline is required.">
              <div class="help-block with-errors"></div>
            </div>

          </div>


          <div class="section_title">Positionen</div>
           <div class="messages"></div>


            <div class="form_table_row_first">

              <div class="form-group">
                <label>Position</label>
              </div>

              <div class="form-group">
                <label>Stunden</label>
              </div>

              <div class="form-group">
                <label>Preisklasse</label>
              </div>

              <div class="form-group">
                <label>Geleistet</label>
              </div>

              <div class="form-group">
                <label>Gesamtpreis</label>
              </div>
            </div>
<?php

$show_title = false;


 } ?>
            <div class="form_table_row">
              <div class="form-group">
                <textarea id="position_name_<?php echo $row[id]; ?>" name="position_name_<?php echo $counter; ?>" class="form-control" required="required" data-error="" ><?php echo $row[position_name] ?></textarea>
              </div>

              <div class="form-group">
                <input id="position_hours_<?php echo $row[id]; ?>" type="number"  step="0.25" name="form_est_hours_<?php echo $counter; ?>" value="<?php echo $row[position_hours]; ?>" class="form-control" data-id="<?php echo $row[id]; ?>">
              </div>

              <div class="form-group">

                    <?php 
                    $priceclass_id = $row[priceclass];

                    $sql2 = "SELECT * FROM priceclass";
                    $result2 = mysqli_query($conn, $sql2);

                    echo "<select id ='form_priceclass_" . $row[id] . "' name='form_priceclass_" . $counter . "' class='form-control' required='required' data-error='Firstname is required.' data-id='" . $row[id] . "'>";
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        if($priceclass_id == $row2['id']){
                         $selected = 'selected="selected"';
                        }
                        echo "<option " . $selected . " value='" . $row2['id'] . "'>" . $row2['priceclass_name'] . "</option>";
                        $selected = "";
                    }

                    echo "</select>";

                    ?>

                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <input id="hours_worked_<?php echo $row[id]; ?>" type="text" name="hours_worked_<?php echo $counter; ?>" value="<?php echo seconds2human(calc_time_diff($positions_id)); ?>" class="form-control" data-id="<?php echo $row[id]; ?>">
                <input type="hidden" id="form_status_<?php echo $row[id]; ?>" name="form_status_<?php echo $counter; ?>" value="false">
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <input id="total_price_<?php echo $row[id]; ?>" type="text" name="total_price_<?php echo $counter; ?>" value="<?php echo $row[position_hours] * $row[rate]; ?> €" class="form-control disabled">
                <input type="hidden" name="position_id_<?php echo $counter; ?>" value="<?php echo $row[id]; ?>">
                <div class="help-block with-errors"></div>
              </div>              
            </div>
<?php

$hours_all += $row[position_hours];
$hours_worked_all += calc_time_diff($row[id]);
$price_all += $row[position_hours] * $row[rate];
$memos = $row[memos];

  }

}

?>
            <div class="form_table_row form_table_last_row">
              <div class="form-group">
                &nbsp;
              </div>

              <div class="form-group">
              </div>

              <div class="form-group">                
              </div>

              <div class="form-group">
              </div>

              <div class="form-group">
              </div>
            </div>


            <div class="section_title">Weiteres</div>


            <div class="row">
              <div class="form-group">
                <label form="form_memo">Memo</label>
                <textarea id="form_memo" name="memos" value="" class="form-control" rows="5"><?php echo $memos; ?></textarea>
                <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="row form_checkboxes form-group">
              <div>
                <div class="help-block with-errors"></div>
              </div>
            </div>               

            <div class="row">
              <button type="submit" class="btn btn-send btn-block disabled" value="Send message">Speichern</button><br><br>
              <a href="index.php?page=projects&action=delete_project&id=<?php echo $row[0]; ?>" onclick="return confirm('<?php echo $row[1]; ?> für immer löschen?')">Projekt löschen</a>
            </div>


          </div>

           <input type="hidden" name="id" value="<?php echo $id; ?>">
           <input type="hidden" name="action" value="edit_project">
           <input type="hidden" id="project_positions" name="project_positions" value="<?php echo $counter ?>">
        </form>

  </div>
</div>  