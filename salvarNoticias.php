<?php
session_start();
include_once './config/config.php';
include_once './classes/Noticia.php';


// aqi se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $noticia = $_POST['conteudo'];
    $dataPublicacao = $_POST['data_publicacao'];
    $imagem = $_FILES['imagem'];

    // Validações do upload da imagem
    $nomeImagem = "";
    if ($imagem['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
        $tamanhoMaximo = 10 * 1024 * 1024; // 10 MB

        // Validar tipo de arquivo
        $tiposPermitidos = ['jpg', 'jpeg', 'png'];
        if (!in_array($extensao, $tiposPermitidos)) {
            die("Apenas arquivos JPG ou PNG são permitidos.");
        }

        // Validar tamanho do arquivo
        if ($imagem['size'] > $tamanhoMaximo) {
            die("O tamanho do arquivo não pode exceder 10 MB.");
        }

        // Gerar nome único para o arquivo
        $nomeImagem = uniqid() . "." . $extensao;
        $destino = "uploads/" . $nomeImagem;

        // Mover o arquivo para o diretório
        if (!move_uploaded_file($imagem['tmp_name'], $destino)) {
            die("Erro ao salvar a imagem.");
        }
    } else if ($imagem['error'] !== UPLOAD_ERR_NO_FILE) {
        die("Erro ao fazer upload da imagem.");
    }

    // Conversão da data para o formato americano
    $noticiaObj = new Noticia($db);
    $dataConvertida = $dataPublicacao;
    //$noticiaObj->converterData($dataPublicacao);

    if (!$dataConvertida) {
        die("Data inválida. Use o formato dd/mm/aaaa.");
    }

    // Salvar a notícia no banco de dados
    $noticiaObj->cadastrar($titulo, $dataConvertida, $autor, $noticia, $nomeImagem);

    echo "Notícia salva com sucesso!";
    echo '<br><a href="index.php">Voltar</a>';
}
?>

