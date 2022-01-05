 <?php  
include '../database.php';

 $output = '';  
 $order = $_POST["order"];  
 if($order == 'desc')  
 {  
      $order = 'asc';  
 }  
 else  
 {  
      $order = 'desc';  
 }  
 $query = "SELECT * FROM kunden ORDER BY ".$_POST["column_name"]." ".$_POST["order"]."";  
 $result = mysqli_query($conn, $query);  
 $output .= '  


<table id="animalsTable" class="table table-striped table-bordered table-dark dataTable no-footer" role="grid" aria-describedby="animalsTable_info" style="width: 1093px;">

  <thead>
    <tr role="row">
      <td class="sorting" data-order="'.$order.'" tabindex="0" rowspan="1" colspan="1" aria-label="Id" style="width: 50px;">Id</td>
      <td class="sorting" data-order="'.$order.'" tabindex="0" rowspan="1" colspan="1" aria-label="company" style="width: 150px;">Firma</td>
      <td class="sorting" data-order="'.$order.'" tabindex="0" rowspan="1" colspan="1" aria-label="name" style="width: 80px;">Vorname</td>
      <td class="sorting" data-order="'.$order.'" tabindex="0" rowspan="1" colspan="1" aria-label="surname" style="width: 80px;">Nachname</td>
      <td class="sorting" data-order="'.$order.'" tabindex="0" rowspan="1" colspan="1" aria-label="email" style="width: 80px;">Email</td>
      <td class="sorting" data-order="'.$order.'" tabindex="0" rowspan="1" colspan="1" aria-label="phone" style="width: 80px;">Telefon</td>
    </tr>
  </thead>

  <tbody>

 ';  
 while($row = mysqli_fetch_array($result))  
 {
      $output .= '  
    <tr role="row">
      <td>' . $row[0] . '</td>
      <td><a href="index.php?page=kunden_view&id=' . $row[0] . '">' . $row[1] . '</a></td>
      <td>' . $row[2] . '</td>
      <td>' . $row[3] . '</td>
      <td><a href="mailto:' . $row[7] . '">' . $row[7] . '</a></td>
      <td><a href="tel:' . $row[8] . '">' . $row[8] . '</td>
    </tr>
      ';  
 }  
 $output .= '</tbody></table>
 <div class="container ">
  <div class="wrapper">
    <div class="row">
      <a href="index.php?page=kunden_neu"><btn class="btn" value="Send message">Neuer Kunde</btn></a>
    </div>
  </div>
</div>';  
 echo $output;  
 ?>  