<?php 
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");
include("funciones.php");

$bd=new bd_conexion();
//print_r($_POST);
//$datos_pdf=$_POST;

/*if($_POST['nombre_equipo']=='' && $_POST['condicion_equipo']=='' && $_POST['id_tecnico']=='' && $_POST['id_departamento']=='' && $_POST['uso_equipo']=='' && $_POST['accion_equipo']=='' && $_POST['garantia']=='' && $_POST['per_proyecto']==''){
echo 'Seleccione al menos una opci&oacute;n para generar los reportes';
die();
}
else{*/
$tabla_segunda_busq='';
$condiciones_reporte='';
$valores_retornar='';
$completar_nombre_tabl='';

$datos_equipo = explode("-", $_POST['nombre_equipo']);

$valores_retornar='a.*, c.DESCRIPCION,d.dependen, e.DESCRIPCION,UPPER(f.NOMBRE),g.DESCRIPCION,h.DESCRIPCION ';
$condiciones_reporte=' a.ID_EQUIPO=c.ID_EQUIPO AND a.id_dependencia=d.id_dependencia AND a.ID_CONDICION=e.ID_CONDICION AND
a.TRANSCRIPTOR=f.USUARIO AND g.ID_USO_EQUIPO=a.ID_USO_EQUIPO ';



if($datos_equipo[1]=='PC')$completar_nombre_tabl='pc';
if($datos_equipo[1]=='LAPTOP')$completar_nombre_tabl='lapto';

if($_POST['nombre_equipo']!=''){

	//$valores_retornar=',a.ID_EQUIPO';
	$condiciones_reporte.=' AND a.ID_EQUIPO='.$datos_equipo[0];
	//echo $condiciones_reporte; 
	}
	
if($_POST['condicion_equipo']!=''){
	//$valores_retornar=',a.ID_CONDICION';
	$condiciones_reporte.=' AND a.ID_CONDICION='.$_POST['condicion_equipo'];
}

if($_POST['id_tecnico']!=''){
	//$valores_retornar=',a.TRANSCRIPTOR';
	$condiciones_reporte.=" AND a.TRANSCRIPTOR='".$_POST['id_tecnico']."'";
}

if($_POST['id_departamento']!=''){
	//$valores_retornar=',a.id_dependencia';
	$condiciones_reporte.=' AND a.id_dependencia='.$_POST['id_departamento'];
}

if($_POST['uso_equipo']!=''){
	//$valores_retornar=',a.ID_USO_EQUIPO';
	$condiciones_reporte.=' AND a.ID_USO_EQUIPO='.$_POST['uso_equipo'];
}
/////REVISAR
if($_POST['accion_equipo']!=''){
	//$valores_retornar=',a.ID_ACCION';
	$condiciones_reporte.=' AND a.ID_ACCION='.$_POST['accion_equipo'];
	//$tabla_segunda_busq.=',accion f';
}

if($_POST['garantia']!=''){
	//$valores_retornar=',a.GARANTIA';
	$condiciones_reporte.=" AND a.GARANTIA='".$_POST['garantia']."'";
}

if($_POST['per_proyecto']!=''){
	//$valores_retornar.=',a.PROYECYO';
	$condiciones_reporte.=" AND a.PERTENECE_PROYECYO='".$_POST['per_proyecto']."'";
}

if($_POST['accion_equipo']!=''){
	//$valores_retornar.=',a.PROYECYO';
	$condiciones_reporte.="  AND a.ID_ACCION=h.ID_ACCION";
}



if($_POST['proc_marca']!='' ){
	$valores_retornar.=',m.DESCRIPCION';
	$tabla_segunda_busq=',inventario_equipo_'.$completar_nombre_tabl.' b, marca_procesador m';
	$condiciones_reporte.=" AND m.ID_MARCA_PRO='".$_POST['proc_marca']."'";
	$condiciones_reporte.=' AND m.ID_MARCA_PRO=b.ID_MARCA_PRO AND b.ID_INVENTARIO=a.ID_INVENTARIO';
}

