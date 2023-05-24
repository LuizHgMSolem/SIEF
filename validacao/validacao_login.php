<?php
session_start();
// error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
  header("Location: index.php");
  exit();
};



validPathLogin();






function validPathLogin(){
include_once('conexao.php');
// SELECIONA DADOS DO TABELA USUÁRIO DO BANCO DE DADOS
  $sqlSelect = "SELECT * FROM usuario WHERE CPF=:login and Senha=:senha" ;
    $returnSQL = $conn->prepare($sqlSelect);
    $returnSQL -> bindParam(':login',$_POST['email']);
    $returnSQL -> bindParam(':senha',$_POST['password']);
    $returnSQL -> execute();
// VERIFICA SE A SELEÇÃOO FOI FEITA ADEQUADAMENTE E PASSA VARIAVEL DE VERIFICAÇÃO
      if ($returnSQL -> execute()) {
        // SELECIONA CADA DADO SELECIONADO NO BANCO DE DADOS
        while ($usuario = $returnSQL->fetch()) {
          // VERIFICA O TIPO DE USUÁRIO E ENVIA PARA A TELA PERTENCENTE A ELE
          switch ($usuario['Tipo']) {
            case '1':
              $_SESSION['tipoUsuario'] = 1;
              header('Location: paginaPrincipal/admin.php');
              break;
            case '2':
              $_SESSION['tipoUsuario'] = 2;
              header('Location: paginaPrincipal/professor.php');
              break;
            case '2':
              $_SESSION['tipoUsuario'] = 3;
              header('Location: paginaPrincipal/aluno.php');
              break;
          }
      }
    }

  }
?>