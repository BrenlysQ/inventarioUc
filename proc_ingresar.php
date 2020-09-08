<?php 
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");
include("funciones.php");

$bd=new bd_conexion();


$datos_equipo = explode("-", $_POST['nombre_equipo']);
/*
echo 'Ok';
print_r($_POST);
print_r($_FILES);

echo  $_SERVER['DOCUMENT_ROOT'].('/inventario_general/images_inventario_equipo/'.$extension );
die();*/


$querry_insertar_datos="
INSERT INTO  inventario_equipo
(
ID_EQUIPO,
SERIAL,
SERIAL_UST,
SERIAL_FACYT,
id_dependencia,
UBICACION,
ID_USO_EQUIPO,
ID_ACCION,
RESPONSABLE,
OBSERVACIONES,
ID_CONDICION,
DIAGNOSTICO,
MARCA,
MODELO,
USO,
GARANTIA,
ANNO_GARANTIA,
PERTENECE_PROYECYO,
DESCRIPCION_PROYECTO,
TRANSCRIPTOR
)
VALUES (
'".$datos_equipo[0]."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['serial_equipo'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['serial_ust'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['serial_facyt'])))."',
'".$_POST['id_departamento']."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['ubicacion'])))."',
'".$_POST['uso_equipo']."',
'".$_POST['accion_equipo']."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['responsable'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['descripcion'])))."',
'".$_POST['condicion_equipo']."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['diagnostico'])))."',
'".htmlspecialchars( stripslashes((string)$_POST['marca']))."',
'".htmlspecialchars( stripslashes((string)$_POST['modelo']))."',
'".htmlspecialchars( stripslashes((string)$_POST['en_uso']))."',
'".htmlspecialchars( stripslashes((string)$_POST['garantia']))."',
'".$_POST['anno_garantia_equipo']."',
'".htmlspecialchars( stripslashes((string)$_POST['per_proyecto']))."',
'".htmlspecialchars( stripslashes((string)$_POST['desc_proyecto']))."',
'".htmlspecialchars( stripslashes((string)$_POST['id_tecnico']))."'
)		
";
//echo $querry_insertar_datos;
$bd->ejecutarQuery($querry_insertar_datos);	

$var_id_inventario_equipo = mysql_insert_id();

if($_POST['condicion_equipo']==1){

if($_POST['pieza_dannada']!='' || $_POST['recomendacion_tec']!=''  ){
$querry_insertar_datos_equipo_malo="
INSERT INTO  equipo_malo
(
ID_INVENTARIO,
PIEZA_DANNADA,
RECOMENDACION_TECNICO
)
VALUES (
'".$var_id_inventario_equipo."',
'".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['pieza_dannada'])))."',
'".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['recomendacion_tec'])))."'
)		
";
//echo $querry_insertar_datos_mouse;
$bd->ejecutarQuery($querry_insertar_datos_equipo_malo);	

}
}

/*
////SUBIR IMAGEN
if($_FILES['imagen_i']['name']!=''){

$dir_subida =  $_SERVER['DOCUMENT_ROOT'].('/inventario_general/images_inventario_equipo/');
$extension = end(explode(".", $_FILES["imagen_i"]["name"]));
$nombre_imagen=$var_id_inventario_equipo.'_INVENTARIO_GENERAL_'.date("Y_m_d").'.'.$extension;

$fichero_subido = $dir_subida.$nombre_imagen;


if (move_uploaded_file($_FILES['imagen_i']['tmp_name'], $fichero_subido)) {
} else {
    echo "&iexcl;Error al subir la imagen!\n";
}



$querry_editar_datos_inventario="
UPDATE inventario_equipo SET 
DIR_IMAGEN='".$nombre_imagen."'
WHERE  ID_INVENTARIO='".$var_id_inventario_equipo."'	
";
//echo $querry_editar_datos;
$bd->ejecutarQuery($querry_editar_datos_inventario);	
}*/
/////FIN SUBIR IMAGEN


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

/////SI EL EQUIPO SELECCIONADO ES IMPRESORA
if ($datos_equipo[1]=="IMPRESORA"){
$querry_insertar_datos_impresora="
INSERT INTO  inventario_equipo_impresora
(
ID_INVENTARIO,
TIPO_TONER,
FECHA_MTTO,
CURRENT_PREVENT
)
VALUES (
'".$var_id_inventario_equipo."',
'".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['toner_impresora'])))."',
'".$_POST['ult_mtto']."',
'".$_POST['Mtto_correct_prevent']."'
)		
";
//echo $querry_insertar_datos_mouse;
$bd->ejecutarQuery($querry_insertar_datos_impresora);	
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

if($_POST['marca_procesador_p']=='')$_POST['marca_procesador_p']=23;

$querry_insertar_datos_pc="
INSERT INTO  inventario_equipo_pc
(
ID_INVENTARIO,
CPU,
ID_MARCA_PRO,
PROCESADOR_VELOCIDAD,
MEMORIA_CAPACIDAD,
MEMORIA_TIPO,
DISCO_DURO_CAPACIDAD,
DISCO_DURO_TIPO,
UNIDADES_LECTURA,
FECHA_MTTO,
CORRECT_PREVENT
)
VALUES (
'".$var_id_inventario_equipo."',
'".$_POST['cpu_pc']."',
'".$_POST['marca_procesador_p']."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['velocidad_procesador'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_capacidad'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_tipo'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_capacidad'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_tipo'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['unidad_lectura_escritura'][0])))."',	
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['ult_mtto'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['Mtto_correct_prevent'])))."'
)
";
//echo $querry_insertar_datos_pc;
$bd->ejecutarQuery($querry_insertar_datos_pc);	
}


/////SI EL EQUIPO SELECCIONADO ES LAPTO  
if ($datos_equipo[1]=="LAPTOP"){

if($_POST['marca_procesador_l']=='')$_POST['marca_procesador_p']=23;

$querry_insertar_datos_lapto="
INSERT INTO inventario_equipo_lapto
(
ID_INVENTARIO,
ID_MARCA_PRO,
PROCESADOR_VELOCIDAD,
MEMORIA_CAPACIDAD,
MEMORIA_TIPO,
DISCO_DURO_CAPACIDAD,
DISCO_DURO_TIPO,
UNIDADES_LECTURA,
FECHA_MTTO,
CORRECT_PREVENT
)
VALUES (
'".$var_id_inventario_equipo."',
'".$_POST['marca_procesador_l']."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['velocidad_procesador'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_capacidad'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_tipo'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_capacidad'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_tipo'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['unidad_lectura_escritura'][0])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['ult_mtto'])))."',
'".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['Mtto_correct_prevent'])))."'
)		
";
//echo $querry_insertar_datos_lapto;
$bd->ejecutarQuery($querry_insertar_datos_lapto);	
}


echo 'Datos Ingresados Satisfactoriamente';

echo "<script> 

function clearFileInput(ctrl) {
  try {
    ctrl.value = null;
  } catch(ex) { }
  if (ctrl.value) {
    ctrl.parentNode.replaceChild(ctrl.cloneNode(true), ctrl);
  }
}

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
 $('#garantia').select2('val', '');
 $('#en_uso').select2('val', '');

document.getElementById('formulario').reset();
  $('html,body').animate({scrollTop: $('#ejecutado').offset().top}, 1000); 

</script>";

?>