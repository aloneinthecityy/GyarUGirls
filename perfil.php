<?php
include './server/config.php';
session_start();
$id_usuario = $_SESSION['id_usuario'];

$sqlUsuario = "SELECT * FROM tb_usuario WHERE id_usuario = $id_usuario";
$resultUsuario = pg_query($conn, $sqlUsuario);

$sql = "SELECT * FROM tb_post_usuario WHERE id_usuario = $id_usuario ORDER BY created_at DESC";
$result = pg_query($conn, $sql);
?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $_SESSION['nm_usuario']  ?></title>


  <!-- Dependências de estilo -->
  <?php include_once './client/css/index.php'; ?>
</head>

<body class="bg-cover" style="background-image: url(./client/images/fundoPerfil.jpg)">
  <!--CABEÇALHO-->
  <header class="bg-black">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 justify-between">
        <div class="flex">
          <div class="-ml-2 mr-2 flex items-center md:hidden">
            <!-- Mobile menu button -->

          </div>
          <div class="flex flex-shrink-0 items-center">
            <img src="./client/images/gatito.png" class="h-10">
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
                <a href="./perfil.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Meu perfil</a>
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




  <div class="wrapper">

    <!-- <h1>SECTION DO PERFIL E POSTS</h1> -->
    <section class="mx-48 my-14 py-14 font-itim bg-zinc-700 rounded-2xl text-white">
      <div class="grid grid-cols-1 justify-center">
        <div class="flex flex-col items-center justify-center px-20 text-center">
          <img src="<?php echo $row['imagem_perfil'] ?>" class="rounded-full" width="40%">
          <br>
          <h1 class="text-4xl font-bold"><?php echo $_SESSION['nm_usuario'] ?></h1>
          <br>
          <?php if (isset($row['cargo'])) : ?>
            <div class="inline-block bg-yellow-300 p-2 rounded">
              <h2 class="text-2xl"><?php echo $row['cargo'] ?></h2>
            </div>
            <br>
          <?php endif; ?>

          <?php if (isset($row['bio'])) : ?>
            <p class="text-xl"><?php echo $row['bio'] ?></p>
          <?php endif; ?>
        </div>

        <div class="flex justify-center space-x-4 mt-8">
          <a href="#posts" class="text-lg font-semibold text-blue-500 hover:text-blue-700">Posts</a>
          <a href="#mural" class="text-lg font-semibold text-blue-500 hover:text-blue-700">Mural</a>
          <a href="#posts-salvos" class="text-lg font-semibold text-blue-500 hover:text-blue-700">Posts Salvos</a>
        </div>

        <div class="justify-center bg-zinc-400 m-28 rounded-xl text-black">
          <?php while ($row = pg_fetch_assoc($result)) : ?>
            <div class="content rounded-2xl px-42">
              <div class="content rounded-2xl mx-18">
                <div class="flex justify-between">
                  <p class="font-bold text-lg"><?php echo $_SESSION['nm_usuario'] ?></p>
                  <p class="font bold"><?php echo $row['created_at'] ?></p>
                </div>
                <div class="justify-content-center text-left">
                  <?php echo $row['conteudo'] ?>
                </div>
                <article class="article text-justify">
                  <br>
                  <p>
                    <img src="<?php echo $row['imagem'] ?>" class="mx-auto" width="80%" style="border-radius: 3%;">
                  </p>
                </article>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </section>
  </div>

  <!-- PAGINAÇÃO -->
  <?php
  // Define o número de resultados por página
  $results_per_page = 3;

  // Consulta SQL para obter o número total de resultados
  $sql = "SELECT COUNT(*) AS total FROM tb_post;";
  $result = pg_query($conn, $sql);
  $row = pg_fetch_assoc($result);
  $total_results = $row['total'];

  // Calcula o número total de páginas
  $total_pages = ceil($total_results / $results_per_page);

  // Obtém o número da página atual a partir do parâmetro GET
  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

  // Exibe os links de página
  echo '<nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">';
  echo '<div class="-mt-px mx-12 flex w-0 flex-1">';
  if ($current_page > 1) {
    echo '<a href="./feed.php?page=' . ($current_page - 1) . '" class="inline-flex items-center border-t-2 border-transparent pr-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
        <svg class="mr-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z" clip-rule="evenodd" />
        </svg>
        Previous
      </a>';
  } else {
    echo '<span class="inline-flex items-center border-t-2 border-transparent pr-1 pt-4 text-sm font-medium text-gray-500">
        <svg class="mr-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z" clip-rule="evenodd" />
        </svg>
        Previous
      </span>';
  }
  echo '</div>';
  echo '<div class="hidden md:-mt-px md:flex">';
  for ($i = 1; $i <= $total_pages; $i++) {
    if ($i == $current_page) {
      echo '<a href="./feed.php?page=' . $i . '" class="inline-flex items-center border-t-2 border-indigo-500 px-4 pt-4 text-sm font-medium text-indigo-600" aria-current="page">
          ' . $i . '</a>';
    } else {
      echo '<a href="./feed.php?page=' . $i . '" class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">' . $i . '</a>';
    }
  }
  echo '</div>';
  echo '<div class="-mt-px mx-12 flex w-0 flex-1 justify-end">';
  if ($current_page < $total_pages) {
    echo '<a href="./feed.php?page=' . ($current_page + 1) . '" class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
      Next
      <svg class="ml-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z" clip-rule="evenodd" />
      </svg>
    </a>';
  } else {
    echo '<span class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500">
      Next
      <svg class="ml-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z" clip-rule="evenodd" />
      </svg>
    </span>';
  }
  echo '</div>';
  echo '</nav>';
  echo '<br>'
  ?>



  <!-- RODAPÉ -->
  <footer class="bg-black">
    <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
      <div class="flex justify-center space-x-6 md:order-2">
        <a href="#" class="text-pink-600 hover:text-pink-700">
          <span class="sr-only">Facebook</span>
          <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
          </svg>
        </a>
        <a href="#" class="text-pink-600 hover:text-pink-700">
          <span class="sr-only">Instagram</span>
          <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
          </svg>
        </a>
        <a href="#" class="text-pink-600 hover:text-pink-700">
          <span class="sr-only">Twitter</span>
          <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
          </svg>
        </a>
        <a href="#" class="text-pink-600 hover:text-pink-700">
          <span class="sr-only">GitHub</span>
          <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
          </svg>
        </a>
        <a href="#" class="text-pink-600 hover:text-pink-700">
          <span class="sr-only">YouTube</span>
          <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" />
          </svg>
        </a>
      </div>
      <div class="mt-8 md:order-1 md:mt-0">
        <p class="text-center text-xs leading-5 text-pink-700">&copy; 2023 GyarUGirls. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>

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