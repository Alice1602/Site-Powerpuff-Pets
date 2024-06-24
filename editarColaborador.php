<?php
session_start();

if (isset($_SESSION['idUsuarioLogado']) && isset($_SESSION['nivelUsuario'])) {
    if (isset($_GET['id_colaborador'])) {
        $id_colaborador = $_GET['id_colaborador'];
    } elseif ($_SESSION['nivelUsuario'] == "COLAB") {
        $id_colaborador = $_SESSION['idUsuarioLogado'];
    } else {
        echo "<script>window.alert('ID do colaborador não fornecido.');</script>";
        exit();
    }

    try {
        require_once("conexao.php");
        $sql = "SELECT * FROM Colaboradores WHERE id_colaborador=:id_colaborador";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_colaborador', $id_colaborador, PDO::PARAM_INT);
        $stmt->execute();
        $registros = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registros) {
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Editar Colaborador</title>
                <link rel="stylesheet" href="css/cadUsuario.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                <link rel="icon" href="images/logoGG.png">
            </head>
            <body>
                <p><b><a class="Home" href="powerfullpets.php">Início</a></b></p>
                <br>
                <div id="main-container2">
                    <h1>Edite suas informações</h1><br><br>
                    <form class="form" id="registro-form" action="atualizarColaborador.php" method="post">
                        <input type="hidden" name="id_colaborador" value="<?php echo $registros['id_colaborador']; ?>">
                        <div class="full-box spacing">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" placeholder="Digite seu nome" value="<?php echo $registros['nome']; ?>">
                        </div>
                        <div class="full-box spacing">
                            <label for="sobrenome">Sobrenome</label>
                            <input type="text" name="sobrenome" id="sobrenome" placeholder="Digite seu sobrenome" value="<?php echo $registros['sobrenome']; ?>">
                        </div>
                        <div class="half-box spacing">
                            <label for="idade">Data de nascimento</label>
                            <input type="date" name="idade" id="idade" value="<?php echo $registros['idade']; ?>" readonly>
                        </div>
                        <div class="half-box spacing">
                            <label for="sexo">Sexo</label>
                            <select id="sexo" name="sexo">
                                <option value="" disabled hidden>Selecione uma opção</option>
                                <option value="feminino" <?php if ($registros['sexo'] === 'feminino') echo 'selected'; ?>>Feminino</option>
                                <option value="masculino" <?php if ($registros['sexo'] === 'masculino') echo 'selected'; ?>>Masculino</option>
                            </select>
                        </div>
                        <div class="grande-box spacing">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" value="<?php echo $registros['email']; ?>" readonly>
                        </div>
                        <div class="full-box spacing">
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" value="<?php echo $registros['senha']; ?>">
                            <i class="bi bi-eye-slash-fill" id="btn-senha" onclick="mostrarSenha()"></i>
                        </div>
                        <div class="full-box spacing">
                            <label for="passconfirmation">Confirmação de senha</label>
                            <input type="password" name="passconfirmation" id="passwordconfirmation" placeholder="Confirme sua senha" value="<?php echo $registros['senha']; ?>">
                            <i class="bi bi-eye-slash-fill" id="btn-senha2" onclick="mostrarSenha2()"></i>
                        </div>
                        <div class="full-box spacing">
                            <input type="submit" value="Atualizar">
                        </div>
                    </form>
                </div>
                <p class="error-validation template"></p>
                <script src="js/scriptcadColaborador.js"></script>
            </body>
            </html>
            <?php
        } else {
            echo "<script>window.alert('Colaborador não encontrado.');</script>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "<script>window.alert('Por favor, faça o login para editar suas informações.');</script>";
    echo "<script>window.location.href='Login.php';</script>";
}
?>
