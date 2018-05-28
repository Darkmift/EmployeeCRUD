<?php
require 'dbCreate.php';
if (!$dbOk) {
    die("database $db is not available,contact site admin");
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        http_response_code(200);

        break;
    case 'POST':
        http_response_code(200);
        // var_dump($_POST['id']);
        // set parameters and execute
        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $recruitment_date = filter_var($_POST['recruitment_date'], FILTER_SANITIZE_STRING);
        try
        {
            // prepare and bind
            $stmt = $conn->prepare("INSERT INTO $db.$table (id, name,recruitment_date ) VALUES (:id,:name, :recruitment_date)");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':recruitment_date', $recruitment_date, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            //echo $e->getMessage();
            $object = new stdClass();
            $object->success = false;
            $object->error = $e->errorInfo;
            echo json_encode($object);
            die();
        }
        $stmt = $conn->prepare("SELECT * FROM $db.$table WHERE id=:id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        $object = new stdClass();
        $object->success = true;
        $object->newUser = $user;
        echo json_encode($object);
        break;
    case 'DELETE':
        http_response_code(200);
        break;
    default:
        http_response_code(400);
}
