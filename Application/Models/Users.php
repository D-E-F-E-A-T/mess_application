<?php 

use MVC\Model;

class ModelsUsers  extends Model {
    
    public function getAllUsers() {

        $sql = "SELECT * FROM messenger.users";
 
        $query = $this->db->query($sql);

        return $query;
    }

}


 
