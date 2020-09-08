<?php
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");

$bd=new bd_conexion();

$datos_tecnico=$bd->consultaObjeto(array("*")," tecnico","1",0);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inventario</title>

<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="css/jquery.dataTables.css" rel="stylesheet">


<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		
	<?php include("menues/menu_principal.php");?>
<div id='contenido_principal'>			
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
			
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Consultar T&eacute;cnico de Equipos</h1>
			</div>
		</div><!--/.row-->
	
					
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					
					<div class="panel-body">
						<div class="col-md-12">
						
						<div id="resultado_rt" style="color:#005B88; text-align:center; size:500">&nbsp;</div>
<div class="table-responsive">
<table id="example" class="display table-hover dt-responsive" cellspacing="0" width="100%">
        <thead>
            <tr>

                <th>Nombre</th>
				<th>Usuario</th>
				<th>Fecha</th>
                <th>Editar</th>
				<!--<th>Eliminar</th> -->
            </tr>
        </thead>
        <tfoot>
        </tfoot>
        <tbody>
           <?php for($i=0;$i<sizeof($datos_tecnico);$i++){?>
		   
		    <tr>

               
				<td><?php echo $datos_tecnico[$i]->NOMBRE;?></td>
				<td><?php echo $datos_tecnico[$i]->USUARIO;?></td>
				<td><?php echo $datos_tecnico[$i]->FECHA_TRANS;?></td>
				<td><a  onClick="editar('<?php echo $datos_tecnico[$i]->ID_TECNICO;?>')"><span class="glyphicon glyphicon-pencil" title="Editar"></span></a></td>
               <!-- <td><a onClick="eliminar('<?php /*echo $datos_inventario[$i]->ID_INVENTARIO;//echo $datos_inventario[$i]->	ID_EQUIPO;*/?>')"><span class="glyphicon glyphicon-trash" title="Eliminar"></span></a></td> -->
            </tr>
			<?php }?>
           
        </tbody>
    </table>
	</div>
</div>
</div>
</div>	
</div>					
			</div>
			

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

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
			
			</div><!-- /.col-->		
		</div><!-- /.row -->



	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.js"></script>
	<script>
		
		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
		
$(document).ready(function() {
	$('#example').DataTable({
			"language": {
                	"url": "js/lenguaje/spanish.json"
           	},
			 "pagingType": "full_numbers",
			"columnDefs": [ {
			  "targets": 2,
			  "orderable": false			  
			},
			{
			  "targets": 3,
			  "orderable": false
			}
			 ]
	});
		
	
} );



function editar($id){
		
			var parametros = {
			"id_tecnico"   	   : $id
			};

			 $.ajax({
                data:  parametros,
                url:   'editar_tecnico.php',
                type:  'POST',
                beforeSend: function () {
                        $("#contenido_principal").html("Procesando, espere por favor...");
                },
                success:  function (response) {
					   $("#contenido_principal").html(response);
					 
					
						
                }
            });
		
}
function eliminar($id,$eq){
	 if (confirm('¿Estás seguro que deseas Eliminar el Inventario del Equipo?')){
      
		  var parametros = {
				"id_inventario"   	   : $id,
				"nombre_equipo"   	   : $eq
				};
	
				 $.ajax({
					data:  parametros,
					url:   'proc_eliminar.php',
					type:  'POST',
					beforeSend: function () {
							$("#resultado_rt").html("Procesando, espere por favor...");
					},
					success:  function (response) {
						   $("#resultado_rt").html(response);
						   window.location.reload();
								
					}
				});
	  
    } 	
			
	
}



	</script>	
</body>

</html>