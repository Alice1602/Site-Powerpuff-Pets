<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Colaborador</title>
    <link rel="stylesheet" href="css/cadUsuario.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="images/logoGG.png">
</head>

<body>
    <p><b><a class="Home" href="powerfullpets.php" target="_blank">Início</a></b></p>
    <br>

    <div id="main-container2">
        <h1>Cadastre o colaborador</h1><br>
        <br>
        <form class="form" id="registro-form" action="cadColaborador.php" method="post">
            <div class="full-box spacing">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome da sua empresa">
            </div>

            <div class="full-box spacing">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" name="sobrenome" id="sobrenome" placeholder="Digite seu sobrenome" data-only-letters data-max-length="30" data-required>
            </div>

            <div class="half-box spacing">
                <label for="idade">Data de nascimento</label>
                <input type="date" name="idade" id="idade">
            </div>

            <div class="half-box spacing">
                <label for="sexo">Sexo</label>
                <select id="sexo" name="sexo" placeholder="Selecione">
                    <option value="" disabled selected hidden>Selecione uma opção</option>
                    <option value="feminino">Feminino</option>
                    <option value="masculino">Masculino</option>
                </select>
            </div>

            <div class="half-box spacing">
                <label for="ong">Qual a sua ONG?</label>
                <select id="ong" name="ong" placeholder="Selecione">
                    <?php
                    require_once("conexao.php");
                    $sql = "Select * from ONG order by nome";
                    $dados = $conn->query($sql);
                    while ($registros = $dados->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $registros['id_ong'] . "'>" . $registros['nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="grande-box spacing">
                <label for="email">E-mail</label> <!-- campo grande -->
                <input type="email" name="email" id="email" placeholder="Digite seu e-mail" data-email-validate>
            </div>

            <div class="full-box spacing">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" data-password-validate data-required>
                <i class="bi bi-eye-slash-fill" id="btn-senha" onclick="mostrarSenha()"></i>
            </div>

            <div class="full-box spacing">
                <label for="passconfirmation">Confirmação de senha</label>
                <input type="password" name="passconfirmation" id="passwordconfirmation" placeholder="Confirme sua senha" data-equal="password" data-required>
                <i class="bi bi-eye-slash-fill" id="btn-senha2" onclick="mostrarSenha2()"></i>
            </div>

            <div class="full-box">
                <input type="checkbox" name="agreement" id="agreement" data-required>
                <label for="agreement" id="agreement-label">Eu li e aceito os <a href="#">termos de uso</a></label>
            </div>

            <div class="full-box spacing">
                <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
    <p class="error-validation template"></p>
    <script src="js/scriptCadUsuario.js"></script>
    <script src="js/main.js"></script>
</body>

</html>