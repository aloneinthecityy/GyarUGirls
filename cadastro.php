<!-- LÓGICA EM PHP -->
<?php

include './server/config.php';

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
      $sql = "INSERT INTO tb_usuario (nm_usuario, email, senha, is_admin, created_at, updated_at) VALUES ($1, $2, $3, $4, $5, $6)";
      $result = pg_query_params(
        $conn,
        $sql,
        array($nm_usuario, $email, $senha, 0, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'))
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
  <link rel="stylesheet" href="./client/css/fonts.css">
  <title>GyarUGirls | Cadastro</title>

  <!-- Dependências de estilo -->
  <?php include_once './client/css/index.php'; ?>
</head>

<body class="bg-repeat overflow-hidden" style="background-image: url(./client/images/fundocadastro.jpg)">
  <!-- Mensagem de erro - BACK END -->
  <?php if (!empty($messageErro)) : ?>
    <div class="rounded-md bg-red-50 p-4">
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
      </div>
    </div>

  <?php endif; ?>

  <!-- Mensagem de sucesso - BACK END -->
  <?php if (!empty($message)) : ?>
    <div class="rounded-md bg-green-50 p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p> <?php echo $message; ?> </p>
        </div>
        <div class="ml-auto pl-3">
          <div class="-mx-1.5 -my-1.5">
            <button type="button" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
              <span class="sr-only">Dismiss</span>
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <br>
  <!-- Mensagem de CONEXÃO DO BANCO -->
  <?php if (!empty($alertBanco)) : ?>
    <div class="rounded-md bg-green-50 p-4" hidden>
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p> <?php echo $alertBanco; ?> </p>
        </div>
        <div class="ml-auto pl-3">
          <div class="-mx-1.5 -my-1.5">
            <button type="button" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
              <span class="sr-only">Dismiss</span>
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <br>

  <div class="relative flex items-center justify-center h-screen">
    <img src="./client/images/coracaocadastro.png" style="width: 60%;">
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