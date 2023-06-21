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
// SELECIONAR DO BANCO A TABELA Turma
$SqlTurma = "SELECT * FROM turma";
$SelctTurma = $conn->prepare($SqlTurma);
$SelctTurma -> execute();
// VERIFICARA SE SELELÇAO FOI CONCLUIDA COM SUCESSO
if (!$SelctTurma -> execute()) {
}else{
  $Turma = $SelctTurma->fetchAll();
  if (!isset($Turma)) {
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
  <link rel="stylesheet" href="../../css-Admin/Style-Forms.css">
  <title>Cadastar Usuario</title>  
</head>
<body>
<?php include_once("../../cabecalho/cabecalho-Turma.php");?>
  <main>
    <section class="Main-Section">
      <div class="main-container">
        <div class="Main-Title">
          <div class="Title-Container">
            <h1 title="Matricula" >Cadastro de Turmas</h1>
          </div>
        </div>
        <div class="Main-Forms">
          <div class="Forms-Container">
            <form action="/sief/validacao/cadastroDiciplina.php" method="post">
              <div class="form-inputs">
                <div class="input-items">
                  <label for="Turma">Nome da Turma</label>
                  <input type="text" id="Turma" class="txtTurma" placeholder="Turma" name="Turma">
                </div>

                <div class="input-items">
                    <label for="TurmaAno">Ano da turma</label>
                    <input type="text" id="TurmaAno" class="txtTurmaAno" value="<?php echo date("Y");?>" name="TurmaAno">
                </div>
              </div>
              <div class="button">
                <input type="submit" class="btn btn-primary cadastrar" value="CADASTRARA TURMA" name="Cadastrar">
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