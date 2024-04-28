<?php
global $conn;

// Variáveis para exibir mensagens
$alertBanco = '';

$conn =
  $conn = pg_connect("host=" . getenv('DB_HOST') . " dbname=" . getenv('DB_NAME') . " user=" . getenv('DB_USER') . " password=" . getenv('DB_PASSWORD'));

$alertBanco = "Conexão estabelecida com sucesso!";
if (!$conn) {
  $alertBanco = "Não foi possível estabelecer uma conexão com o banco de dados.";
  exit;
}
