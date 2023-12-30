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
$country = new App\Countries($db);
$data = json_decode(file_get_contents("php://input"));
if(
    !empty($data->name)
){
    $country->name = $data->name;
    if($country->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Country was created."));
    } else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create country."));
    }
}
else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create country. Data is incomplete."));
}
?>

