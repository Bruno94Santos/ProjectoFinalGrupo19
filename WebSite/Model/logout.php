<?php  
session_start(); //on index top
if(isset($_SESSION["loggedin"])){
  session_unset();
  session_destroy();
}?>