if($_POST['proc_tipo']!='' && $_POST['proc_marca']=='' ){
	$valores_retornar.=',m.DESCRIPCION,p.DESCRIPCION';
	$tabla_segunda_busq=',inventario_equipo_'.$completar_nombre_tabl.' b, marca_procesador m,tipo_procesador p';
	$condiciones_reporte.=" AND p.ID_TIPO_PRO='".$_POST['proc_tipo']."'  AND m.ID_MARCA_PRO=b.ID_MARCA_PRO
	AND m.ID_TIPO_PRO=p.ID_TIPO_PRO	  AND b.ID_INVENTARIO=a.ID_INVENTARIO";

}

if($datos_equipo[1]=='PC' && $_POST['cpu_pc']!='' ){
	if($tabla_segunda_busq==''){
		$tabla_segunda_busq=',inventario_equipo_'.$completar_nombre_tabl.' b';
		}
	
	$condiciones_reporte.=" AND b.CPU='".$_POST['cpu_pc']."'  AND b.ID_INVENTARIO=a.ID_INVENTARIO";	

}


if($_POST['proc_tipo']!='' && $_POST['proc_marca']!=''){
	$valores_retornar.=',m.DESCRIPCION,p.DESCRIPCION';
	$tabla_segunda_busq=',inventario_equipo_'.$completar_nombre_tabl.' b, marca_procesador m,tipo_procesador p';
	$condiciones_reporte.=" AND m.ID_MARCA_PRO='".$_POST['proc_marca']."' AND p.ID_TIPO_PRO='".$_POST['proc_tipo']."' AND m.ID_TIPO_PRO=p.ID_TIPO_PRO ";
	$condiciones_reporte.=' AND b.ID_INVENTARIO=a.ID_INVENTARIO';

}



$query_reporte="
SELECT ".$valores_retornar." FROM inventario_equipo a, equipo c, dec_dependencia d, condicion e, tecnico f,uso_equipo g, accion h ".$tabla_segunda_busq."  
WHERE ".$condiciones_reporte."
";
//echo $query_reporte;
$datos_reporte_generado=$bd->consultaQuery($query_reporte);

//echo'<pre>';print_r($datos_reporte_generado);echo'</pre>';

//$datos_inventario_reporte=$bd->consultaObjeto(array("*"),"inventario_equipo","1 ".$condiciones_reporte,1);

//}
 
$array=array_envia($_POST); 

?>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="css/jquery.dataTables.css" rel="stylesheet">
<link href="css/select2.css" rel="stylesheet">


<div class="table-responsive">
<div id='contenido_principal'>	
<div id="resultado_rt" style="color:#005B88; text-align:center; size:500">&nbsp;</div><br>	
<div style=" float:right; margin-right:25%">


<a href="proc_reporte_pdf.php" onclick="window.open(this.href+'?datos=<?=$array?>&arry_bus_colum='+array_tabla_ord[0][0]+'&arry_bus_par='+array_tabla_ord[0][1]);return false;" target="_blank">
<img src="imagenes/icono_pdf-1.png" alt="Generar PDF" title="Generar PDF" width="45px" height="45px" />
</a></div>

<table id="example_reporte" class="display table-hover dt-responsive" cellspacing="0" width="100%" style="color:#000000">
        <thead>
            <tr>

<th>Descripci&oacute;n</th>
<th>Departamento</th>
<th>Condici&oacute;n</th>
<th>Custodio</th>

<?php if($_POST['proc_marca']!=''){?>
<th>Prosc. Marca</th>
<?php }?>

<?php if($_POST['proc_tipo']!=''){?>
<th>Prosc. Tipo</th>
<?php }?>


<?php if($_POST['id_tecnico']!=''){?>
<th>T&eacute;cnico</th>
<?php }?>


<?php if($_POST['uso_equipo']!=''){?>
<th>Uso</th>
<?php }?>

