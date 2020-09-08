<?php
class bd{
	private $conexion;
/** Server es el nombre del servidor MySql.*/
	private $server;
	private $login;
	private $passwd;
	private $dbname;
	private $query;

	function setServer($aux){
		$this->server=$aux;		
	}
	function setLogin($aux){
		$this->login=$aux;		
	}
	function setPasswd($aux){
		$this->passwd=$aux;		
	}
	function setDBname($aux){
		$this->dbname=$aux;		
	}
	
	function setConexion($aux){
		$this->conexion=$aux;
	}

	function getConexion(){
		return $this->conexion;
	}
	function getServer(){
		return $this->server;
	}

	function getLogin(){
		return $this->login;
	}
	function getPasswd(){
		return $this->passwd;
	}
	
	function getDBname(){
		return $this->dbname;
	}
	function cerrar(){
		mysql_close($this->getConexion());
	}
	function fin(){
		mysql_close($this->getConexion());
	}

// MONTAR LA CLASE BD DE MANERA DE EXTENDER CADA CLASE BD EN PARTICULAR LLENANDO LOS 4 ATRIBUTOS Y QUE FUNCIONE.
// REVISAR SI ES NECESARIO PASAR VALORES AL CONSTRUCTOR.
	function __construct($auxserver="",$auxdbname="",$auxlogin="",$auxpasswd=""){


// 		if() 	si son diferentes de null, asi garantiza la sobreescritura del metododd,

		if($auxserver!=""){
			$this->server=$auxserver;
		}
		if($auxdbname!=""){
		$this->dbname=$auxdbname;
		}
		if($auxlogin!=""){
		$this->login=$auxlogin;
		}
		if($auxpasswd!=""){
		$this->passwd=$auxpasswd;
		}

		try{
//			$this->conexion=mysql_connect($this->server,$this->login,$this->passwd) or die("Fallo en la conexion.");
			$auxconn=mysql_connect($this->getServer(),$this->getLogin(),$this->getPasswd()); //or die("Fallo en la conexion.");//Aca escribo en el archivo y en la tabla
			if (!$auxconn) {
//				log_errores::archivoLog("Fall� en la conexi�n".mysql_error());
			}
			$this->setConexion($auxconn);
			mysql_select_db($this->getDBname());
		}catch(Exception $ex){
//			log_errores::archivoLog("Fall� en la conexi�n".mysql_error());
				//echo"Problemas capturados por el try...";	//echo"MENSAJE: ".$ex->getMessage();
			}
	}
	function cambiarBD($dbname){
		try{
			//msql_close();
			$auxconn=mysql_select_db($dbname);
			if (!$auxconn) {
//				log_errores::archivoLog("No se pudo seleccionar la Base de Datos".$dbname.mysql_error());
			}
		}catch(Exception $ex){
//			log_errores::archivoLog("No se pudo seleccionar la Base de Datos . Revisar el /var/log/http.log".$dbname.mysql_error());
			//echo"Problemas en el cambio de BD. Revisar el /var/log/http.log";
		}
	}

	/** count: cuenta ocurrencia de campos en una tabla dada. Por defecto cuenta el id. 05-10-2009*/
	function count($campo,$tabla){
		$query="SELECT COUNT( `".$campo."` ) FROM `".$tabla."`";
		$mysql_result=mysql_query($query,$this->getConexion());	
			if(!$mysql_result){
				$errno=mysql_errno($this->getConexion());
				$errordesc=mysql_error($this->getConexion());
				echo"<br><br><strong>MYSQL: Error. El query es incorrecto. Revise la consulta. Errno: $errno Error: $errordesc</strong>";
				die();				
			}
		$campo=mysql_fetch_row($mysql_result);
		return $campo[0];
	}


/**
 * Funcion consulta_bd($query,$return="row")
 * Funcion Privada llamada desde los metodos desarrollados en la clase BD.php. 
 * Utilice solo si desea enviar un query SQL correctamente construido.
 */

