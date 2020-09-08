<?php 
header("Content-Type: text/html;charset=utf-8");
include("lib/bd_conexion.php");
include("funciones.php");

$bd=new bd_conexion();

$procesador_marca=$bd->consultaObjeto(array("ID_TIPO_PRO"),"marca_procesador","1 AND ID_MARCA_PRO='".$_POST['id_marca']."'",1);
$procesador_tipo=$bd->consultaObjeto(array("ID_TIPO_PRO","DESCRIPCION"),"tipo_procesador","1 AND ID_TIPO_PRO='".$procesador_marca[0]->ID_TIPO_PRO."' ORDER BY DESCRIPCION ASC",1);



for($pm=0;$pm<sizeof($procesador_tipo);$pm++){?>
<option value="<?php echo $procesador_tipo[$pm]->ID_TIPO_PRO;?>"><?php echo $procesador_tipo[$pm]->DESCRIPCION;?></option>
<?php }?>
</select>



