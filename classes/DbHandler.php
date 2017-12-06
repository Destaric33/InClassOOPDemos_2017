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
        $sql="SELECT id, category,Summary.total 
                FROM categories JOIN (SELECT COUNT(*) AS total, 
                                      category_id
                                      FROM pages
                                      GROUP BY category_id) AS Summary
             WHERE categories.id = Summary.category_id
             ORDER BY category";
        try{
            $stmt = $this->conn->query($sql);
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Create an array to hold the success|failure
            // Date|message
            $data = array('error'=>false,
                          'items'=>$categories);
            
        } catch (PDOException $ex) {
            $data = array ('error'=>true,
                           'message'=>$ex->getMessage()
                    );
        }// end of try catch
        // Return data back to calling enviroment
        return $data;
    }
    /**
     *  getPopularList() method
     *  Get a list of the 3 most popular articles based on history of pages visited
     * 
     */
   public function getPopularList(){
       $sql="SELECT COUNT(*)AS num, page_id, pages.title, 
                       CONCAT(LEFT(pages.description,30),'...') AS description
             FROM history JOIN pages ON pages.id = history.page_id
             WHERE type = 'page'
             GROUP BY page_id
             ORDER BY 1 DESC
             LIMIT 3";
       
       try{
            $stmt = $this->conn->query($sql);
            $popular = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Create an array to hold the success|failure
            // Date|message
            $data = array('error'=>false,
                          'items'=>$popular);
            
        } catch (PDOException $ex) {
            $data = array ('error'=>true,
                           'message'=>$ex->getMessage()
                    );
        }// end of try catch
        // Return data back to calling enviroment
        return $data;
       
   }//End of get PopularList
   
   public function getArticle($id){
       try{
           //Prepare our sql query with $id param coming from outside environment.
           $stmt=$this->conn->prepare("SELECT title,description,content
                                      FROM pages
                                      WHERE id=:id");
           //Bind our parameter
           $stmt->bindvalue(':id',$id,PDO::PARAM_INT);
            
           //Execute the query
           $stmt-> execute();
           
           //Fetch the data of an associtative array
           $page = $stmt->FetchAll(PDO::FETCH_ASSOC);
           
           //Fetch array of data items
           $data = array(
               'error' =>false,
               'items' =>$page
           );
               
           } catch (PDOException $ex) {
            $data = array ('error'=>true,
                           'message'=>$ex->getMessage()
       );
       
   }//end of try catch
   
   //return final data array
   return $data;
   
   }//end of getArticle
   
    public function getArticles(){
      
           //Prepare our sql query 
           $sql = ("SELECT id,title,description FROM pages ORDER BY title");
           
           try{
               $stmt=$this->conn->query($sql);
               $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
               //return array of data items
               $data = array(
               'error' =>false,
               'items' =>$articles
           );
            
           } catch (PDOException $ex) {
            $data = array ('error'=>true,
                           'message'=>$ex->getMessage()
       );
       
   }//end of try catch
   
   //return final data array
   return $data;
   
   }//end of getArticles
    
}//End of class
