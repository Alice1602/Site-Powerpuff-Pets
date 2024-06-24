<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styleLogin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="images/logoGG.png">
</head>
<body>
    <p><b><a class="Home" href="powerfullpets.php" target="_blank">Início</a></b></p>

    <div class="wrapper fadeInDown">
        <div id="formContent">
          <!-- Tabs Titles -->
          <h2 class="active"> Login </h2>
          <h2 class="inactive underlineHover"><a href="cadastroUsuarios.php">Cadastro</a></h2>

          <!-- Login Form -->
          <!-- Login Form -->
        <form action="validarLogin.php" method="post">
            <input type="text" id="email" class="fadeIn second" name="email" placeholder="e-mail" required>
            <div id="passwordInput" class="fadeIn third"> <!-- Adicionei a classe aqui -->
                <input type="password" id="senha" name="senha" placeholder="senha" required>
                <i class="bi bi-eye-slash-fill" id="btn-senhaLogin" onclick="mostrarSenhaLogin()"></i>
            </div>
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>

      
          <!-- Remind Password -->
          <!-- <div id="formFooter">
            <a class="underlineHover" href="senha_nova.html">Esqueceu a senha?</a>
          </div> -->
      
        </div>
      </div>
      <script src="js/main.js"></script>
</body>
</html>
