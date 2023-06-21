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
$CadTurma = filter_input_array(INPUT_POST, FILTER_DEFAULT);
/***************************
 * INICIANDO CADASTROS
***************************/
if (isset($CadTurma) && !empty($CadTurma)){
  foreach ($CadTurma as $key => $value) {
    if (!empty($value)) {
      $_SESSION['TurmaInvalida'] = false;
    }else {
      $_SESSION['TurmaInvalida'] = true;
    }
  }
/***********************************
CADASTRO DA TURMA NO BANCO DE DADOS 
************************************/
  if ($_SESSION['TurmaInvalida']) {
    header('Location: ../paginaPrincipal/Administrador/Turma_diciplina/turma/turma-Cliente.php');
  }else{
    $SqlTurma = "INSERT INTO turma VALUES(0, :Nome, :Ano)";
    $InsertTurma = $conn -> prepare($SqlTurma);
    $InsertTurma->bindParam(':Nome',$CadTurma['Turma']);
    $InsertTurma->bindParam(':Ano',$CadTurma['TurmaAno']);
    // SE TURMA FOI CADASTRADA COM SUCESSO
    if ($InsertTurma->execute()) {
      echo 'Turma Cadastrada';
    }
  }
// APAGAR SESSIONS CRIADOS
unset($_SESSION['DiciplinaInvalida']);
unset($_SESSION['TurmaInvalida']);
unset($_SESSION['VinculoInvalido']);
}
?>