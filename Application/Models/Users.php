<?php 

use MVC\Model;

class ModelsUsers  extends Model {
    
    public function getAllUsers() {

        $sql = "SELECT * FROM messenger.users";
 
        $query = $this->db->query($sql);

        return $query;
    }
    public function getInfoUser($userName){
        $sql =  "SELECT * FROM messenger.users_profile WHERE users_profile.userName = '$userName'";
        $result = $this->db->query($sql);
         return $result;
    }

}


 
