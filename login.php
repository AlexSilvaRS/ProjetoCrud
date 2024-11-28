<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

$usuario = new Usuario($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        if ($dados_usuario = $usuario->login($email, $senha)) {
            $_SESSION['usuario_id'] = $dados_usuario['id'];
            header('Location: portal.php');
            exit();
        } else {
            $mensagem_erro = "Credenciais inválidas!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Autenticação</title>
</head>

<body>
    <!-- Cabeçalho -->
    <header>
        <div class="header-content">
        <div class="logo">
            <img src="./imagens/logoNoticias.png" alt="Logo do Portal" height="50">
        </div>
            <h1>Portal de Notícias</h1><br>
            <a href="index.php" class="btn-voltar">Início</a>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <div class="container">
        <div class="box">
            <h2>Faça seu Login</h2>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" required>
                <input type="submit" name="login" value="Entrar">
            </form>
            <p>Não tem uma conta? <a href="./registrar.php">Registre-se aqui</a></p>
            <?php if (isset($mensagem_erro)) echo '<div class="mensagem-erro">' . $mensagem_erro . '</div>'; ?>
        </div>
    </div>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2024 Portal de Notícias. Todos os direitos reservados Alex Silva.</p>
    </footer>
</body>

</html>






















































