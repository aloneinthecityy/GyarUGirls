<!-- LÓGICA EM PHP -->
<?php include './server/create.php'; ?>


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
    <?php if (!empty($messageErro)) : ?>
      <div class="rounded-md bg-red-50 p-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">There were 2 errors with your submission</h3>
            <div class="mt-2 text-sm text-red-700">
              <ul role="list" class="list-disc space-y-1 pl-5">
                <php? echo $messageErro; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Mensagem de sucesso -->
    <?php if (!empty($messageErro)) : ?>
      <div class="rounded-md bg-green-50 p-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <?php echo $message; ?>
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


    <!-- Formulário de criação -->
    <form action="./create.php" method="post" enctype="multipart/form-data" class="mb-8">
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
        <input type="radio" id="categoria" name="categoria" value="1">
        <label for="categoria">Categoria 1</label><br>
        <input type="radio" id="categoria" name="categoria" value="2">
        <label for="categoria">Categoria 2</label><br>
        <input type="radio" id="categoria" name="categoria" value="3">
        <label for="categoria">Categoria 3</label><br>
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
          <th class="border border-gray-400 px-4 py-2">Sinopse/breve descrição:</th>
          <th class="border border-gray-400 px-4 py-2">Conteúdo:</th>
          <th class="border border-gray-400 px-4 py-2">Categoria:</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = pg_fetch_assoc($result)) : ?>
          <tr>
            <td class="border border-gray-400 px-4 py-2"><?php echo $row['titulo'] ?></td>
            <td class="border border-gray-400 px-4 py-2"><img src="<?php echo $row['imagem'] ?>" width="100"></td>
            <td class="border border-gray-400 px-4 py-2"><?php echo $row['sinopse'] ?></td>
            <td class="border border-gray-400 px-4 py-2"><?php echo $row['conteudo'] ?></td>
            <td class="border border-gray-400 px-4 py-2"><?php echo $row['id_categoria'] ?></td>
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