<?php if($_POST['accion_equipo']!=''){?>
<th>Acci&oacute;n</th>
<?php }?>

<?php if($_POST['garantia']!=''){?>
<th>Garant&iacute;a</th>
<?php }?>

<?php if($_POST['per_proyecto']!=''){?>
<th>Proyecto</th>
<?php } //echo'<pre>';print_r($datos_reporte_generado);echo'</pre>';?>

<th>Consultar</th>
<!--  <th>Editar</th> -->

            </tr>
        </thead>
        <tfoot>
        </tfoot>
        <tbody>
           <?php for($i=0;$i<sizeof($datos_reporte_generado);$i++){?>
		   
		    <tr>

               <td><?php 
			   		$nombre_equipo=$bd->consultaObjeto(array("DESCRIPCION"),"equipo","ID_EQUIPO='".$datos_reporte_generado[$i][1]."'",0);
			   echo  $nombre_equipo[0]->DESCRIPCION;?></td>
			   
			   <td><?php $nombre_dep=$bd->consultaObjeto(array("dependen"),"dec_dependencia","id_dependencia='".$datos_reporte_generado[$i][5]."'",0);
			   echo $nombre_dep[0]->dependen;?></td>
			   
			    <td><?php $nombre_cond=$bd->consultaObjeto(array("DESCRIPCION"),"condicion","ID_CONDICION='".$datos_reporte_generado[$i][11]."'",0);
			   echo $nombre_cond[0]->DESCRIPCION;?></td>
			   
			   <td><?php 
			   if($datos_reporte_generado[$i][9]!='')echo $datos_reporte_generado[$i][9];
			   else echo 'SIN CUSTODIO';?></td>
			   			   
			   

				<?php if($_POST['proc_marca']!=''){?>
				<td><?php  echo $datos_reporte_generado[$i][23];?></td>
				<?php }?>
				
				<?php if($_POST['proc_tipo']!=''){?>
				<td><?php echo $datos_reporte_generado[$i][24];?></td>
				<?php }?>
				
				<?php if($_POST['id_tecnico']!=''){?>
				<td><?php $nombre_tec=$bd->consultaObjeto(array("NOMBRE"),"tecnico","USUARIO='".$datos_reporte_generado[$i][21]."'",0);
			   echo strtoupper($nombre_tec[0]->NOMBRE);?></td>
				<?php }?>
				
				<?php if($_POST['uso_equipo']!=''){?>
				<td><?php $nombre_uso=$bd->consultaObjeto(array("DESCRIPCION"),"uso_equipo","ID_USO_EQUIPO='".$datos_reporte_generado[$i][7]."'",0);
			   echo strtoupper($nombre_uso[0]->DESCRIPCION);?></td>
				<?php }?>
				
				<?php if($_POST['accion_equipo']!=''){?>
				<td><?php $nombre_acc=$bd->consultaObjeto(array("DESCRIPCION"),"accion","ID_ACCION='".$datos_reporte_generado[$i][8]."'",0);
			   echo strtoupper($nombre_acc[0]->DESCRIPCION);?></td>
				<?php }?>
				
				<?php if($_POST['garantia']!=''){?>
				<td><?php echo $_POST['garantia'];?></td>
				<?php }?>
				
				<?php if($_POST['per_proyecto']!=''){?>
				<td><?php echo $_POST['per_proyecto'];?></td>
				<?php }?>
			   
			   
			<td><a  onClick="consultar('<?php echo $datos_reporte_generado[$i][0]?>')" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $datos_reporte_generado[$i][0];?>" class="open-Modal"><span class="glyphicon glyphicon-search" title="Consultar"></span></a></td>   
		<!--	<td>
			<a  onClick="editar('<?php echo $datos_reporte_generado[$i][0]?>')" data-toggle="modal" data-target="#myModal_e"  data-id="<?php echo  $datos_reporte_generado[$i][0];?>" class="open-Modal">
<span class="glyphicon glyphicon-pencil" title="Editar"></span></a></td>
            </tr> -->
			<?php }?>
           
        </tbody>
    </table>
	</div>
