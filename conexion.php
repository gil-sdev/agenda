<?php
   $hostname_login = "localhost";
   $database_login = "agenda_colaborativo";
   $username_login = "root";
   $password_login = "";
     $login = mysqli_connect($hostname_login, $username_login, $password_login) or trigger_error(mysql_error(),E_USER_ERROR);
     mysqli_select_db($login,$database_login);
        mysqli_query($login,"SET NAMES 'utf8'");

   
?>