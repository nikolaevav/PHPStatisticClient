<?php

$page = 1;
if(!empty($_GET['page'])) {
  $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
  if(false === $page) {
      $page = 1;
  }
}