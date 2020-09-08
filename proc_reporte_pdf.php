<?php 
include("lib/bd_conexion.php");
include("funciones.php");
require("lib/fpdf.php");


//print_r($_POST);
$datos_pdf=$_GET['datos'];


$datos_pdf=array_recibe($datos_pdf);
//$datos_busq=array_recibe($datos_busq);

//print_r($datos_pdf);
//echo $_GET['arry_bus_colum'];
//echo $_GET['arry_bus_par'];

//die();


$bd=new bd_conexion();

$tabla_segunda_busq='';
$condiciones_reporte='';
$valores_retornar='';
$completar_nombre_tabl='';



$datos_equipo = explode("-", $datos_pdf['nombre_equipo']);

$valores_retornar='a.*, c.DESCRIPCION,d.dependen, e.DESCRIPCION,UPPER(f.NOMBRE),g.DESCRIPCION,h.DESCRIPCION ';
$condiciones_reporte=' a.ID_EQUIPO=c.ID_EQUIPO AND a.id_dependencia=d.id_dependencia AND a.ID_CONDICION=e.ID_CONDICION AND
a.TRANSCRIPTOR=f.USUARIO AND g.ID_USO_EQUIPO=a.ID_USO_EQUIPO ';


if($datos_equipo[1]=='PC')$completar_nombre_tabl='pc';
if($datos_equipo[1]=='LAPTOP')$completar_nombre_tabl='lapto';

if($datos_pdf['nombre_equipo']=='' && $datos_pdf['condicion_equipo']=='' && $datos_pdf['id_departamento']==''){
//echo 'ssssssss';
	$header = array('EQUIPO','DEPENDENCIA','CONDICION','CUSTODIO');///columnas imprimir en el reporte
	$column = array('23','24','25','9');//columnas base de datos
}

if($datos_pdf['nombre_equipo']!=''){
	$header = array('DEPENDENCIA','CONDICION','CUSTODIO','EQUIPO');///columnas imprimir en el reporte
	$column = array('24','25','9','23');//columnas base de datos
	//$valores_retornar=',a.ID_EQUIPO';
	$condiciones_reporte.=' AND a.ID_EQUIPO='.$datos_equipo[0];
	$titulo_adicional.=' de '.$datos_equipo[1];
	//echo $condiciones_reporte; 
	}
	
if($datos_pdf['condicion_equipo']!=''){
	$header = array('EQUIPO','DEPENDENCIA','CUSTODIO','CONDICION');///columnas imprimir en el reporte
	$column = array('23','24','9','25');//columnas base de datos
	//$valores_retornar=',a.ID_CONDICION';
	$condiciones_reporte.=' AND a.ID_CONDICION='.$datos_pdf['condicion_equipo'];
	$condicion_des=$bd->consultaObjeto(array("DESCRIPCION"),"condicion","ID_CONDICION='".$datos_pdf['condicion_equipo']."'",0);
	$titulo_adicional.=' '.ucwords (strtolower ($condicion_des[0]->DESCRIPCION));
}

if($datos_pdf['id_tecnico']!=''){
	$header = array('EQUIPO','CONDICION','CUSTODIO','DEPENDENCIA','TECNICO');///columnas imprimir en el reporte
	$column = array('23','25','9','24','26');//columnas base de datos
	//$valores_retornar=',a.TRANSCRIPTOR';
	$condiciones_reporte.=" AND a.TRANSCRIPTOR='".$datos_pdf['id_tecnico']."'";
	$tecnico_nombre=$bd->consultaObjeto(array("NOMBRE"),"tecnico","USUARIO='".$datos_pdf['id_tecnico']."'",0);
	$titulo_adicional.=' Tecnico:'.ucwords (strtolower ($tecnico_nombre[0]->NOMBRE));
	
}

if($datos_pdf['id_departamento']!=''){
	$header = array('EQUIPO','CONDICION','CUSTODIO','DEPENDENCIA');///columnas imprimir en el reporte
	$column = array('23','25','9','24');//columnas base de datos
	//$valores_retornar=',a.id_dependencia';
	$condiciones_reporte.=' AND a.id_dependencia='.$datos_pdf['id_departamento'];
	$departamento=$bd->consultaObjeto(array("dependen"),"dec_dependencia","id_dependencia='".$datos_pdf['id_departamento']."'",0);
	$titulo_adicional.=' '.ucwords (strtolower ($departamento[0]->dependen));
}

if($datos_pdf['uso_equipo']!=''){
	$header = array('EQUIPO','CONDICION','CUSTODIO','DEPENDENCIA','USO');///columnas imprimir en el reporte
	$column = array('23','25','9','24','27');//columnas base de datos
	//$valores_retornar=',a.ID_USO_EQUIPO';
	$condiciones_reporte.=' AND a.ID_USO_EQUIPO='.$datos_pdf['uso_equipo'];
}

