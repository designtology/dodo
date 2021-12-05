<?php
//include library
include('../tcpdf/tcpdf.php'); 

//make TCPDF object
$pdf = new TCPDF('P','mm','A4', false, 'ISO-8', false);
setlocale(LC_CTYPE, 'de_DE');


//custom header and footer
class MYPDF extends TCPDF {
	public function Header() {
	    $headerData = $this->getHeaderData();
	    $this->SetFont('helvetica', 'B', 10);
	    $this->writeHTML($headerData['string']);
	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='<table cellspacing="0" cellpadding="1" border="1"><tr><td rowspan="3">test</td><td>test</td></tr></table>', $tc=array(0,0,0), $lc=array(0,0,0));

$pdf->setPrintFooter(false);

//add page
$pdf->AddPage();

//add content (student list)
//title
$pdf->SetFont('futurabook','',18);
$pdf->Cell(190,10,"University of Insert Names Here",0,1,'C');

$pdf->SetFont('futurabook','',8);
$pdf->Cell(190,5,"Student List",0,1,'C');

$pdf->SetFont('futurabook','',10);
$pdf->Cell(30,5,"Class",0);
$pdf->Cell(160,5,": Programming 101",0);
$pdf->Ln();
$pdf->Cell(30,5,"Teacher Name",0);
$pdf->Cell(160,5,": Prof. John Smith",0);
$pdf->Ln();
$pdf->Ln(2);



include ("../database.php");
require_once('../secondstohuman.php');
include('../calc_time_diff.php');



$sql = "SELECT project,rate,priceclass_name,company_id,position_name,company,start_date,deadline,hours,position_hours,priceclass,hours_worked,price,active,positions.id FROM priceclass,positions,kunden,projects WHERE projects.company_id = kunden.id AND positions.project_id = projects.id AND priceclass.id = positions.priceclass AND projects.id = 1 AND active = 'true' ORDER BY projects.id";

$result = mysqli_query($conn, $sql);
$show_title = true;
$hours_all = 0;
$hours_worked_all = 0;
$price_all = 0;
$pdf->SetFont('futuraheavy','',8);

$header = '
			<table>
				<thead>
					<tr style="background-color:#f2f2f2; color:#000;">
						<td width="290" height="15" style="font-size: 8pt; border-bottom:1px solid black; border-right:1px solid black;">Leistungsbeschreibung</td>
						<td width="60" height="15" style="text-align:right;	font-size: 8pt; border-bottom:1px solid black; border-right:1px solid black;">Preis in EUR</td>
						<td width="60" height="15" style="text-align:right; font-size: 8pt; border-bottom:1px solid black; border-right:1px solid black;">Menge</td>
						<td width="70" height="15" style="text-align:right; font-size: 8pt; border-bottom:1px solid black;">Gesamt in EUR</td>
					</tr>
				</thead>
			</table>
			';

$pdf->WriteHTMLCell(0,0,20,130,utf8_encode($header),0);	

if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
	  $id = $row[id];
		$pdf->SetFont('futurabook','',8);

		$html .= '
				<tr>
					<td width="290" height="15" style="">'. $row[position_name] .'</td>
					<td width="60" height="15" style="text-align:right;">'. $row[rate] .'</td>
					<td width="60" height="15" style="text-align:right;">'. $row[position_hours] .'</td>
					<td width="70" height="15" style="text-align:right;">'. number_format($row[position_hours] * $row[rate],0,',','.') .'</td>
				</tr>';
		
  }

}

$html .= '
	</table>
	<style>
		table {
			border-collapse:collapse;
			border: none;
		}

thead{
}

		td{
			height: 16px;
		}

		td:not(:last-child) {
			border-bottom: 1px solid black;
			border-right: 1px solid black;
		}

		table tr th {
			background-color:#888;
			color:#fff;
			font-weight:bold;
		}
	</style>';
//WriteHTMLCell
$pdf->WriteHTMLCell(0,0,20,135,utf8_encode($html),0);	


//output
$pdf->Output();
//$pdf->Output($_SERVER['DOCUMENT_ROOT'] . 'dodo/documents/kv/name.pdf','F');
?>







