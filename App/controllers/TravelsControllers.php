<?php

namespace App\controllers;

use App\Models\Travels;
use Core\Response;

class TravelsControllers
{
    private $data;

    public function __construct()
    {
        $this->data = json_decode(file_get_contents('php://input'), true);
    }

    public function readAll()
{
    $statement = Travels::readAll();
    if (!empty($statement)) {
        Response::get(200, $statement);
    } else {
        Response::get(404, "No travels found");
    }
}

    public function read()
    {
        $id = $_GET['id'];
        $statement = Travels::read($id);
        if (!$statement) {
            Response::get(404, "No travels found");
        }
        Response::get(200, $statement);
    }

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