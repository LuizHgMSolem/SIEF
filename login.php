<?php 
session_start();

error_reporting(0)
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>loginValid</title>
</head>
<body>
    <main>
      <!-- SESSÃO PARA DISPLAY -->
      <section class="displayLogin">
        <div class="loginContainer">
          <h1 style="text-align:center; margin-bottom:2rem;">ADMINISTRATIVO</h1>
          <!-- FORMULARIO -->
          <form action="validacao/validacao_login.php" method="post">
            <div class="login breakline">
              <input type="text" name="login" class="bardisplay" id="email" placeholder="Insira o Login" value="<?php echo $_COOKIE["emailValido"]?>" required>
            </div>
            <div class="senha breakline">
              <input type="password" name="password" class="bardisplay" id="password" placeholder="Insira a Senha" value="<?php echo $_COOKIE["senhaValida"]?>" required>
            </div>
            <div class="breakline center">
              <div>
                <input type="submit" class="enviar" value="LOGIN">
                <a href="cadastrar.php" class="registrar">REGISTRAR USUARIO</a>
              </div>
            </div>
          </form>
        </div>
      </section>
    </main>

    <?php
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);

    ?>
</body>
</html>