<?php
session_start();

if ($_SERVER['REQUEST_METHOD']=='GET') {
  header("Location: ../login.php");
  exit();
}

include_once('conexao.php');

$CheckMatricula = "SELECT Matricula.id FROM Matricula ORDER BY Matricula.id";
$SQLMatricula = $conn -> prepare($CheckMatricula);
$SQLMatricula -> execute();
if ($SQLMatricula -> execute()) {
  $AllMatricula = $SQLMatricula->fetchAll();
    if ($AllMatricula) {
      $cadastro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
      var_dump($cadastro);
      // Valida cadastro
      if (isset($cadastro) && !empty($cadastro)) {
        // Verifica se possui informações vazias;
        foreach ($cadastro as $key => $value) {
          $emptyInfoCadastro = $cadastro[$key];
          if (empty($emptyInfoCadastro)) {
              $_SESSION['CadastroInvalido'] = true;
          }else {
            $_SESSION['CadastroInvalido'] = false;
          }
        }
        // Se possuir informações vazias retornar para cadastro;
        if ($_SESSION['CadastroInvalido']) {
          $_SESSION["Administrador"] = true;
          header("Location: ../paginaPrincipal/Administrador/cadastro_usuario.php");
        }else {
          foreach ($AllMatricula as $key => $value) {
            $idmatricula = $value[0][0];
            if ($idmatricula == $cadastro["Matricula"]){
            $_SESSION["MatriculaValida"] = true;
          }
        }
                
        if ($_SESSION["MatriculaValida"]) {
          // Primeiro Insere Usuario no Banco
          $InsertUsuario = "INSERT INTO Usuario VALUES (0, :Nome, :Usuario, :Senha, :Matricula)";
          $SqlUsuario = $conn->prepare($InsertUsuario);
          $SqlUsuario -> bindParam(":Nome", $cadastro["UsuarioName"]);
          $SqlUsuario -> bindParam(":Usuario", $cadastro["userLogin"]);
          $SqlUsuario -> bindParam(":Senha", $cadastro["Senha"]);
          $SqlUsuario -> bindParam(":Matricula", $cadastro["Matricula"]);
          $SqlUsuario->execute();

          // SELECIONA ULTIMO ID DA TABLEA USUARIO 
          $CheckUsuario = "SELECT MAX(Usuario.id)  FROM Usuario";
          $SqlIDUsuario = $conn -> prepare($CheckUsuario);
          $SqlIDUsuario -> execute();
          $fetchUsuario = $SqlIDUsuario -> fetchAll();
          var_dump($fetchUsuario);

            switch ($cadastro["InsertTipoUser"]) {
              case '1':
                $InsertAdmin = "INSERT INTO admin VALUES (0, :FK_Usuario)";
                $SqlUserAdmin = $conn->prepare($InsertAdmin);
                $SqlUserAdmin -> bindParam(":FK_Usuario", $fetchUsuario[0]['MAX(Usuario.id)']);
                $SqlUserAdmin->execute();
              break;
              case '2':
                $InsertProf = "INSERT INTO professor VALUES (0, :FK_Usuario)";
                $SqlUserProf = $conn->prepare($InsertProf);
                $SqlUserProf -> bindParam(":FK_Usuario", $fetchUsuario[0]['MAX(Usuario.id)']);
                $SqlUserProf->execute();
                break;
              case '3':
                $InsertAluno = "INSERT INTO aluno(id,FK_Usuario) VALUES (0, :FK_Usuario)";
                $SqlUserAluno = $conn->prepare($InsertAluno);
                $SqlUserAluno -> bindParam(":FK_Usuario", $fetchUsuario[0]['MAX(Usuario.id)']);
                $SqlUserAluno->execute();
              break;
            }
          if ($SqlUsuario->execute()) { 
          
            echo "<h1>Cadastro concluido</h1>";
          }else{
            header("Location: ../paginaPrincipal/Administrador/cadastro_usuario.php");
          }
        }
      }
    }
  }
}
?>