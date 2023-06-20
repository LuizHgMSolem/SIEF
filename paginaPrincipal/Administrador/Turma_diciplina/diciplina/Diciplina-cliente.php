<?php
session_start();
// BD
include_once('../../../../validacao/conexao.php');
// VALIDAR REGISTRO
function ValidarRegistro(){
  // FAZ LOGOUT 
  if (isset($_POST["Logout"]) && !empty($_POST["Logout"])) {
    if ($_POST["Logout"]) {
      $_SESSION['tipoUsuario'] = 0;
    }
  }

  // Validação do Registro.
  if (!$_SESSION['tipoUsuario'] == 1){
    header('Location: ../../../login.php');        
  }
}
ValidarRegistro();
// SELECIONAR DO BANCO A TABELA DICIPLINA
$SqlDiciplina = "SELECT * FROM diciplina";
$SelctDiciplina = $conn->prepare($SqlDiciplina);
$SelctDiciplina -> execute();
// VERIFICARA SE SELELÇAO FOI CONCLUIDA COM SUCESSO
if (!$SelctDiciplina -> execute() ) {
}else{
  $Diciplina = $SelctDiciplina->fetchAll();
  if (!isset($Diciplina)) {
  }else{
?>
<!-- ******* 
HTML START
******** -->
<!DOCTYPE html>
<html lang="pt-br">
<head> 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../../css/Style-Forms.css">
  <title>Cadastar Usuario</title>  
</head>
<body>
<?php include_once("../cabecalho.php");?>
  <main>
    <section class="Main-Section">
      <div class="main-container">
        <div class="Main-Title">
          <div class="Title-Container">
            <h1 title="Matricula" >Cadastro de Diciplina</h1>
          </div>
        </div>
        <div class="Main-Forms">
          <div class="Forms-Container">
            <form action="../../validacao/cadastroTurma.php" method="post">
              <div class="form-inputs">
                <div class="input-items">
                  <label for="UsuarioName">Nome da Diciplina</label>
                  <input type="text" id="Diciplina" class="txtDiciplina" placeholder="Diciplina" name="Diciplina">
                </div>
              </div>
              <div class="button">
                <input type="submit" class="btn btn-primary cadastrar" value="CADASTRARA DICIPLINA" name="CadDiciplina">
              </div>
            </form>
      </div>
    </section>
  </main>
</body>
</html>
<?php  
 
    }
}
?>