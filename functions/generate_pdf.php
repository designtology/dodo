<?php
$type = $_REQUEST['type'];
$action = $_REQUEST['action'];

//include library
require ('../vendor/autoload.php');
require ('../vendor/tecnickcom/tcpdf/tcpdf.php');


use Spipu\Html2Pdf\Html2Pdf;
$pdf = new Html2Pdf();

require_once ("../database.php");
require_once('secondstohuman.php');
include('calc_invoice_diff.php');
include('calc_time_diff.php');


if($type == "invoice"){

	$sql_invoice_number = "SELECT * FROM invoices ORDER BY rn DESC LIMIT 0,1";
	$result_invoice = mysqli_query($conn, $sql_invoice_number);

	if(mysqli_num_rows($result_invoice) > 0){
	  while($row = mysqli_fetch_assoc($result_invoice)){
	  	$invoice_number = $row[rn] + 1;
	  }
		include 'write_invoice.php';
	}
}


$sql = "SELECT name, surname, street, street_ext, city,project,priceclass_name,company_id,position_name,company,start_date,deadline,hours,position_hours,rate,priceclass,hours_worked,price,active,positions.id as pos_id,projects.id FROM priceclass,positions,kunden,projects WHERE projects.company_id = kunden.id AND positions.project_id = projects.id AND priceclass.id = positions.priceclass AND projects.id = {$_GET['id']} AND active = 'true' ORDER BY projects.id";



$result = mysqli_query($conn, $sql);
$show_title = true;
$hours_all = 0;
$hours_worked_all = 0;
$price_all = 0;
$pdf->setDefaultFont("FuturaHeavy");

ob_start();
?><?php
	$pdf->addFont('futuraheavy', '', 'futuraheavy.php');
	$pdf->addFont('futurabook', '', 'futurabook.php');
?>
	<style>
		table {
			border-collapse:collapse;
			border: none;
		}

		td{
			height: 16px;
		}

		td {
			border-bottom: 0.75pt solid black;
			border-right:0.75pt solid black;	
			padding:2pt 2.5pt;		
		}


		table tr th {
			background-color:#888;
			color:#fff;
			font-weight:bold;
		}

	  table.footer{
	  	line-height: 8pt;
	  	font-size: 8pt;
	  	text-align: center;
	  	padding: 5pt;
	  	text-align: left;
	  	border: none;
	    font-size: 6pt;
	    margin-left: 35pt;
	  }

		table.footer td{
			border-top: 1px solid lightgrey;
			border-bottom: 1px solid lightgrey;
			border-left:none;
			border-right:none;
			width: 105pt;
			height: 50pt;
		}

		table.footer td.page_display{
			border-bottom: none;
			height: 10pt;
		}

	  .page_footer{
			left: 20pt;
	  }

		.page_display{
			text-align: center;
		}

		.footer_url{
	  	line-height: 10pt;
			font-size: 10pt;			
			text-align: right;
			color: grey;	
			width: 130pt;					
		}

		.footer_url span{
			color: black;
		}


		.table_header,
		.bottom_header{
			font-family: futuraheavy;
			text-align:right;
			font-size: 8pt;
			font-weight: bold;
			border-bottom:0.75pt solid black;
			border-right:0.75pt solid black;
			vertical-align: middle;
		}

		.table_header_last,
		.table_content_last,
		.table_summary_last{
			border-right: none;
		}

		.table_summary{
			font-family: futurabook;
			border-bottom: none;
			text-align: right;
			font-size: 8pt;
		}

		.table_content{
			text-align:right;
			font-size: 8pt;
			font-family: futurabook;
			vertical-align: middle;
		}

		.price_all{
			font-family: futuraheavy;
		}

		.table_content_description,
		.table_header_description{
			text-align: left;
		}

		.anrede{
			font-family: futurabook;			
			text-align: left;
			padding-bottom: 20pt;
			font-size: 9pt;
			width: 100%;
		}

		.bottom_header{
			border-top: 3pt solid black;
		}

		.bottom_header_last{
			border-right: none;
		}

		.customer_address{
			font-size: 8pt;
			font-family: futurabook;
			line-height:12pt;
		}

		.customer_label,
		.customer_sender{
			font-family: futurabook;
			font-size: 6pt;
			padding: 20pt 0;
		}

	.form_table_last_row .form-grpup{
		text-align: center;
	}

		.customer_sender{
			padding-top: 30pt;
		}

		.header_wrapper{
			width: 100%;
		}

		.left{
		  position: absolute;
		  left: 0px;
		  top: 100pt;
		  width: 50%;
		}

		.right{
			font-family: futurabook;	
			font-size: 9pt;
			line-height: 12pt;
		  position: absolute;
		  text-align: right;
		  right: 0px;
		  top: 70pt;
		  width: 50%;
			padding-top: 18pt;  
		}

		.rechnung{
			position: absolute;
			top: 220pt;
		}

		.pdf_wrapper{
			position: relative;
		}

		.letter_topic{
			font-family: futuraheavy;
			padding-top: 5pt;
		}

		.bottom_text{
			font-family: futurabook;
			font-size: 9pt;
			padding-top: 20pt;
		}
	</style>




