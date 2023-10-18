<?php
while ($rowComentario = pg_fetch_assoc($resultComentario)) : ?>
  <div class="content rounded-2xl bg-pink-100 my-5 p-5">
    <div class="content rounded-2xl bg-pink-100 my-5 p-5" style="border: 2px blue solid;">
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <img src="caminho/para/imagem.jpg" class="w-8 h-8 rounded-full mr-2">
          <p class="font-itim">@<?php echo $rowComentario['nm_usuario'] ?></p>
        </div>
        <p class="font-itim"><?php echo $rowComentario['created_at'] ?></p>
      </div>
      <p class="font-itim">
        <?php echo $rowComentario['comentario'] ?>
      </p>
      <form method="POST">
        <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
        <input type="hidden" name="id_post" value="<?php echo $row['id_post']; ?>">
        <input type="hidden" name="id_comentario" value="<?php echo $row['id_comentario']; ?>">
        <textarea name="resposta" id="resposta" class="block w-full rounded-md bg-white placeholder-gray-300 h-20 resize-none" placeholder="Sério? acho que..."></textarea>
        <button name="submitResposta" class=" my-3 bg-pink-500 hover:bg-pink-600 text-white py-1 px-2 rounded">Responder</button>


      </form>
      <p class="font-itim">@<?php echo $rowComentario['nm_usuario'] ?></p>
      <!-- ... outras informações de comentário ... -->

      <!-- Laço para exibir as respostas -->
      <?php
      $id_comentario = $rowComentario['id_comentario'];
      $sqlResposta = "SELECT r.*, u.nm_usuario, r.updated_at as resposta_updated_at 
                   FROM tb_resposta r 
                   JOIN tb_usuario u ON r.id_usuario = u.id_usuario 
                   WHERE r.id_comentario = $id_comentario";
      $resultRespostas = pg_query($conn, $sqlResposta);

      while ($rowResposta = pg_fetch_assoc($resultRespostas)) :
      ?>
        <div class="content rounded-2xl bg-pink-200 ml-8 p-5 my-4">
          <div class="content rounded-2xl bg-pink-200 ml-8 p-5 my-4" style="border: 2px blue solid;">
            <div class="flex justify-between items-center">
              <div class="flex items-center">
                <img src="caminho/para/imagem.jpg" class="w-8 h-8 rounded-full mr-2">
                <p class="font-itim">@<?php echo $row['nm_usuario'] ?></p>
              </div>
              <p class="font-itim"><?php echo $row['created_at'] ?></p>
            </div>
            <p class="font-itim">
              <?php echo $row['resposta'] ?>
            </p>
            <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
            <input type="hidden" name="id_comentario" value="<?php echo $row['id_comentario']; ?>">
          </div>
          <p class="font-itim">@<?php echo $rowResposta['nm_usuario'] ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endwhile; ?>