<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de ONG</title>
    <link rel="stylesheet" href="css/fotoUsuario.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="images/logoGG.png">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputFile = document.querySelector("#foto");
            const pictureImage = document.querySelector(".picture__image");
            const pictureText = document.querySelector(".picture__text");

            inputFile.addEventListener("change", function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.getElementById('imgPreview');
                        img.src = e.target.result;
                        img.style.display = 'block';
                        pictureText.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else {
                    pictureText.style.display = 'block';
                }
            });
        });
    </script>
</head>

<body>
    <center>
        <div id="main-container">
            <h1>Adicione uma foto de perfil</h1><br>
            <br>
            <form id="registro-form" action="cadfotoUsuario.php" method="post" enctype="multipart/form-data">
                <center>
                    <label class="picture" for="foto" tabIndex="0">
                        <span class="picture__text">Escolha a imagem</span>
                        <input type="file" name="foto" id="foto" style="display:none;" required>
                        <img id="imgPreview" class="picture__image" alt="Preview" style="display:none;">
                    </label>
                    <br>
                    <div class="full-box spacing">
                        <input type="submit" value="Salvar">
                    </div>
                </center>
            </form>
        </div>
    </center>
</body>

</html>