if($datos_pdf['accion_equipo']!=''){
	$header = array('EQUIPO','CONDICION','CUSTODIO','DEPENDENCIA','ACCION');///columnas imprimir en el reporte
	$column = array('23','25','9','24','28');//columnas base de datos
	//$valores_retornar=',a.ID_ACCION';
	$condiciones_reporte.=' AND a.ID_ACCION='.$datos_pdf['accion_equipo'];
	//$tabla_segunda_busq.=',accion f';
}

if($datos_pdf['garantia']!=''){
	$header = array('EQUIPO','CONDICION','CUSTODIO','DEPENDENCIA','GARANTIA');///columnas imprimir en el reporte
	$column = array('23','25','9','24','16');//columnas base de datos
	//$valores_retornar=',a.GARANTIA';
	$condiciones_reporte.=" AND a.GARANTIA='".$datos_pdf['garantia']."'";
}

if($datos_pdf['per_proyecto']!=''){
	$header = array('EQUIPO','CONDICION','CUSTODIO','DEPENDENCIA','PROYECTO');///columnas imprimir en el reporte
	$column = array('23','25','9','24','18');//columnas base de datos
	//$valores_retornar.=',a.PROYECYO';
	$condiciones_reporte.=" AND a.PERTENECE_PROYECYO='".$datos_pdf['per_proyecto']."'";
}

if($datos_pdf['proc_marca']!=''){
	$header = array('EQUIPO','CONDICION','CUSTODIO','DEPENDENCIA','PROSC. MARCA');///columnas imprimir en el reporte
	$column = array('23','25','9','24','29');//columnas base de datos
	
	$valores_retornar.=',m.DESCRIPCION';
	$tabla_segunda_busq=',inventario_equipo_'.$completar_nombre_tabl.' b, marca_procesador m';
	$condiciones_reporte.=" AND m.ID_MARCA_PRO='".$datos_pdf['proc_marca']."'";
	$condiciones_reporte.=' AND m.ID_MARCA_PRO=b.ID_MARCA_PRO AND b.ID_INVENTARIO=a.ID_INVENTARIO';
	
}


if($datos_equipo[1]=='PC' && $datos_pdf['cpu_pc']!='' ){
	if($tabla_segunda_busq==''){
		$tabla_segunda_busq=',inventario_equipo_'.$completar_nombre_tabl.' b';
		}
	
	$condiciones_reporte.=" AND b.CPU='".$datos_pdf['cpu_pc']."'  AND b.ID_INVENTARIO=a.ID_INVENTARIO";	
	$titulo_adicional.=' '.$datos_pdf['cpu_pc'];

}


//$forma_buscar=$_POST['array_tabla_ord'][0][1];
$b='';
$posicion_columna=$_GET['arry_bus_colum'];
$forma_buscar=$_GET['arry_bus_par'];


if($column[$posicion_columna]=='23')$b='c.DESCRIPCION'; //EQUIPO
if($column[$posicion_columna]=='24')$b='d.dependen'; //DEPENDENCIA
if($column[$posicion_columna]=='25')$b='e.DESCRIPCION'; //CONDICION
if($column[$posicion_columna]=='9')$b='a.RESPONSABLE';  //CUSTODIO
if($column[$posicion_columna]=='29')$b='b.PROCESADOR_MARCA ';
if($column[$posicion_columna]=='30')$b='b.PROCESADOR_TIPO'; 
if($column[$posicion_columna]=='26')$b='UPPER(f.NOMBRE)';  
if($column[$posicion_columna]=='27')$b='g.DESCRIPCION'; 
if($column[$posicion_columna]=='28')$b='h.DESCRIPCION'; 
if($column[$posicion_columna]=='16')$b='a.GARANTIA'; 
if($column[$posicion_columna]=='18')$b='a.,h.DESCRIPCION';  

$titulo = array('1' => 'Reporte Inventario'.$titulo_adicional);



$query_reporte="
SELECT ".$valores_retornar." FROM inventario_equipo a, equipo c, dec_dependencia d, condicion e, tecnico f,uso_equipo g, accion h ".$tabla_segunda_busq."  
WHERE ".$condiciones_reporte." ORDER BY ".$b." " .$forma_buscar."  
";

//echo $query_reporte; 
$datos_reporte_generado=$bd->consultaQuery($query_reporte);

//echo'<pre>';print_r($datos_reporte_generado);echo '</pre>';
//die();
			  $pdf = new PDF();
			  $pdf->AliasNbPages();
			  $pdf->AddPage();
			  $pdf->SetFont('Arial','',11);
			  $pdf->tabla($header,$datos_reporte_generado,$column,$titulo,'1');
			  $pdf->Output('I');		
?>