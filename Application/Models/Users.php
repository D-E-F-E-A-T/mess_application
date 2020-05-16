<?php 

use MVC\Model;

class ModelsUsers  extends Model {
    
    public function getAllUsers() {

        // sql statement
        $sql = "SELECT * FROM " . DB_PREFIX . ".users";
 
        $query = $this->db->query($sql);

        return $query;
    }

}



?>
