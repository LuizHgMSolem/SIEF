<?php
session_start();

if ($_SESSION['tipoUsuario'] == 1){
  echo "<h1>AREA ADMINISTRATIVA</h1>";
}


?>