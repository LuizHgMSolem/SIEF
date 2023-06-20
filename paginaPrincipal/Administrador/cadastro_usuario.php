<?php
session_start();
function ValidarRegistro(){
  // FAZ LOGOUT 
  if (isset($_POST["Logout"]) && !empty($_POST["Logout"])) {
    if ($_POST["Logout"]) {
      $_SESSION['tipoUsuario'] = 0;
    }
  }

  // Validação do Registro.
  if (!$_SESSION['tipoUsuario'] == 1){
    header('Location: ../../login.php');        
  }
}
ValidarRegistro();

  include_once('../../validacao/conexao.php');
  $userMTR = "SELECT Matricula.id, Matricula.Nome, Matricula.CPF, Matricula.Tipo  FROM Matricula WHERE Matricula.Tipo = :Tipo";
  $sqlUserMTR = $conn->prepare($userMTR);
  $sqlUserMTR -> bindParam(":Tipo", $_POST["Tipo"]);
  $sqlUserMTR -> execute();


  if (!$sqlUserMTR -> execute()) {
  }else{
    $userList = $sqlUserMTR->fetchAll();
    if (!isset($userList)) {
    }else{
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/Style-Forms.css">
  <title>Cadastar Usuario</title>  
</head>
<body>
<?php include_once("cabecalho.php");?>
  <main>
    <section class="Main-Section">
      <div class="main-container">
        <div class="Main-Title">
          <div class="Title-Container">
            <h1 title="Matricula" >Cadastro Usuario</h1>
          </div>
        </div>
        <div class="Main-Forms">
          <div class="Forms-Container">
          <form action="cadastro_usuario.php" method="post">
              <div class="form-inputs">
                <div class="input-items">
                  <label for="Usuario">Selecionar Tipo</label>
                  <select name="Tipo" class="UsuarioTipo" id="Usuario">
                    <option value="#"></option>
                    <option value="1">Administrador</option>
                    <option value="2">Professor</option>
                    <option value="3">Aluno</option>
                  </select>
                </div>
                <div class="input-items">         
                      <label for="MatriculaId">Número da Matricula</label>
                      <input type="text" name="Matricula" id="MatriculaId" class="txtMatriculaId" value='<?php echo !empty($_POST['Matricula']) ? $_POST['Matricula'] : "";?>' name="MatriculaId">
                      <!-- ********************
                          BOTÂO TIPO
                      ******************* -->
                      <input type="submit" class="btn btn-secondary SendTipo" value="Pesquisar Usuário">
                  </div>
            </form>
            <form action="../../validacao/validarcadastro.php" method="post">
              <div class="form-inputs">
                <div class="input-items">
                  <label for="UsuarioName">Selecionar Usuario</label>
                  <select name="UsuarioName" id="UsuarioName">
                  <?php 
                  if (empty($userList)) {
                    echo "<option value=''></option>";
                  }else{
                    foreach ($userList as $key => $value) {
                      if ($_POST['Matricula'] == $userList[$key]['id']) {
                      echo"<option value='".$userList[$key]["Nome"]."'>". $userList[$key]["Nome"]."</option>";
                      }
                    }
                  } 
                  ?>
                  </select>
                </div>

                <div class="input-items">         
                  <?php
                    if(!empty($userList)){
                  ?>
                      <label for="MatriculaId">Número da Matricula</label>
                      <input type="text" name="Matricula" id="MatriculaId" class="txtMatriculaId" value='<?php echo !empty($_POST['Matricula']) ? $_POST['Matricula'] : "";?>' name="MatriculaId">

                  <?php
                    }
                  ?>
                  </div>

                <div class="input-items">
                  <?php
                    if (empty($userList)){
                  ?>
                    <label for="userLogin">Login de Usuário</label>
                    <input type="text" id="userLogin" class="txtuserLogin" value="" name="userLogin">

                  <?php
                    }
                  ?>
                  <?php

                      foreach ($userList as $key => $value) {
                      if ($_POST['Matricula'] == $userList[$key]['id']) {
                      
                  ?>
                    <label for="userLogin">Login de Usuário</label>
                    <input type="text" id="userLogin" class="txtuserLogin" value="<?= $userList[$key]["CPF"]?>" name="userLogin">
                 <?php
                      }
                    } 
                 ?>
                </div>
                <div class="input-items">
                  <label for="Senha">Senha</label>
                  <input type="text" id="Senha" class="txtSenha " name="Senha">
                </div>

                <div class="input-items">
                  <label for="Usuario">Cadastrar Usuario Como:</label>
                  <select name="InsertTipoUser" class="UsuarioTipo" id="Usuario">
                  <option value="1">Administrador</option>
                  <option value="2">Professor</option>
                  <option value="3">Aluno</option>
                  </select>
                </div>
              </div>
              <div class="button">
                <input type="submit" class="btn btn-primary cadastrar" value="Cadastrar" name="Cadastrar">
                <input type="reset" class="btn btn-secondary desmarcar"  name="desmarcar">
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>
</html>

<?php  
    }
}
?>