<?php
require "common/database.php";
require "common/response.php";

$response = new Response();

try {
    $items = $mysql->query("SELECT * FROM Product");
} catch (Exception $e) {
    $response->error("Database error: " . $e->getMessage());
    die;
}

$response->send($items);

$mysql->close();
