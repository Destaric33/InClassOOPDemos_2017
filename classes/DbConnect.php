<?php

/* 
 Database Connection file
 * This is an object-oriented version of our database connection.
 * Object-oriented programming can speed up large development projects and
 * make your code reusable.
 * Class will become objects when instantiated (ie New Keyword
 * When an instance of a class comes to life (now an object) a special method is automatically called: the constructor
 * An object can also have properties (characteristics of the class) and methods (what the class can do)
 * 
 * For example a person could have the following properties
 * -FirstName
 * -LastName
 * - Address
 * etc.
 * 
 * An example method could be
 * -AddPerson ( to add a new person to the database)
 * - UpdatePerson (to update an existing person in the database)
 * - DeletePerson (to delete an existing person in the database)
 * - ShowPerson (To view an existing person in the database)
 * 
 */





// An object can be something that can hold many characteristics.
class DbConnect{
    //Create a private variable
    private $conn;
    
    function __construct()  {
        //Empty Constructor
    }
   /**
    * Establish the database connection to local database server and return the database connection handler.
    */
    function connect(){
        //1. Get the connection info
        require_once dirname($_SERVER['DOCUMENT_ROOT']).'/dbconn/2017_oop_connect.php';
        //2. Make the connection.
        $this->conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
        //3. Set error reporting level.
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //4. Return the connection resource back to calling environment.
        return $this->conn;
    }
    
}//End of class

