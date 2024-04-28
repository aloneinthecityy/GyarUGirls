<?php
session_start();
echo var_dump($_SESSION);

if (isset($_POST['submit'])) {
  logout();
}

function logout()
{
  session_destroy();
  header('Location: ./login.php');
  exit;
}
