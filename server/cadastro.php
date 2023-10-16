<?php

// Inicia a sessão
session_start();

// Importa as configurações do banco de dados
include 'config.php';

// Variáveis para exibir mensagens
$message = '';
$alert_class = '';

// Função para "higienizar" a entrada de dados
// function sanitize($input)
// {
//   global $conn;
//   $input = trim($input);
//   $input = strip_tags($input);
//   $input = htmlspecialchars($input);
//   $input = pg_escape_string($conn, $input);
//   return $input;
// }

// Verifica se o formulário foi enviado
if (isset($_POST['submit'])) {
  // Consistência de dados
  $nm_usuario = $_POST['usuario'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  // Verifica se os campos não estão vazios
  if (empty($usuario)) {
    $message = 'Campo vazio';
  } elseif (empty($email)) {
    $message = 'Campo vazio';
  } elseif (empty($senha)) {
    $message = 'Campo vazio';
  } elseif (empty($usuario) && empty($email) && empty($senha)) {
    $message = 'Campos vazios';
  } else {

    // Insere os dados no banco de dados
    $sql = "INSERT INTO tb_usuario (nm_usuario, email, senha) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $sql, array($nm_usuario, $email, $senha));

    // Verifica se os dados foram inseridos com sucesso
    if ($result) {
      echo 'Dados inseridos com sucesso';
    } else {
      echo 'Erro ao inserir dados: ' . pg_last_error($conn);
    }
  }
}
