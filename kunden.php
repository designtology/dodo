<div class="title"><h2>Kunden</h2></div>

<div class="container">
  <div class="wrapper" id="kundentabelle">




<table id="animalsTable" class="table table-striped table-bordered table-dark dataTable no-footer" role="grid" aria-describedby="animalsTable_info" style="width: 1093px;">
  <thead>
    <tr role="row">
      <td class="sorting" data-order="asc" tabindex="0" rowspan="1" colspan="1" aria-label="company" style="width: 150px;">Firma</td>
      <td class="sorting" data-order="asc" tabindex="0" rowspan="1" colspan="1" aria-label="name" style="width: 80px;">Vorname</td>
      <td class="sorting" data-order="asc" tabindex="0" rowspan="1" colspan="1" aria-label="surname" style="width: 80px;">Nachname</td>
      <td class="sorting" data-order="asc" tabindex="0" rowspan="1" colspan="1" aria-label="email" style="width: 80px;">Email</td>
      <td class="sorting" data-order="asc" tabindex="0" rowspan="1" colspan="1" aria-label="phone" style="width: 80px;">Telefon</td>
    </tr>
  </thead>

  <tbody>


<?php
include "database.php";


if($_REQUEST['action']){
  $action = $_REQUEST['action'];
}

if($action == 'delete_user'){

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $id = $_REQUEST['id'];
  $sql = "DELETE FROM kunden WHERE id='{$id}'";


  if (mysqli_query($conn, $sql)) {
      echo "user deleted";
  } else {
      echo "not deleted";
  }


}


$sql = "SELECT * FROM kunden ORDER BY company asc";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_array($result)){
?>

    <tr role="row">
      <td><b><a href="index.php?page=kunden_view&id='<?php echo $row[0]; ?>'"><?php echo $row[1]; ?></a></b></td>
      <td><?php echo $row[2]; ?></td>
      <td><?php echo $row[3]; ?></td>
      <td><a href="mailto:<?php echo $row[7]; ?>"><?php echo $row[7]; ?></a></td>
      <td><a href="tel:<?php echo $row[8]; ?>"><?php echo $row[8]; ?></td>
    </tr>

<?php    

  }
}
mysqli_close($conn);

?>


  </tbody>

</table>
<div class="container ">
  <div class="wrapper">
    <div class="row">
      <a href="index.php?page=kunden_neu"><btn class="btn" value="Send message">Neuer Kunde</btn></a>
    </div>
  </div>
</div>

  </div>
</div>  