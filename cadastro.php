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

    <form class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
    text-center 
    flex flex-col items-center" action="./cadastro.php">
      <pre class="font-itim text-xl text-pink-500">
        Cadastre-se no blog 
        mais descolado e @$#%%* da web
      </pre>
      <label for="user" class="text-pink-500 font-itim">Nome de usuário:</label>
      <input type="text" name="user" id="user" class="block w-full rounded-md bg-white placeholder-gray-300" style="width: 80%; height: 12%;" placeholder="@marshmallowsalgado">

      <label for="email" class="text-pink-500 font-itim">E-mail:</label>
      <input type="email" name="email" id="email" class="block w-full rounded-md bg-white placeholder-gray-300" style="width: 80%; height: 12%;" placeholder="ciclaninhodasilva@gmail.com">

      <label for="password" class="text-pink-500 font-itim">Crie uma senha:</label>
      <input type="password" name="password" id="password" class="block w-full rounded-md bg-white placeholder-gray-300" style="width: 80%; height: 12%;" placeholder="***********">

      <button class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">
        Entrar
      </button>

      <a href="./login.php" class="text-pink-500 font-itim">Já tem uma conta? Faça login!</a>
    </form>
  </div>

</body>


</html>