	function consulta_bd($query,$return="row"){
		
		try{
//			echo"<p><p><strong>consulta_bd::query= ".$query;
			$mysql_result=mysql_query($query,$this->getConexion());// or die("<br><br><strong>MYSQLL: Error. El query es incorrecto. Revise la consulta.".mysql_error($this->getConexion())."</strong>");
			//print_r($mysql_result);
			
				if(!$mysql_result){
//				log_errores::archivoLog("El query es incorrecto.Revise la consulta. Error: ".mysql_error.$query);
//				error::put("EError MYSQL: ".mysql_errno($this->getConexion())." Error:".mysql_error($this->getConexion()),"bd");
//				$conexion=;
				
				$errno=mysql_errno($this->getConexion());
				
				$errordesc=mysql_error($this->getConexion());
				
			//echo'<br><br><img src="/imagenes/mensaje_error_inesperado.png" width="457" height="160" alt="error" title="error" />';
				
			echo mysql_error($this->getConexion());///descomentar cuando querramos ver el error
			
				$cadena="<br><br><strong>MYSQL: Error. El query es incorrecto. Revise la consulta. Errno: $errno Error: $errordesc</strong>";
				//error::put("Error: ".$errordesc,"bd");
				//die();					
			}
			
			switch($return){
				case "row":
					while($fila=mysql_fetch_row($mysql_result)){
						$row[]=$fila; // Almacena cada row
					}	
					return $row;
				break;
				case "object":
					$object=mysql_fetch_object($mysql_result);
					return $object;
				break;
				case "objeto": // 22-05-2010 por si acaso object se usa en algun otro lugar.
					while($obj=mysql_fetch_object($mysql_result)){
						$object[]=$obj;	
					}
					return $object;
				break;
			}
		}catch(Exception $ex){
//				log_errores::archivoLog("El query es incorrecto.Revise la consulta. Error: ".mysql_error.$query);
				error::put("EEError MYSQL: ".mysql_errno($this->getConexion())." Error:".mysql_error($this->getConexion()),"bd");			
		}
	}
	
		function consulta_bd_objeto($query,$return="row"){
		try{
//			echo"<p><p><strong>consulta_bd::query= ".$query;
			$mysql_result=mysql_query($query,$this->getConexion()) or die("<br><br><strong>MYSQL: Error. El query es incorrecto. Revise la consulta.".mysql_error."</strong>");
			switch($return){
				case "row":
					while($fila=mysql_fetch_row($mysql_result)){
						$row[]=$fila; // Almacena cada row
					}	
					return $row;
				break;
				case "object":
					while($object=mysql_fetch_object($mysql_result)){
					$objeto1=$object;
					}
					return $objeto1;
				break;
			}
		}catch(Exception $ex){
			echo"Problemas capturados por el try...";	//echo"MENSAJE: ".$ex->getMessage();
		}
	}


	function setQuery($query){
		$this->query=$query;
	}
	function getQuery(){
		return $this->query;
	}
/**
 * 	Function consultaSimple($campo,$tabla,$condicion)
 * 	Utilice esta funci�n cuando requiera UN (1) SOLO CAMPO desde la consulta.
 *	NO COLOQUE EL WHERE
 */
	
	function consultaSimple($campo,$tabla,$condicion,$verquery="0"){
		$query="SELECT `".$campo."` FROM `".$tabla."` WHERE ".$condicion." LIMIT 1";
		if($verquery)echo"<p><strong>QUERY_CONSULTA_SIMPLE:</strong> <em>".$query."</em></p>";
		$arreglo=$this->consulta_bd($query,"row"); 
		if(sizeof($arreglo)==1){
//			echo"return arreglo......";
			return $arreglo[0][0];
		}
	}
        function consultaSimple2($campo,$tabla,$condicion,$verquery="0"){
		$query="SELECT ".$campo." FROM `".$tabla."` WHERE ".$condicion." LIMIT 1";
		if($verquery)echo"<p><strong>QUERY_CONSULTA_SIMPLE:</strong> <em>".$query."</em></p>";
		$arreglo=$this->consulta_bd($query,"row"); 
		if(sizeof($arreglo)==1){
//			echo"return arreglo......";
			return $arreglo[0][0];
		}
	}
/** ConsultaArreglo: devuelve un arreglo de una consulta simple (1 solo campo)*/
	function consultaArreglo($campo,$tabla,$condicion,$verquery=0){
		$query="SELECT ".$campo." FROM ".$tabla." WHERE ".$condicion;
		if($verquery){echo"<p><strong>Query Consulta Arreglo: </strong><em>".$query."</em></p>";}
		$arreglo=$this->consulta_bd($query,"row"); 
		for($i=0;$i<sizeof($arreglo);$i++){
			$aux[$i]=$arreglo[$i][0];
		}
		return $aux;
	}
/** ConsultaArreglo: devuelve un arreglo de una consulta simple (1 solo campo)*/
	function contarCampo($campo,$tabla,$condicion,$verquery=0){
		$query="SELECT `".$campo."` FROM `".$tabla."` WHERE ".$condicion;
		if($verquery){echo"<p><strong>Query Consulta Arreglo: </strong><em>".$query."</em></p>";}
		$result=$this->consulta_bd($query,"row"); 
		$aux=sizeof($result);		
//		echo"cantidad de campos es: $aux";
		return $aux;
	}

//	VOY POR AQUI Y POR VISTA DE PREACTAS, YA TENGO EL METODO PARA SABER SI LLAMO A NUEVA PREACTA O A EDITAR
//	VIERNES: MONTAR EDITAR PREACTA.

