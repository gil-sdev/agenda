<?php
include 'funciones.php';
class Funciones
{
    function Logueo($d1,$d2)
    {
        include "conexion.php";
        @mysqli_query($login,"SET NAMES 'utf8'");
        $sql="SELECT idusuarios,usuario,tipo_usuario FROM usuarios where usuario='".$d1."' and contraseña='".$d2."'";
        $query=mysqli_query($login,$sql);
        if (mysqli_num_fields($query)>0)
        {
            session_start();

            $row=mysqli_fetch_assoc($query);
            $_SESSION['id'] = $row['idusuarios'];
            $_SESSION['user'] = $row['usuario'];
            $_SESSION['nivel'] = $row['tipo_usuario'];



            switch($row['tipo_usuario'])
            {
                case 1:
                    print "admin/principal.php";
                    break;
                case 2:
                    print "agenda.php";
                    break;
                default:
                    print 'false';
                    break;

            }
        }
        else
        {
            print 'false';
        }
    }
    function buscarUsuario()
    {
        include 'conexion.php';
        //Ventana para opcion eliminar usuario
        $content='
              <input type="hidden" id="txtTempDelUser" value="">
                ¿Esta seguro de eliminar al usuario?<div id="divNotes"></div>';
        $icon='<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
        modalWindows('delUserMODAL','Eliminar registro',$content,'Cancelar','Eliminar','fDelUser(7,1)',$icon);

        $icon='<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
        modalWindows('EditUserMODAL','Modificar  usuario',frmEditarUsuario(),'Cancelar','Guardar cambios','EditGetUserFrm(8,2)',$icon);

        $icon='<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>';
        modalWindows('addUserMODAL','Agregar nuevo usuario',frmNuevoUsuario(),'Cancelar','Agregar','Operacion(1,4,1)',$icon);


        $sql="select idusuarios from usuarios";
        mysqli_query($login,"SET NAMES 'utf8'");
        $Resultado=mysqli_query($login,$sql);


   print '         <div class="panel panel-info">
          <!-- Default panel contents -->
          <div class="panel-heading">Usuarios registrados: '.mysqli_num_rows($Resultado).' </div>
          <div class="panel-body">
          ';

        print '
        <div class="navbar-form navbar-left" role="search">
            <div class="form-group">
                 <input id="txtBucador" type="text" class="form-control" placeholder="Buscar usuario" >
            </div>
            <button type="submit" class="btn btn-default" onclick="javascript:Operacion(1,11,2)">Buscar
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            </button>

        </div>

        <div class="navbar-form navbar-left" role="search">
            <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#addUserMODAL">Agregar usuario
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>

        </div>


        ';
    }
    function tblUsuario($sql)
    {

        include 'conexion.php';
        mysqli_query($login,"SET NAMES 'utf8'");
        $Resultado=mysqli_query($login,$sql);
        if(mysqli_num_rows($Resultado) > 0)
        {
            print '
<table class="table table-hover">
<caption>Usuarios registrados</caption>
    <thead>
        <tr>
            <th>Id</th>
            <th>NOMBRE</th>
            <th>USUARIO</th>
            <th>CONTRASEÑA</th>
            <th>CARGO</th>
            <th>TIPO DE USUARIO</th>
            <th>HABILITADO</th>
            <th>DEPARTAMENTO</th>
        </tr>
    </thead>
<tbody>';

            while($Datos=mysqli_fetch_array($Resultado))
            {
                print '<tr>
				 <td>'.$Datos['idusuarios'].'</td>
				 <td>'.$Datos['nombre'].' '.$Datos['primer_apellido'].' '.$Datos['segundo_apellido'].'</td>
				 <td>'.$Datos['usuario'].'</td>
				 <td>'.$Datos['contraseña'].'</td>
				 <td>'.$Datos['cargo'].'</td><td>';
                switch ($Datos['tipo_usuario'])
                {
                    case 1:
                        print 'Administrador';
                        break;
                    case 2:
                        print 'Usuario normal';
                        break;
                }
				print  '</td><td>';
               switch ($Datos['estado'])
               {
                   case 1:
                       print 'SI';
                       break;
                   case 2:
                       print 'NO';
                       break;
               }

                print '</td>
				  <td>'.buscar_dato('SELECT nombredepartamento FROM departamento where iddepartamento ='.$Datos['departamento_iddepartamento'],'nombredepartamento').'</td>
				  <td>

				  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#EditUserMODAL" onclick="javascript:
	EditSetUserFrm('.$Datos['idusuarios'].',\''.$Datos['nombre'].'\',\''.$Datos['primer_apellido'].'\',\''.$Datos['segundo_apellido'].'\',\''.
                    $Datos['usuario'].'\',\''.$Datos['contraseña'].'\',\''.$Datos['cargo'].'\','.$Datos['estado'].','.$Datos['departamento_iddepartamento'].')">

                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				  </button>

				 <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#delUserMODAL" onclick="javascript:frmEliminarUser('.$Datos['idusuarios'].',\''.$Datos['usuario'].'\')">
				 <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
				 </button>
                   </td>
              </tr>'
                ;
            }
            print '</tbody></table>
            <div id="resultados3">
            </div>
            </div>
            </div>';
        }else
            print 'NO HAY REGISTROS';
    }
    function fActulizaUsuario()
    {
        include 'conexion.php';
        mysqli_query($login,"SET NAMES 'utf8'");
       $sql="UPDATE usuarios SET nombre = '".$_GET['d1']."', primer_apellido = '".$_GET['d2']."', segundo_apellido = '".$_GET['d3']."', usuario = '".$_GET['d4']."', contraseña = '".$_GET['d5']."', cargo = '".$_GET['d6']."', estado =".$_GET['d7'].", departamento_iddepartamento =".$_GET['d8'].", tipo_usuario =".$_GET['d9']." WHERE usuarios.idusuarios =".$_GET['q'];

  //      print $sql;

       if ($sql=mysqli_query($login,$sql)){
         //  header("Location:operaciones.php?q=1&opc=2");
           header("Location:operaciones.php?txtBucador=".$_GET['d1']."&opc=11");
       }
        else
           print "NO SE PUDO MODIFICAR POR ".mysqli_error().$sql.'<p></p>';
    }
    function fInsertaUsuario(){
	  include 'conexion.php';

	   $sql="INSERT INTO usuarios(idusuarios,nombre,primer_apellido,segundo_apellido,usuario,contraseña,cargo,tipo_usuario,estado,departamento_iddepartamento)
	   VALUES (NULL,'".$_GET['d1']."','".$_GET['d2']."','".$_GET['d3']."','".$_GET['d4']."','".$_GET['d5']."','".$_GET['d6']."',".$_GET['d9'].",'".$_GET['d7']."','".$_GET['d8']."');";
   //  print $sql."\n";
       mysqli_query($login,"SET NAMES 'utf8'");
       $sql=mysqli_query($login,$sql)  or trigger_error((mysqli_error($login)));
	   if ($sql){
           print '';
			header("Location:operaciones.php?q=1&opc=2");
		//	print 'LA INFORMACIÓN SE INSERTO CORRECTAMENTE';
	   }
	   else
		   print "IMPOSIBLE EJECUTAR".$sql.'<p></p>';

   }
    function exportarAexcel()
   {
       //http://localhost/Web2/pg2_u1/admin/PhpExcel/exportar_usuarios.php
       header("location:PhpExcel/exportar_usuarios.php");
   }

    function fEliminarUsuario()
    {
        include 'conexion.php';
        mysqli_query($login,"SET NAMES 'utf8'");
        $sql="Delete from usuarios WHERE idusuarios=".$_GET['q'];
        $sql=mysqli_query($login,$sql);
        if ($sql)
        {
            header("Location:operaciones.php?q=1&opc=2");
        }
        else
            print "Imposible eliminar".mysqli_error().$sql.'<p></p>';

    }
    //bloque para manejo de departamentos
    function visorDepartamentos()
    {

        include 'conexion.php';
        header("Content-type:text/html;charset=utf-8");

        $sql="select iddepartamento,nombredepartamento from departamento;";
        mysqli_query($login,"SET NAMES 'utf8'");
        $Resultado=mysqli_query($login,$sql);
        if(mysqli_num_rows($Resultado) > 0){
            print '
    <div class="panel panel-info">
      <!-- Default panel contents -->
      <div class="panel-heading">Departamentos registrados</div>
      <div class="panel-body">

        <div class="form-inline navbar-form navbar-left">
           <div class="form-group">
              Lista de departamentos registrados en el sistema
           </div>
           <div class="form-group ">
        <div class="navbar-form navbar-left">
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addDepMODAL">Agregar departamento
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
            </div>
       </div>
         </div>


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>DEPARTAMENTO</th>
                    </tr>
                </thead>
            <tbody>
';
            while($Datos=mysqli_fetch_array($Resultado))
            {
                print '<tr>
				 <td>'.$Datos['iddepartamento'].'</td>
				 <td>'.$Datos['nombredepartamento'].'</td>
				 <td>
                      <button type="button" id="btnDelDep" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#delDepMODAL" onclick="javascript:ConfirmarEliminar('.$Datos['iddepartamento'].',\''.$Datos['nombredepartamento'].'\')">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                      </button>
                     <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#editDepMODAL" onclick="javascript:editDep('.$Datos['iddepartamento'].',\''.$Datos['nombredepartamento'].'\')">
                     <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                     </button>
                 </td>';

            }
            print '</tbody></table></div>';// <br><a href="javascript:Operacion(0,12,2)">Exportar</a>';
            print '<div id="resultados2"></div>    </div>';

            //Ventana para opcion eliminar departamento
            $content='
              <input type="hidden" id="txtTempDElDep" value="">
                ¿Esta seguro de eliminar el departamento?<div id="divNotes"></div>';
            $icon='<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
            modalWindows('delDepMODAL','Eliminar registro',$content,'Cancelar','Eliminar','delDep(16,1)',$icon);


            //Ventana para opcion editar departamento
            $content='
                <div class="form-group">
                     <input type="hidden" id="txtTempEditDep" value="">
                     <input id="txtDep" type="text" class="form-control" placeholder="Departamento" name="txtDep" TITLE="Departamento" value="">
                </div>
                ';
            $icon='<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
            modalWindows('editDepMODAL','Cambiar departamento',$content,'Cancelar','Editar','delDep(15,1)',$icon);


            //Ventana para opcion agregar departamento
            $content='
                    <div class="form-group">
                         <input id="txtAddDep" type="text" class="form-control" placeholder="Departamento" name="txtDep" TITLE="Departamento">
                    </div>
                ';
            $icon='<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>';
            modalWindows('addDepMODAL','Agregar nuevo departamento',$content,'Cancelar','Agregar','Operacion(1,14,1)',$icon);

        }else
        {
            print 'NO HAY REGISTROS';
        }


    }
    function fIsertDep()
    {
        include 'conexion.php';
        mysqli_query($login,"SET NAMES 'utf8'");
        $sql="INSERT INTO departamento (iddepartamento, nombredepartamento) VALUES (NULL, '".$_GET['txtAddDep']."');";
       print $sql;
        $resultado=mysqli_query($login,$sql);
        if($resultado) header("location:operaciones.php?opc=10");
        else print 'Error al intentar registrar';

    }
    function fEditDep()
    {

        include 'conexion.php';
        mysqli_query($login,"SET NAMES 'utf8'");
        $sql="UPDATE departamento SET nombredepartamento = '".$_GET['txtDep']."' WHERE iddepartamento =".$_GET['q'].";";
        // print $sql;
        $resultado=mysqli_query($login,$sql);
        if($resultado)
        {
            print '';
            header("location:operaciones.php?opc=10");
        }
        else print 'Error al intentar registrar';
    }
    function fDelDep()
    {
        include 'conexion.php';
        mysqli_query($login,"SET NAMES 'utf8'");
        $sql="DELETE FROM departamento WHERE iddepartamento =".$_GET['q'].";";
        // print $sql;
        $resultado=mysqli_query($login,$sql);
        if($resultado)
        {
            print '';
            header("location:operaciones.php?opc=10");
        }
        else
        {
            print '
            <div class="panel panel-danger">
              <div class="panel-heading">
                <h4 class="panel-title">Error al intentar eliminar</h4>
              </div>
              <div class="panel-body">
                Es posible que existan usuarios vinculados al departamento
              </div>
            </div>';
            print '<button type="button" class="btn btn-warning" onclick="javascript:Operacion(4,10,1)"> Entendido </button></div>';
        }
    }

}//Fin de la Clase
?>