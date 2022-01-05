<?php 
   $count =  $_POST['count'] + 1;
   echo "<div>Position Nr. " . $count . "</div>";
 ?>            

 <hr></hr>
              <div>
                <div class="form-group">
                  <input id="position_name_<?php echo $count; ?>" type="text" name="position_name_<?php echo $count; ?>" class="form-control" placeholder="Musterstraße 11">
                  <div class="help-block with-errors"></div>
                </div>
              </div>

              <div class="form_names">
                <div class="form-group">
                  <label for="form_priceclass_<?php echo $count; ?>">Preisklasse</label>

                    <?php 
                      include 'database.php';

                      $sql = "SELECT * FROM priceclass";
                      $result = mysqli_query($conn, $sql);

                      echo "<select id='form_priceclass_" . $count . "' name='form_priceclass_" . $count . "' class='form-control' required='required' data-error='Firstname is required.'>";
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo "<option value='" . $row['id'] . "'>" . $row['priceclass_name'] . "</option>";
                      }
                      echo "</select>";

                    ?>
                  <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                  <label for="form_est_hours_<?php echo $count; ?>">Zeitschätzung</label>
                  <input id="form_est_hours_<?php echo $count; ?>"  type="number" step="0.25" name="form_est_hours_<?php echo $count; ?>" class="form-control" placeholder="Musterstraße 11">
                  <div class="help-block with-errors"></div>
                </div>
              </div>