        /*16-03-2011 Se implementa para no tener que usar result[0][0], $result[0][1]*/
function consultaRegistro($campos="", $tabla="", $condicion="1", $verquery=0){
    $result=$this->consulta($campos,$tabla,$condicion,$verquery);
    return $result[0];
}

/**
	function consulta($campos="", $tabla, $condicion="1");
	Esta funcion arma el query pasando un arreglo de campos y el nombre de la tabla.

*/
	function consulta($campos="", $tabla="", $condicion="1",$verquery=0){
		$query="SELECT ";
		if(($campos=="")||(!isset($campos))){
			$query.="*";
		}else{
			for($i=0;$i<sizeof($campos);$i++){
				$query.="$campos[$i]";
				if($i<sizeof($campos)-1){
					$query.=", ";
				}
			}
		}
		$query.=" FROM ".$tabla." WHERE ".$condicion;
if($verquery)
		echo"<p><strong>consulta: </strong><em>".$query."</em></p>";
		$this->setQuery($query);
//		echo"<p><p>Antes de llamar a consulta_bd: query vale: ".$query."<p><p>";
		$arreglo=$this->consulta_bd($query); 
		return $arreglo;
	}
/** 25-05-2010 Retorna el result de haber hecho el query sin darle forma de result consulta normal. para usar con el fecth object*/
	function consultaObjeto($campos="", $tabla="", $condicion="1",$verquery=0){
		$query="SELECT ";
		if(($campos=="")||(!isset($campos))){
			$query.="*";
		}else{
			for($i=0;$i<sizeof($campos);$i++){
				$query.="$campos[$i]";
				if($i<sizeof($campos)-1){
					$query.=", ";
				}
			}
		}
		$query.=" FROM ".$tabla." WHERE ".$condicion;
if($verquery)
		echo"consulta objeto: ".$query."<p>";
		$this->setQuery($query);
//		echo"<p><p>Antes de llamar a consulta_bd: query vale: ".$query."<p><p>";
		$arreglo=$this->consulta_bd($query,"objeto"); 
		return $arreglo;
	}
/** es la misma logica que consultaObjeto pero esta vez paginado */
        function consultaObjetoP($campos="", $tabla="", $condicion="1", $pagina, $max, $verquery=0){
            $inicio = $max*($pagina-1);
            $condicion = $condicion." LIMIT ".$inicio.", ".$max.";";
	    return $this->consultaObjeto($campos, $tabla, $condicion, $verquery);
	}
/** cuenta la cantidad de registros para la paginación */
        function cuentaRegistros($tabla="", $condicion="1", $verquery=0){
            $query = "SELECT count(*) FROM ".$tabla." WHERE ".$condicion;
            if($verquery) echo"cuenta registros: ".$query."<p>";
            $this->setQuery($query);
            $result=$this->consulta_bd($query);
            return $result[0][0];
	}

/** cuenta la cantidad de registros para la paginación con DISTINCT y una columna*/
        function cuentaRegistrosDistinct($tabla="", $condicion="1", $col,$verquery=0){
            $query = "SELECT count(DISTINCT ".$col.") FROM ".$tabla." WHERE ".$condicion;
            if($verquery) echo"cuenta registros: ".$query."<p>";
            $this->setQuery($query);
            $result=$this->consulta_bd($query);
            return $result[0][0];
	}

/** 25-05-2010 Retorna el result de haber hecho el query sin darle forma de result consulta normal. para usar con el fecth object*/
	function consultaSimpleObjeto($campos="", $tabla="", $condicion="1",$verquery=0){
		$query="SELECT ";
		if(($campos=="")||(!isset($campos))){
			$query.="*";
		}else{
			for($i=0;$i<sizeof($campos);$i++){
				$query.="$campos[$i]";
				if($i<sizeof($campos)-1){
					$query.=", ";
				}
			}
		}
		$query.=" FROM ".$tabla." WHERE ".$condicion;
if($verquery)
		echo"consulta simple objeto: ".$query."<p>";
		$this->setQuery($query);
//		echo"<p><p>Antes de llamar a consulta_bd: query vale: ".$query."<p><p>";
		$arreglo=$this->consulta_bd($query,"objeto"); 
		return $arreglo[0];
	}

