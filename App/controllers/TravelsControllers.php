<?php
//  The above class is a PHP controller class for managing CRUD operations on a Travels model.  

namespace App\controllers;

use App\Models\Travels;
use Core\Response;

class TravelsControllers
{
    private $data;

    // The constructor is used to get the data from the HTTP request.
    public function __construct()
    {
        $this->data = json_decode(file_get_contents('php://input'), true);
    }

    // Function to retrieve all travels
    public function readAll()
{
    $country = $_GET['country'] ?? null;
    $seatsAvailable = $_GET['seats_available'] ?? null;

    if ($country !== null || $seatsAvailable !== null) {
        Response::get(200, Travels::search($country, $seatsAvailable));
    } else {
        Response::get(200, Travels::readAll());
    }
}

    // Function to retrieve a single travel by ID
    public function read()
    {
        $id = $_GET['id'];
        $statement = Travels::read($id);
        if (!$statement) {
            Response::get(404, "No travels found");
        }
        Response::get(200, $statement);
    }

    // Function to create a new travel
    public function create()
    {
        $newTravel = $this->data;
        if (!empty($newTravel)) {
            $statement = Travels::create($newTravel);
            Response::get(201, ["New travel has been added with ID: {$statement}" => $newTravel]);
        } else {
            Response::get(400, "The body request is not correct, please try again");
        }
    }

    // Function to update an existing travel
    public function update()
    {
        $id = $_GET['id'];
        $newTravel = $this->data;
        $currentTravel = Travels::read($id);

        if(!empty($newTravel)){
            Travels::update($currentTravel, $newTravel);
            Response::get(200, "Travel has been updated");
        } else {
            Response::get(400, "The body request is not correct, please try again");
        }
    }

    // Function to delete an existing travel
    public function delete()
    {
        $id = $_GET['id'];
        $statement = Travels::delete($id);
        if (!$statement) {
            Response::get(404, "No travels found");
        }
        Response::get(200, "Travel has been deleted");
    }
}