<?php
// BD
include_once('conexao.php');
// VALIDAR REGISTRO

// SELECIONAR DO BANCO A TABELA CALENDARIO DE AULA
$SqlCalendario = "SELECT turma_diciplina.id FROM turma_diciplina WHERE turma_diciplina.FK_turma = :turma AND turma_diciplina.FK_diciplina = :diciplina";
$SelctCalendario = $conn->prepare($SqlCalendario);
$SelctCalendario->bindParam(":turma",$Vinculo["TurmaName"] );
$SelctCalendario->bindParam(":diciplina",$Vinculo["DiciplinaName"] );
$SelctCalendario -> execute();
$fetchCalendario = $SelctCalendario->fetchAll();

  // SELECIONAR DO BANCO A TABELA ALUNO
  $SqlAluno = "SELECT * FROM aluno WHERE aluno.FK_turma_diciplina = :turma_diciplina";
  $SelctAluno = $conn->prepare($SqlAluno);
  $SelctAluno->bindParam(":turma_diciplina", $fetchCalendario[0]["id"]); 
  $SelctAluno -> execute();
  $Aluno = $SelctAluno->fetchAll();

  foreach ($Aluno as $key => $value) {
   // SELECIONAR DO BANCO A TABELA USUARIO
   $SqlUsuario = "SELECT id, nome FROM usuario WHERE usuario.id = :idUsuario";
   $SelctUsuario = $conn->prepare($SqlUsuario);
   $SelctUsuario->bindParam(":idUsuario", $value["FK_Usuario"]); 
   $SelctUsuario -> execute();
   $Usuario[] = $SelctUsuario->fetchAll(); 
  }

if (!empty($Usuario)) {
  foreach ($Usuario as $key => $value) {
    $key++;
    ?>
<div class="input-items">
    <!-- IDENTIFICADORES -->
    <div class="display-id">
      <ul class="campo-edicoes">
        <li><?=$value[0]["id"]?></li>
      </ul>
    </div>
    <!-- Usuario -->
    <div class='diplay-info'>
      <div>
      <?=$value[0]['nome']?>
      </div>
    </div>
    <!-- CAMPOS DE EDIÇÃO -->
    <div class="display-Interacao">
        <ul class="campo-edicoes">
          <li class="btn-edicoes"><a href="Usuario-alterar">Alt</a></li>
          <li class="btn-edicoes"><a href="Usuario-Deletar">Del</a></li>
        </ul>
    </div>
</div> 
<?php 
  }
}
?>