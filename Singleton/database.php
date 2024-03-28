<?php

class Database{

    private static Database $database;
    private static PDO $conn;
    private static string $dbname;
    private static string $username;
    private static string $password;

    private function __construct(){
        try {
            $d = self::$dbname;
            $u = self::$username;
            $p = self::$password;
            self::$conn = new PDO("sqlite:{$d}",$u,$p);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function getInstance(){
        if (!isset(self::$database)) {
            self::$database = new Database();
        }
        return self::$database;
    }

    public function query($sql){
        $statement = self::$conn->prepare($sql);
        $statement->execute();
        return $statement->fetchAll();
    }

    public static function config($filename){
        $jsonString = file_get_contents($filename);
        if ($jsonString === false){
            throw new Exception("Cannot read the file");
        }

        $data = json_decode($jsonString,true);
        self::$dbname = $data["dbname"];
        self::$password = $data["password"];
        self::$username = $data["username"];
    }

    public function getConfig(){
        return [self::$dbname,self::$username,self::$password];
    }
}
