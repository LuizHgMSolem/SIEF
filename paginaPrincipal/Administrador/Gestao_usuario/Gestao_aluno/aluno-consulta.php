<?php
// BD
include_once('../../../../validacao/conexao.php');


// SELECIONAR DO BANCO A TABELA DICIPLINA
$SqlDiciplina = "SELECT * FROM diciplina";
$SelctDiciplina = $conn->prepare($SqlDiciplina);
$SelctDiciplina -> execute();


// SELECIONAR DO BANCO A TABELA Turma
$SqlTurma = "SELECT * FROM Turma";
$SelctTurma = $conn->prepare($SqlTurma);
$SelctTurma -> execute();
// VERIFICARA SE SELELÇAO FOI CONCLUIDA COM SUCESSO
if (!$SelctDiciplina -> execute() && $SelctTurma -> execute()) {
}else{
  $Diciplina = $SelctDiciplina->fetchAll();
  $Turma = $SelctTurma->fetchAll();
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
            <h1 title="Matricula" >Consultar Grupo de Alunos</h1>
          </div>
        </div>
        <div class="Main-Forms">
          <div class="Forms-Container">
            <form action="aluno-lista.php" method="post">
                <div class="input-items">
                  <label for="TurmaName">Adicionar Turma</label>
                  <select name="TurmaName" id="TurmaName">
                    <?php 
                      if (empty($Turma)) {
                        echo "<option value=''></option>";
                      }else{
                        foreach ($Turma as $key => $value) {
                          echo"<option value='".$value[0]."'>". $value[1]."</option>";

                        }
                      } 
                    ?>
                  </select>
                </div>
                <div class="input-items">
                  <label for="DiciplinaName">Adicionar Diciplina</label>
                  <select name="DiciplinaName" id="DiciplinaName">
                    <?php 
                    if (empty($Diciplina)) {
                      echo "<option value=''></option>";
                    }else{
                      foreach ($Diciplina as $key => $value) {
                        echo"<option value='".$value[0]."'>". $value[1]."</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="button">
                  <input type="submit" class="btn btn-primary cadastrar" value="Pesquisar" name="Cadastrar">
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