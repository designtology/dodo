


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



$sql = "SELECT projects.memos,project,rate,priceclass_name,company_id,position_name,company,start_date,deadline,hours,position_hours,priceclass,hours_worked,price,active,positions.id FROM priceclass,positions,kunden,projects WHERE projects.company_id = kunden.id AND positions.project_id = projects.id AND priceclass.id = positions.priceclass AND projects.id = {$_GET['id']} AND active = 'true' ORDER BY projects.id";
$result = mysqli_query($conn, $sql);
$show_title = true;
$hours_all = 0;
$hours_worked_all = 0;
$price_all = 0;

if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){

  $start_date_row = strtotime( $row[start_date] );
  $start_date_formated = date( 'd.m.Y', $start_date_row );
  $deadline_row = strtotime( $row[deadline] );
  $deadline_formated = date( 'd.m.Y', $deadline_row );
  $id = $row[id];

if($show_title){
?>

            <div class="form_company">

              <div class="form-group">
                <label for="form_company">Firma</label>
                <input disabled id="form_company" type="text" name="company" value="<?php echo $row[company] ?>" class="form-control disabled" data-error="Company is required.">
                <div class="help-block with-errors"></div>
              </div>

            </div>

            <div class="form_names">

              <div class="form-group">
                <label for="form_name">Start Date</label>
                <input disabled id="form_name" type="text" name="name" value="<?php echo $start_date_formated ?>" class="form-control disabled" required="required" data-error="Firstname is required.">
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <label for="form_lastname">Deadline</label>
                <input disabled id="form_lastname" type="text" name="surname" value="<?php echo $deadline_formated ?>" class="form-control disabled" required="required" data-error="Lastname is required.">
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
                       <textarea id="position_name" name="position_name" class="form-control disabled" required="required" data-error="Valid email is required." ><?php echo $row[position_name] ?></textarea>
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <input disabled id="position_hours" type="text" name="position_hours" value="<?php echo $row[position_hours]; ?>" class="form-control disabled">
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <input disabled id="priceclass_name" type="text" name="priceclass_name" value="<?php echo $row[priceclass_name]; ?>" class="form-control disabled">
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <input disabled id="calc_time_diff" type="text" name="calc_time_diff" value="<?php echo seconds2human(calc_time_diff($id)); ?>" class="form-control disabled">                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <input disabled id="form_phone" type="text" name="total_hours" value="<?php echo number_format($row[position_hours] * $row[rate],2,',','.'); ?> €" class="form-control disabled">
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
                Gesamt
              </div>

              <div class="form-group">
                <?php echo $hours_all; ?>
              </div>

              <div class="form-group">                
              </div>

              <div class="form-group">
                <?php echo seconds2human($hours_worked_all); ?>
              </div>

              <div class="form-group">
                <?php echo number_format($price_all,2,',','.'); ?> €
              </div>
            </div>


            <div class="section_title">Weiteres</div>


            <div class="row">
              <div class="form-group">
                <label form="form_memo">Memo</label>
                <textarea disabled id="form_memo" name="memo" value="" class="form-control disabled" rows="5"><?php echo $memos; ?></textarea>
                <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="row form_checkboxes form-group">
              <div>
                <div class="help-block with-errors"></div>
              </div>
            </div>               
            <div class="button_row">
              <div class="row">
                <a href="index.php?page=project_edit&id=<?php echo $_GET['id']; ?>"><btn type="submit" class="btn btn-send btn-block disabled" value="Send message">Bearbeiten</button></btn></a>
              </div>
              <div class="row">
                <a href="functions/generate_pdf.php?id=<?php echo $_GET['id']; ?>&action=save_file"><btn type="submit" class="btn btn-send btn-block disabled" value="Send message">Kostenvoranschlag erstellen</button></btn></a>
              </div>
              <div class="row">
                <a href=""><btn type="submit" class="btn btn-send btn-block disabled" value="Send message">Rechnung erstellen</button></btn></a>
              </div>
            </div>

          </div>

        </form>

  </div>
</div>  