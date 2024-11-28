<?php
class Noticia
{
    private $conn;
    private $table_name = "noticias";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para cadastrar uma notícia no banco
    public function cadastrar($titulo, $dataConvertida, $autor, $noticia, $nomeImagem)
    {
        $query = "INSERT INTO " . $this->table_name . " (titulo, autor, conteudo, imagem, data_publicacao)
                  VALUES (:titulo, :autor, :conteudo, :imagem, :data_publicacao)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':conteudo', $noticia);
        $stmt->bindParam(':imagem', $nomeImagem);
        $stmt->bindParam(':data_publicacao', $dataConvertida);

        return $stmt->execute();
    }
    public function deletar($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function atualizar($id, $nome, $sexo, $fone, $email)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, sexo = ?, fone = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $sexo, $fone, $email, $id]);
        return $stmt;
    }
    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
    