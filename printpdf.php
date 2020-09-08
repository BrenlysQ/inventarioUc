<?php 
				include("bd.php");
			  require("lib/fpdf.php");
		      $data = new database();
	          $querynot = "SELECT * FROM `datos`";
              $apunt = $data->openConnectionWithReturn($querynot);
			  while ($val = mysql_fetch_assoc($apunt)){
			  	$dat[] = $val;
			  }
			  //echo "<pre>echo_pre:<br /><br />";
			  //echo print_r($dat, TRUE)."<br /><br />/echo_pre</pre>";
			  $header = array('ID','Nombre','Direccion','Correo','Pais');
			  $column = array('id','Nombre','Direccion','correo','Nacionalidad');
			  $titulo = array('1' => 'Pruebas en PHP','2'=>'Esto es para Yefraina');
			  $pdf = new PDF();
			  $pdf->AliasNbPages();
			  $pdf->AddPage();
			  $pdf->SetFont('Arial','',12);
			  $pdf->tabla($header,$dat,$column,$titulo);
			  $pdf->Output('I');			
?>
