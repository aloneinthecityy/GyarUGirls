<!-- LÓGICA EM PHP -->
<?php
include '../server/config.php';

session_start();

if (!isset($_SESSION['id_usuario'])) {
  header('Location: login.php');
  exit();
}

$message = '';
$messageErro = '';

function sanitize($input)
{
  $input = trim($input);
  $input = strip_tags($input);
  $input = htmlspecialchars($input);
  return $input;
}

$id_post = isset($_POST['id_post']) ? $_POST['id_post'] : null;
$sql = "SELECT * FROM tb_post WHERE id_post = $1";
$result = pg_query_params($conn, $sql, array($id_post));
$post = pg_fetch_assoc($result);
var_dump($id_post);


if (isset($_POST['submit'])) {
  $imagem = isset($_FILES['imagem']) ? $_FILES['imagem'] : '';
  $titulo = isset($_POST['titulo']) ? sanitize($_POST['titulo']) : '';
  $sinopse = isset($_POST['sinopse']) ? sanitize($_POST['sinopse']) : '';
  $conteudo = isset($_POST['conteudo']) ? sanitize($_POST['conteudo']) : '';
  $id_categoria = isset($_POST['categoria']) ? sanitize($_POST['categoria']) : '';

  $sql = "UPDATE tb_post SET imagem = $imagem, titulo = $titulo, sinopse = $sinopse, conteudo = $conteudo, id_categoria = $id_categoria WHERE id_post = $id_post";


  if ($result) {
    $message = "Post atualizado com sucesso!";
  } else {
    $messageErro = "Não foi possível atualizar o post.";
  }
}

$id_usuario = $_SESSION['id_usuario'];
$sqlUsuario = "SELECT * FROM tb_usuario WHERE id_usuario = $id_usuario";
$resultUsuario = pg_query($conn, $sqlUsuario);

?>

<!-- FRONT-END -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criação | GyaruGirls</title>

  <!-- Dependências de estilo -->
  <?php include_once './css/index.php'; ?>
</head>

<body>
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
          <div class="flex-shrink-0">
            <a href="./postar.php">
              <button type="button" class="relative inline-flex items-center gap-x-1.5 rounded-md bg-pink-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pink-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                </svg>
                Postar
              </button>
            </a>
          </div>
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

  <div class="container mx-auto px-4 mt-6">
    <h1 class="text-2xl font-bold mb-4">Criação de posts</h1>

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

    <!-- Formulário de criação -->
    <form method="post" enctype="multipart/form-data" class="mb-8">
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="imagem">
          Imagem:
        </label>
        <img src="<?php echo $post['imagem'] ?>" alt="Imagem do post" width="20%">
        <input id="imagem" type="file" name="imagem" value="<?php echo $post['imagem'] ?>">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="titulo">
          Título:
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="titulo" type="text" name="titulo" value="<?php echo $post['titulo'] ?>">
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="sinopse">
          Breve resumo/sinopse:
        </label>
        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="sinopse" name="sinopse"><?php echo $post['sinopse'] ?></textarea>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="conteudo">
          Conteúdo do post:
        </label>
        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="conteudo" name="conteudo"><?php echo $post['conteudo'] ?></textarea>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="categoria">
          Categoria:
        </label>
        <p>Categoria escolhida anteriormente: <?php echo $post['id_categoria'] ?></p>
        <input type="radio" id="categoria1" name="categoria" value="1">
        <label for="categoria">Categoria 1</label><br>
        <input type="radio" id="categoria2" name="categoria" value="2">
        <label for="categoria">Categoria 2</label><br>
        <input type="radio" id="categoria3" name="categoria" value="3">
        <label for="categoria">Categoria 3</label><br>
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="submit">
          Alterar
        </button>
      </div>
    </form>