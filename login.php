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

  <div class="relative flex items-center justify-center h-screen">
    <img src="./client/images/fundologin.png" style="width: 60%;">

    <form class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
    text-center 
    flex flex-col items-center" action="./cadastro.php">
      <pre class="font-itim text-xl text-pink-500">
       Faça login no cantinho mais fofo do mundo
      </pre>
      <label for="user" class="text-pink-500 font-itim">Nome de usuário:</label>
      <input type="text" name="user" id="user" class="block w-full rounded-md bg-white placeholder-gray-300" style="width: 80%; height: 12%;" placeholder="@marshmallowsalgado">

      <label for="password" class="text-pink-500 font-itim">Senha:</label>
      <input type="password" name="password" id="password" class="block w-full rounded-md bg-white placeholder-gray-300" style="width: 80%; height: 12%;" placeholder="***********">

      <button class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">
        Entrar
      </button>

      <a href="./cadastro.php" class="text-pink-500 font-itim">Não tem uma conta? Cadastre-se!</a>
    </form>
  </div>

</body>


</html>