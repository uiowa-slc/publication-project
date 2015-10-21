<?php
class Author extends Contributor {

 private static $db = array(
  
    );
    
 private static $has_one = array( 

 );
 
 private static $many_many = array(
 	'Articles' => 'Article'
 );   

    
   public function getCMSFields() {
        $fields = parent::getCMSFields();
        
        
        return $fields;
    }
    
}
