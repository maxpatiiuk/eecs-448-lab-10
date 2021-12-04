<?php
require_once '../components/main.php';
require_once '../components/mysql.php';

echo $head;
echo '<link rel="stylesheet" href="../styles.css">';
echo $body; ?>

<main>
  <h1>Admin Area</h1>
  <table>
    <thead>
      <tr>
        <th scope="col">Username</th>
        <th scope="col">Post Count</th>
        <th scope="col">View Posts</th>
      </tr>
    </thead>
    <tbody> <?php

      $query_posts = $mysql->query('SELECT u.id, u.username, (SELECT COUNT(*) FROM post p WHERE p.user_id = u.id) AS \'post_count\' FROM user u;');

      while ($row = $query_posts->fetch_assoc()){ ?>
        <tr>
          <td><?=$row['username']?></td>
          <td><?=$row['post_count']?></td>
          <td><a href="./user/?id=<?=$row['id']?>">View Posts</a></td>
        </tr> <?php
      } ?>

    </tbody>
  </table>

</main> <?php


echo $footer;
