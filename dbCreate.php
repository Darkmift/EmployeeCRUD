<?php

//host of SQL:
$host = "localhost";
//sql user:
$root = "root";
//sql user pw:
$root_password = "root12";
//DB to conect/create:
$db = "employees";
$table = "employees";
//set flag for DB operations...true if DB and table are ready for work
$dbOk = false;
$conn = new PDO(
    "mysql:host=$host",
    $root,
    $root_password,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);
//check if connection ok
if ($conn === false) {
    die(json_encode(
        array(
            $conn->errorInfo(),
            $conn->errorCode(),
        ),
        true)
    );
}

//create db if not exists
$conn->exec("CREATE DATABASE  IF NOT EXISTS `$db`;");

//check if created succesfully
$db_check = $conn->query("SHOW DATABASES like '$db'");
if ($db_check->rowCount() > 0) {
    // CREATED
    //echo '$db exists';
    $conn->exec("CREATE TABLE IF NOT EXISTS `employees`.`employees`(
                           `id` INT(9) NOT NULL,
                           `name` VARCHAR(100) NOT NULL,
                           `recruitment_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                           UNIQUE(`id`)
                       ) ENGINE = InnoDB;");
    $table_check = $conn->query("SHOW DATABASES like '$db'");
    if ($table_check->rowCount() > 0) {
        // CREATED
        //echo '$table exists';
        $dbOk = true;
    } else {
        //echo '$table not exists';
        die(array("error" => "fatal error creating DB: $table"));
    }
} else {
    //echo 'not exists';
    //create db if not exists
    die(array("error" => "fatal error creating $table in $db"));
}

// echo $dbOk;
