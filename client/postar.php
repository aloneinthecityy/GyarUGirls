<?php
include '../server/config.php';

session_start();
if (!isset($_SESSION['id_usuario'])) {
  header('Location: ./404.php');
  exit();
}

$message = '';
$messageErro = '';

function sanitize($input)
{
  global $conn, $messageErro, $message;
  $input = trim($input);
  $input = strip_tags($input);
  $input = htmlspecialchars($input);
  $input = pg_escape_string($conn, $input);
  return $input;
}

function uploadImagem($imagem)
{
  global $message, $messageErro;
  if ($imagem['error'] != 0) {
    $messageErro = 'Erro ao fazer upload da imagem';
    exit;
  }

  if ($imagem['size'] > 2097152) {
    $messageErro = 'Tamanho de imagem excedido. Tamanho máximo de 2MB!';
    exit;
  }

  $pasta = './images/post_usuario/';
  $nomeDoArquivo = $imagem['name'];
  $novoNome = uniqid();
  $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

  if (!in_array($extensao, array('jpg', 'png', 'gif', 'jpeg'))) {
    $messageErro = 'Formato de imagem inválido. Por favor, envie uma imagem no formato JPG, PNG ou GIF';
    exit;
  }

  $patch = $pasta . $novoNome . '.' . $extensao;
  $verificaEnvioDoArquivo = move_uploaded_file($imagem['tmp_name'], $patch);
  if ($verificaEnvioDoArquivo == false) {
    $messageErro = 'Erro ao fazer upload da imagem';
    exit;
  } else {
    $message = 'Imagem enviada com sucesso, clique aqui para visualizar a imagem <a href= "./images/post_usuario/' . $novoNome . '.' . $extensao . '">Clique aqui</a>';
    return $patch;
  }
}

if (isset($_POST['submit'])) {
  $conteudo = sanitize($_POST['conteudo']);
  $imagem = $_FILES['imagem'];

  if (empty($conteudo) && empty($imagem["name"])) {
    $messageErro = 'Preencha pelo menos um dos campos (Conteúdo ou Imagem)!';
  } else {
    if ($imagem['error'] == 0) {
      $imagem = uploadImagem($imagem);
    } else {
      $imagem = null;
    }

    $id_usuario = $_SESSION['id_usuario'];

    $sql = "INSERT INTO tb_post_usuario (id_usuario, imagem, conteudo) VALUES ($1, $2, $3)";
    $result = pg_query_params(
      $conn,
      $sql,
      array($id_usuario, $imagem, $conteudo)
    );

    if (!$result) {
      $messageErro = 'Erro ao salvar o post no banco de dados: ' . pg_last_error($conn);
    } else {
      $message = 'Post criado com sucesso!';
    }
  }
}

if (isset($_POST['apagar'])) {

  $id_post_usuario = sanitize($_POST['id_post_usuario']);

  $sql = "DELETE FROM tb_post_usuario WHERE id_post_usuario = $1";
  $result = pg_query_params(
    $conn,
    $sql,
    array($id_post_usuario)
  );

  if (!$result) {
    $messageErro = 'Erro ao apagar o post no banco de dados: ' . pg_last_error($conn);
  } else {
    $message = 'Post apagado com sucesso!';
  }
}



$sql = "SELECT * FROM tb_post_usuario WHERE id_usuario = $1 ORDER BY created_at DESC";
$result = pg_query_params($conn, $sql, array($_SESSION['id_usuario']));

$sqlUsuario = "SELECT * FROM tb_usuario where id_usuario = $1";
$resultUsuario = pg_query_params($conn, $sqlUsuario, array($_SESSION['id_usuario']));

pg_close($conn);
?>




<!-- FRONT-END -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postar | GyaruGirls</title>

  <!-- Dependências de estilo -->
  <?php include_once './css/index.php'; ?>
</head>

