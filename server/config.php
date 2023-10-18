<?php
global $conn;

// Variáveis para exibir mensagens
$alertBanco = '';

$conn =
  // pg_connect("host=200.19.1.18 dbname=mariabastos user=mariabastos password=123456");
  pg_connect("host=192.168.20.18 dbname=mariabastos user=mariabastos password=123456");

$alertBanco = "Conexão estabelecida com sucesso!";
if (!$conn) {
  $alertBanco = "Não foi possível estabelecer uma conexão com o banco de dados.";
  exit;
}
