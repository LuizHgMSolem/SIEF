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
// SELECIONA DADOS DO TABELA USUÁRIO DO BANCO DE DADOS.
echo $_POST['login']."<br>";
echo $_POST['password'];
  $sqlSelect = "SELECT  Matricula.id, Usuario.FK_Matricula, Usuario.Senha, Usuario.Usuario, Matricula.Tipo FROM Usuario INNER JOIN Matricula on Matricula.id = Usuario.FK_Matricula and Usuario.Usuario=:login and Usuario.Senha=:senha" ;
    $returnSQL = $conn->prepare($sqlSelect);
    $returnSQL -> bindParam(':login',$_POST['login']);
    $returnSQL -> bindParam(':senha',$_POST['password']);
    $returnSQL -> execute();
// VERIFICA SE A SELEÇÃOO FOI FEITA ADEQUADAMENTE E PASSA VARIAVEL DE VERIFICAÇÃO.
      if ($returnSQL -> execute()) {
        // SELECIONA CADA DADO SELECIONADO NO BANCO DE DADOS.
          $fetchall = $returnSQL -> fetchAll();


        // Valida SELEÇÃO.
        if (!$fetchall) {
          setcookie("emailInvalido", "EMAIL INCORRETO", time() + 3600, "/");
          setcookie("senhaInvalida", "SENHA INCORRETA", time() + 3600, "/");
          $_SESSION['msg'] = $_COOKIE["emailInvalido"] . " / ".  $_COOKIE["senhaInvalida"];
          header('Location: ../login.php');
        }else{ 
        if ($_SESSION['loginPermitido'] = true) {
          setcookie("emailValido", $_POST['login'], time() + 3600, "/");
          setcookie("senhaValida", $_POST['password'], time() + 3600, "/");
        }
          unset($_SESSION['loginPermitido']);

          // Verifica Tipo De Usuário.
          switch ($fetchall[0]['Tipo']) {
            case '1':
              $_SESSION['tipoUsuario'] = 1;
              header('Location: ../paginaPrincipal/Administrador/admin.php');
              break;
            case '2':
              $_SESSION['tipoUsuario'] = 2;
              header('Location: ../paginaPrincipal/professor.php');
              break;
            case '2':
              $_SESSION['tipoUsuario'] = 3;
              header('Location: ../paginaPrincipal/aluno.php');
              break;
            }
        }
      }else{
        header('Location: ../login.php');      
      }

  }
?>