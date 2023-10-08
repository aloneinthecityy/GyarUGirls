<?php
// Inclui o arquivo de conexão com o banco de dados
include 'config.php';

// Comando SQL para criar a tabela
$sql = "CREATE TABLE IF NOT EXISTS tb_post (
        id_post SERIAL PRIMARY KEY,
        id_categoria INTEGER NOT NULL,
        titulo VARCHAR(50),
        imagem BYTEA NOT NULL,
        sinopse text NOT NULL,
        conteudo text NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );

      CREATE TABLE IF NOT EXISTS tb_categoria (
        id_categoria SERIAL PRIMARY KEY,
        nm_categoria VARCHAR(50) NOT NULL UNIQUE
      );

      CREATE TABLE IF NOT EXISTS tb_post_categoria (
        id_post INTEGER NOT NULL,
        id_categoria INTEGER NOT NULL
      );

    --   ALTER TABLE tb_post_categoria
    --   ADD CONSTRAINT pk_post_categoria PRIMARY KEY (id_post, id_categoria);

    --   ALTER TABLE tb_post_categoria
    --   ADD CONSTRAINT fk_post_categoria_post_id
    --   FOREIGN KEY (id_post) REFERENCES tb_post(id_post);

    --   ALTER TABLE tb_post_categoria
    -- ADD CONSTRAINT fk_post_categoria_categoria_id
    -- FOREIGN KEY (id_categoria) REFERENCES tb_categoria(id_categoria);
    
      ";

// Executa o comando SQL
$result = pg_query($conn, $sql);

// Verifica se o comando SQL foi executado com sucesso
if (!$result) {
  echo "Erro ao criar tabela: " . pg_last_error($conn);
  exit;
}

echo "Tabela criada com sucesso!";

// Fecha a conexão com o banco de dados
pg_close($conn);
