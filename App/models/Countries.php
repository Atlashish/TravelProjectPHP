<?php

namespace App\Models;

use Core\App;
use Core\Response;
use PDO;

class Countries
{
    private static $table_name = "countries";

    // Function to retrieve all countries from the database
    public static function readAll()
    {
        $statement = App::get('database')::query(
            "SELECT * FROM " . self::$table_name);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // Function to retrieve a single country by ID from the database
    public static function read($id)
    {
        $statement = App::get('database')::query(
            "SELECT * FROM " . self::$table_name . " WHERE id = :id",
            ['id' => $id]);
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    // Function to create a new country in the database
    public static function create($data)
    {
        try{
            $statement = App::get('database')::query(
                "INSERT INTO " . self::$table_name . " SET name = :name",
                [
                    'name' => $data['name']
                ]);
        } catch (\Exception $e){
            Response::get(500, $e->getMessage());
        }

        if ($statement->rowCount() > 0) {
            return App::get('database')::$connection->lastInsertId();
        }
        return false;
    }

    // Function to update an existing country in the database
    public static function update($currentData, $newData)
    {
        try{
            $statement = App::get('database')::query(
                "UPDATE " . self::$table_name . " SET name = :name WHERE id = :id",
                [
                    'name' => $newData['name'],
                    'id' => $currentData['id']
                ]);
        } catch (\Exception $e){
            Response::get(500, $e->getMessage());
        }
        return $statement && $statement->rowCount() > 0;
    }

    // Function to delete an existing country from the database by ID
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
