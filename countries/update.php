<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../vendor/autoload.php';

$database = new App\Database();
$db = $database->getConnection();

$country = new App\Countries($db);

$data = json_decode(file_get_contents("php://input"));

$country->id = $data->id;
$country->name = $data->name;

if($country->update()){
    http_response_code(200);
    echo json_encode(array("message" => "Country was updated."));
}
else{
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update country."));
}
?>