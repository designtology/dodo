<?php
//include library
require ('../vendor/autoload.php');
require ('../vendor/tecnickcom/tcpdf/tcpdf.php');


use Spipu\Html2Pdf\Html2Pdf;
$pdf = new Html2Pdf();

include ("../database.php");
require_once('../secondstohuman.php');
include('../calc_time_diff.php');


$sql = "SELECT name, surname, street, street_ext, city,project,rate,priceclass_name,company_id,position_name,company,start_date,deadline,hours,position_hours,priceclass,hours_worked,price,active,positions.id FROM priceclass,positions,kunden,projects WHERE projects.company_id = kunden.id AND positions.project_id = projects.id AND priceclass.id = positions.priceclass AND projects.id = {$_GET['id']} AND active = 'true' ORDER BY projects.id";

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
			text-align: right;
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
			padding-top: 12pt;
		}
	  .page_footer{
	  	font-size: 8pt;
	  	text-align: center;
	  }

	  .footer{
	  	padding: 5pt;
	  	text-align: left;
			position: absolute;
	    width: 82%;
	    bottom: 15pt;
	    left: 40pt;
	    right: 40pt;
	    border-top: 1pt solid #c1c1c1;
	    border-bottom: 1pt solid #c1c1c1;
	    font-size: 6pt;
	  }

		.col
		{
		    float: left;
		    width: 25%;
		}

		.last{
		    float: right;
		    width: 25%;
		}


	</style>




<?php 
$header_filter = true;

if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
	  $id = $row[id];

	  if($header_filter){
	  	echo '
<page  backtop="25mm" backbottom="55mm" backleft="15mm" backright="15mm">

  <page_footer class="page_footer">

	  <div class="footer">
		  <div class="col">
			  Baris Sarial<br>
				Prenzlauer Promenade 176<br>
				13189 Berlin<br>
		  </div>
		  <div class="col">
			  UStID: DE 14 504 01802<br>
				www.crosscreations.de<br>
				kontakt@crosscreations.de<br>
		  </div>
		  <div class="col">
			  Berliner Sparkasse<br>
				IBAN: DE13 1005 0000 6016 7021 43<br>
				BIC: BELADEBEXXX<br>
		  </div>
		  <div class="last">
		  crosscreations.de<br>
			  grafikdesign & technologien
		  </div>
	  </div>

    [[page_cu]]/[[page_nb]]

  </page_footer>


<div class="header_wrapper">
	<div class="left">
		<div class="customer_label">Empfänger:</div>
		<div class="customer_address">
			<b>' . $row[company] . '</b><br>'
			. $row[street] . '<br>'
			. $row[street_ext] . '<br>'
			. $row[city] . '
		</div>
		<div class="customer_sender">Baris Sarial / Prenzlauer Promenade 176 /13189 Berlin</div>
		<div class="letter_topic">Kostenvoranschlag</div>
	</div>
	<div class="right">
		<b>Baris Sarial</b><br><br>
		Prenzlauer Promenade 176<br>
		13189 Berlin<br><br>
		www.crosscreations.de<br>
		rechnung@crosscreations.de<br><br>
		UStID: DE 14 504 01802<br><br><br>
		Berlin, ' . date( 'd.m.Y') . '
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

		echo '
				<tr>
					<td width="360" height="15" class="table_content table_content_description">'. $row[position_name] .'</td>
					<td width="70" height="15" class="table_content"">'. $row[rate] .'</td>
					<td width="70" height="15" class="table_content"">'. $row[position_hours] .'</td>
					<td width="80" height="15" class="table_content table_content_last">'. number_format($row[position_hours] * $row[rate],2,',','.') .'</td>
				</tr>';
		
$price_all += $row[position_hours] * $row[rate];


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
	<p><b>Hinweise</b>: Dieser Kostenvoranschlag ist unverbindlich. Ich behalte es mir vor, unvorhersehbaren Mehraufwand zusätzlich zu berechnen. Dieser kann nicht pauschal berechnet werden, liegt aber im Schnitt bei 10 - 20% des Bruttowertes. Zusätzlich anfallende Kosten für Server, Lizenzen, Schriftarten o.Ä. sind nicht inbegriffen und werden dem Kunden in Rechnung gestellt. Relevante Abweichungen werden zeitnah kommuniziert. Ich freue mich über die Erteilung des Auftrages.</p><br>
	<p>Mit freundlichen Grüßen</p><br>
	<p>Baris Sarial</p>

</div>
</div>

</page>
<?php

$output = ob_get_clean();
$pdf->writeHTML($output);

$pdf->Output();

$html .= '
	';
//WriteHTMLCell
$pdf->WriteHTML(utf8_encode($html));	


//output
//$pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'dodo/documents/kv/name.pdf','F');
?>







