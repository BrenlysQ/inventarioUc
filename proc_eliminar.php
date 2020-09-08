<?php 
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");
include("funciones.php");

$bd=new bd_conexion();



$nombre_equipo=$bd->consultaObjeto(array("DESCRIPCION"),"equipo","1 and ID_EQUIPO='".$_POST['nombre_equipo']."'",0);


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


$querry_eliminar_datos="DELETE FROM inventario_equipo WHERE ID_INVENTARIO='".$_POST['id_inventario']."'";
//echo $querry_eliminar_datos;
$bd->ejecutarQuery($querry_eliminar_datos);	


echo 'Datos Eliminados Satisfactoriamente';

?>
