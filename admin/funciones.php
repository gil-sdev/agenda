<?php


function versihay($sql)
{
//FUNCI�N PARA SABER SI HAY DATOS [REGRESA EL TOTAL DE REGISTROS ENCONTRADOS])
   @mysqli_query("SET NAMES 'utf8'");

   $query=mysqli_query($sql);
   return mysqli_num_rows($query);
}
function buscar_dato($sql,$campo)
{
    include "conexion.php";
    $Dato="";
	@mysqli_query("SET NAMES 'utf8'");
	$query=mysqli_query($login,$sql);
	if (mysqli_num_fields($query)>0){
	    $row=mysqli_fetch_assoc($query);
		$Dato=$row[$campo];
	}
	return $Dato;

}

function modalWindows($id,$tile,$content,$btn1,$btnOk,$operacion,$icon)
{
    print '<div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
    print '<div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> '.$tile.'</h4>
              </div>
              <div class="modal-body">
                '.$content.'
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">'.$btn1.'</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="javascript:'.$operacion.'">'.$btnOk.$icon.'</button>
      </div>
    </div>
  </div>
</div>
              ';

}

function frmNuevoUsuario(){
    $a = $b = $c ="";
    include 'conexion.php';
    mysqli_query($login,"SET NAMES 'utf8'");
    $a= '
        <div class="form-horizontal">

          <div class="form-group">
          <label for="d1Add" class=" control-label">Nombre</label>
			  <input name="d1Add" type="text" id="d1Add" size="40" maxlength="70" title="NOMBRE DEL USUARIO" class="form-control">
		  </div>

		   <div class="form-group">
			<label for="d2Add" class="control-label">Primer apellido</label>
			  <input name="d2Add" type="text" id="d2Add" size="40" maxlength="70" title="PRIMER APELLIDO" class="form-control">
		   </div>

		  <div class="form-group">
			<label for="d3Add" class="control-label">Segundo apellido</label>
			  <input name="d3Add" type="text" id="d3Add" size="40" maxlength="70" title="SEGUNDO APELLIDO" class="form-control">
		  </div>

		  <div class="form-group">
			<label for="d4Add" class="control-label">Usuario</label>
			  <input name="d4Add" type="text" id="d4Add" size="40" maxlength="70" title="NOMBRE DE LA CUENTA" class="form-control">
		  </div>

		  <div class="form-group" >
			<label for="d5Add" class=" control-label">Contraseña</label>
			  <input name="d5Add" type="text" id="d5Add" size="40" maxlength="70" title="CONTRASEÑA DE LA CUENTA" placeholder="**" class="form-control">
		  </div>

		  <div class="form-group">
			<label for="d6Add" class=" control-label">Cargo</label>
			  <input name="d6Add" type="text" id="d6Add" size="40" maxlength="70" title="CARGO DEL USUARIO" class="form-control">
		  </div>

		  <div class="form-group">
		  	<label for="d7Add" class=" control-label">Habilitado</label>
			  <select name="d7Add" id="d7Add" class="form-control">
				<option value="-1">---Seleccione--</option>
				<option value="1">Si</option>
				<option value="2">No</option>
			  </select>
		  </div>

		  <div class="form-group">
			<label for="d8Add" class=" control-label">Departamento</label>
			  <select name="d8Add" id="d8Add" class="form-control">
				<option value=-1>---Seleccione--</option>';
    $sql="select * from departamento";
    $Resultado=mysqli_query($login,$sql);
    if(mysqli_num_rows($Resultado) > 0)
    {
        while($Datos=mysqli_fetch_array($Resultado)){
            $b .= '<option value="'.$Datos['iddepartamento'].'">'.$Datos['nombredepartamento'].'</option>';
        }
    }

    $c=  '
			  </select>
		   </div>
		 <div class="form-group">
		  	<label for="d9Add" class=" control-label">Tipo de usuario</label>
			  <select name="d9Add" id="d9Add" class="form-control">
				<option value="-1">---Seleccione--</option>
				<option value="1">Administrador</option>
				<option value="2">Usuario normal</option>
			  </select>
		  </div>

	</div>
';

    return ($a.$b.$c);
}
function frmEditarUsuario(){
    $a = $b = $c ="";
    include 'conexion.php';
    mysqli_query($login,"SET NAMES 'utf8'");
    $a= '
        <input type="hidden" id="txtTempEditUserId" value="">
        <div class="form-horizontal">

          <div class="form-group">
          <label for="d1" class=" control-label">Nombre</label>
			  <input name="d1" type="text" id="d1" size="40" maxlength="70" title="NOMBRE DEL USUARIO" class="form-control">
		  </div>

		   <div class="form-group">
			<label for="d2" class="control-label">Primer apellido</label>
			  <input name="d2" type="text" id="d2" size="40" maxlength="70" title="PRIMER APELLIDO" class="form-control">
		   </div>

		  <div class="form-group">
			<label for="d3" class="control-label">Segundo apellido</label>
			  <input name="d3" type="text" id="d3" size="40" maxlength="70" title="SEGUNDO APELLIDO" class="form-control">
		  </div>

		  <div class="form-group">
			<label for="d4" class="control-label">Usuario</label>
			  <input name="d4" type="text" id="d4" size="40" maxlength="70" title="NOMBRE DE LA CUENTA" class="form-control">
		  </div>

		  <div class="form-group" >
			<label for="d5" class=" control-label">Contraseña</label>
			  <input name="d5" type="text" id="d5" size="40" maxlength="70" title="CONTRASEÑA DE LA CUENTA" placeholder="**" class="form-control">
		  </div>

		  <div class="form-group">
			<label for="d6" class=" control-label">Cargo</label>
			  <input name="d6" type="text" id="d6" size="40" maxlength="70" title="CARGO DEL USUARIO" class="form-control">
		  </div>

		  <div class="form-group">
		  	<label for="d7" class=" control-label">Habilitado</label>
			  <select name="d7" id="d7" class="form-control">
				<option value="-1">---Seleccione--</option>
				<option value="1">Si</option>
				<option value="2">No</option>
			  </select>
		  </div>

		  <div class="form-group">
			<label for="d8" class=" control-label">Departamento</label>
			  <select name="d8" id="d8" class="form-control">
				<option value="-1">---Seleccione--</option>';
    $sql="select * from departamento";
    $Resultado=mysqli_query($login,$sql);
    if(mysqli_num_rows($Resultado) > 0)
    {
        while($Datos=mysqli_fetch_array($Resultado)){
            $b .= '<option value="'.$Datos['iddepartamento'].'">'.$Datos['nombredepartamento'].'</option>';
        }
    }

    $c=  '
			  </select>
		   </div>

		    <div class="form-group">
		  	<label for="d9" class=" control-label">Tipo de usuario</label>
			  <select name="d9" id="d9" class="form-control">
				<option value="-1">---Seleccione--</option>
				<option value="1">Administrador</option>
				<option value="2">Usuario normal</option>
			  </select>
		  </div>

	</div>
';

    return ($a.$b.$c);
}

?>