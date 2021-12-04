<?php
require_once './components/main.php';
require_once './components/mysql.php';

echo $head;
echo $body; ?>

<main>
  <h1>Blog</h1>
  <nav>
    <li><a href="./user/new">Create User</a></li>
    <li><a href="./post/new">Create Post</a></li>
    <li><a href="./admin/">Admin Area</a></li>
  </nav> <?php

  $query_posts = $mysql->query('SELECT p.content, u.username FROM post p INNER JOIN user u ON u.id=p.user_id');

  while ($row = $query_posts->fetch_assoc()){ ?>
    <article>
      <h2>Post by <?=$row['username']?>:</h2>
      <p><?=$row['content']?></h2>
    </article> <?php
  } ?>

</main> <?php


echo $footer;
