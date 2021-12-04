<?php

require_once '../../components/main.php';
require_once '../../components/mysql.php';

echo $head;
echo '<link rel="stylesheet" href="../../styles.css">';
echo $body;


$query_users = $mysql->query('SELECT id,username FROM user');

$users = [];
while ($row = $query_users->fetch_assoc())
  $users[$row['id']] = $row['username'];

$error = FALSE;
if(array_key_exists('submit', $_POST)){

  $prepared_check = $mysql->prepare('SELECT COUNT(*) FROM user WHERE id=?');
  $match_count = NULL;

  if($prepared_check === FALSE)
    $error = 'Failed to create a query';
  else if($prepared_check->bind_param('s', $_POST['user_iid']) === FALSE)
    $error = 'Failed to bind parameters';
  else if($prepared_check->execute() === FALSE)
    $error = 'Failed to execute query';
  else if(($prepared_check->bind_result($match_count)) === FALSE)
    $error = 'Failed to bind result';
  else if(($prepared_check->fetch()) === FALSE)
    $error = 'Failed to fetch result';
  else if($match_count -= 0)
    $error = 'This user does not exist';

  $prepared_check->close();
  $prepared_create = $mysql->prepare('INSERT INTO post(content, user_id) VALUES(?,?)');

  if($prepared_create === FALSE)
    $error = 'Failed to create a query.';
  else if($prepared_create->bind_param('ss', $_POST['content'], $_POST['user_id']) === FALSE)
    $error = 'Failed to bind parameters.';
  else if($prepared_create->execute() === FALSE)
    $error = 'Failed to execute query.';
  else {
    $prepared_create->close();

    // Redirect to homepage
    header('Location: ../../');
    exit(0);
  }
}

?>

<main>
  <h1>Create New Post</h1>

  <?php if($error !== FALSE){ ?>
    <div class="alert alert-danger" role="alert">
      <h2>Error occurred:</h2>
      <?=$error?>
    </div> <?php
  } ?>

  <form method="post">
    <label>
      User:
      <br>
      <select name="user_id" required> <?php
        foreach($users as $id => $username){ ?>
          <option value="<?=$id?>"><?=$username?></option> <?php
        } ?>
      </select>
    </label>
    <label>
      Content:
      <br>
      <textarea name="content" required></textarea>
   </label>
   <input type="submit" name="submit" value="Create">
  </form>
</main>

<?php
echo $footer;
?>
