<?php
  require_once 'system/import.php';
  if (User::isLogin()) {
    User::logout();
  }
  Util::redirect('index.php');
?>