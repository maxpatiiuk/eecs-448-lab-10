<?php

$mysql = new mysqli('HOSTNAME','USER','PASSWORD','DATABASE'

if ($mysql->connect_errno)
  exit("Connect failed: %s\n");
