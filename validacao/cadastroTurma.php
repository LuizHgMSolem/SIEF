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
// VERIFICA TIPO DE CADASTRO TIPOS(DICIPLINA OU TURMA OU VINCULAÇÃO);
$TipoCadastro = isset($CadTurma['Diciplina']) && isset($CadTurma['CadDiciplina']) ? 'CadastroDiciplina' : 'cadastroTurma';
$VinculoCad  = isset($CadTurma['DiciplinaName']) && isset($CadTurma['TurmaName'])? "VinculoTurma": '';
// VERIFICAR TIPOS DE CADASTRO
  if ($TipoCadastro == "CadastroDiciplina") { //TIPO (DICIPLINA)
    foreach ($CadTurma as $key => $value) {
      if (empty($value)) {
        $_SESSION['DiciplinaInvalida'] = true;
      }
    }
  }else {
    $_SESSION['DiciplinaInvalida'] = false;
  }
  if ($TipoCadastro == "cadastroTurma") { //TIPO (TURMA)
    foreach ($CadTurma as $key => $value) {
      if (!empty($value)) {
        $_SESSION['TurmaInvalida'] = false;
      }
    }
  }else {
    $_SESSION['TurmaInvalida'] = true;
  }
  // VERIFICAR VINCULAÇÃO
  if ($VinculoCad == 'VinculoTurma' && !empty($VinculoCad)) { //TIPO (VICULAÇÃO)
        
    foreach ($CadTurma as $key => $value) {
      if (!empty($value)) {
        $_SESSION['VinculoInvalido'] = false;
      }
    }
  }else {
        $_SESSION['VinculoInvalido'] = true;
  }
/**************************************
CADASTRO DA DICIPLINA NO BANCO DE DADOS 
***************************************/
  if($_SESSION['DiciplinaInvalida']){
    header('Location: ../paginaPrincipal/Administrador/Turma_diciplina.php');
  }else {
    $SqlDiciplina = "INSERT INTO diciplina VALUES(0, :Materia)";
    $InsertDiciplina = $conn -> prepare($SqlDiciplina);
    $InsertDiciplina->bindParam(':Materia',$CadTurma['Diciplina']);
    if ($InsertDiciplina->execute()) {
      echo 'Diciplina Cadastrada';
    }
  }
/***********************************
CADASTRO DA TURMA NO BANCO DE DADOS 
************************************/
  if ($_SESSION['TurmaInvalida']) {
    header('Location: ../paginaPrincipal/Administrador/Turma_diciplina.php');
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
/************************************
VINCULAR CADASTROS NO BANCO DE DADOS 
*************************************/
  if ($_SESSION['VinculoInvalido']){
        echo "VINCULO NÃO FOI CADASTRADO";
      header('Location: ../paginaPrincipal/Administrador/Turma_diciplina.php');
  }else {
  /*********************** VALIDAR VINCULAÇÃO  **********************/  
    $validarVinculo = "SELECT * FROM turma_diciplina WHERE turma_diciplina.FK_Turma = :FK_Turma AND turma_diciplina.FK_Diciplina = :FK_Diciplina";
    $SelectVinculo = $conn -> prepare($validarVinculo);
    $SelectVinculo->bindParam(':FK_Turma',$CadTurma['TurmaName']);
    $SelectVinculo->bindParam(':FK_Diciplina',$CadTurma['DiciplinaName']);
    $SelectVinculo->execute();
    $AllVinculo = $SelectVinculo->fetchAll();
    // ***** SE VINCULO JÁ EXISTE REDIRIECIONAR PAGINA*****
    if ($AllVinculo) {
     echo "VINCULO JÁ EXISTE";
     header('Location: ../paginaPrincipal/Administrador/Turma_diciplina.php');
    }else { // ******************** VINCULO ACEITO **********************
      $SqlVinculo = "INSERT INTO turma_diciplina VALUES(0, :FK_Diciplina, :FK_Turma)";
        $InsertVinculo = $conn -> prepare($SqlVinculo);
        $InsertVinculo->bindParam(':FK_Turma',$CadTurma['TurmaName']);
        $InsertVinculo->bindParam(':FK_Diciplina',$CadTurma['DiciplinaName']);
        // SE VINVULO FOI CADASTRADO COM SUCESSO
        if ($InsertVinculo->execute()) {
          echo "VINVULO FOI CADASTRADO COM SUCESSO";  
        }
      header('Location: ../paginaPrincipal/Administrador/Turma_diciplina.php');
    }
  }

// APAGAR SESSIONS CRIADOS
unset($_SESSION['DiciplinaInvalida']);
unset($_SESSION['TurmaInvalida']);
unset($_SESSION['VinculoInvalido']);
}
?>