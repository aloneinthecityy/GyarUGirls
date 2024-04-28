<?php
// Inclui o arquivo de conexão com o banco de dados
include 'config.php';

// Comando SQL para criar a tabela
$sql = "CREATE TABLE IF NOT EXISTS tb_usuario (
        id_usuario SERIAL PRIMARY KEY,
        nm_usuario VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(50) NOT NULL UNIQUE,
        senha VARCHAR(50) NOT NULL,
        is_admin BOOLEAN DEFAULT FALSE,
        imagem_perfil VARCHAR(100) DEFAULT '../client/images/perfil_usuario/default.jpg',
        cargo VARCHAR(50),
        bio TEXT,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );

      CREATE TABLE IF NOT EXISTS tb_categoria (
        id_categoria SERIAL PRIMARY KEY,
        nm_categoria VARCHAR(50) NOT NULL UNIQUE
      );

      CREATE TABLE IF NOT EXISTS tb_post (
        id_post SERIAL PRIMARY KEY,
        id_categoria INTEGER NOT NULL,
        titulo VARCHAR(50) NOT NULL,
        imagem VARCHAR(100) NOT NULL,
        sinopse text NOT NULL,
        conteudo text NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_categoria) REFERENCES tb_categoria(id_categoria)
      );

      CREATE TABLE IF NOT EXISTS tb_comentario (
        id_comentario SERIAL PRIMARY KEY,
        id_post INTEGER NOT NULL,
        id_usuario INTEGER NOT NULL,
        comentario TEXT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_post) REFERENCES tb_post (id_post),
        FOREIGN KEY (id_usuario) REFERENCES tb_usuario (id_usuario)
      );

      CREATE TABLE IF NOT EXISTS tb_comentario_mural (
        id_comentario SERIAL PRIMARY KEY,
        id_usuario_comentador INTEGER NOT NULL,
        id_usuario INTEGER NOT NULL,
        comentario TEXT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_usuario_comentador) REFERENCES tb_usuario (id_usuario)
      );


      CREATE TABLE IF NOT EXISTS tb_post_usuario (
        id_post_usuario SERIAL PRIMARY KEY,
        id_usuario INTEGER NOT NULL,
        imagem VARCHAR(100),
        conteudo TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_usuario) REFERENCES tb_usuario (id_usuario)
      );

      -- CREATE TABLE IF NOT EXISTS tb_resposta (
      --   id_resposta SERIAL PRIMARY KEY,
      --   id_comentario INTEGER NOT NULL,
      --   id_usuario INTEGER NOT NULL,
      --   resposta TEXT NOT NULL,
      --   created_at DATE DEFAULT CURRENT_DATE,
      --   FOREIGN KEY (id_comentario) REFERENCES tb_comentario (id_comentario),
      --   FOREIGN KEY (id_usuario) REFERENCES tb_usuario (id_usuario)
      -- );
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
