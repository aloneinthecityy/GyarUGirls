<!-- LÓGICA EM PHP -->
<?php

include '../server/config.php';

$message = '';
$messageErro = '';

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
  // Verifica se os campos obrigatórios foram preenchidos
  if (empty($_POST['usuario']) || empty($_POST['email']) || empty($_POST['senha'])) {
    $messageErro = 'Por favor, preencha todos os campos obrigatórios';
  } else {
    // Consistência de dados
    $nm_usuario = sanitize($_POST['usuario']);
    $email = sanitize($_POST['email']);
    $senha = sanitize($_POST['senha']);

    $senha = md5($senha);

    // Verifica se o usuário já existe no banco de dados
    $sql = "SELECT * FROM tb_usuario WHERE nm_usuario = $1 OR email = $2";
    $result = pg_query_params($conn, $sql, array($nm_usuario, $email));

    if (pg_num_rows($result) > 0) {
      // O usuário já existe
      $messageErro = 'O usuário já existe';
    } else {
      // Insere os dados no banco de dados
      $sql = "INSERT INTO tb_usuario (nm_usuario, email, senha, is_admin) VALUES ($1, $2, $3, $4)";
      $result = pg_query_params(
        $conn,
        $sql,
        array($nm_usuario, $email, $senha, 0)
      );

      // Verifica se os dados foram inseridos com sucesso
      if ($result) {
        header('Location: ./login.php');
        exit;
      } else {
        $messageErro = 'Erro ao cadastrar o usuário';
      }
    }
  }
}
// Fecha a conexão com o banco de dados
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/fonts.css">
  <title>GyarUGirls | Cadastro</title>

  <!-- Dependências de estilo -->
  <?php include_once './css/index.php'; ?>
</head>

<body class="bg-repeat overflow-hidden" style="background-image: url(./images/fundocadastro.jpg)">
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
    <img src="./images/coracaocadastro.png" style="width: 60%;">
    <!-- Formulário de cadastro -->
    <form class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
    text-center 
    flex flex-col items-center" method="POST">
      <pre class="font-itim text-xl text-pink-500">
        Cadastre-se no blog 
        mais descolado e @$#%%* da web
      </pre>
      <label for="usuario" class="text-pink-500 font-itim">Nome de usuário:</label>
      <input type="text" name="usuario" id="usuario" class="block w-full rounded-md bg-white placeholder-gray-300" style="width: 80%; height: 12%;" placeholder="@marshmallowsalgado">

      <label for="email" class="text-pink-500 font-itim">E-mail:</label>
      <input type="email" name="email" id="email" class="block w-full rounded-md bg-white placeholder-gray-300" style="width: 80%; height: 12%;" placeholder="ciclaninhodasilva@gmail.com">

      <label for="senha" class="text-pink-500 font-itim">Crie uma senha:</label>
      <input type="password" name="senha" id="senha" class="block w-full rounded-md bg-white placeholder-gray-300" style="width: 80%; height: 12%;" placeholder="***********">

      <button name="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">
        Entrar
      </button>


      <a href="./login.php" class="text-pink-500 font-itim">Já tem uma conta? Faça login!</a>
    </form>
  </div>

</body>


</html>