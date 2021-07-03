<?php
require "common/database.php";
require "common/request.php";
require "common/response.php";

$request = new Request();
$response = new Response();

try {
    $params = $request->getBodyParams(["id", "name", "description", "price"]);
} catch (Exception $e) {
    $response->error($e->getMessage(), 400);
    die;
}

try {
    $mysql
        ->prepare("UPDATE Product SET name=?, description=?, price=? WHERE id=?")
        ->run([
            $params["name"],
            $params["description"],
            $params["price"],
            $params["id"]
        ]);
} catch (Exception $e) {
    $response->error("Database error: " . $e->getMessage());
    die;
}

$response->send();

$mysql->close();
