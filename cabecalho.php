<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Powerpuff Pets</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" href="images/logoGG.png">
</head>

<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Logo -->
      <div class="navbar-header">
        <a class="navbar-brand" href="powerfullpets.php"><img src="images/logo1-grande-Photoroom.png"></a>
      </div>
      <!-- Links de navegação -->
      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <?php if (isset($_SESSION['nivelUsuario'])) { ?>
            <?php if ($_SESSION['nivelUsuario'] == '') { ?>
              <li><a href="cadastroONG.php">Cadastre sua ONG</a></li>
              <li><a href="adocao.php">Quero adotar</a></li>
              <li><a href="Login.php"><button class="btn btn-default btn-enter custom-link">Login</button></a></li>
            <?php } else if ($_SESSION['nivelUsuario'] == 'COLAB') { ?>
              <li><a href="cadastroAnimais.php">Cadastre o Animal</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">Listar<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="listarAnimais.php">Listar Animais</a></li>
                  <li><a href="listarAdocao.php">Listar Adoção</a></li>
                  <li><a href="listaEspera.php">Lista de Espera</a></li>
                </ul>
              </li>
              <li><a href="adocao.php">Quero adotar</a></li>
              <div id="user-menu" class="user-menu profile-container">
                <img src="exibirImagem.php" id="profile-pic" class="profile-pic" onerror="this.onerror=null; this.src='images/fotoPerfil.jpg';">
                <div id="drop-menu" class="drop-menu">
                  <a href="fotoUsuario.php">Foto de perfil</a>
                  <?php
                  if (isset($_SESSION['idUsuarioLogado'])) {
                    $id_colaborador = $_SESSION['idUsuarioLogado'];
                    echo '<a href="editarColaborador.php?id_colaborador=' . $id_colaborador . '">Editar Perfil</a>';
                }
                  ?>
                  <a href="logout.php" id="logout-btn">Sair</a>
                </div>
              </div>
            <?php } else if ($_SESSION['nivelUsuario'] == 'USR') { ?>
              <li><a href="adocao.php">Quero adotar</a></li>
              <div id="user-menu" class="user-menu profile-container">
                <img src="exibirImagem.php" id="profile-pic" class="profile-pic" onerror="this.onerror=null; this.src='images/fotoPerfil.jpg';">
                <div id="drop-menu" class="drop-menu">
                  <a href="fotoUsuario.php">Foto de perfil</a>
                  <a href="editarUsuario.php?adotanteID=<?php echo $_SESSION['idUsuarioLogado']; ?>">Editar perfil</a>
                  <a href="logout.php" id="logout-btn">Sair</a>
                </div>
              </div>
            <?php } else if ($_SESSION['nivelUsuario'] == 'ADM') { ?>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">Cadastros<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="cadastroAnimais.php">Cadastro de Animal</a></li>
                  <li><a href="cadastroONG.php">Cadastro de ONG</a></li>
                  <li><a href="cadastroColaborador.php">Cadastro de Colaborador</a></li>
                  <li><a href="cadastroAdocao.php">Cadastro de Adoção</a></li>
                  <li><a href="cadastroUsuarios.php">Cadastro de Usuário</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">Listar<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="listarAnimais.php">Listar Animais</a></li>
                  <li><a href="listarONG.php">Listar ONG</a></li>
                  <li><a href="listarColaborador.php">Listar Colaborador</a></li>
                  <li><a href="listarAdocao.php">Listar Adoção</a></li>
                  <li><a href="listarUsuarios.php">Listar Usuarios</a></li>
                  <li><a href="listaEspera.php">Lista de Espera</a></li>
                </ul>
              </li>
              <li><a href="adocao.php">Quero adotar</a></li>
              <div id="user-menu" class="user-menu profile-container">
                <img src="exibirImagem.php" id="profile-pic" class="profile-pic" onerror="this.onerror=null; this.src='images/fotoPerfil.jpg';">
                <div id="drop-menu" class="drop-menu">
                  <a href="fotoUsuario.php">Foto de perfil</a>
                  <a href="logout.php" id="logout-btn">Sair</a>
                </div>
              </div>
            <?php } else if ($_SESSION['nivelUsuario'] == 'ONG') { ?>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">Colaboradores<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="listarColaborador.php">Listar Colaboradores</a></li>
                  <li><a href="cadastroColaborador.php">Cadastrar Colaborador</a></li>
                </ul>
              </li>
              <div id="user-menu" class="user-menu profile-container">
                <img src="exibirImagem.php" id="profile-pic" class="profile-pic" onerror="this.onerror=null; this.src='images/fotoPerfil.jpg';">
                <div id="drop-menu" class="drop-menu">
                  <a href="fotoUsuario.php">Foto de perfil</a>
                  <?php
                  if (isset($_SESSION['idUsuarioLogado'])) {
                    $id_ong = $_SESSION['idUsuarioLogado'];
                    echo '<a href="editarONG.php?id_ong=' . $id_ong . '">Editar Perfil</a>';
                }
                  ?>
                  <a href="logout.php" id="logout-btn">Sair</a>
                </div>
              </div>
            <?php }
          } else { ?>
            <li><a href="cadastroONG.php">Cadastre sua ONG</a></li>
            <li><a href="adocao.php">Quero adotar</a></li>
            <li><a href="Login.php"><button class="btn btn-default btn-enter custom-link">Login</button></a></li>
          <?php }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script>
    function toggleDropdownMenu() {
      const dropdownMenu = document.getElementById('drop-menu');
      dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }
    // Adicionando os eventos quando o DOM estiver carregado
    document.addEventListener('DOMContentLoaded', (event) => {
      const profilePic = document.getElementById('profile-pic');
      const dropdownMenu = document.getElementById('drop-menu');

      // Mostrar ou esconder o dropdown menu quando clicar na foto do perfil
      profilePic.addEventListener('click', function(event) {
        event.stopPropagation(); // Impede a propagação do evento para o window listener
        toggleDropdownMenu();
      });

      // Esconder o dropdown menu se clicar fora dele
      window.addEventListener('click', function(event) {
        if (!event.target.matches('.profile-pic')) {
          dropdownMenu.style.display = 'none';
        }
      });
    });
  </script>
</body>

</html>
