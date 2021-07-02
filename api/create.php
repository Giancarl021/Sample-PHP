<?php
require "common/database.php";
require "common/request.php";
require "common/response.php";

$request = new Request();
$response = new Response();

try {
    $params = $request->getBodyParams(["name", "description", "price"]);
} catch (Exception $e) {
    $response->error($e->getMessage(), 400);
    die;
}

try {
    $items = $mysql
        ->prepare("INSERT INTO Product (name, description, price) VALUES (?, ?, ?)")
        ->run([
            $params["name"],
            $params["description"],
            $params["price"]
        ]);
} catch (Exception $e) {
    $response->error("Database error: " . $e->getMessage());
    die;
}

$response
    ->status(201)
    ->send();

$mysql->close();
