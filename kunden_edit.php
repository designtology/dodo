
<?php

include('database.php');



$sql = "SELECT * FROM kunden WHERE id = ".$_GET['id']."";  
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){

  $row = mysqli_fetch_array($result);

}

?>


<div class="container ">
  <div class="wrapper">

      <form id="contact-form" method="post" action="kunden_edit_send.php" role="form" novalidate="true">
      <div class="section_title">Rechnungsadresse</div>

          <div class="messages"></div>

          <div class="controls">

            <div class="form_company">

              <div class="form-group">
                <label for="form_company">Firma</label>
                <input id="form_company" type="text" name="company" value="<?php echo $row[1] ?>" class="form-control" placeholder="Firma" data-error="Company is required.">
                <div class="help-block with-errors"></div>
              </div>

            </div>

            <div class="form_names">

              <div class="form-group">
                <label for="form_name">Vorname *</label>
                <input id="form_name" type="text" name="name" value="<?php echo $row[2] ?>" class="form-control" placeholder="Max" required="required" data-error="Firstname is required.">
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <label for="form_lastname">Nachname *</label>
                <input id="form_lastname" type="text" name="surname" value="<?php echo $row[3] ?>" class="form-control" placeholder="Mustermann" required="required" data-error="Lastname is required.">
                <div class="help-block with-errors"></div>
              </div>

            </div>

            <div class="form_address">

              <div class="form-group">
                <label for="form_street">Straße / Nr *</label>
                <input id="form_street" type="text" name="street" value="<?php echo $row[4] ?>" class="form-control" placeholder="Musterstraße 11" required="required" data-error="Firstname is required.">
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <label for="form_city">PLZ / Stadt *</label>
                <input id="form_city" type="text" name="city" value="<?php echo $row[6] ?>" class="form-control" placeholder="12345 Musterstadt" required="required" data-error="Lastname is required.">
                <div class="help-block with-errors"></div>
              </div>

            </div>

            <div class="form_address_ext">

              <div class="form-group">
                <label for="form_street_ext">Adresserweiterung</label>
                <input id="form_street_ext" type="text" name="street_ext" value="<?php echo $row[5] ?>" class="form-control" placeholder="Musterstraße 11">
                <div class="help-block with-errors"></div>
              </div>

            </div>



          <div class="section_title">Kontaktdaten</div>

          <div class="messages"></div>


            <div class="form_contacts">

              <div class="form-group">
                <label for="form_email">Email *</label>
                <input id="form_email" type="email" name="email" value="<?php echo $row[7] ?>" class="form-control" placeholder="max@provider.de" required="required" data-error="Valid email is required.">
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <label for="form_phone">Telefon</label>
                <input id="form_phone" type="tel" name="phone" value="<?php echo $row[8] ?>" class="form-control" placeholder="0123 456 798 0">
                <div class="help-block with-errors"></div>
              </div>

            </div>

            <div class="section_title">Weiteres</div>


            <div class="row">
              <div class="form-group">
                <label form="form_memo">Memo</label>
                <textarea id="form_memo" name="memo" value="" class="form-control" placeholder="Kundenmemos ..." rows="5"><?php echo $row[9] ?></textarea>
                <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="row form_checkboxes form-group">
              <div>
                <div class="help-block with-errors"></div>
              </div>
            </div>               

            <div class="row">
              <button type="submit" class="btn btn-send btn-block disabled" value="Send message">Speichern</button><br><br><a href="index.php?page=kunden&action=delete_user&id=<?php echo $row[0]; ?>" onclick="return confirm('<?php echo $row[1]; ?> für immer löschen?')">Kunden löschen</a>

            </div>     

            <div class="row">
            </div>

            <div class="row">
              <p class="text-muted"><strong>*</strong> Eingabe erforderlich.</p>
            </div>

          </div>

           <input type="hidden" name="id" value="<?php echo $row[0]; ?>">

        </form>

  </div>
</div>  