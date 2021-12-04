<?php
require_once '../../components/main.php';
require_once '../../components/mysql.php';

echo $head;
echo '<link rel="stylesheet" href="../../styles.css">';
echo $body; ?>


<main>
  <h1>User Posts</h1> <?php

  $prepared_posts = $mysql->prepare('SELECT id, content FROM post WHERE user_id=?');
  $id = NULL;
  $content = NULL;

  $error = FALSE;
  if($prepared_posts === FALSE)
    $error = 'Failed to create a query';
  else if($prepared_posts->bind_param('i', $_GET['id']) === FALSE)
    $error = 'Failed to bind parameters';
  else if($prepared_posts->execute() === FALSE)
    $error = 'Failed to execute query';
  else if($prepared_posts->bind_result($id, $content) === FALSE)
    $error = 'Failed to bind result';

  if($error !== FALSE)
    exit($error);

  while ($prepared_posts->fetch()){ ?>
    <article>
      <h1>Post:</h1>
      <p><?=$content?></h2>
      <br>
      <a href="../post/delete/?id=<?=$id?>">Remove post</a>
    </article> <?php
  } ?>

</main> <?php

echo $footer;