<body class="bg-pink-100">
  <!--CABEÇALHO-->
  <header class="bg-gradient-to-r from-pink-200 to-pink-300">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 justify-between">
        <div class="flex">
          <div class="-ml-2 mr-2 flex items-center md:hidden">
            <!-- Mobile menu button -->

          </div>
          <div class="flex flex-shrink-0 items-center">
            <img src="./images/gatito.png" class="h-10">
            <div class="hidden md:flex md:items-center md:space-x-4 ml-3">
              <a href="./feed.php" class="text-pink-600 font-bold rounded-md text-2xl font-medium">GyarUGirls</a>
            </div>
          </div>
        </div>
        <div class="flex items-center">
          <div class="hidden md:ml-4 md:flex md:flex-shrink-0 md:items-center">

            <!-- Profile dropdown -->
            <?php $row = pg_fetch_assoc($resultUsuario) ?>
            <div class="relative ml-3">
              <div>
                <button type="button" id="user-menu-button" class="relative flex rounded-full bg-pink-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-pink-600" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                  <span class="absolute -inset-1.5"></span>
                  <span class="sr-only">Open user menu</span>
                  <img class="h-8 w-8 rounded-full" src="<?php echo $row['imagem_perfil'] ?>" width="20%">
                </button>
              </div>
              <!--dropdown menu-->
              <div id="profile-dropdown" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                <!-- Active: "bg-gray-100", Not Active: "" -->
                <a href="./meuPerfil.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Meu perfil</a>
                <a href="./configuracoes.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Configurações</a>
                <form action="./logout.php" method="POST">
                  <button name="submit" class="block px-4 py-2 text-sm text-gray-700" id="user-menu-item-2">Logout</button>
                </form>
              </div>
            </div>
            <php? ?>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="md:hidden" id="mobile-menu">
      <div class="border-t border-pink-600 pb-3 pt-4">
        <div class="flex items-center px-5 sm:px-6">
          <div class="flex-shrink-0">
            <img class="h-8 w-8 rounded-full" src="<?php echo $row['imagem_perfil'] ?>" width="20%">
          </div>
          <div class="ml-3">
            <div class="text-base font-medium text-pink-800">@<?php echo $_SESSION['nm_usuario'] ?></div>
            <div class="text-sm font-medium text-pink-600"><a href="./perfil.php">Meu perfil</a></div>
            <div class="text-sm font-medium text-pink-600"><a href="./configuracoes.php">Configurações</a></div>
            <form action="./logout.php" method="POST">
              <button name="submit" class="text-sm font-medium text-pink-600" id="user-menu-item-2">Logout</button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </header>

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

  <div class="container mx-auto px-4 mt-6">
    <h1 class="text-2xl font-bold mb-4">Criação de posts</h1>


    <!-- Formulário de criação -->
    <form method="POST" enctype="multipart/form-data" class="mb-8">

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="conteudo">
          Conteúdo do post:
        </label>
        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="conteudo" name="conteudo"></textarea>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="imagem">
          Imagem:
        </label>
        <input id="imagem" type="file" name="imagem">
      </div>

      <div class="flex items-center justify-between">
        <button name="submit" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Postar
        </button>
      </div>
    </form>
  </div>

  <!-- Tabela exibindo os posts do usuário -->
  <table class="w-full border-collapse mb-8">
    <thead>
      <tr>
        <th class="border border-gray-400 px-4 py-2">Conteúdo</th>
        <th class="border border-gray-400 px-4 py-2">Imagem</th>
        <th class="border border-gray-400 px-4 py-2">Postado em:</th>
        <th class="border border-gray-400 px-4 py-2">Apagar?</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = pg_fetch_assoc($result)) : ?>
        <tr>
          <td class="border border-gray-400 px-4 py-2"><?php echo $row['conteudo'] ?></td>
          <td class="border border-gray-400 px-4 py-2"><img src="<?php echo $row['imagem'] ?>" width="15%"></td>
          <td class="border border-gray-400 px-4 py-2"><?php echo $row['created_at'] ?></td>
          <td class="border border-gray-400 px-4 py-2">
            <form method="POST">
              <input type="hidden" name="id_post_usuario" value="<?php echo $row['id_post_usuario'] ?>">
              <button type="submit" name="apagar" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Apagar!
              </button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>

    </tbody>
  </table>

  <!-- LÓGICA DO BOTÃO -->
  <script>
    // Obtém o botão do perfil
    const profileButton = document.getElementById('user-menu-button');

    // Obtém o elemento de dropdown do perfil
    const profileDropdown = document.getElementById('profile-dropdown');

    // Define uma variável de estado para controlar se o menu dropdown está visível ou oculto
    let isProfileDropdownVisible = false;

    // Adiciona um evento de clique ao botão do perfil
    profileButton.addEventListener('click', function(event) {
      // Impede que o evento de clique se propague para o documento
      event.stopPropagation();

      // Alterna o estado da variável de estado do menu dropdown
      isProfileDropdownVisible = !isProfileDropdownVisible;

      // Mostra ou oculta o elemento de dropdown do perfil com base no estado da variável de estado
      if (isProfileDropdownVisible) {
        profileDropdown.classList.remove('hidden');
      } else {
        profileDropdown.classList.add('hidden');
      }
    });

    document.addEventListener('click', function(event) {
      // Oculta o elemento de dropdown do perfil se o usuário clicar fora do menu
      if (!event.target.closest('#profile-dropdown') && !event.target.closest('#user-menu-button')) {

        // Define o estado da variável de estado do menu dropdown como oculto
        isProfileDropdownVisible = false;

        // Oculta o elemento de dropdown do perfil
        profileDropdown.classList.add('hidden');
      }
    });
  </script>
</body>

</html>