<?php 
$header_filter = true;

if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){

  	

	  if($header_filter){
	  	echo '
<page backtop="25mm" backbottom="45mm" backleft="15mm" backright="15mm">

  <page_footer class="page_footer">
	  <table class="footer">
		  <tr>
			  <td>
				  Baris Sarial<br><br>
					Prenzlauer Promenade 176<br>
					13189 Berlin<br>
			  </td>
			  <td>
				  UStID: DE 14 504 01802<br><br>
					www.crosscreations.de<br>
					kontakt@crosscreations.de<br>
			  </td>
			  <td>
				  Berliner Sparkasse<br><br>
					IBAN: DE13 1005 0000 6016 7021 43<br>
					BIC: BELADEBEXXX<br>
			  </td>
			  <td class="footer_url">
			  <span>crosscreations.de</span><br>
				  grafikdesign & technologien
			  </td>
		  </tr>
		  <tr>
		  	<td colspan="4" class="page_display">
    			[[page_cu]]/[[page_nb]]
    		</td>
		  </tr>
		</table>
  </page_footer>


<div class="header_wrapper">
	<div class="left">
		<div class="customer_label">Empfänger:</div>
		<div class="customer_address">
			<b>' . $row[company] . '</b><br>'
			. $row[name] . ' ' . $row[surname] . '<br>'
			. $row[street] . '<br>'
			. $row[street_ext] . '<br>'
			. $row[city] . '
		</div>
		<div class="customer_sender">Baris Sarial / Prenzlauer Promenade 176 /13189 Berlin</div>';
		if($type == 'invoice'){
			echo '<div class="letter_topic">Rechnung</div>';
		}else{
			echo '<div class="letter_topic">Kostenvoranschlag</div>';
		}
	echo '</div>
	<div class="right">
		<b>Baris Sarial</b><br><br>
		Prenzlauer Promenade 176<br>
		13189 Berlin<br><br>
		www.crosscreations.de<br>
		rechnung@crosscreations.de<br><br>
		UStID: DE 14 504 01802<br><br><br>
		Berlin, ' . date( 'd.m.Y');

		if($type == 'invoice'){
			echo '<br>
						<span class="customer_sender">Zeitraum ist gleich Rechnungsdatum</span><br><br>
						<b>Rechnungsnummer:</b> ' . $invoice_number . '<br>
						<span class="customer_sender">(bitte immer angeben)</span>';
		}

		echo '
	</div>
</div>
<div class="rechnung">
			<div class="anrede">Sehr geehrte/r ' . $row[name] . ' ' . $row[surname] . ',<br> anbei erhalten Sie einen Kostenvoranschlag, für die abgesprochenen Leistungen:</div>
			<table>	  	
		  	<tr style="background-color:#f2f2f2; color:#000;">
					<td width="360" height="12" class="table_header table_header_description">Leistungsbeschreibung</td>
					<td width="70" height="12"  class="table_header">Preis in EUR</td>
					<td width="70" height="12"  class="table_header">Menge</td>
					<td width="80" height="12"  class="table_header table_header_last">Position in EUR</td>
				</tr>';
			$header_filter = false;
	  }

		$worked_hours = calc_invoice_diff($row[pos_id]);

	  if($type == 'invoice' && $worked_hours > 0){
				echo '
						<tr>
							<td width="360" height="15" class="table_content table_content_description">'. $row[position_name] .'</td>
							<td width="70" height="15" class="table_content">'. $row[rate] .'</td>
							<td width="70" height="15" class="table_content">'. number_format(calc_invoice_diff($row[pos_id])/3600,2,',','.').' </td>
							<td width="80" height="15" class="table_content table_content_last">'. number_format(calc_invoice_diff($row[pos_id])/3600 * $row[rate],2,',','.') .'</td>
						</tr>';
					$price_all += calc_invoice_diff($row[pos_id])/3600 * $row[rate];
	  }else if($type == "quotation"){
				echo '
						<tr>
							<td width="360" height="15" class="table_content table_content_description">'. $row[position_name] .'</td>
							<td width="70" height="15" class="table_content">'. $row[rate] .'</td>
							<td width="70" height="15" class="table_content">'. $row[position_hours] .'</td>
							<td width="80" height="15" class="table_content table_content_last">'. number_format($row[position_hours] * $row[rate],2,',','.') .'</td>
						</tr>';
					$price_all += $row[position_hours] * $row[rate];
			}
		

		$company_name = $row[company];
		$project_name = $row[project];

  }
}

