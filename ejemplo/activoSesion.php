<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();//start session if session not start
    if (@!$_SESSION['user']) header("Location:../");
   /*

     else
    {
        if($_SESSION['nivel'] == 2)  header("Location:../index.php");
        if($_SESSION['nivel'] == 1)  header("Location:principal.php");
    };
    */

}

?>