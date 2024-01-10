<?php

namespace App\Models;

use Core\App;
use Core\Response;
use PDO;

class Travels
{
    private static $table_name = "travels";

    // Function to retrieve all travels from the database
    public static function readAll()
    {
        $statement = App::get('database')::query(
            "SELECT * FROM " . self::$table_name);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // Function to search for travels in the database based on country and available seats
    public static function search($country, $seatsAvailable)
{
    $params = [];
    $conditions = [];
    $query = "SELECT * FROM " . self::$table_name . " WHERE";

    if ($country !== null || $seatsAvailable !== null) {

        if ($country !== null) {
            $conditions[] = "country LIKE :country";
            $params['country'] = "%{$country}%";
        }

        if ($seatsAvailable !== null) {
            $conditions[] = "seats_available > :seats_available";
            $params['seats_available'] = $seatsAvailable;
        }

        $query .= " " . implode(" AND ", $conditions);

        $statement = App::get('database')::query($query, $params);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    } else {
        return self::readAll();
    }
}

    // Function to retrieve a single travel by ID from the database
    public static function read($id)
    {
        $statement = App::get('database')::query(
            "SELECT * FROM " . self::$table_name . " WHERE id = :id",
            ['id' => $id]);
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    // Function to create a new travel in the database
    public static function create($data)
    {
        try{
            $statement = App::get('database')::query(
                "INSERT INTO " . self::$table_name . " SET country = :country, seats_available = :seats_available",
                [
                    'country' => $data['country'],
                    'seats_available' => $data['seats_available']
                ]);
        } catch (\Exception $e){
            Response::get(500, $e->getMessage());
        }
        if($statement->rowCount() > 0){
            return App::get('database')::$connection->lastInsertId();
        }
        return false;
    }

    // Function to update an existing travel in the database
    public static function update($currentData, $newData)
    {
        try{
            $statement = App::get('database')::query(
                "UPDATE " . self::$table_name . " SET country = :country, seats_available = :seats_available WHERE id = :id",
                [
                    'country' => $newData['country'],
                    'seats_available' => $newData['seats_available'],
                    'id' => $currentData['id']
                ]);
        } catch (\Exception $e){
            Response::get(500, $e->getMessage());
        }
        return $statement && $statement->rowCount() > 0;
    }

    // Function to delete an existing travel from the database by ID
    public static function delete($id)
    {
        try{
            $statement = App::get('database')::query(
                "DELETE FROM " . self::$table_name . " WHERE id = :id",
                ['id' => $id]);
        } catch (\Exception $e){
            Response::get(500, $e->getMessage());
        }
        return $statement && $statement->rowCount() > 0;
    }
}