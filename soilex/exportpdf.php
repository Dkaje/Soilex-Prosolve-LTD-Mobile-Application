<?php

require('fpdf183/fpdf.php');
require('includes/config.php');
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('assets/images/ic-logo.png',10,-1,70);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(80,10,'Approved customers',1,0,'C');
    // Line break
    $this->Ln(20);
}
 
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

 
// $db = new dbObj();
// $connString =  $db->getConnstring();
}
$display_heading = array('id'=>'ID', 'email'=> 'Email', 'password'=> 'Password', 'fname'=> 'First name', 'sname'=> 'Second name','gender'=> 'Gender','phone'=> 'Phone','address'=> 'Address','status'=> 'Status');
 
$result = mysqli_query($connect, "SELECT `id`, `email`, `password`, `fname`, `sname`, `gender`, `phone`, `address`, `status` FROM `tbl_customer` WHERE status='1'") or die("Location: index.php");
$header = mysqli_query($connect, "SHOW columns FROM tbl_customer");
 
$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',6);
foreach($header as $heading) {
$pdf->Cell(20,12,$display_heading[$heading['Field']],1);
}
foreach($result as $row) {
$pdf->Ln();
foreach($row as $column)
$pdf->Cell(20,12,$column,1);
}
$pdf->Output();



?>