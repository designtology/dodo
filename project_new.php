<?php include('database.php'); ?>


<div class="container">
  <div class="wrapper">

      <form id="contact-form" method="post" role="form" novalidate="true">
      <div class="section_title">Projekt</div>

          <div class="messages"></div>

          <div class="controls">

            <div class="form_project">

              <div class="form-group">
                <label for="form_project_name">Projektname</label>

                <input id="form_project_name" type="text" name="form_project_name" class="form-control" placeholder="Projekt" data-error="Project Name is required." required='required'>
                <div class="help-block with-errors"></div>
              </div>

            </div>

            <div class="form_company">

              <div class="form-group">
                <label for="form_company">Firma</label>

                  <?php 

                  $sql = "SELECT * FROM kunden";
                  $result = mysqli_query($conn, $sql);

                  echo "<select name='form_company' class='form-control' required='required' data-error='Firstname is required.'>";
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='" . $row['id'] . "'>" . $row['company'] . "</option>";
                  }
                  echo "</select>";

                  ?>

                <div class="help-block with-errors"></div>
              </div>

            </div>

            <div class="form_names">

              <div class="form-group">
                <label for="form_start">Startdatum</label>
                <input id="form_start" type="date" name="form_start" class="form-control"  data-error="Startdate is required." required='required'>
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">
                <label for="form_deadline">Deadline</label>
                <input id="form_deadline" type="date" name="form_deadline" class="form-control" data-error="Deadline is required." required='required'>
                <div class="help-block with-errors"></div>
              </div>

            </div>

            <div class="section_title">Positionen</div>
            


            <div id="positions">
              <div>Position Nr. 1</div>
              <hr></hr>

              <div>
                <div class="form-group">
                  <input id="form_position_1" type="text" name="form_position_1" class="form-control" placeholder="Musterstraße 11" data-error="Position Name is required." required='required'>
                  <div class="help-block with-errors"></div>
                </div>
              </div>

              <div class="form_names">
                <div class="form-group">
                  <label for="form_priceclass_1">Preisklasse</label>

                    <?php 

                    $sql = "SELECT * FROM priceclass";
                    $result = mysqli_query($conn, $sql);

                    echo "<select id ='form_priceclass_1' name='form_priceclass_1' class='form-control'>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['priceclass_name'] . "</option>";
                    }
                    echo "</select>";

                    ?>

                <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                  <label for="form_est_hours_1">Zeitschätzung</label>
                  <input id="form_est_hours_1" type="text" name="form_est_hours_1" class="form-control" placeholder="Musterstraße 11" data-error="Time is required." required='required'>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
            </div>

            <div class="row">
              <btn id="add_position_form">Neue Position</button>
            </div>

            <div class="section_title">Weiteres</div>


            <div class="row">
              <div class="form-group">
                <label form="form_memo">Memo</label>
                <textarea id="form_memo" name="memo" class="form-control" placeholder="Kundenmemos ..." rows="5"></textarea>
                <div class="help-block with-errors"></div>
              </div>
            </div>

            <div class="row form_checkboxes form-group">
              <div>
                <div class="help-block with-errors"></div>
              </div>
            </div>               

            <div class="row">
              <button type="submit" class="btn btn-send btn-block disabled" value="Send message">Speichern</button>
            </div>

            <div class="row">
              <p class="text-muted"><strong>*</strong> Eingabe erforderlich.</p>
            </div>

          </div>
           <input type="hidden" name="new_project" value="new">
           <input type="hidden" id="project_positions" name="project_positions" value="1">

        </form>

  </div>
</div>  