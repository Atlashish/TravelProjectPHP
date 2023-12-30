/* The code you provided is a PHP script that handles the update of a travel record in a database. */
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

$travel = new App\Travels($db);

$data = json_decode(file_get_contents("php://input"));

$travel->id = $data->id;
$travel->country = $data->country;
$travel->seats_available = $data->seats_available;

if($travel->update()){
    http_response_code(200);
    echo json_encode(array("message" => "Travel was updated."));
}
else{
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update travel."));
}