?>
<tr>
	<td width="360" height="12" class="bottom_header">Netto in EUR</td>
	<td width="70" height="12" class="bottom_header">MwSt. in %</td>
	<td width="70" height="12" class="bottom_header">MwSt. in EUR</td>
	<td width="80" height="12" class="bottom_header bottom_header_last">Brutto in EUR</td>
</tr>
<?php


echo '
<tr>
	<td width="360" height="15" class="table_summary">'. number_format($price_all,2,',','.') .'</td>
	<td width="70" height="15" class="table_summary">19%</td>
	<td width="70" height="15" class="table_summary">'. number_format($price_all* 0.19,2,',','.') .'</td>
	<td width="80" height="15" class="table_summary table_summary_last price_all">'. number_format($price_all * 1.19,2,',','.') .'</td>
</tr>';
?>
</table>
	
<div class="bottom_text">

	<?php
	  if($type == 'invoice'){
	?>
		<p><b>Ich bedanke mich für die Zusammenarbeit und das Vertrauen.</b> Sobald nicht bereits geschehen: Den vereinbarten Betrag, in
Verbindung mit der <b>Rechnungsnummer</b>, innerhalb von 14 Tagen bitte auf das unten genannte Konto überweisen.</p><br>
	<p>Mit freundlichen Grüßen</p>

	<p>Baris Sarial</p>
<?php
}else if($type == 'quotation'){
	?>

	<p><b>Hinweise</b>: Dieser Kostenvoranschlag ist unverbindlich. Ich behalte es mir vor, unvorhersehbaren Mehraufwand zusätzlich zu berechnen. Dieser kann nicht pauschal berechnet werden, liegt aber im Schnitt bei 10 - 20% des Bruttowertes. Zusätzlich anfallende Kosten für Server, Lizenzen, Schriftarten o.Ä. sind nicht inbegriffen und werden dem Kunden in Rechnung gestellt. Relevante Abweichungen werden zeitnah kommuniziert. Ich freue mich über die Erteilung des Auftrages.</p><br>
	<p>Mit freundlichen Grüßen</p>
	<p>Baris Sarial</p>

	<?php
}
?>
</div>
</div>

</page>
<?php

$output = ob_get_clean();
$pdf->writeHTML($output);

if($action == 'save_file'){
	$date = date('d-m-Y');

  if($type == 'invoice'){
  	$filename = $_SERVER['DOCUMENT_ROOT'] . 'dodo/documents/invoice/invoice_' . $invoice_number . '_' . strtolower(str_replace(' ','_',$company_name)) . '_' . strtolower(str_replace(' ','_',$project_name)) . '.pdf';

		$pdf->Output($filename,'F');

			if(file_exists($filename)){
				write_invoice_database($invoice_number, $price_all);
			}

	}else if($type == 'quotation'){
		$pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'dodo/documents/kv/kv_' . $date . '_' . strtolower(str_replace(' ','_',$company_name)) . '_' . strtolower(str_replace(' ','_',$project_name)) . '.pdf','F');
	}

	$pdf->Output();

}else{
	$pdf->Output();
}


?>







