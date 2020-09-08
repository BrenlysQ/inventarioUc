<?php 
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");
include("funciones.php");

$bd=new bd_conexion();


$datos_equipo = explode("-", $_POST['nombre_equipo']);
$querry_insertar_datos="
INSERT INTO  inventario_equipo
(
ID_EQUIPO,
SERIAL,
SERIAL_UST,
id_dependencia,
ID_LUGAR_UBI,
ID_USO_EQUIPO,
ID_ACCION,
RESPONSABLE,
OBSERVACIONES,
ID_CONDICION,
MARCA,
MODELO,
USO,
TRANSCRIPTOR
)
VALUES (
'".$datos_equipo[0]."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['serial_equipo'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['serial_ust'])))."',
'".$_POST['id_departamento']."',
'".$_POST['ubicacion']."',
'".$_POST['uso_equipo']."',
'".$_POST['accion_equipo']."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['responsable'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['descripcion'])))."',
'".$_POST['condicion_equipo']."',
'".htmlspecialchars( stripslashes((string)$_POST['marca']))."',
'".htmlspecialchars( stripslashes((string)$_POST['modelo']))."',
'".htmlspecialchars( stripslashes((string)$_POST['en_uso']))."',
'".$_POST['usuario_tecnico']."'
)		
";
//echo $querry_insertar_datos;
$bd->ejecutarQuery($querry_insertar_datos);	

$var_id_inventario_equipo = mysql_insert_id();

/////SI EL EQUIPO SELECCIONADO ES MOUSE 
if ($datos_equipo[1]=="MOUSE"){
$querry_insertar_datos_mouse="
INSERT INTO  inventario_equipo_mouse
(
ID_INVENTARIO,
MODELO,
CONECTOR
)
VALUES (
'".$var_id_inventario_equipo."',
'".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['modelo_mouse'])))."',
'".$_POST['conector_mouse']."'
)		
";
//echo $querry_insertar_datos_mouse;
$bd->ejecutarQuery($querry_insertar_datos_mouse);	
} 

/////SI EL EQUIPO SELECCIONADO ES MONITOR  
if ($datos_equipo[1]=="MONITOR"){
$querry_insertar_datos_monitor="
INSERT INTO  inventario_equipo_monitor
(
ID_INVENTARIO,
MODELO
)
VALUES (
'".$var_id_inventario_equipo."',
'".$_POST['modelo_monitor']."'
)		
";
//echo $querry_insertar_datos_monitor;
$bd->ejecutarQuery($querry_insertar_datos_monitor);	
}

/////SI EL EQUIPO SELECCIONADO ES PC  
if ($datos_equipo[1]=="PC"){
$querry_insertar_datos_pc="
INSERT INTO  inventario_equipo_pc
(
ID_INVENTARIO,
CPU,
PROCESADOR_MARCA,
PROCESADOR_TIPO,
PROCESADOR_VELOCIDAD,
MEMORIA_CAPACIDAD,
MEMORIA_TIPO,
DISCO_DURO_CAPACIDAD,
DISCO_DURO_TIPO,
UNIDADES_LECTURA
)
VALUES (
'".$var_id_inventario_equipo."',
'".$_POST['cpu_pc']."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['marca_procesador'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['tipo_procesador'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['velocidad_procesador'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_capacidad'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_tipo'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_capacidad'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_tipo'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['unidad_lectura_escritura'][0])))."'
)		
";
//echo $querry_insertar_datos_pc;
$bd->ejecutarQuery($querry_insertar_datos_pc);	
}


/////SI EL EQUIPO SELECCIONADO ES LAPTO  
if ($datos_equipo[1]=="LAPTOP"){
$querry_insertar_datos_lapto="
INSERT INTO inventario_equipo_lapto
(
ID_INVENTARIO,
PROCESADOR_MARCA,
PROCESADOR_TIPO,
PROCESADOR_VELOCIDAD,
MEMORIA_CAPACIDAD,
MEMORIA_TIPO,
DISCO_DURO_CAPACIDAD,
DISCO_DURO_TIPO,
UNIDADES_LECTURA
)
VALUES (
'".$var_id_inventario_equipo."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['marca_procesador'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['tipo_procesador'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['velocidad_procesador'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_capacidad'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_tipo'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_capacidad'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_tipo'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['unidad_lectura_escritura'][0])))."'
)		
";
//echo $querry_insertar_datos_lapto;
$bd->ejecutarQuery($querry_insertar_datos_lapto);	
}


echo 'Datos Ingresados Satisfactoriamente';

echo "<script> 

$(':input','#formulario')
 .not(':button, :submit, :reset, :hidden')
 .val('')
 .removeAttr('checked')
 .removeAttr('selected');
 
 $('.select2-search-choice').remove();
 
 $('#nombre_equipo').select2('val', '');
 $('#condicion_equipo').select2('val', '');
 $('#id_tecnico').select2('val', '');
 $('#id_departamento').select2('val', '');
 $('#ubicacion').select2('val', '');
 $('#uso_equipo').select2('val', '');
 $('#accion_equipo').select2('val', '');
 $('#en_uso').select2('val', '');
 
</script>";
?>
