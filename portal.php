<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario = new Usuario($db);

// Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    if ($usuario->deletar($id)) {
        header('Location: portal.php');
        exit();
    } else {
        $mensagem_erro = "Erro ao deletar usuário!";
    }
}

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];

// Obter dados dos usuários para exibir na tabela
$dados = $usuario->ler();

if (!$dados) {
    $mensagem_erro = "Nenhum usuário encontrado!";
}

// Função para determinar a saudação
function saudacao()
{
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } elseif ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
    <link rel="stylesheet" href="portal.css">
    
</head>

<body>
    <!-- Cabeçalho com logo e botão de sair -->
    <header>
        <div class="logo">Portal</div>
            <img src="./imagens/logoNoticias.png" alt="Logo do Portal" height="50">
        </div>
        <a href="logout.php" class="sair-btn">Sair</a>
    </header>

    <main>
        <h1><?php echo saudacao() . ", " . htmlspecialchars($nome_usuario); ?>!</h1>

        <div class="links">
            <a href="./registrar.php">Adicionar Usuário</a>
            <a href="./cadastroNoticias.php">Cadastrar Notícias</a>
        </div>

        <!-- Mensagens de erro ou sucesso -->
        <?php if (isset($mensagem_erro)) : ?>
            <p class="error-message"><?php echo htmlspecialchars($mensagem_erro); ?></p>
        <?php endif; ?>

        <!-- Tabela de usuários -->
        <?php if ($dados && $dados->rowCount() > 0) : ?>
            <div class="table-container">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Sexo</th>
                        <th>Fone</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                    <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                            <td><?php echo htmlspecialchars($row['fone']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                                <a href="portal.php?deletar=<?php echo $row['id']; ?>">Deletar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        <?php else : ?>
            <p style="text-align: center;">Nenhum usuário encontrado.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Portal de Usuários. Todos os direitos reservados Alex SilvaS.</p>
    </footer>
</body>

</html>













