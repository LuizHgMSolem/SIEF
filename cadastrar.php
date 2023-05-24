<?php 
session_start();

error_reporting(0);

if ($_SESSION["registroExiste"]) {
  $msgErro = "CADASTRO JÁ EXISTE";
}
          
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

<style>
 
</style>

<body>
    <main>
      <!-- SESSÃO PARA DISPLAY -->
      <section class="displayLogin">
        <div class="loginContainer">
          <h1 style="text-align:center; margin-bottom:2rem;">Faça Seu Cadastro Aqui</h1>
          <!-- FORMULARIO -->
          <form action="validacao/validarcadastro.php" method="post">
            <div class="login breakline">
              <label for="email">E-mail</label>
              <input type="email" name="email" class="bardisplay" id="email" placeholder="Email" value=" " required>
            </div>
            <div class="senha breakline">
              <label for="password">Senha</label>
              <input type="password" name="password" class="bardisplay" id="password" placeholder="Senha" value="" required>
            </div>
            <div class="breakline center">
              <div>
                <input type="submit" class="enviar" value="CADASTRAR">
                <div>
                <a class="topSapce center" href="login.php">Login</a>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div>
          <span class='errocadastro'><?=$msgErro?></span>
        </div>
      </section>
    </main>
</body>
</html>