	function consultaQuery($query,$tipo="row"){
		$this->setQuery($query);
		if($tipo=="row")
		{
		//echo"<p><p>Antes de llamar a consulta_bd: query vale: ".$query."<p><p>";
			$arreglo=$this->consulta_bd($query); 
			if($arreglo!=null)	return $arreglo;
		}
		else
		{
			$arreglo=$this->consulta_bd($query,"object"); 
			if($arreglo!=null)	return $arreglo;	
		}
	}
/** Utilice para hacer ejecuciones de codigo SQL como UPDATE que no devuelven arreglos.*/
	function ejecutarQuery($query,$verquery=0,$ejecutar=1){

		if($verquery) echo"<p><strong>Ejecutar Query: </strong><em>".$query."</em></p>";
		if($ejecutar==1){
			$this->consulta_bd($query,"no");
		}else{
		 	echo"=== Query a ejecutarse: <br>".$query." === DESHABILITADO<br>";
		}
	}
	function ejecutarQueryError($query,$verquery=1){
		if($verquery) echo"<p><strong>Ejecutar Query: </strong><em>".$query."</em></p>";

		$result=mysql_query($query,$this->getConexion());
		if(!$result){
			echo mysql_error();die("Se detiene.");
		}
		//echo"LLEGO AQUI";
	}

/**
 *	function reporte($result,$descripcion=NULL){
 * 	Esta funci�n recibe el array devuelto por las funciones consulta y formatea la salida en un reporte.
 *  Puede recibir un arreglo de descripci�n de los campos para el formato de salida. Si no recibe descripci�n
 *  utiliza los nombres originales de los campos en la Base de Datos.
 */
	function reporte($result,$descripcion=NULL){

		if($descripcion==null){
			$descripcion=$this->generarDescripcion();
		}
		echo '<table border="1" width=80% align="center">';

		if($descripcion!=NULL){
			echo'<tr class="descripcion">';
			for($i=0;$i<sizeof($descripcion);$i++){
				echo"<td>$descripcion[$i]</td>";				
			}
			echo"</tr>";
		}
                $size=sizeof($result);
		for($i=0;$i<$size;$i++){
			echo'<tr class="fila">';
                        $size2=sizeof($result[$i]);
			for($j=0;$j<$size2;$j++){
				echo"<td>";
					if($result[$i][$j]!=NULL) echo $result[$i][$j]; else echo"&nbsp;";
				echo"</td>\n";
			}
			echo"</tr>\n";
		}
		echo"</table>";
	echo'<div align="center">'."Tama&ntilde;o de la consulta: ".$size." elementos.</div>";
	}
/**
 *	function generarDescripcion(){
 *   Deber�a ser privada. Solo es llamada desde la clase.
 */	
	function generarDescripcion(){
		$arreglo=$this->consulta_bd($this->getQuery(),"object");
		foreach($arreglo as $indice => $valor){
			$categ[]=$indice;
		}
		return $categ;
	}
	
	
	
