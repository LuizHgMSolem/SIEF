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

// CAPITURA INFORMAÇÕES TIPO POST VINDAS DA TELA Vinculo.php 
$CadVinculo = filter_input_array(INPUT_POST, FILTER_DEFAULT);
/***************************
 * INICIANDO CADASTROS
***************************/
if (isset($CadVinculo) && !empty($CadVinculo)){
  foreach ($CadVinculo as $key => $value) {
    if (empty($value)) {
      $_SESSION['VinculoInvalido'] = true;
    }else {
    $_SESSION['VinculoInvalido'] = false;
    }
  } 
/**************************************
CADASTRO DA DICIPLINA NO BANCO DE DADOS 
***************************************/
  if($_SESSION['VinculoInvalido']){
    echo "VINCULO NÃO FOI CADASTRADO";
    header('Location: ../paginaPrincipal/Administrador/Turma_diciplina/vinculo/Vinculo-Cliente.php');
}else {
/*********************** VALIDAR VINCULAÇÃO  **********************/  
  $validarVinculo = "SELECT * FROM turma_diciplina WHERE turma_diciplina.FK_Turma = :FK_Turma AND turma_diciplina.FK_Diciplina = :FK_Diciplina";
  $SelectVinculo = $conn -> prepare($validarVinculo);
  $SelectVinculo->bindParam(':FK_Turma',$CadVinculo['TurmaName']);
  $SelectVinculo->bindParam(':FK_Diciplina',$CadVinculo['DiciplinaName']);
  $SelectVinculo->execute();
  $AllVinculo = $SelectVinculo->fetchAll();
  // ***** SE VINCULO JÁ EXISTE REDIRIECIONAR PAGINA*****
  if ($AllVinculo) {
   echo "VINCULO JÁ EXISTE";
   header('Location: ../paginaPrincipal/Administrador/Turma_diciplina/vinculo/Vinculo-Cliente.php');
  }else { // ******************** VINCULO ACEITO **********************
    $SqlVinculo = "INSERT INTO turma_diciplina VALUES(0, :FK_Diciplina, :FK_Turma)";
      $InsertVinculo = $conn -> prepare($SqlVinculo);
      $InsertVinculo->bindParam(':FK_Turma',$CadVinculo['TurmaName']);
      $InsertVinculo->bindParam(':FK_Diciplina',$CadVinculo['DiciplinaName']);
      // SE VINVULO FOI CADASTRADO COM SUCESSO
      if ($InsertVinculo->execute()) {
        echo "VINVULO FOI CADASTRADO COM SUCESSO";  
      }
      header('Location: ../paginaPrincipal/Administrador/Turma_diciplina/vinculo/Vinculo-Cliente.php');
    }
  }
}

unset($_SESSION['VinculoInvalido']);    
?>