<?php
// $bd_host = "192.168.20.18"
global $conn;

$conn =
  pg_connect("host=200.19.1.18 dbname=mariabastos user=mariabastos password=123456");
echo "Conexão estabelecida com sucesso!";
if (!$conn) {
  echo "Não foi possível estabelecer uma conexão com o banco de dados.";
  exit;
}