	/** consulta query para inscripcion*/
	function consulta_inscripcion($query,$return="object"){
		try{
//			echo"<p><p><strong>consulta_bd::query= ".$query;
			$mysql_result=mysql_query($query,$this->getConexion()) or die("<br><br><strong>MYSQL: Error. El query es incorrecto. Revise la consulta.</strong>");
			switch($return){
				case "row":
					while($fila=mysql_fetch_row($mysql_result)){
						$row[]=$fila; // Almacena cada row
					}	
					return $row;
				break;
				case "object":
					$object=mysql_fetch_object($mysql_result);
					return $object;
				break;
			}
		}catch(Exception $ex){
			echo"Problemas capturados por el try...";	//echo"MENSAJE: ".$ex->getMessage();
		}
	}
	
	
	function seleccionar_bd($nombre_bd) //Funcion para cambiar de base de datos Creada el  19/11/09 acrodriguez1
	{
		$resultado=mysql_select_db($nombre_bd, $this->conexion);
		return $resultado;
	}
	function renombrar_tabla($tabla_actual,$tabla_nueva) //12/02/2010 acrodriguez1 Funci�n que renombra el nombre de una tabla por un nuevo nombre..
	{
		
		$rename="RENAME TABLE `inscripcionWeb`.`$tabla_actual`  TO `inscripcionWeb`.`$tabla_nueva`" ;	
		$this->ejecutarQuery($rename,1);
		
	}
	function eliminar_tabla($tabla)// 17/02/2010 acrodriguez1 Funci�n que elimina una tabla previamente debi� haberse establecido la conexi�n
	{
		$eliminar_tabla="DROP table $tabla";
		$this->ejecutarQuery($eliminar_tabla);
	}
	function existe_tabla($table_name) //12/02/2010 acrodriguez1 Funci�n que verifica si una tabla existe,previamente debi� haberse establecido la conexi�n 
	{
  
 			 $Table = $this->consultaQuery("show tables like '" .
  			  $table_name . "'");

  			if(sizeof($Table)==0)
   				return(false);
  			return(true);
	}
	function cerrar_conexion()//Funcion para cerrar la conexion de una base de datos
	{
			mysql_close ($this->conexion);
	}
	
	function verificar_consulta_vacia($resultado_query)// Fecha de Creaci�n 03/12/09 acrodriguez1
{
	$num_rows = mysql_fetch_row($resultado_query);
	//echo "Num rows".$num_rows;die("Numero de filas");
	return $num_rows;
}
	
	function seleccionar_bd_aux($nombre_bd,$user,$pass) //Funcion para cambiar de base de datos Creada el  05/02/10 acrodriguez1
	{
		$conexion=mysql_connect('localhost',$user,$pass);
		$resultado=mysql_select_db($nombre_bd, $conexion);
		return $resultado;
	}
	
	
	
	function consultaQueryWizard($query,$tipo="row"){ //08/02/10 acrodriguez1
		$this->setQuery($query);
		if($tipo=="row")
		{
		//echo"<p><p>Antes de llamar a consulta_bd: query vale: ".$query."<p><p>";
			$arreglo=$this->consulta_bd($query); 
			if($arreglo!=null)	return $arreglo;
		}
		else
		{
			$arreglo=$this->consulta_bd($query,"object"); 
			if($arreglo!=null)	return $arreglo;	
		}
	}
        
        function consulta2($consulta)
 {
	$resultado = mysql_query($consulta,$this->conexion);
  	if(!$resultado)
	{
  		echo 'MySQL Error: ' . mysql_error();
	    exit;
	}
  	return $resultado; 
  }
  
 function fetch_array($consulta)
 { 
  	return mysql_fetch_array($consulta);
 }
 
 function num_rows($consulta)
 { 
 	 return mysql_num_rows($consulta);
 }
 
 function fetch_row($consulta)
 { 
 	 return mysql_fetch_row($consulta);
 }
 function fetch_assoc($consulta)
 { 
 	 return mysql_fetch_assoc($consulta);
 } 
	
	
}





	
/*
echo"consulta BD";
$campos=array("E_COD","A_CI","M_S","M_CLAVE");
$result=consulta($campos,"081_DATA_701","`A_CI`=018859559");
reporte($result);
*/
?>

