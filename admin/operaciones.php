<?php
   include("procesar.php");
   $c=new Funciones;
   switch($_GET['opc']){
      case 1://LOGUEO
	      $c->Logueo($_POST['d1'],$_POST['d2']);
		  break;
      case 2:
          $c->buscarUsuario();
          print '<div id="resultados2">';
          //$sql="select * from usuarios LIMIT 0,5;";
	      //$c->tblUsuario($sql);
          print 'Para modificar o eliminar a un usuario, coloque una palabra o parte de ella que recuerde del usuario en el buscador';
          print '</div>';
		  break;
      case 4://INSERTA DATOS DEL USUARIO
	      $c->fInsertaUsuario();
	      break;
      case 6://MODIFICA USUARIO SELECCIONADO
	      $c->fActulizaUsuario();
	      break;
       case 7:
           $c->fEliminarUsuario();
           break;
       case 8:
           $c->fActulizaUsuario();
           break;
       case 10:
           $c->visorDepartamentos();
           break;
       case 11:
           if(!isset($_GET['txtBucador']))$_GET['txtBucador']=" ";
           $sql="select vbuscador.* from vbuscador where nombre like'%".$_GET['txtBucador']."%' or primer_apellido like'%".$_GET['txtBucador']."%' or segundo_apellido like'%".$_GET['txtBucador']."%' or usuario like'%".$_GET['txtBucador']."%' or nombredepartamento like'%".$_GET['txtBucador']."%' or cargo like'%".$_GET['txtBucador']."%';";
          // print $sql;
           $c->tblUsuario($sql);
           break;
       case 14:
           $c ->fIsertDep();
           break;
       case 15:
           $c->fEditDep();
            break;
       case 16:
           $c->fDelDep();
           break;

   }
?>