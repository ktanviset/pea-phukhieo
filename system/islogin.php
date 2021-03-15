<?php
  if (!User::isLogin()) {
    Util::redirect('index.php');
  }
?>