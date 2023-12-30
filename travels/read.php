<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../vendor/autoload.php';

$database = new App\Database();
$db = $database->getConnection();
$travels = new App\Travels($db);

// Ottenere i parametri di query dalla richiesta GET
$country_searched = isset($_GET['country_searched']) ? $_GET['country_searched'] : '';
$seats_available_searched = isset($_GET['seats_available_searched']) ? $_GET['seats_available_searched'] : '';

// Modificare la query in base ai parametri forniti
$stmt = ($country_searched || $seats_available_searched) ? $travels->searchByCountryAndBySeatsAvailable($country_searched, $seats_available_searched) : $travels->read();

$num = $stmt->rowCount();

if ($num > 0) {
    $travels_arr = array();
    $travels_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $travels_item = array(
            "id" => $id,
            "country" => $country,
            "seats_available" => $seats_available
        );
        array_push($travels_arr["records"], $travels_item);
    }

    http_response_code(200);
    echo json_encode($travels_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No travels found.")
    );
}
?>
