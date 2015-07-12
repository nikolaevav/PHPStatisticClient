<?php

// Подключаемся к базе
$sqlConnection = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);

// Проверяем есть ли таблица статистики в нашей базе: Если нет - создаем
$chechQuery = "SELECT id FROM statistic";
$chechResult = mysql_query($chechQuery);

if(empty($chechResult)) {
  $newTable = "CREATE TABLE IF NOT EXISTS `statistic` (
                `id` int(6) NOT NULL AUTO_INCREMENT,
                `key` varchar(255) NOT NULL,
                `filename` varchar(255) NOT NULL,
                `authorname` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

  mysql_query($newTable);
  // echo "Create Table";

}