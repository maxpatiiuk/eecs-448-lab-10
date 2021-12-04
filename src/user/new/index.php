<?php

require_once '../../components/main.php';
require_once '../../components/mysql.php';

echo $head;
echo '<link rel="stylesheet" href="../../styles.css">';
echo $body;

$error = FALSE;
if(array_key_exists('submit', $_POST)){

  $prepared_check = $mysql->prepare('SELECT COUNT(*) FROM user WHERE username=?');
  $match_count = NULL;

  if($prepared_check === FALSE)
    $error = 'Failed to create a query';
  else if($prepared_check->bind_param('s', $_POST['username']) === FALSE)
    $error = 'Failed to bind parameters';
  else if($prepared_check->execute() === FALSE)
    $error = 'Failed to execute query';
  else if(($prepared_check->bind_result($match_count)) === FALSE)
    $error = 'Failed to bind result';
  else if(($prepared_check->fetch()) === FALSE)
    $error = 'Failed to fetch result';
  else if($match_count != 0)
    $error = 'Username is already taken';

  $prepared_check->close();

  if($error === FALSE){
    $prepared_create = $mysql->prepare('INSERT INTO user(username) VALUES(?)');

    if( $prepared_create === FALSE)
      $error = 'Failed to create a query.';
    else if($prepared_create->bind_param('s', $_POST['username']) === FALSE)
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
}

?>

<main>
  <h1>Create New User</h1>

  <?php if($error !== FALSE){ ?>
    <div class="alert alert-danger" role="alert">
      <h2>Error occurred:</h2>
      <?=$error?>
    </div> <?php
  } ?>

  <form method="post">
    <label>
      Username:
      <input type="text" name="username" required minlength="8">
   </label>
   <input type="submit" name="submit" value="Create">
  </form>
</main>

<?php
echo $footer;
?>