</div>	
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" id="mdialTamanio">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Datos Inventario de Equipo</h4>
      </div>
      <div class="modal-body" id="contenido_modal">
	
      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>-->	
    </div>

  </div>
</div>	

<!-- Modal Editar-->
<div id="myModal_e" class="modal fade" role="dialog">
  <div class="modal-dialog" id="mdialTamanio">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Datos Inventario de Equipo</h4>
      </div>
      <div class="modal-body" id="contenido_modal_e">
	
      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>-->	
    </div>

  </div>
</div>			
			
			</div><!-- /.col-->		
		</div><!-- /.row -->


	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.js"></script>
<script> 
$(document).ready(function () {
  
$('#nombre_equipo').select2();
$('#condicion_equipo').select2();	
$('#id_departamento').select2();			
$('#uso_equipo').select2();	
$("#accion_equipo").select2();		
$('#en_uso').select2();	
$('#garantia').select2();	
$('#per_proyecto').select2();	
$('#marca_procesador_l').select2();	
$('#marca_procesador_p').select2();	
						
$('#cpu_pc').select2();	


 });

function editar($id){
alert($id);
		
			var parametros = {
			"id_inventario"   	   : $id
			};

			 $.ajax({
                data:  parametros,
                url:   'editar_reporte.php',
                type:  'POST',
                beforeSend: function () {
                        $("#contenido_modal_e").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					   $("#contenido_modal_e").html(response);
					 
					
						
                }
            });
		
}

function consultar($id){
		
			var parametros = {
			"id_inventario"   	   : $id
			};

			 $.ajax({
                data:  parametros,
                url:   'datos_consultar.php',
                type:  'POST',
                beforeSend: function () {
                        $("#contenido_modal").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					   $("#contenido_modal").html(response);
					 
					
						
                }
            });
		
}

	var table = $('#example_reporte').DataTable({
			"language": {
                	"url": "js/lenguaje/spanish.json"
           	},
			 "pagingType": "full_numbers",
			"columnDefs": [ {
			  "orderable": false			  
			}
			 ]
	});

		
var array_tabla_ord=table.order();	
		//console.log(table);

	//alert(array_tabla_ord[0][0]);



function generar_pdf(){
//alert(array_tabla_ord);
	 	
	 	var T_NOMBRE_E= '<?=$_POST['nombre_equipo']?>';
		var T_COND_E = '<?=$_POST['condicion_equipo']?>';
		var T_TEC_E = '<?=$_POST['id_tecnico']?>';
		var T_DEP_E = '<?=$_POST['id_departamento']?>';
		var T_USO_E = '<?=$_POST['uso_equipo']?>';
		var T_ACC_E = '<?=$_POST['accion_equipo']?>';
	    var T_GARAN_E = '<?=$_POST['garantia']?>';
		var T_PROY_E = '<?=$_POST['per_proyecto']?>';
		var T_ORDER_T = array_tabla_ord;
					

			var parametros = {
			"nombre_equipo"   	   : T_NOMBRE_E,
			"condicion_equipo"   : T_COND_E,
			"id_tecnico"       : T_TEC_E,
			"id_departamento"   : T_DEP_E,
			"uso_equipo"    : T_USO_E,
			"accion_equipo"        : T_ACC_E,
			"garantia"          : T_GARAN_E,
			"per_proyecto"           : T_PROY_E,
			"array_tabla_ord":T_ORDER_T
			};

			 $.ajax({
                data:  parametros,
                url:   'proc_reporte_pdf.php',
                type:  'POST',
                beforeSend: function () {
                       $("#resultado_rt").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					window.location = url;
					  
					   //$("#resultado_rt").html(response);
						//alert("33333Datos insertados satisfactoriamente");
					//	window.location.reload();
					
						
                }
            });
		
}
</script>
