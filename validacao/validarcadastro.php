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
            var_dump($value);
          if ($value['id'] == $cadastro["MatriculaId"]){
            $_SESSION["MatriculaValida"] = true;
          }
        }
        
        if ($_SESSION["MatriculaValida"]) {
          $InsertUsuario = "INSERT INTO Usuario VALUES (0, :Nome, :Usuario, :Senha, :Matricula)";
          $SqlUsuario = $conn->prepare($InsertUsuario);
          $SqlUsuario -> bindParam(":Nome", $cadastro["UsuarioName"]);
          $SqlUsuario -> bindParam(":Usuario", $cadastro["userLogin"]);
          $SqlUsuario -> bindParam(":Senha", $cadastro["Senha"]);
          $SqlUsuario -> bindParam(":Matricula", $cadastro["MatriculaId"]);
          $SqlUsuario->execute();
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