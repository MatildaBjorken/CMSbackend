<?php

declare(strict_types=1);
//connects database och gets data, all info from the database

class Database {

    // database parameters (private vars can only be accessed within class)

    //Declare properties without assigning values, Easier if that is changed
    private array $options;
    private $username;
    private $password;
    private $host;
    private $db;

    // database connection object
    private PDO $conn;

    //DB to connect
    //init the database with our env variables (you can't set functions as properties by default so I used a constructor.
    //In a constructor, what you write will run in the beginning
    //__construct =  make sure that parameters are defined, or actions are made when created
    //automaticly updates the properties, Instantiate an object from a class
    //Assign the values here

    //get-env var , store variables as database creds so that others cant access them
    public function __construct() {
        $this->options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // this is if we get an error message
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::MYSQL_ATTR_SSL_CA => getenv('MYSQL_SSL_CA'),
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            PDO::MYSQL_ATTR_SSL_KEY => getenv('MYSQL_SSL_KEY'),
            PDO::MYSQL_ATTR_SSL_CERT => getenv('MYSQL_SSL_CERT'),
        );

        $this->username = getenv('MYSQL_USERNAME');
        $this->password = getenv('MYSQL_PASSWORD');
        $this->host = getenv('MYSQL_HOST');
        $this->db = getenv('MYSQL_DATABASE');
    }

    public function getConnection(): PDO {

        //What if we get an error message - use try and catch and trow an exception
        try { // create a connection, passing in the database parameters, dsn =  database type and host, all that is needed to connect
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->db", $this->username, $this->password, $this->options);
        } catch (PDOException $exception) {
            echo "Something went wrong. Here's what: " . $exception->getMessage(); // show the error message, method
        }

        return $this->conn; // returns the PDO connection object
    }
}


//pdo execption
