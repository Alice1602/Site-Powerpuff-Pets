<?php
require_once('cabecalho.php');
require_once('conexao.php');
date_default_timezone_set('America/Sao_Paulo');

$is_adotante = false;
$disable_button = true;

if (isset($_SESSION['idUsuarioLogado'])) {
    $adotanteID = $_SESSION['idUsuarioLogado'];

    // Check if the user is an adopter
    $sql = "SELECT * FROM adotante WHERE adotanteID = :adotanteID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':adotanteID', $adotanteID, PDO::PARAM_INT);
    $stmt->execute();
    $adotante = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($adotante) {
        $is_adotante = true;

        // Check adoption limit
        $sql = "SELECT COUNT(*) AS click_count 
                FROM lista_espera 
                WHERE adotanteID = :adotanteID 
                AND data >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':adotanteID', $adotanteID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $click_count = $result['click_count'];

        $disable_button = ($click_count >= 1);
    } else {
        $disable_button = true; // Not an adopter
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adoção de Animais</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" href="images/logoGG.png">
</head>

<body>
  <?php
  require_once("cabecalho.php");
  require_once("conexao.php");

  $tipo = $_POST['tipo'] ?? "";
  $sexo = $_POST['sexo'] ?? "";
  $idade = $_POST['idade'] ?? "";
  $porte = $_POST['porte'] ?? "";

  $sql = "SELECT * FROM Animal WHERE disponibilidade = 'Disponível'";

  if (!empty($tipo) && $tipo != "todos") {
    $sql .= " AND tipo_animal = '$tipo'";
  }

  if (!empty($sexo) && $sexo != "todos") {
    $sql .= " AND sexo = '$sexo'";
  }

  if (!empty($idade) && $idade != "todos") {
    $sql .= " AND idade = '$idade'";
  }

  if (!empty($porte) && $porte != "todos") {
    $sql .= " AND porte = '$porte'";
  }

  $sql .= " ORDER BY nome";

  $dados = $conn->query($sql);
  ?>
  <div class="form">
    <div class="filtro">
      <form id="filtroForm" action="adocao.php" method="post" righteous-regular>
        <br><label for="tipo">Espécie</label>
        <select id="tipo" name="tipo">
          <option value="" disabled selected hidden>Selecione</option>
          <option value="todos" <?php if (isset($tipo) && $tipo == "todos") echo "selected"; ?>>Todos</option>
          <option value="gato" <?php if (isset($tipo) && $tipo == "gato") echo "selected"; ?>>Gato</option>
          <option value="cachorro" <?php if (isset($tipo) && $tipo == "cachorro") echo "selected"; ?>>Cachorro</option>
        </select><br>

        <br><label for="sexo">Sexo</label>
        <select id="sexo" name="sexo">
          <option value="" disabled selected hidden>Selecione</option>
          <option value="todos" <?php if (isset($sexo) && $sexo == "todos") echo "selected"; ?>>Todos</option>
          <option value="Macho" <?php if (isset($sexo) && $sexo == "Macho") echo "selected"; ?>>Macho</option>
          <option value="Fêmea" <?php if (isset($sexo) && $sexo == "Fêmea") echo "selected"; ?>>Fêmea</option>
        </select><br>

        <br><label for="idade">Idade</label>
        <select id="idade" name="idade">
          <option value="" disabled selected hidden>Selecione</option>
          <option value="todos" <?php if (isset($idade) && $idade == "todos") echo "selected"; ?>>Todos</option>
          <option value="bebe" <?php if (isset($idade) && $idade == "bebe") echo "selected"; ?>>0 a 6 meses (filhotes)</option>
          <option value="jovem" <?php if (isset($idade) && $idade == "jovem") echo "selected"; ?>>7 meses a 5 anos (jovens)</option>
          <option value="adulto" <?php if (isset($idade) && $idade == "adulto") echo "selected"; ?>>6 a 10 anos (adultos)</option>
          <option value="idoso" <?php if (isset($idade) && $idade == "idoso") echo "selected"; ?>>11 anos ou mais (idosos)</option>
        </select><br>

        <br><label for="porte">Porte</label>
        <select id="porte" name="porte">
          <option value="" disabled selected hidden>Selecione</option>
          <option value="todos" <?php if (isset($porte) && $porte == "todos") echo "selected"; ?>>Todos</option>
          <option value="peq" <?php if (isset($porte) && $porte == "peq") echo "selected"; ?>>Porte pequeno</option>
          <option value="med" <?php if (isset($porte) && $porte == "med") echo "selected"; ?>>Porte médio</option>
          <option value="grande" <?php if (isset($porte) && $porte == "grande") echo "selected"; ?>>Porte grande</option>
        </select><br>

        <br><button type="submit" class="custom-button">Filtrar</button>
        <button type="button" onclick="limparCampos()" class="custom-button">Limpar</button>
      </form>
    </div>
  </div>

  <div class="adocao">
    <?php
    // Verifica se há animais para exibir
    if ($dados->rowCount() > 0) {
      // Variável para alternar entre as cores
      $cores = ['verde', 'rosa', 'azul'];
      $indice_cor = 0; // Índice para acessar a próxima cor na array

      // Itera sobre os registros de animais
      while ($registro = $dados->fetch(PDO::FETCH_ASSOC)) {
        // Determina a classe com base no índice da array de cores
        $classe = $cores[$indice_cor];

        // Incrementa o índice para acessar a próxima cor na próxima iteração
        $indice_cor = ($indice_cor + 1) % count($cores);

        // Codifica a imagem em base64
        $imagemBase64 = base64_encode($registro['foto']);
        $imagemSrc = 'data:image/jpeg;base64,' . $imagemBase64;

        // Determina o texto correspondente à idade
        $idade_texto = '';
        if ($registro['idade'] == 'bebe') {
          $idade_texto = "0 a 6 meses.";
        } elseif ($registro['idade'] == 'jovem') {
          $idade_texto = "7 meses a 5 anos.";
        } elseif ($registro['idade'] == 'adulto') {
          $idade_texto = "6 a 10 anos.";
        } elseif ($registro['idade'] == 'idoso') {
          $idade_texto = "11 anos ou mais.";
        }

        // Determina o texto correspondente ao porte
        $porte_texto = '';
        if ($registro['porte'] == 'peq') {
          $porte_texto = "Pequeno";
        } elseif ($registro['porte'] == 'med') {
          $porte_texto = "Médio";
        } elseif ($registro['porte'] == 'grande') {
          $porte_texto = "Grande";
        }

        // Determina o texto correspondente ao sexo
        $sexo_texto = $registro['sexo']; // Não há necessidade de alteração, pois já está sendo exibido corretamente no código original

        $saude_texto = $registro['saude'];

        $descricao_texto = $registro['historico'];

        // Exibe o registro apenas se a variável $idade_texto estiver definida
        if (!empty($idade_texto)) {

    ?>
          <div class="<?php echo $classe; ?>">
            <div class="animais">
              <div class="fakeimg">
                <img src="<?php echo $imagemSrc; ?>" alt="Imagem do animal">
              </div>
              <h3><?php echo $registro['nome']; ?></h3>
              <p>Idade: <?php echo $idade_texto; ?></p>
              <p>Porte: <?php echo $porte_texto; ?></p>
              <p>Sexo: <?php echo $sexo_texto; ?></p>
              <div class="adotar">
                <button class="adopt-btn" data-id="<?php echo $registro['animalID']; ?>" data-nome="<?php echo $registro['nome']; ?>" data-imagem="<?php echo $imagemSrc; ?>" data-idade="<?php echo $idade_texto; ?>" data-porte="<?php echo $porte_texto; ?>" data-sexo="<?php echo $sexo_texto; ?>" data-saude="<?php echo $saude_texto; ?>" data-descricao="<?php echo $descricao_texto; ?>" data-animalid="<?php echo $registro['animalID']; ?>">
                  <i class="bi bi-heart"></i>
                  <i class="bi bi-heart-fill"></i>
                </button>
              </div>
            </div>
          </div>
    <?php
        }
      }
    } else {
      // Caso não haja registros
      echo "<p>Nenhum animal encontrado.</p>";
    }

    // Fechar conexão
    $conn = null;

    ?>
  </div>

  <div id="lightbox" class="lightbox">
    <div class="lightbox-content">
      <span id="close-lightbox" class="close">&times;</span>
      <div class="lightbox-img-container">
        <img id="lightbox-img" src="" alt="Imagem do animal">
      </div>
      <div class="lightbox-info">
        <h3 id="lightbox-nome"></h3>
        <p id="lightbox-idade"></p>
        <p id="lightbox-porte"></p>
        <p id="lightbox-sexo"></p>
        <p id="lightbox-saude"></p>
        <p id="lightbox-descricao"></p>
        <br>
        <br>
        <form id="adocaoForm" action="cadPedido.php" method="post">
          <input type="hidden" name="data" value="<?php echo date('Y-m-d H:i:s'); ?>">
          <input type="hidden" name="status" value="Pendente">
          <input type="hidden" name="adotanteID" value="<?php echo htmlspecialchars($adotante['adotanteID']); ?>">
          <input type="hidden" name="animalID" value="">
          <button type="submit" class="adotar-button" <?php if ($disable_button) echo 'disabled'; ?>>Adotar</button>
          <?php if ($disable_button) : ?>
              <br>
              <p><br>
                  * Você atingiu o limite de 1 adoções neste mês. <br>Por favor, tente novamente no próximo mês.
              </p>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
    // Função para abrir o Lightbox
    function openLightbox(event) {
        <?php if ($is_adotante) { ?>
            const button = event.currentTarget;
            const animalID = button.getAttribute("data-id");
            const nome = button.getAttribute("data-nome");
            const imagem = button.getAttribute("data-imagem");
            const idade = button.getAttribute("data-idade");
            const porte = button.getAttribute("data-porte");
            const sexo = button.getAttribute("data-sexo");
            const saude = button.getAttribute("data-saude");
            const descricao = button.getAttribute("data-descricao");

            document.getElementById("lightbox-img").src = imagem;
            document.getElementById("lightbox-nome").textContent = nome;
            document.getElementById("lightbox-idade").innerHTML = "Idade: " + idade.replace(/\n/g, '<br>');
            document.getElementById("lightbox-porte").innerHTML = "Porte: " + porte.replace(/\n/g, '<br>');
            document.getElementById("lightbox-sexo").innerHTML = "Sexo: " + sexo.replace(/\n/g, '<br>');
            document.getElementById("lightbox-saude").innerHTML = "Saúde: " + saude.replace(/\n/g, '<br>');
            document.getElementById("lightbox-descricao").innerHTML = "Descrição: " + descricao.replace(/\n/g, '<br>');

            const form = document.getElementById("adocaoForm");
            form.querySelector("input[name='animalID']").value = animalID;

            document.getElementById("lightbox").style.display = "block";
        <?php } else { ?>
            alert('Faça seu Login para poder adotar');
        <?php } ?>
    }

    // Função para fechar o Lightbox
    function closeLightbox() {
        document.getElementById("lightbox").style.display = "none";
    }

    // Adiciona o evento de clique aos botões de adoção
    const buttons = document.querySelectorAll(".adopt-btn");
    buttons.forEach(button => {
        button.addEventListener("click", openLightbox);
    });

    // Adiciona o evento de clique ao botão de fechar do Lightbox
    document.getElementById("close-lightbox").addEventListener("click", closeLightbox);

    // Fecha o Lightbox ao clicar fora do conteúdo
    document.getElementById("lightbox").addEventListener("click", function(event) {
        if (event.target === this) {
            closeLightbox();
        }
    });
});


    // Função para limpar os campos do formulário
    function limparCampos() {
      document.getElementById("filtroForm").reset();
      window.location.href = "adocao.php"; // Redireciona para a página inicial
    }
  </script>

  <style>
    .adopt-btn {
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      position: relative;
      margin-left: 235px;
      top: -55px;
      background-color: transparent;
      /* Remover fundo adicional */
      border: none;
      /* Remover bordas adicionais */
    }

    .adopt-btn i.bi-heart,
    .adopt-btn i.bi-heart-fill {
      font-size: 2.4em;
      position: absolute;
      transition: color 0.3s ease, opacity 0.3s ease;
    }

    .adopt-btn i.bi-heart {
      color: black;
      opacity: 1;
      /* Garantir que o ícone de coração vazio seja visível */
    }

    .adopt-btn i.bi-heart-fill {
      color: red;
      opacity: 0;
      /* Garantir que o ícone de coração cheio não seja visível inicialmente */
    }

    .adopt-btn:hover i.bi-heart {
      opacity: 0;
      /* Tornar o ícone de coração vazio invisível ao passar o mouse */
    }

    .adopt-btn:hover i.bi-heart-fill {
      opacity: 1;
      /* Tornar o ícone de coração cheio visível ao passar o mouse */
    }

    /* Estilo para o Lightbox */
    .lightbox {
      display: none;
      /* Inicialmente oculto */
      position: fixed;
      /* Para manter o Lightbox no lugar enquanto a página é rolada */
      top: 0;
      left: 0;
      width: 100%;
      /* Cobrir toda a largura */
      height: 100%;
      /* Cobrir toda a altura */
      background-color: rgba(0, 0, 0, 0.7);
      /* Fundo semi-transparente */
      z-index: 9999;
      /* Para garantir que o Lightbox esteja na parte superior */
    }

    .lightbox-content {
      margin: 15% auto;
      padding: 20px;
      /* Reduzir o espaçamento interno aqui */
      width: 80%;
      max-width: 700px;
      background-color: #fff;
      border-radius: 8px;
      position: relative;
      display: flex;
      border: 5px solid #bee9a8e8;
      border-radius: 10px;
    }

    #lightbox-img {
      width: 55%;
      /* Ajuste conforme necessário */
      /* max-height: auto; */
      /* object-fit: cover; */
      border: 3px solid #a4d7d8;
      border-radius: 10px;
    }

    .lightbox-info {
      flex-direction: column;
      /* Coloca as informações do animal uma em baixo da outra */
    }

    .lightbox-info p,
    .lightbox-info h3 {
      word-wrap: break-word;
      margin-left: -220px;
    }

    .close {
      color: #8d8d8d;
      font-size: 30px;
      font-weight: bold;
      padding: 10px;
      right: 10px;
      position: absolute;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .fakeimg {
      position: relative;
      height: 250px;
      overflow: hidden;
      border: 1px solid #000000;
      border-radius: 5px;
    }

    .fakeimg img {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .custom-button {
      background-color: #c08cd4;
      color: white;
      border: none;
      margin-top: 0px;
      border-radius: 20px;
      height: 30px;
      width: 80px;
      cursor: pointer;
      margin-left: 10px;
    }

    .adotar-button {
      background-color: #dfa7bf;
      color: white;
      border: none;
      margin-top: 0px;
      border-radius: 20px;
      height: 30px;
      width: 80px;
      cursor: pointer;
      margin-left: 10px;
    }
  </style>

<?php
  require_once("footer.php");
  ?>
</body>

</html>