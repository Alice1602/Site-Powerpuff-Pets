<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Animal</title>
    <link rel="stylesheet" href="css/cadUsuario.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="images/logoGG.png">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const inputFile = document.querySelector("#foto");
        const pictureImage = document.querySelector(".picture__image");

        inputFile.addEventListener("change", function (e) {
            const file = e.target.files[0];
            const pictureImageTxt = "Escolha a imagem";

            if (file) {
                const reader = new FileReader();

                reader.addEventListener("load", function () {
                    const img = document.createElement("img");
                    img.src = reader.result;
                    img.classList.add("picture__img");

                    pictureImage.innerHTML = "";
                    pictureImage.appendChild(img);
                });

                reader.readAsDataURL(file);
            } else {
                pictureImage.innerHTML = pictureImageTxt;
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('foto').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('imgPreview');
                    const text = document.querySelector('.picture__text');
                    img.src = e.target.result;
                    img.style.display = 'block';
                    text.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
    });

    </script>
</head>
<body>
    <p><b><a class="Home" href="powerfullpets.php" target="_blank">Início</a></b></p>
    <br>
    <div id="main-container">
    <br><h1>Cadastro do animal</h1><br>
        <br>
        <form id="registro-form" action="cadAnimais.php" method="post" enctype="multipart/form-data">

        <div class="picture-container">
            <label class="picture spacing" for="foto" tabIndex="0">
                <span class="picture__text">Escolha a imagem</span>
                <input type="file" name="foto" id="foto" style="display:none;" data-required>
                <img id="imgPreview" class="picture__image" alt="Preview">
            </label>
            <div class="fields">
            <br><div class="halff-box "> 
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome" data-required data-max-length="16" data-only-letters>
            </div>
            
            <div class="half-box "> 
                <label for="raca">Raça</label>
                <input type="text" name="raca" id="raca" placeholder="Digite a raça do animal" data-only-letters>
            </div>

            <div class="half-box">
                <label for="idade">Idade</label>
                <select id="idade" name="idade" data-required>
                    <option value="" disabled selected hidden>Selecione</option>
                    <option value="bebe">0 a 6 meses (filhotes)</option>
                    <option value="jovem">7 meses a 5 anos (jovens)</option>
                    <option value="adulto">6 a 10 anos (adultos)</option>
                    <option value="idoso">11 anos ou mais (idosos)</option>
                </select>
          </div>

            <div class="half-box spacing"> 
                <label for="sexo">Sexo</label>
                <select id="sexo" name="sexo" placeholder="Selecione" data-required>
                    <option value="" disabled selected hidden>Selecione</option>
                    <option value="Macho">Macho</option>
                    <option value="Fêmea">Fêmea</option>
                </select>
            </div>

            <div class="half-box "> 
                <label for="tipo_animal">Espécie</label>
                <select id="tipo_animal" name="tipo_animal" placeholder="Selecione" data-required>
                    <option value="" disabled selected hidden>Selecione</option>
                    <option value="gato">Gato</option>
                    <option value="cachorro">Cachorro</option>
                </select>
            </div>

            <div class="half-box "> 
                <label for="porte">Porte</label>
                <select id="porte" name="porte">
                    <option value="" disabled selected hidden>Selecione</option>
                    <option value="peq">Porte pequeno</option>
                    <option value="med">Porte médio</option>
                    <option value="grande">Porte grande</option>
                </select><br>
            </div>
            </div>
        </div>

        <div class="full-box spacing"> 
                <label for="saude">Saúde</label>
                <textarea class="texto" name="saude" rows="6" cols="45" placeholder="Digite os dados da saúde do animal."></textarea>
            </div>

            <div class="full-box spacing"> 
                <label for="historico">Descrição</label>
                <textarea class="texto" name="historico" rows="6" cols="45" placeholder="Digite a descrição do animal (personalidade, histórico, etc.)."></textarea>
            </div>

            <div class="half-box spacing"> 
                <label for="dt_entrada">Data da entrada</label>
                <input type="date" name="dt_entrada" id="dt_entrada" data-required>
            </div>

            <div class="half-box spacing"> 
                <label for="dt_saida">Data da saída</label>
                <input type="date" name="dt_saida" id="dt_saida" data-required>
            </div>

            <div class="half-box "> 
                <label for="disponibilidade">Disponibilidade</label>
                <select id="disponibilidade" name="disponibilidade" placeholder="Selecione">
                    <option value="" disabled selected hidden>Selecione</option>
                    <option value="Disponível">Disponível</option>
                    <option value="Indisponível">Indisponível</option>
                </select>
            </div>

            <div class="full-box spacing">
                <input type="submit"  value="Cadastrar">
            </div>
        </form>
        <br>
        <br>
        <br>
    </div>
    <p class="error-validation template"></p>
    <script src="js/scriptCadUsuario.js"></script>
</body>
</html>