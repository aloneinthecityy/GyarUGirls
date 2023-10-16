<!-- LÓGICA EM PHP -->
<?php include './server/cadastro.php'; ?>


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
  <div class="relative flex items-center justify-center h-screen">
    <img src="./client/images/coracaocadastro.png" style="width: 60%;">

    <!-- Mensagem de erro -->
    <?php if (!empty($message)) : ?>
      <div class="max-w-xs bg-white border rounded-md shadow-lg dark:bg-gray-800 dark:border-gray-700" role="alert">
        <div class="flex p-4">
          <div class="flex-shrink-0">
            <svg class="h-4 w-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm text-gray-700 dark:text-gray-400">
              <?php echo $message ?>
            </p>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Formulário de cadastro -->
    <form class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
    text-center 
    flex flex-col items-center" action="./server/cadastro.php" method="POST">
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

      <button class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">
        Entrar
      </button>

      <a href="./login.php" class="text-pink-500 font-itim">Já tem uma conta? Faça login!</a>
    </form>
  </div>

</body>


</html>