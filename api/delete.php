<?php
require "common/database.php";
require "common/request.php";
require "common/response.php";

$request = new Request();
$response = new Response();

try {
    $params = $request->getBodyParams(["id"]);
} catch (Exception $e) {
    $response->error($e->getMessage(), 400);
    die;
}

try {
    $mysql
        ->prepare("DELETE FROM Product WHERE id = ?")
        ->run([
            $params["id"]
        ]);
} catch (Exception $e) {
    $response->error("Database error: " . $e->getMessage());
    die;
}

$response
    ->status(200)
    ->send();

$mysql->close();
