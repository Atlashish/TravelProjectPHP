<?php

namespace App\Models;

use Core\App;
use Core\Response;
use PDO;

class Countries
{
    private static $table_name = "countries";

    public static function readAll()
    {
        $statement = App::resolver('database')::query(
            "SELECT * FROM " . self::$table_name);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function read($id)
    {
        $statement = App::resolver('database')::query(
            "SELECT * FROM " . self::$table_name . " WHERE id = :id",
            ['id' => $id]);
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function create($data)
    {
        try{
            $statement = App::resolver('database')::query(
                "INSERT INTO " . self::$table_name . " SET name = :name",
                [
                    'name' => $data['name']
                ]);
        } catch (\Exception $e){
            Response::get(500, $e->getMessage());
        }

        if ($statement->rowCount() > 0) {
            return App::resolver('database')::$connection->lastInsertId();
        }
        return false;
    }

    public static function update($currentData, $newData)
    {
        try{
            $statement = App::resolver('database')::query(
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

    public static function delete($id)
    {
        try{
            $statement = App::resolver('database')::query(
                "DELETE FROM " . self::$table_name . " WHERE id = :id",
                ['id' => $id]);
        } catch (\Exception $e){
            Response::get(500, $e->getMessage());
        }
        return $statement && $statement->rowCount() > 0;
    }
}
