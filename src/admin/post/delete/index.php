<?php
require_once '../../../components/main.php';
require_once '../../../components/mysql.php';

$prepared_post = $mysql->prepare('DELETE FROM post WHERE id=?');
$id = NULL;
$content = NULL;

$error = FALSE;
if($prepared_post === FALSE)
  $error = 'Failed to create a query';
else if($prepared_post->bind_param('i', $_GET['id']) === FALSE)
  $error = 'Failed to bind parameters';
else if($prepared_post->execute() === FALSE)
  $error = 'Failed to execute query';

if($error !== FALSE)
  exit($error);

header('Location: ../../../');
