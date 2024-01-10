<?php
/* The Database class is a PHP class that provides a connection to a MySQL database and allows for
executing queries. */

namespace Core;

use PDO;

class Database
	{
		public static $connection;

		public function __construct($config)
		{
			$dsn = 'mysql:' . http_build_query($config, '', ';');
			try{
				self::$connection = new PDO($dsn);
			} catch (\PDOException $e){
				die($e->getMessage());
			}
		}

		public static function query($query, $params = [])
		{
			$statement = self::$connection->prepare($query);
			$statement->execute($params);
			return $statement;
		}
	}
?>