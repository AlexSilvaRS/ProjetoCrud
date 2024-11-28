<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Portal de Notícias</title>
</head>

<body>
    <!-- Cabeçalho -->
    <header>
        <div class="logo">
            <img src="./imagens/logoNoticias.png" alt="Logo do Portal" height="50">
        </div>
        <div class="login-btn">
            <a href="login.php" class="btn">Logar</a>
        </div>
    </header>

    <?php
    include_once './config/config.php';
    include_once './classes/Noticia.php';
    $noticias = new Noticia($db);
    $dados = $noticias->ler();
    ?>


    <!-- Conteúdo principal -->
    <main>
        <h1>Bem-vindo ao Portal de Notícias</h1>

        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <section class="noticias">

                <article>
                    <img src="<?php echo htmlspecialchars($row['imagem']); ?>" alt="Imagem da manchete 1" class="imagem-manchete">
                    <div class="manchete-conteudo">
                        <h2> <?php echo htmlspecialchars($row['titulo']); ?> </h2>
                        <p><?php echo htmlspecialchars($row['conteudo']); ?> </p>
                        <!-- <h3>/*<?php// echo htmlspecialchars($row['autor']); ?></h3>-->
                    </div>
                    <!-- Manchete 1 -->
                </article>
            <?php endwhile; ?>
            </section>

    </main>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2024 Portal de Notícias. Todos os direitos reservados a Alex Silva.</p>
    </footer>
</body>

</html>