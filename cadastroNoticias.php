<?php

include_once './config/config.php';
include_once './classes/Noticia.php';

$database = new Database();
$db = $database->getConnection();
$noticia = new Noticia($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $data = $_POST['data'];
    $autor = $_POST['autor'];
    $noticiaTexto = $_POST['noticia'];
    $imagem = '';

    if (!empty($_FILES['imagem']['name'])) {
        $target_dir = "imagens/img/";
        $imagem = $target_dir . basename($_FILES["imagem"]["name"]);
        if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem)) {
            echo "Erro ao fazer upload da imagem.";
            exit();
        }
    }

    if ($noticia->cadastrar($titulo, $data, $autor, $noticiaTexto, $imagem)) {
        echo "<script>alert('Notícia cadastrada com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar notícia.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./cadastroNoticias.css">
    <title>Cadastrar Notícia</title>
</head>

<body>
    <header>
        <div class="logo">Portal</div>
        <img src="./imagens/logoNoticias.png" alt="Logo do Portal" height="50">
        </div>
        <a href="logout.php" class="sair-btn">Sair</a>
    </header>
    <main>
        <form class="form-cadastro" action="cadastroNoticias.php" method="POST" enctype="multipart/form-data">
            <h1>Cadastrar Nova Notícia</h1>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Digite o Titulo" required>

            <label for="data">Data:</label>
            <input type="date" id="data" name="data" required>

            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" placeholder="Digite a data do ocorrido" required>

            <label for="noticia">Notícia:</label>
            <textarea id="noticia" name="noticia" rows="5" required placeholder="Escreva um resumo da Noticia"></textarea>

            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem" name="imagem">

            <button type="submit">Salvar</button>
        </form>
    </main>
</body>

</html>