<?php

if (!$_COOKIE["emailValido"] && !$_COOKIE["senhaValida"]){
  header("Location: index.php");
  unset($_SESSION['loginValido']);
  exit();
  
}else{
  echo "PARABÉNS O LOGIN FOI EFETUADO COM SUCESSO";
  $inputInfo = filter_input_array(INPUT_POST, FILTER_DEFAULT);
  if (!empty($inputInfo['Logout'])) {
    setcookie("emailValido", "Encerrado", time() - 60);
    setcookie("senhaValida", "Encerrado", time() - 60);
    header("Location: logado.php");
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
  <main>
    <section>
      <form action="logado.php" method="post">
        <input type="submit" name="Logout" value="Logout">
      </form>
    </section>
  </main>

</body>
</html>


<?php
}
?>