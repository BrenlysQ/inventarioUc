<?php
//error_reporting(E_ALL ^ E_NOTICE);
require_once("bd.php");
class bd_conexion extends bd{

// MONTAR LA CLASE BD DE MANERA DE EXTENDER CADA CLASE BD EN PARTICULAR LLENANDO LOS 4 ATRIBUTOS Y QUE FUNCIONE.
// REVISAR SI ES NECESARIO PASAR VALORES AL CONSTRUCTOR.
	function __construct(){

		$this->setServer("localhost");
		$this->setDBname("tic_inventario");
		$this->setLogin("tic_inventario");
		$this->setPasswd("20Inventario15Facyt");
		


		try{
//			$this->conexion=mysql_connect($this->server,$this->login,$this->passwd) or die("Fallo en la conexion.");
			$auxconn=mysql_connect($this->getServer(),$this->getLogin(),$this->getPasswd()) or die("Fallo en la conexion.");
			$this->setConexion($auxconn);
			mysql_select_db($this->getDBname());
			mysql_query("SET NAMES 'utf8'");

		}catch(Exception $ex){
				echo"Problemas capturados por el try...";	//echo"MENSAJE: ".$ex->getMessage();
			}
	}
}
?>
