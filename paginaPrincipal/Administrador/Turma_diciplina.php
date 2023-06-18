<?php
  include_once('../../validacao/conexao.php');
  $SqlDiciplina = "SELECT * FROM diciplina";
  $SelctDiciplina = $conn->prepare($SqlDiciplina);
  $SelctDiciplina -> execute();
  if (!$SelctDiciplina -> execute()) {

  }else{
    $Diciplina = $SelctDiciplina->fetchAll();
    var_dump($Diciplina[0]['Nome_Diciplina']);

    if (!isset($Diciplina)) {
    }else{
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/Style-Forms.css">
  <title>Cadastar Usuario</title>  
</head>
<body>
<?php include_once("cabecalho.php");?>
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
            <form action="../../validacao/validarcadastro.php" method="post">
              <div class="form-inputs">
                <div class="input-items">
                  <label for="UsuarioName">Nome da Diciplina</label>
                  <input type="text" id="Diciplina" class="txtDiciplina" placeholder="Diciplina" name="Diciplina">
                </div>
              </div>
              <div class="button">
                <input type="submit" class="btn btn-primary cadastrar" value="Cadastrar" name="Cadastrar">
                <input type="reset" class="btn btn-secondary desmarcar"  name="desmarcar">
              </div>
            </form>
          </div>
        </div>
        <div class="Main-Forms">
          <div class="Forms-Container">
            <form action="../../validacao/validarcadastro.php" method="post">
              <div class="form-inputs">
                <div class="input-items">
                  <label for="Turma">Nome da Turma</label>
                  <input type="text" id="Turma" class="txtTurma" placeholder="Turma" name="Turma">
                </div>

                <div class="input-items">
                    <label for="TurmaAno">Ano da turma</label>
                    <input type="text" id="TurmaAno" class="txtTurmaAno" value="<?php echo date("Y");?>" name="TurmaAno">
                </div>

                <div class="input-items">
                  <label for="DiciplinaName">Adicionar Diciplina</label>
                  <select name="DiciplinaName" id="DiciplinaName">
                  <?php 
                  if (empty($Diciplina)) {
                    echo "<option value=''></option>";
                  }else{
                    foreach ($Diciplina as $key => $value) {
                      echo"<option value='".$Diciplina[0]['Nome_Diciplina']."'>". $Diciplina[0]['Nome_Diciplina']."</option>";
                    }
                  } 
                  ?>
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