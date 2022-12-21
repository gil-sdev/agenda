<?php
if(session_status() == PHP_SESSION_NONE)
{
    session_start();//start session if session not start
    if (@!$_SESSION['user']) header("Location:../");

}

?>