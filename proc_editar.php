<?php 
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");
include("funciones.php");

$bd=new bd_conexion();

/*
echo 'Ok';
print_r($_POST);
print_r($_FILES);

echo  $_SERVER['DOCUMENT_ROOT'].('/inventario_general/images_inventario_equipo/'.$extension );
die();*/

//echo'<pre>';print_r($_POST);echo'</pre>';die();

$datos_equipo = explode("-", $_POST['nombre_equipo']);

$nombre_equipo=$bd->consultaObjeto(array("DESCRIPCION"),"equipo","1 and ID_EQUIPO='".$_POST['nombre_equipo_ant']."'",0);

if($_POST['per_proyecto']=='NO'){$_POST['desc_proyecto']='';}

if($datos_equipo[0]!=$_POST['nombre_equipo_ant']){
$querry_editar_datos="
UPDATE inventario_equipo SET 
ID_EQUIPO='".$datos_equipo[0]."',
SERIAL='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['serial_equipo'])))."',
SERIAL_UST='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['serial_ust'])))."',
id_dependencia='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['id_departamento'])))."',
UBICACION='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['ubicacion'])))."',
ID_USO_EQUIPO='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['uso_equipo'])))."',
ID_ACCION='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['accion_equipo'])))."',
RESPONSABLE='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['responsable'])))."',
OBSERVACIONES='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['descripcion'])))."',
ID_CONDICION='".$_POST['condicion_equipo']."',
DIAGNOSTICO='".$_POST['diagnostico']."',
MARCA='".htmlspecialchars( stripslashes((string)$_POST['marca']))."',
MODELO='".htmlspecialchars( stripslashes((string)$_POST['modelo']))."',
USO='".htmlspecialchars( stripslashes((string)$_POST['en_uso']))."',
GARANTIA='".htmlspecialchars( stripslashes((string)$_POST['garantia']))."',
ANNO_GARANTIA='".$_POST['anno_garantia_equipo']."',
PERTENECE_PROYECYO='".htmlspecialchars( stripslashes((string)$_POST['per_proyecto']))."',
DESCRIPCION_PROYECTO='".htmlspecialchars( stripslashes((string)$_POST['desc_proyecto']))."'
WHERE  ID_INVENTARIO='".$_POST['id_inventario']."'	
";
//echo $querry_editar_datos;
$bd->ejecutarQuery($querry_editar_datos);	


///SI EL EQUIPO ESTA MALO
if($_POST['condicion_equipo']=='1'){
$si_esta_malo=$bd->consultaObjeto(array("ID_EQUIPO_MALO"),"equipo_malo","1 and ID_INVENTARIO='".$_POST['id_inventario']."'",0);

if($si_esta_malo[0]->ID_EQUIPO_MALO!=''){
$querry_editar_equipo_malo="
UPDATE equipo_malo SET 
PIEZA_DANNADA='".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['pieza_dannada'])))."',
RECOMENDACION_TECNICO='".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['recomendacion_tec'])))."'
WHERE  ID_INVENTARIO='".$_POST['id_inventario']."'	
";
//echo $querry_editar_datos;
$bd->ejecutarQuery($querry_editar_equipo_malo);	
}
else{
$querry_insertar_datos_equipo_malo="
INSERT INTO  equipo_malo
(
ID_INVENTARIO,
PIEZA_DANNADA,
RECOMENDACION_TECNICO
)
VALUES (
'".$_POST['id_inventario']."',
'".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['pieza_dannada'])))."',
'".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['recomendacion_tec'])))."'
)		
";
//echo $querry_insertar_datos_mouse;
$bd->ejecutarQuery($querry_insertar_datos_equipo_malo);	

}
}
else{
$querry_eliminar_datos_equipo_malo="DELETE FROM equipo_malo WHERE ID_INVENTARIO='".$_POST['id_inventario']."'";
//echo $querry_eliminar_datos_mouse;
$bd->ejecutarQuery($querry_eliminar_datos_equipo_malo);	
}
//FIN EQUIPO MALO


////SUBIR IMAGEN
//echo $_FILES['imagen_i']['name'];
if($_FILES['imagen_i']['name']!=''){

$dir_subida =  $_SERVER['DOCUMENT_ROOT'].('/inventario/images_inventario_equipo/');
///eliminando imagen servidor
if($_POST['imagen_anterior']!='')unlink($dir_subida.$_POST['imagen_anterior']);//sabiendo que estos son los parametros para tu caso 


$dir_subida =  $_SERVER['DOCUMENT_ROOT'].('/inventario/images_inventario_equipo/');
$extension = end(explode(".", $_FILES["imagen_i"]["name"]));
$nombre_imagen=$_POST['id_inventario'].'_INVENTARIO_GENERAL_'.date("Y_m_d").'.'.$extension;

$fichero_subido = $dir_subida.$nombre_imagen;


if (move_uploaded_file($_FILES['imagen_i']['tmp_name'], $fichero_subido)) {
} else {
    echo "&iexcl;Error al subir la imagen!\n";die();
}

$querry_editar_datos_imagen="
UPDATE inventario_equipo SET 
DIR_IMAGEN='".$nombre_imagen."'
WHERE  ID_INVENTARIO='".$_POST['id_inventario']."'	
";
//echo $querry_editar_datos;
$bd->ejecutarQuery($querry_editar_datos_imagen);	
	
}
/////FIN SUBIR IMAGEN
/////SI EL EQUIPO SELECCIONADO ES MOUSE 
if ($nombre_equipo[0]->DESCRIPCION=="MOUSE"){
$querry_eliminar_datos_mouse="DELETE FROM inventario_equipo_mouse WHERE ID_INVENTARIO='".$_POST['id_inventario']."'";
//echo $querry_eliminar_datos_mouse;
$bd->ejecutarQuery($querry_eliminar_datos_mouse);	
} 

/////SI EL EQUIPO SELECCIONADO ES MONITOR  
if ($nombre_equipo[0]->DESCRIPCION=="MONITOR"){
$querry_eliminar_datos_monitor="DELETE FROM inventario_equipo_monitor WHERE ID_INVENTARIO='".$_POST['id_inventario']."'";
//echo $querry_eliminar_datos_monitor;
$bd->ejecutarQuery($querry_eliminar_datos_monitor);	
}

/////SI EL EQUIPO SELECCIONADO ES PC  
if ($nombre_equipo[0]->DESCRIPCION=="PC"){
$querry_eliminar_datos_pc="DELETE FROM inventario_equipo_pc WHERE ID_INVENTARIO='".$_POST['id_inventario']."'";
//echo $querry_eliminar_datos_pc;
$bd->ejecutarQuery($querry_eliminar_datos_pc);	
}

/////SI EL EQUIPO SELECCIONADO ES LAPTO  
if ($nombre_equipo[0]->DESCRIPCION=="LAPTOP"){
$querry_eliminar_datos_laptop="DELETE FROM inventario_equipo_lapto WHERE ID_INVENTARIO='".$_POST['id_inventario']."'";
//echo $querry_eliminar_datos_laptop;
$bd->ejecutarQuery($querry_eliminar_datos_laptop);	
}


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
'".$_POST['id_inventario']."',
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
'".$_POST['id_inventario']."',
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
UNIDADES_LECTURA
)
VALUES (
'".$_POST['id_inventario']."',
'".$_POST['cpu_pc']."',
'".$_POST['marca_procesador_p']."',
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
UNIDADES_LECTURA
)
VALUES (
'".$_POST['id_inventario']."',
'".$_POST['marca_procesador_l']."',
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




}
else{

$querry_editar_datos="
UPDATE inventario_equipo SET 
SERIAL='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['serial_equipo'])))."',
SERIAL_UST='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['serial_ust'])))."',
id_dependencia='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['id_departamento'])))."',
UBICACION='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['ubicacion'])))."',
ID_USO_EQUIPO='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['uso_equipo'])))."',
ID_ACCION='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['accion_equipo'])))."',
RESPONSABLE='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['responsable'])))."',
OBSERVACIONES='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['descripcion'])))."',
ID_CONDICION='".$_POST['condicion_equipo']."',
DIAGNOSTICO='".$_POST['diagnostico']."',
MARCA='".htmlspecialchars( stripslashes((string)$_POST['marca']))."',
MODELO='".htmlspecialchars( stripslashes((string)$_POST['modelo']))."',
USO='".htmlspecialchars( stripslashes((string)$_POST['en_uso']))."',
GARANTIA='".htmlspecialchars( stripslashes((string)$_POST['garantia']))."',
PERTENECE_PROYECYO='".htmlspecialchars( stripslashes((string)$_POST['per_proyecto']))."',
DESCRIPCION_PROYECTO='".htmlspecialchars( stripslashes((string)$_POST['desc_proyecto']))."'
WHERE  ID_INVENTARIO='".$_POST['id_inventario']."'	
";
//echo $querry_editar_datos;
$bd->ejecutarQuery($querry_editar_datos);	



///SI EL EQUIPO ESTA MALO
if($_POST['condicion_equipo']=='1'){
$si_esta_malo=$bd->consultaObjeto(array("ID_EQUIPO_MALO"),"equipo_malo","1 and ID_INVENTARIO='".$_POST['id_inventario']."'",0);

if($si_esta_malo[0]->ID_EQUIPO_MALO!=''){
$querry_editar_equipo_malo="
UPDATE equipo_malo SET 
PIEZA_DANNADA='".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['pieza_dannada'])))."',
RECOMENDACION_TECNICO='".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['recomendacion_tec'])))."'
WHERE  ID_INVENTARIO='".$_POST['id_inventario']."'	
";
//echo $querry_editar_datos;
$bd->ejecutarQuery($querry_editar_equipo_malo);	
}
else{
if($_POST['pieza_dannada']!='' || $_POST['recomendacion_tec']!=''  ){
$querry_insertar_datos_equipo_malo="
INSERT INTO  equipo_malo
(
ID_INVENTARIO,
PIEZA_DANNADA,
RECOMENDACION_TECNICO
)
VALUES (
'".$_POST['id_inventario']."',
'".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['pieza_dannada'])))."',
'".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['recomendacion_tec'])))."'
)		
";
//echo $querry_insertar_datos_mouse;
$bd->ejecutarQuery($querry_insertar_datos_equipo_malo);	
}
}
}
else{
$querry_eliminar_datos_equipo_malo="DELETE FROM equipo_malo WHERE ID_INVENTARIO='".$_POST['id_inventario']."'";
//echo $querry_eliminar_datos_mouse;
$bd->ejecutarQuery($querry_eliminar_datos_equipo_malo);	
}
//FIN EQUIPO MALO

////SUBIR IMAGEN
//echo $_FILES['imagen_i']['name'];
if($_FILES['imagen_i']['name']!=''){

$dir_subida =  $_SERVER['DOCUMENT_ROOT'].('/inventario/images_inventario_equipo/');
///eliminando imagen servidor
if($_POST['imagen_anterior']!='')unlink($dir_subida.$_POST['imagen_anterior']);//sabiendo que estos son los parametros para tu caso 


$dir_subida =  $_SERVER['DOCUMENT_ROOT'].('/inventario/images_inventario_equipo/');
$extension = end(explode(".", $_FILES["imagen_i"]["name"]));
$nombre_imagen=$_POST['id_inventario'].'_INVENTARIO_GENERAL_'.date("Y_m_d").'.'.$extension;

$fichero_subido = $dir_subida.$nombre_imagen;


if (move_uploaded_file($_FILES['imagen_i']['tmp_name'], $fichero_subido)) {
} else {
    echo "&iexcl;Error al subir la imagen!\n";die();
}

$querry_editar_datos_imagen="
UPDATE inventario_equipo SET 
DIR_IMAGEN='".$nombre_imagen."'
WHERE  ID_INVENTARIO='".$_POST['id_inventario']."'	
";
//echo $querry_editar_datos;
$bd->ejecutarQuery($querry_editar_datos_imagen);	
	
}
/////FIN SUBIR IMAGEN

/////SI EL EQUIPO SELECCIONADO ES MOUSE 
if ($nombre_equipo[0]->DESCRIPCION=="MOUSE"){
$querry_editar_datos_mouse="
UPDATE inventario_equipo_mouse SET 
MODELO='".TildesHtml(htmlspecialchars(stripslashes((string)$_POST['modelo_mouse'])))."',
CONECTOR='".$_POST['conector_mouse']."'
WHERE  ID_INVENTARIO='".$_POST['id_inventario']."'	
";
//echo $querry_editar_datos_mouse;
$bd->ejecutarQuery($querry_editar_datos_mouse);	
} 

/////SI EL EQUIPO SELECCIONADO ES MONITOR  
if ($nombre_equipo[0]->DESCRIPCION=="MONITOR"){
$querry_editar_datos_monitor="
UPDATE inventario_equipo_monitor SET 
MODELO='".$_POST['modelo_monitor']."'
WHERE  ID_INVENTARIO='".$_POST['id_inventario']."'	
";
//echo $querry_editar_datos_monitor;
$bd->ejecutarQuery($querry_editar_datos_monitor);	
}

/////SI EL EQUIPO SELECCIONADO ES PC  
if ($nombre_equipo[0]->DESCRIPCION=="PC"){

if($_POST['marca_procesador_p']=='')$_POST['marca_procesador_p']=23;

$querry_editar_datos_pc="
UPDATE inventario_equipo_pc SET 
CPU='".$_POST['cpu_pc']."',
ID_MARCA_PRO='".$_POST['marca_procesador_p']."',
PROCESADOR_VELOCIDAD='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['velocidad_procesador'])))."',
MEMORIA_CAPACIDAD='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_capacidad'])))."',
MEMORIA_TIPO='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_tipo'])))."',
DISCO_DURO_CAPACIDAD='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_capacidad'])))."',
DISCO_DURO_TIPO='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_tipo'])))."',
UNIDADES_LECTURA='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['unidad_lectura_escritura'][0])))."'
WHERE  ID_INVENTARIO='".$_POST['id_inventario']."'	
";

