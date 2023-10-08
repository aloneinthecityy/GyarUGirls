<!-- LÓGICA EM PHP -->
<?php include './server/src/create.php'; ?>


<!-- FRONT-END -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criação | GyaruGirls</title>

  <!-- Dependências de estilo -->
  <?php include_once './client/css/index.php'; ?>
</head>

<body>
  <div class="container mx-auto px-4 mt-6">
    <h1 class="text-2xl font-bold mb-4">Criação de posts</h1>

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

    <!-- Formulário de criação -->
    <form action="./create.php" method="post" class="mb-8">
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="imagem">
          Imagem:
        </label>
        <input id="imagem" type="file" name="imagem">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="titulo">
          Título:
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="titulo" type="text" placeholder="Como a revolução industrial impacta no meu mau humor?" name="titulo">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="sinopse">
          Breve resumo/sinopse:
        </label>
        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="sinopse" name="sinopse"></textarea>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="conteudo">
          Conteúdo do post:
        </label>
        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="conteudo" name="conteudo"></textarea>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="categoria">
          Categoria:
        </label>
        <input type="checkbox" id="alegria" name="categoria[]" value="1">
        <label for="1"> 1 - Alegria</label><br>
        <input type="checkbox" id="tristeza" name="categoria[]" value="2">
        <label for="2"> 2 - tristeza </label><br>
        <input type="checkbox" id="raiva" name="categoria[]" value="3">
        <label for="3"> 3 - raiva </label><br>
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="submit">
          Adicionar
        </button>
      </div>
    </form>

    <!-- Tabela exibindo os dados -->
    <table class="w-full border-collapse mb-8">
      <thead>
        <tr>
          <th class="border border-gray-400 px-4 py-2">Título</th>
          <th class="border border-gray-400 px-4 py-2">Imagem</th>
          <th class="border border-gray-400 px-4 py-2">Sinopse:breve descrição:</th>
          <th class="border border-gray-400 px-4 py-2">Conteúdo:</th>
          <th class="border border-gray-400 px-4 py-2">Categoria:</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = pg_fetch_assoc($result)) : ?>
          <tr>
            <td class="border border-gray-400 px-4 py-2"><?php echo $row['titulo'] ?></td>
            <td class="border border-gray-400 px-4 py-2"><?php echo $row['imagem'] ?></td>
            <td class="border border-gray-400 px-4 py-2"><?php echo $row['sinopse'] ?></td>
            <td class="border border-gray-400 px-4 py-2"><?php echo $row['conteudo'] ?></td>
            <td class="border border-gray-400 px-4 py-2"><?php echo $row['categoria[]'] ?></td>
            <td class="border border-gray-400 px-4 py-2">
              <a href="#" class="text-blue-500 hover:text-blue-700 px-2">Editar</a>
              <a href="#" class="text-red-500 hover:text-red-700 px-2">Deletar</a>
            </td>
          </tr>
        <?php endwhile; ?>

      </tbody>
    </table>
  </div>
</body>

</html>