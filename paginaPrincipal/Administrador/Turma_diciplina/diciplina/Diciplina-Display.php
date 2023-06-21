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
  <link rel="stylesheet" href="../../css-Admin/Style-Display.css">
  <title>Listagem Usuario</title>  
</head>
<body>
<?php include_once("../../cabecalho/cabecalho-Turma.php");?>

  <main>
    <section class="Main-Section">
      <div class="main-container">
        <div class="Main-Title">
          <div class="Title-Container">
            <h1 title="Matricula" >Listagem de Diciplina</h1>
          </div>
        </div>
        <div class="Main-Forms">
          <div class="Forms-Container">
            <div class="form-inputs">
                      <?php 
                      if (!empty($Diciplina)) {
                        foreach ($Diciplina as $key => $value) {
                          $key++;
                          ?>
              <div class="input-items">
                          <!-- IDENTIFICADORES -->
                          <div class="display-id">
                            <ul class="campo-edicoes">
                              <li><?=$key?></li>
                            </ul>
                          </div>
                          <!-- DICIPLINAS -->
                          <div class='diplay-Diciplina'>
                            <div>
                            <?=$value[1]?>
                            </div>
                          </div>
                          <!-- CAMPOS DE EDIÇÃO -->
                          <div class="display-Interacao">
                              <ul class="campo-edicoes">
                                <li class="btn-edicoes"><a href="Diciplina-alterar">Alt</a></li>
                                <li class="btn-edicoes"><a href="Diciplina-Deletar">Del</a></li>
                              </ul>
                          </div>
              </div> 
                      <?php 
                        }
                      }
                      ?>
            </div>
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