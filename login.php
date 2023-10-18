<!-- LÓGICA PHP -->
<?php
include './server/config.php';

session_start();

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
  if (empty($_POST['usuario']) || empty($_POST['senha'])) {
    $messageErro = 'Por favor, preencha todos os campos obrigatórios';
  } else {
    $nm_usuario = sanitize($_POST['usuario']);
    $senha = sanitize($_POST['senha']);
    $senha = md5($senha);

    // Verifica se o usuário existe
    $sql = "SELECT * FROM tb_usuario WHERE nm_usuario = $1 AND senha = $2";
    $result = pg_query_params($conn, $sql, array($nm_usuario, $senha));
    $usuario = pg_fetch_assoc($result); // Retorna um array associativo com os dados do usuário

    if (pg_num_rows($result) > 0) {
      // O usuário existe, então cria uma sessão
      $_SESSION['id_usuario'] = $usuario['id_usuario'];
      $_SESSION['is_admin'] = $usuario['is_admin'];

      if ($_SESSION['is_admin'] == 't') {
        header('Location: ./create.php');
      } else {
        header('Location: ./feed.php');
      }
    } else {
      header('Location: ./login.php?erro=1');
      $messageErro = 'Usuário ou senha incorretos';
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
  <link rel="stylesheet" href="./client/css/fonts.css">
  <title>GyarUGirls | Login</title>

  <!-- Dependências de estilo -->
  <?php include_once './client/css/index.php'; ?>
</head>

<body class="bg-repeat overflow-hidden" style="background-image: url(./client/images/backgroundlogin.jpg)">
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
    <div class="rounded-md bg-green-50 p-4">
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
    <img src="./client/images/fundologin.png" style="width: 60%;">

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