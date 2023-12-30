<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../vendor/autoload.php';

$database = new App\Database();
$db = $database->getConnection();

$country = new App\Countries($db);

$data = json_decode(file_get_contents("php://input"));

$country->id = $data->id;

if($country->delete()){
    http_response_code(200);
    echo json_encode(array("message" => "Country was deleted."));
}
else{
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete country."));
}
?>