<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../vendor/autoload.php';

$database = new App\Database();

$db = $database->getConnection();

$travel = new App\Travels($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->country) && !empty($data->seats_available)){
    $travel->country = $data->country;
    $travel->seats_available = $data->seats_available;

    if($travel->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Travel was created."));
    }
    else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create travel."));
    }
}



