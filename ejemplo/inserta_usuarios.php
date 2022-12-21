<?php

   require_once('conexion.php');//PARAUTILIZAR LA CONEXION
   $max=1500000; //PESO M�XIMO DEL ARCHIVO A SUBIR
   $archivo=$_FILES['archivo']['name'];//OBTENER NOMBRE TEMPORAL DEL ARCHIVO
   $peso = $_FILES['archivo']['size'];//PESO DEL ARCHIVO
   if($peso> $max){//SI PESA MAS DE LO PERMITIDO; FINALIZAR
       print 'SELECCIONE UN ARCHIVO CON MENOS PESO (MAX.: 1.5 MB)';
	   return false;
   }

if((mb_ereg(".xls", $archivo)) || (mb_ereg(".xlsx", $archivo)))
  // if((preg_match(".xls", $archivo)) || (preg_match(".xlsx", $archivo)))
   {
	   $rutatemporal=$_FILES['archivo']['tmp_name'];//RUTA TEMPORAL DEL ARCHIVO
       $rutadestino=$archivo;	 
	   move_uploaded_file($rutatemporal,$rutadestino);//GUARDAMOS 
	   require_once("PhpExcel/Classes/PHPExcel.php");
	   require_once("PhpExcel/Classes/PHPExcel/Reader/Excel2007.php");
	   $objReader = new PHPExcel_Reader_Excel2007(); 
	   $objPHPExcel = $objReader->load($rutadestino);
	   $objPHPExcel->setActiveSheetIndex(0);
	   $Fila=2;
        $cont=0;
        $afrRes=$negRes="";
        $nombre='';
        $genero='';
        $user='';
        $pass='';

	   while ($objPHPExcel->getActiveSheet()->getCell("A".$Fila)->getValue()!="")
       {
           $nombre=$objPHPExcel->getActiveSheet()->getCell("B".$Fila)->getValue();
           $genero=$objPHPExcel->getActiveSheet()->getCell("C".$Fila)->getValue();
           $user=$objPHPExcel->getActiveSheet()->getCell("D".$Fila)->getValue();
           $pass=$objPHPExcel->getActiveSheet()->getCell("E".$Fila)->getValue();
           $sql="insert into usuarios values (null,'".$nombre."',".$genero.",'".$user."','".$pass."');";
          // print $sql.'<br>';
           $resultado=mysqli_query($login,$sql) or trigger_error((mysqli_error($login)));
      //      print $resultado;
           if($resultado)
           {
              $afrRes .=  "<br>Se ha regstrado correctamente: Registro No. ".($Fila-1);
               $cont++;
           }

           else $negRes .= "<br>Error al intentar registar: registro No. ".($Fila-1)." (".$nombre."',".$genero.",'".$user."','".$pass."')  ".$resultado;
		  $Fila++;
	   }
        print $negRes.'<br>'.$afrRes;
        print "<br><br>Se han importando correctamente ".$cont." Registros nuevos del archivo ".$archivo;
	   unlink($rutadestino);//ELIMINAR EL ARCHIVO
//header("Location:javascript:Operacion(4,6,2)");
 }
else
     print 'EL ARCHIVO SELECCIONADO NO ES DE EXCEL';
?>