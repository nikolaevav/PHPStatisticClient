<?php

  function statistic_insert($filename, $author)
  {
    $query = 'INSERT INTO `statistic`(`key`, `filename`, `authorname`) VALUES ("' . md5($filename) . '","' . $filename . '","' . $author . '")';
    $result = mysql_query($query) or die("Invalid query: " . mysql_error());
    return $result;
  }

  function statistic_read($page)
  {
    $itemsPerPage = 1000;
    $offset = ($page - 1) * $itemsPerPage;

    $query = "SELECT *, count(filename) as count FROM `statistic` GROUP BY `key` LIMIT " . $offset . "," . $itemsPerPage;
    $result = mysql_query($query) or die("Invalid query: " . mysql_error());
    return $result;
  }

  function commiter_count($key)
  {
    $query = "SELECT authorname, count(filename) as count FROM `statistic` WHERE `key` = '" . $key . "' GROUP BY `authorname`";
    $result = mysql_query($query) or die("Invalid query: " . mysql_error());
    return $result;
  }