//echo $querry_editar_datos_pc;
$bd->ejecutarQuery($querry_editar_datos_pc);	
}

/////SI EL EQUIPO SELECCIONADO ES LAPTO  
if ($nombre_equipo[0]->DESCRIPCION=="LAPTOP"){

if($_POST['marca_procesador_l']=='')$_POST['marca_procesador_p']=23;

$querry_editar_datos_laptop="
UPDATE inventario_equipo_lapto SET 
ID_MARCA_PRO='".$_POST['marca_procesador_l']."',
PROCESADOR_VELOCIDAD='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['velocidad_procesador'])))."',
MEMORIA_CAPACIDAD='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_capacidad'])))."',
MEMORIA_TIPO='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['memoria_tipo'])))."',
DISCO_DURO_CAPACIDAD='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_capacidad'])))."',
DISCO_DURO_TIPO='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['disco_duro_tipo'])))."',
UNIDADES_LECTURA='".TildesHtml(htmlspecialchars( stripslashes((string)$_POST['unidad_lectura_escritura'][0])))."'
WHERE  ID_INVENTARIO='".$_POST['id_inventario']."'	
";
//echo $querry_editar_datos_laptop;
$bd->ejecutarQuery($querry_editar_datos_laptop);	
}

}//fin else sino son iguales tipos de equipo



echo 'Datos Editados Satisfactoriamente';

echo "<script>

  $('#pre_imagen').hide();
 $('html,body').animate({scrollTop: $('#ejecutado').offset().top}, 1000);
/*$('html, body').animate({
                scrollTop: $('#ejecutado').offset().top
            }, 1500, 'swing');*/
</script>";

?>
