<?php
// The above class is a PHP controller class for managing CRUD operations on a Countries model.

namespace App\Controllers;

use App\Models\Countries;
use Core\Response;

class CountriesControllers
{
    private $data;

    // The constructor is used to get the data from the HTTP request.
    public function __construct()
    {
        $this->data = json_decode(file_get_contents('php://input'), true);
    }

    // Function to retrieve all countries
    public function readAll()
{
    $statement = Countries::readAll();
    if (!empty($statement)) {
        Response::get(200, $statement);
    } else {
        Response::get(404, "No countries found");
    }
}

    // Function to retrieve a single country by ID
    public function read()
    {
        $id = $_GET['id'];
        $statement = Countries::read($id);
        if (!$statement) {
            Response::get(404, "No countries found");
        }
        Response::get(200, $statement);
    }

    // Function to create a new country
    public function create()
    {
        $newCountry = $this->data;
        if (!empty($newCountry)) {
            $statement = Countries::create($newCountry);
            Response::get(201, ["New country has been added with ID: {$statement}" => $newCountry]);
        } else {
            Response::get(400, "The body request is not correct, please try again");
        }
    }

    // Function to update an existing country
    public function update()
    {
        $id = $_GET['id'];
        $newCountry = $this->data;
        $currentCountry = Countries::read($id);


        if (!empty($newCountry)) {
            Countries::update($currentCountry, $newCountry);
            Response::get(200, "Country has been updated");
        } else {
            Response::get(400, "The body request is not correct, please try again");
        }
    }

    // Function to delete an existing country
    public function delete()
    {
        $id = $_GET['id'];
        $statement = Countries::delete($id);
        if (!$statement) {
            Response::get(404, "ID not found");
        } else {
            Response::get(200, "Country has been deleted");
        }
    }
}
