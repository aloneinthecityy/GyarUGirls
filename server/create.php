<?php
// Inicia a sessão
session_start();

// Importa as configurações do banco de dados
include 'config.php';

// Variáveis para exibir mensagens
$message = '';
$messageErro = '';

// Função para "higienizar" a entrada de dados
function sanitize($input)
{
  global $conn, $messageErro, $message;
  $input = trim($input);
  $input = strip_tags($input);
  $input = htmlspecialchars($input);
  $input = pg_escape_string($conn, $input);
  return $input;
}

// Função para enviar a imagem para o servidor
function uploadImagem($imagem)
{
  global $message, $messageErro;
  if ($imagem['error'] != 0) {
    $messageErro = 'Erro ao fazer upload da imagem';
    exit;
  }

  if ($imagem['size'] > 2097152) {
    $messageErro = 'Tamanho de imagem excedido. Tamanho máximo de 2MB!';
    exit;
  }

  $pasta = './client/images/upload_post/';
  $nomeDoArquivo = $imagem['name'];
  $novoNome = uniqid(); // CRIA UM NOVO NOME PRA IMAGEM, um nome aleatório
  $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION)); // elimina a extensão do nome da imagem

  if ($extensao != 'jpg' && $extensao != 'png' && $extensao != 'gif' && $extensao != 'jpeg') {
    $messageErro = 'Formato de imagem inválido. Por favor, envie uma imagem no formato JPG, PNG ou GIF';
    exit;
  }

  $patch = $pasta . $novoNome . '.' . $extensao;
  $verificaEnvioDoArquivo = move_uploaded_file($imagem['tmp_name'], $patch);
  if ($verificaEnvioDoArquivo == false) {
    $messageErro = 'Erro ao fazer upload da imagem';
    exit;
  } else {
    $message = 'Imagem enviada com sucesso, clique aqui para visualizar a imagem <a href= "./client/images/upload_post/' . $novoNome . '.' . $extensao . '">Clique aqui</a>';
    return $patch;
  }
}

if (isset($_POST['submit'])) {
  // Verifica se os campos obrigatórios foram preenchidos
  if (empty($_POST['titulo']) || empty($_POST['sinopse']) || empty($_POST['conteudo']) || empty($_POST['categoria'])) {
    $messageErro = 'Por favor, preencha todos os campos obrigatórios';
  } else {
    // Consistência de dados
    $titulo = sanitize($_POST['titulo']);
    $sinopse = sanitize($_POST['sinopse']);
    $conteudo = sanitize($_POST['conteudo']);
    $id_categoria = sanitize($_POST['categoria']);

    // Consistência de imagem
    if (isset($_FILES['imagem'])) {
      $imagem = $_FILES['imagem'];
      $imagemPatch = uploadImagem($imagem);
    }

    // Verifica se a categoria existe na tabela tb_categoria
    $sql = "SELECT id_categoria FROM tb_categoria WHERE id_categoria = $1";
    $result = pg_query_params($conn, $sql, array($id_categoria));
    if (pg_num_rows($result) == 0) {
      $messageErro = 'Categoria não encontrada';
    } else {
      // Insere os dados na tabela
      $sql = "INSERT INTO tb_post (id_categoria, titulo, imagem, sinopse, conteudo) VALUES ($1, $2, $3, $4, $5)";
      $result = pg_query_params($conn, $sql, array($id_categoria, $titulo, $imagemPatch, $sinopse, $conteudo));

      // Verifica se os dados foram inseridos com sucesso
      if ($result) {
        $message = 'Dados inseridos com sucesso';
      } else {
        $messageErro = 'Erro ao inserir dados: ' . pg_last_error($conn);
      }
    }
  }
}

// Recupera os dados do banco de dados
$sql = "SELECT * FROM tb_post";
$result = pg_query($conn, $sql);

// Fecha a conexão com o banco de dados
pg_close($conn);
