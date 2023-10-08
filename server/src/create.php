<?php

// Inicia a sessão
session_start();

// Importa as configurações do banco de dados
include './server/config.php';

// Variáveis para exibir mensagens
$message = '';
$alert_class = '';

// Função para "higienizar" a entrada de dados
function sanitize($input)
{
  global $conn;
  $input = trim($input);
  $input = strip_tags($input);
  $input = htmlspecialchars($input);
  $input = pg_escape_string($conn, $input);
  return $input;
}

// Verifica se o formulário foi enviado
if (isset($_POST['submit'])) {
  // Consistência de dados
  $titulo = sanitize($_POST['titulo']);
  $imagem = sanitize($_POST['imagem']);
  $sinopse = sanitize($_POST['sinopse']);
  $conteudo = sanitize($_POST['conteudo']);
  $categorias = $_POST['categoria'];

  echo $categorias;
  // Verifica se os campos nome e email não estão vazios
  if (empty($titulo) || empty($imagem)) {
    $message = 'Título and imagem fields are required';
    $alert_class = 'alert-danger';
  } else {

    // Insere os dados no banco de dados
    $sql = "INSERT INTO tb_post (titulo, imagem, sinopse, conteudo, categoria) VALUES ($1, $2, $3, $4)";


    // Recupera o id do post inserido
    $row = pg_fetch_assoc($result);
    $id_post = $row['id_post'];

    // Insere as categorias selecionadas na tabela tb_post_categoria
    foreach ($categorias as $categoria) {
      $sql = "INSERT INTO tb_post_categoria (id_post, id_categoria) VALUES ($1, $2)";
      $stmt = pg_prepare($conn, "", $sql);
      $result = pg_execute($conn, "", array($id_post, $categoria));
    }

    // Verifica se os dados foram inseridos com sucesso
    if ($result) {
      $message = 'Post added successfully';
      $alert_class = 'alert-success';
    } else {
      $message = 'Error adding post: ' . pg_last_error($conn);
      $alert_class = 'alert-danger';
    }
  }
}

// Recupera os dados do banco de dados
$sql = "SELECT * FROM tb_post";
$result = pg_query($conn, $sql);
