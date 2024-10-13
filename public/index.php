<?php declare(strict_types=1);

require './PDOConnection.php';

function dd($var): void {
    echo '<pre>';
    print_r($var);
    echo '<pre>';
    die;
}

function parseClientId(string $clientIdsFromQuery): array {
    $clientIds = explode(',', $clientIdsFromQuery);
    if ($clientIds) {
        return array_map('intval', $clientIds);
    }
    return [];

}

function getClientOrders(array $clients): array {
    $pdo = PDOConnection::getInstance();
    $placeholders = implode(',', array_map(function ($idx) {
        return ":id$idx";
    }, array_keys($clients)));
    $stmt = $pdo->prepare("
        SELECT * FROM user_order uo
        INNER JOIN products p ON p.id = uo.product_id 
        WHERE uo.user_id IN ($placeholders)
        ORDER BY p.title, p.price DESC
    ");
    foreach ($clients as $idx => $clientId) {
        $stmt->bindParam(":id$idx", $clients[$idx], PDO::PARAM_INT);
    }
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


if (!empty($_GET['client_ids'])) {
    $clientIds = parseClientId($_GET['client_ids']);
    if (!$clientIds) return;
    $orders = getClientOrders($clientIds);
    header('Content-Type: application/json');
    echo json_encode($orders);
}
