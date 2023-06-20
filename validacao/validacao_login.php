<?php
session_start();
// error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
  header("Location: ../index.php");
  exit();
};



validPathLogin();


function validPathLogin(){
// Seleciona dados enviados pro INPUT tipo POST
  $PostInfo = filter_input_array(INPUT_POST, FILTER_DEFAULT);
include_once('conexao.php');
// SELECIONA DADOS DO TABELA USUÁRIO DO BANCO DE DADOS.
  $sqlSelect = "SELECT  Matricula.id, Usuario.FK_Matricula, Usuario.Senha, Usuario.Usuario, Matricula.Tipo FROM Usuario INNER JOIN Matricula on Matricula.id = Usuario.FK_Matricula and Usuario.Usuario=:login and Usuario.Senha=:senha";    
    $returnSQL = $conn->prepare($sqlSelect);
    $returnSQL -> bindParam(':login',$PostInfo['login']);
    $returnSQL -> bindParam(':senha',$PostInfo['password']);
    $returnSQL -> execute();
    // VERIFICA SE A SELEÇÃOO FOI FEITA ADEQUADAMENTE E PASSA VARIAVEL DE VERIFICAÇÃO.
      if ($returnSQL -> execute()) {
        // SELECIONA CADA DADO SELECIONADO NO BANCO DE DADOS.
          $fetchUser = $returnSQL -> fetchAll();
        // Valida SELEÇÃO.
        if (!$fetchUser) {
          setcookie("emailInvalido", "EMAIL INCORRETO", time() + 3600, "/");
          setcookie("senhaInvalida", "SENHA INCORRETA", time() + 3600, "/");
          $_SESSION['msg'] = $_COOKIE["emailInvalido"] . " / ".  $_COOKIE["senhaInvalida"];
          header('Location: ../login.php');
        }else{ 
        if ($_SESSION['loginPermitido'] = true) {
          setcookie("emailValido", $_POST['login'], time() + 3600, "/");
          setcookie("senhaValida", $_POST['password'], time() + 3600, "/");
        }
        // Passa o ID de USUARAIO que Logou na tela  
        $idTableUsuario =$fetchUser[0]['id'];         
          // Verifica Tipo De Usuário.
<<<<<<< HEAD
          switch ($fetchall[0]['Tipo']) {
            case '1':
              $_SESSION['tipoUsuario'] = 1;
              header('Location: ../paginaPrincipal/admin.php');
              break;
            case '2':
              $_SESSION['tipoUsuario'] = 2;
              header('Location: ../paginaPrincipal/professor.php');
              break;
            case '3':
              $_SESSION['tipoUsuario'] = 3;
              header('Location: ../paginaPrincipal/aluno.php');
              break;
=======
            if ($PostInfo['TipoUsuario'] == 1){
              $SqlTipoUser = "SELECT Admin.FK_Usuario FROM Admin,Usuario WHERE Admin.FK_Usuario=$idTableUsuario";
              $returnTipo = $conn->prepare($SqlTipoUser);
                $returnTipo -> execute();
                $fetchTipo = $returnTipo->fetchAll();
                if ($fetchTipo) {
                $_SESSION['tipoUsuario'] = 1;
                header('Location: ../paginaPrincipal/Administrador/admin.php');
                }else{
                  echo "<h1 style='text-align:center;'>VOCÊ NÃO POSSUÍ ACESSO COMO ADIMINISTRADOR</h1>";
                  header('Location: ../login.php');
                }
>>>>>>> 0e6ffb5a1a620e1161bf1c5764af63ba0f482df6
            }
            if ($PostInfo['TipoUsuario'] == 2){
              $SqlTipoUser = "SELECT Professor.FK_Usuario FROM Professor,Usuario WHERE Professor.FK_Usuario=$idTableUsuario";
              $returnTipo = $conn->prepare($SqlTipoUser);
                $returnTipo -> execute();
                $fetchTipo = $returnTipo->fetchAll();
                if ($fetchTipo) {
                $_SESSION['tipoUsuario'] = 2;
                header('Location: ../paginaPrincipal/Professor/professor.php');
                }else {
                  echo "<h1 style='text-align:center;'>VOCÊ NÃO POSSUÍ ACESSO COMO PROFESSOR</h1>";
                  header('Location: ../login.php');
                }
            }
            if ($PostInfo['TipoUsuario'] == 3){
              $SqlTipoUser = "SELECT Aluno.FK_Usuario FROM Aluno,Usuario WHERE Aluno.FK_Usuario=$idTableUsuario";
              $returnTipo = $conn->prepare($SqlTipoUser);
                $returnTipo -> execute();
                $fetchTipo = $returnTipo->fetchAll();
                if ($fetchTipo) {
                $_SESSION['tipoUsuario'] = 3;
                header('Location: ../paginaPrincipal/Aluno/aluno.php');
                }else {
                  echo "<h1 style='text-align:center;'>VOCÊ NÃO POSSUÍ ACESSO COMO ALUNO</h1>";
                  header('Location: ../login.php');
                }
            }
          unset($_SESSION['loginPermitido']);
        }
      }else{
        header('Location: ../login.php');      
      }

  }
?>
