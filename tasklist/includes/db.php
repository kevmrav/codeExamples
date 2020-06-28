<?php
/*
 * Schema
 *
 CREATE TABLE `tasks` (
      `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
      `task_name` varchar(30) NOT NULL,
      `task_description` varchar(100) NOT NULL DEFAULT '',
      `target_date` date DEFAULT NULL,
      `completion_date` date DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
 */

class DB
{
    /**
     * Initiates a database connection
     *
     * @return PDO
     */
    public function dbConnect(){
        try{
            //Replace with credentials
            $connection = [
                'dbName' => DB_NAME,
                'host' => DB_HOST,
                'user' => DB_USER,
                'password' => DB_PASSWORD
            ];

            if (!$connection){
                throw new PDOException("No database connection could be set");
            }

            //Database Connection
            $conn = new PDO("mysql:host=".$connection['host'].";dbname=".$connection['dbName'].";charset=utf8", $connection['user'], $connection['password']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); //queries returned as object

        } catch(PDOException $e) {
            $this->showMsg("ERROR: {$e->getCode()} | Line: {$e->getLine()} | File: {$e->getFile()} \nMsg: {$e->getMessage()} ");
        }

        return $conn;
    }

}
