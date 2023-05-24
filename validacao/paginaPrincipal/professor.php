<?php
session_start();

if ($_SESSION['tipoUsuario'] == 2){
  echo "<h1>AREA DO PROFESSOR</h1>";
}


?>