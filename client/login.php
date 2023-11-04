<!-- LÓGICA PHP -->
<?php
session_start();


$messageErro = '';

function sanitize($input)
{
  $input = trim($input);
  $input = strip_tags($input);
  $input = htmlspecialchars($input);
  return $input;
}

if (isset($_POST['submit'])) {
  if (empty($_POST['usuario']) || empty($_POST['senha'])) {
    $messageErro = 'Por favor, preencha todos os campos obrigatórios';
  } else {
    include '../server/config.php';

    $nm_usuario = sanitize($_POST['usuario']);
    $senha = sanitize($_POST['senha']);
    $senhaHash = md5($senha);

    $sql = "SELECT id_usuario, nm_usuario, email, is_admin FROM tb_usuario WHERE nm_usuario = $1 AND senha = $2";
    $result = pg_query_params($conn, $sql, array($nm_usuario, $senhaHash));

    if ($result) {
      $usuario = pg_fetch_assoc($result);

      if ($usuario) {
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['is_admin'] = $usuario['is_admin'];
        $_SESSION['nm_usuario'] = $usuario['nm_usuario'];
        $_SESSION['email'] = $usuario['email'];


        if ($_SESSION['is_admin'] == 't') {
          header('Location: ./create.php');
          exit();
        } else {
          header('Location: ./feed.php');
          exit();
        }
      } else {
        $messageErro = 'Usuário ou senha incorretos';
      }
    } else {
      $messageErro = 'Erro na consulta ao banco de dados';
    }

    // Verificação adicional para verificar se o usuário não existe
    $sql = "SELECT COUNT(*) FROM tb_usuario WHERE nm_usuario = $1";
    $result = pg_query_params($conn, $sql, array($nm_usuario));
    $row = pg_fetch_row($result);

    if ($row[0] == 0) {
      $messageErro = 'Usuário não encontrado';
    }
  }
}
?>

<!-- FRONT END -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/fonts.css">
  <title>GyarUGirls | Login</title>

  <!-- Dependências de estilo -->
  <?php include_once './css/index.php'; ?>
</head>

<body class="bg-repeat overflow-hidden" style="background-image: url(./images/backgroundlogin.jpg)">
  <!-- Mensagem de erro - BACK END -->
  <?php if (isset($_POST['submit'])) : ?>
    <?php if (!empty($messageErro)) : ?>
      <div class="rounded-md bg-red-50 p-4 alerta">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800"><?php echo $messageErro; ?></h3>
            <div class="mt-2 text-sm text-red-700">
            </div>
          </div>
          <div class="ml-auto pl-3">
            <div class="-mx-1.5 -my-1.5">
              <button type="button" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="document.querySelector('.alerta').style.display='none';">
                <span class="sr-only">Fechar</span>
                <!-- Ícone de X para fechar o alerta -->
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M14.348 5.652a.5.5 0 00-.707 0L10 9.293 6.357 5.652a.5.5 0 00-.707.707L9.293 10l-3.643 3.643a.5.5 0 10.707.707L10 10.707l3.643 3.643a.5.5 0 00.707-.707L10.707 10l3.641-3.648a.5.5 0 000-.707z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>

  <div class="relative flex items-center justify-center h-screen">
    <img src="./images/fundologin.png" style="width: 60%;">

    <form class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
    text-center 
    flex flex-col items-center" method="POST">
      <pre class="font-itim text-xl text-pink-500">
       Faça login no cantinho mais fofo do mundo
      </pre>
      <label for="usuario" class="text-pink-500 font-itim">Nome de usuário:</label>
      <input type="text" name="usuario" id="usuario" class="block w-full rounded-md bg-white placeholder-gray-300" style="width: 80%; height: 12%;" placeholder="@marshmallowsalgado">

      <label for="senha" class="text-pink-500 font-itim">Senha:</label>
      <input type="password" name="senha" id="senha" class="block w-full rounded-md bg-white placeholder-gray-300" style="width: 80%; height: 12%;" placeholder="***********">

      <button name="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">
        Entrar
      </button>

      <a href="./cadastro.php" class="text-pink-500 font-itim">Não tem uma conta? Cadastre-se!</a>
    </form>
  </div>

</body>


</html>