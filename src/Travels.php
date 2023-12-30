<?php

namespace App;

class Travels{

    private $conn;
    private $table_name = "travels";
    public $id;
    public $country;
    public $seats_available;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){

        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create(){

        $query = "INSERT INTO " . $this->table_name . " SET country = :country, seats_available = :seats_available";

        $stmt = $this->conn->prepare($query);

        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->seats_available=htmlspecialchars(strip_tags($this->seats_available));

        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":seats_available", $this->seats_available);

        if($stmt->execute()){
            return true;
        }

        return false;

    }

    public function update(){

        $query = "UPDATE " . $this->table_name . "
        SET
        country = :country,
        seats_available = :seats_available
        WHERE
        id = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->country = htmlspecialchars(strip_tags($this->country));
        $this->seats_available=htmlspecialchars(strip_tags($this->seats_available));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":seats_available", $this->seats_available);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);
        

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function searchByCountryAndBySeatsAvailable($country_searched, $seats_available_searched){
        $query = "SELECT * FROM travels WHERE country LIKE :country AND seats_available >= :seats_available";

        $stmt = $this->conn->prepare($query);
        $country_searched = "%{$country_searched}%";
        $stmt->bindParam(':country', $country_searched, \PDO::PARAM_STR);
        $stmt->bindParam(':seats_available', $seats_available_searched, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

}