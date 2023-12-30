<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../vendor/autoload.php';

$database = new App\Database();
$db = $database->getConnection();
$countries = new App\Countries($db);
$stmt = $countries->read();
$num = $stmt->rowCount();
if ($num > 0) {
    $countries_arr = array();
    $countries_arr["records"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $countries_item = array(
            "id" => $id,
            "name" => $name
        );
        array_push($countries_arr["records"], $countries_item);
    }
    http_response_code(200);
    echo json_encode($countries_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No countries found.")
    );
}
