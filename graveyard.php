<?php
//chunk 1
$conn->exec("CREATE DATABASE  IF NOT EXISTS `$db`;
                -- CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                -- GRANT ALL ON `$db`.* TO '$root'@'localhost';
                -- FLUSH PRIVILEGES;
    ") or die(print_r($conn->errorInfo(), true));
