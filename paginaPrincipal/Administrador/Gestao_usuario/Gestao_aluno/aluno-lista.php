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
    header('Location: /sief/login.php');             
  }
}
ValidarRegistro();

$Vinculo = filter_input_array(INPUT_POST, FILTER_DEFAULT);
// SELECIONAR DO BANCO A TABELA Aluno
$SqlAluno = "SELECT Usuario.*, aluno.* FROM Usuario, aluno WHERE aluno.FK_Usuario = Usuario.id ";
$SelctAluno = $conn->prepare($SqlAluno);// VERIFICARA SE SELELÇAO FOI CONCLUIDA COM SUCESSO
if (!$SelctAluno -> execute() ) {
}else{
  $Aluno = $SelctAluno->fetchAll();
  if (!isset($Aluno)) {
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
  <link rel="stylesheet" href="../../css-Admin/Style-Display.css">
  <title>Listagem Usuario</title>  
</head>
<body>
<?php include_once("../../cabecalho/cabecalho-main.php");?>

  <main>
    <section class="Main-Section">
      <div class="main-container">
        <div class="Main-Title">
          <div class="Title-Container">
            <h1 title="Matricula" >Listagem de Aluno</h1>
          </div>
        </div>        
        <div class="Forms-Container">
        <li><a href="aluno-consulta">⮪ Consultar Grupos</a></li>
          <div class="form-inputs">
            <?php 
              include_once("../../../../validacao/ConsultarAluno.php");
            ?>
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