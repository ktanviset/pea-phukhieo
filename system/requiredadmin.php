<?php
  if (SC::get('role') != 'admin') {
    Util::redirect('begin.php');
  }
?>