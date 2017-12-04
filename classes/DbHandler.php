<?php

/* 
 * DbHandler.php
 * Class to handle all database operations
 * this class will have all the CRUD methods:
 * CRUD meaning below
 * C - Create
 * R - Read
 * U - Update
 * D - Delete
 */

class DbHandler{
    
    //Private variable to hold the connection
    private $conn;
    
    // Constructor object - will run automatically when class is instantiated
    function __construct() {
        //Initialize the database
        require_once dirname(__FILE__.'/DbConnect.php');
        // Open db Connection
        try{
            $db = new DbConnect();
            $this->conn =  $db->connect();
        } catch (Exception $ex) {
            $this::DbConnectError($ex->getCode());
        }
        
    }// end of constructor
    
    //Create a static function called DbConnectError
    // A Static function can be called without instantiating the class
    // In other words no need to use the new keyword
    private static function dbConnectError($code){
        switch ($code){
            case 1045:
                echo"A database access error has occured!!";
                break;
            case 2002:
                echo "A database server error has occured!";
                break;
            default:
                echo"A server error has occured!";
                break;
            
        } //end of switch
    }// End of dbConnectError Function
    /**
     * getCategoryList() Function
     * Get a list of categories for creating menu
     */
    public function getCategoryList(){
        $sql="";
        try{
            
        } catch (Exception $ex) {

        }
    }
    
}//End of class