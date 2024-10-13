<?php declare(strict_types=1);

require './debug.php';
require './PDOConnection.php';

function handleSubmitGoodForm(array $data): bool {
    $pdo = PDOConnection::getInstance();

    $sql = "INSERT INTO products (title, price) VALUES ";

    $values = [];
    foreach ($data as $key => $item) {
        $values[] = "(:title_" . $key . ", :price_" . $key . ")";
    }

    $sql .= implode(", ", $values);
    $stmt = $pdo->prepare($sql);
    
    foreach ($data as $key => $item) {
        $stmt->bindParam(":title_" . $key, $item['title'], PDO::PARAM_STR);
        $stmt->bindParam(":price_" . $key, $item['price'], PDO::PARAM_STR);
    }

    $stmt->execute();

    if ($stmt->errorInfo()[0] !== 0) {
        return false;
    }

    return true;
}

header('Content-Type: application/json');
$jsonData = file_get_contents('php://input');

if ($jsonData === false) {
    die('Error reading JSON data');
}

$data = json_decode($jsonData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON data: ' . json_last_error_msg());
}

handleSubmitGoodForm($data);