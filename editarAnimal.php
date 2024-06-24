<?php
if (isset($_GET['animalID'])) {
    try {
        $animalID = $_GET['animalID'];
        require_once("conexao.php");
        $sql = "SELECT * FROM animal WHERE animalID=" . $animalID;
        $dados = $conn->query($sql);
        while ($registros = $dados->fetch(PDO::FETCH_ASSOC)) {
?>

            <link rel="stylesheet" href="css/cadUsuario.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <link rel="icon" href="images/logoGG.png">
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                const inputFile = document.querySelector("#foto");
                const pictureImage = document.querySelector(".picture__image");

                inputFile.addEventListener("change", function(e) {
                    const file = e.target.files[0];
                    const pictureImageTxt = "Escolha a imagem";

                    if (file) {
                        const reader = new FileReader();

                        reader.addEventListener("load", function() {
                            pictureImage.src = reader.result;
                            pictureImage.style.display = 'block';
                            pictureImage.nextElementSibling.style.display = 'none'; // Esconder o texto de "Escolha a imagem"
                        });

                        reader.readAsDataURL(file);
                    } else {
                        pictureImage.src = ""; // Limpar a imagem se nenhum arquivo for selecionado
                        pictureImage.style.display = 'none';
                        pictureImage.nextElementSibling.style.display = 'block'; // Mostrar o texto de "Escolha a imagem"
                    }
                });
            });
            </script>

            </head>

            <body>
                <p><b><a class="Home" href="powerfullpets.php" target="_blank">Início</a></b></p>
                <br>
                <div id="main-container">
                    <br>
                    <br>
                    <h1>Editar animal</h1><br>
                    <br>
                    <form id="registro-form" action="atualizarAnimal.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="animalID" value="<?php echo $registros['animalID']; ?>">
                        <div class="picture-container">
                            <label class="picture spacing" for="foto" tabIndex="0">
                                <span class="picture__text">Escolha a imagem</span>
                                <input type="file" name="foto" id="foto" style="display:none;" data-required>
                                <img id="imgPreview" class="picture__image" alt="Preview" src="getImage.php?animalID=<?php echo $registros['animalID']; ?>">
                            </label>

                            <div class="fields">
                                <br>
                                <div class="halff-box ">
                                    <label for="nome">Nome</label>
                                    <input type="text" name="nome" id="nome" placeholder="Digite o nome" data-required data-max-length="16" data-only-letters value="<?php echo $registros['nome']; ?>">
                                </div>

                                <div class="half-box ">
                                    <label for="raca">Raça</label>
                                    <input type="text" name="raca" id="raca" placeholder="Digite a raça do animal" data-only-letters value="<?php echo $registros['raca']; ?>">
                                </div>

                                <div class="half-box">
                                    <label for="idade">Idade</label>
                                    <select id="idade" name="idade" data-required readonly>
                                        <option value="" disabled selected hidden>Selecione</option>
                                        <option value="bebe" <?php if ($registros['idade'] === 'bebe') echo 'selected'; ?>>0 a 6 meses (filhotes)</option>
                                        <option value="jovem" <?php if ($registros['idade'] === 'jovem') echo 'selected'; ?>>7 meses a 5 anos (jovens)</option>
                                        <option value="adulto" <?php if ($registros['idade'] === 'adulto') echo 'selected'; ?>>6 a 10 anos (adultos)</option>
                                        <option value="idoso" <?php if ($registros['idade'] === 'idoso') echo 'selected'; ?>>11 anos ou mais (idosos)</option>
                                    </select>
                                </div>

                                <div class="half-box spacing">
                                    <label for="sexo">Sexo</label>
                                    <select id="sexo" name="sexo" placeholder="Selecione" data-required readonly>
                                        <option value="" disabled selected hidden>Selecione</option>
                                        <option value="Macho" <?php if ($registros['sexo'] === 'Macho') echo 'selected'; ?>>Macho</option>
                                        <option value="Fêmea" <?php if ($registros['sexo'] === 'Fêmea') echo 'selected'; ?>>Fêmea</option>
                                    </select>
                                </div>

                                <div class="half-box">
                                    <label for="tipo_animal">Espécie</label>
                                    <select id="tipo_animal" name="tipo_animal" placeholder="Selecione" data-required readonly>
                                        <option value="" disabled hidden>Selecione</option>
                                        <option value="gato" <?php if ($registros['tipo_animal'] === 'gato') echo 'selected'; ?>>Gato</option>
                                        <option value="cachorro" <?php if ($registros['tipo_animal'] === 'cachorro') echo 'selected'; ?>>Cachorro</option>
                                    </select>
                                </div>


                                <div class="half-box ">
                                    <label for="porte">Porte</label>
                                    <select id="porte" name="porte" placeholder="Selecione" value="<?php echo $registros['porte']; ?>">
                                        <option value="" disabled selected hidden>Selecione</option>
                                        <option value="peq" <?php if ($registros['porte'] === 'peq') echo 'selected'; ?>>Porte pequeno</option>
                                        <option value="med" <?php if ($registros['porte'] === 'med') echo 'selected'; ?>>Porte médio</option>
                                        <option value="grande" <?php if ($registros['porte'] === 'grande') echo 'selected'; ?>>Porte grande</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="full-box spacing">
                            <label for="saude">Saúde</label>
                            <textarea class="texto" name="saude" rows="6" cols="45" placeholder="Digite os dados da saúde do animal."><?php echo $registros['saude']; ?></textarea>
                        </div>

                        <div class="full-box spacing">
                            <label for="historico">Descrição</label>
                            <textarea class="texto" name="historico" rows="6" cols="45" placeholder="Digite a descrição do animal (personalidade, histórico, etc.)."><?php echo $registros['historico']; ?></textarea>
                        </div>

                        <div class="half-box spacing">
                            <label for="dt_entrada">Data da entrada</label>
                            <input type="date" name="dt_entrada" id="dt_entrada" data-required value="<?php echo $registros['dt_entrada']; ?>">
                        </div>

                        <div class="half-box spacing">
                            <label for="dt_saida">Data da saída</label>
                            <input type="date" name="dt_saida" id="dt_saida" data-required value="<?php echo $registros['dt_saida']; ?>">
                        </div>

                        <div class="half-box ">
                            <label for="disponibilidade">Disponibilidade</label>
                            <select id="disponibilidade" name="disponibilidade" placeholder="Selecione" value="<?php echo $registros['disponibilidade']; ?>">
                                <option value="" disabled selected hidden>Selecione</option>
                                <option value="Disponível" <?php if ($registros['disponibilidade'] === 'Disponível') echo 'selected'; ?>>Disponível</option>
                                <option value="Indisponível" <?php if ($registros['disponibilidade'] === 'Indisponível') echo 'selected'; ?>>Indisponível</option>
                            </select>
                        </div>

                        <div class="full-box spacing">
                            <input type="submit" value="Cadastrar">
                        </div>
                    </form>
                </div>
                <p class="error-validation template"></p>
                <script src="js/scriptCadUsuario.js"></script>
                <!-- <script src="js/main.js"></script> -->
</body>
</html>
    <?php
        } //Fim do while
    } catch (Exception $erro) {
        echo "<p>Erro:" . $erro->getMessage();
    }
} else {
    echo "<script>window.alert('Selecione um registro.');</script>";
}
    ?>