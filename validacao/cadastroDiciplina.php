<?php
session_start();
include_once('../validacao/conexao.php');
// ***** VALIDA LOGIN *******
function ValidarRegistro(){
  // FAZ LOGOUT 
  if (isset($_POST["Logout"]) && !empty($_POST["Logout"])) {
    if ($_POST["Logout"]) {
      $_SESSION['tipoUsuario'] = 0;
    }
  }

  // Validação do Registro.
  if (!$_SESSION['tipoUsuario'] == 1){
    header('Location: ../login.php');        
  }
}
ValidarRegistro();
// *********** BLOQUEIA ENTRADA DE GET
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
  header('Location: ../Login');
}

// CAPITURA INFORMAÇÕES TIPO POST VINDAS DA TELA Diciplina-Cliente.php 
$CadDiciplina = filter_input_array(INPUT_POST, FILTER_DEFAULT);
/***************************
 * INICIANDO CADASTROS
***************************/
if (isset($CadDiciplina) && !empty($CadDiciplina)){
  foreach ($CadDiciplina as $key => $value) {
    if (empty($value)) {
      $_SESSION['DiciplinaInvalida'] = true;
    }else {
    $_SESSION['DiciplinaInvalida'] = false;
    }
  } 
/**************************************
CADASTRO DA DICIPLINA NO BANCO DE DADOS 
***************************************/
  if($_SESSION['DiciplinaInvalida']){
    header('Location: ../paginaPrincipal/Administrador/Turma_diciplina/vinculo/vinculo.php');
  }else {
    $SqlDiciplina = "INSERT INTO diciplina VALUES(0, :Materia)";
    $InsertDiciplina = $conn -> prepare($SqlDiciplina);
    $InsertDiciplina->bindParam(':Materia',$CadDiciplina['Diciplina']);
    if ($InsertDiciplina->execute()) {
      echo 'Diciplina Cadastrada';
      header('Location: ../paginaPrincipal/Administrador/Turma_diciplina/vinculo/vinculo.php');
    }
  }
}

unset($_SESSION['DiciplinaInvalida']);    
?>