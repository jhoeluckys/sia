<?php
if (!isset($_SESSION)) {
	session_start();
}

require_once "fpdf.php";

class PDF extends FPDF {

	function Header()
	{
		$this->SetFont('Times','B',14);
		$this->Cell(0,5,'ARCHIVO REGIONAL', 0, 0, 'C');
		$this->Ln();
		$this->SetFont('Arial','B',14);
		$this->Cell(0,5,utf8_decode('PUNO'), 0, 0, 'C');
		$this->Ln();
		$this->SetFont('Arial','B',11);
		$this->Cell(0,5,utf8_decode('SIA (SISTEMA DE INDEXACIÓN DEL ARCHIVO)'), 0, 0, 'C');
		$this->Ln();
		$this->Ln(2);
		$this->SetFont('arial','B',12);
		$this->Cell(0,5,utf8_decode("Listado de Todos los Ínices Registrados"), 0, 0, 'C');
		$this->Ln();
		
		$this->Ln(4);
		$this->cabecera();
		
	}
	
	function cabecera()
	{
		$this->SetFont('arial','B',7);
		$this->Cell(7,5,utf8_decode('N°'), 1, 0, 'C');
		$this->Cell(13,5,'NÚMERO', 1, 0, 'C');
		$this->Cell(60,5,'NOMBRE NOTARIO', 1, 0, 'C');
		$this->Cell(60,5,'OTORGANTE', 1, 0, 'C');
		$this->Cell(60,5,'FAVORECIDO', 1, 0, 'C');
		$this->Cell(60,5,'FECHA', 1, 0, 'C');
		$this->Cell(60,5,'SERIE', 1, 0, 'C');
		$this->Cell(60,5,'FOLIO', 1, 0, 'C');
		$this->Cell(60,5,'ESCRITURA', 1, 0, 'C');
		$this->Cell(60,5,'NOMBRE DEL BIEN', 1, 0, 'C');
		//$this->Cell(30,5,'CLAVE', 1, 0, 'C');
		$this->Ln();
		$this->Ln(1);
	}
	
	function Footer()
	{
		$vFecha = getdate(time());
		$this->SetFont('arial','',8);
		$this->Line(20, 277, 190, 277);
		$this->SetY(-20);
		$vFecha = date("d-m-Y H:i:s");
		$this->Cell(120, 4,"Fecha: ".$vFecha, 0,0,'L');
		$this->Cell(50, 4,'WebApp',0,0,'R');

	}
	function Body($usuarios)
	{			
		//global $sEstupdf;
		$this->SetFont('arial','',8);
		$vCont = 1;
		foreach ($usuarios as $clave => $usuario) {
			$this->Cell(7,5, $vCont, 'B', 0, 'C');
			$this->Cell(13,5, $usuario['codIndice'], 'B', 0, 'C');
			$this->Cell(60,5, ucwords(strtolower($usuario['notario'])), 'B', 0, 'L');
			//$this->Cell(60,5, ucwords(strtolower($usuario['paterno'].' '.$usuario['materno'].' '.$usuario['nombres'])), 'B', 0, 'L');
			$this->Cell(60,5, ucwords(strtolower($usuario['otorgante'])), 'B', 0, 'L');
			$this->Cell(60,5, ucwords(strtolower($usuario['favorecido'])), 'B', 0, 'L');
			$this->Cell(60,5, ucwords(strtolower($usuario['fecha'])), 'B', 0, 'L');
			$this->Cell(60,5, ucwords(strtolower($usuario['subserie'])), 'B', 0, 'L');
			$this->Cell(60,5, ucwords(strtolower($usuario['folio'])), 'B', 0, 'L');
			$this->Cell(60,5, ucwords(strtolower($usuario['escritura'])), 'B', 0, 'L');
			$this->Cell(60,5, ucwords(strtolower($usuario['bien'])), 'B', 0, 'L');
			//$this->Cell(30,5,$usuario['clave'], 'B', 0, 'C');
			$this->Ln();
			$vCont++;
		}
	}
}


$pdf=new PDF('P', 'mm', 'A4');
$pdf->SetMargins(20, 20);
$pdf->AliasNbPages();
$pdf->AddFont('arialn','','arialn.php');
$pdf->AddFont('arialn','B','arialnb.php');
$pdf->AddPage();
$pdf->Body($_SESSION['oPDF']);

$pdf->Output();


?>