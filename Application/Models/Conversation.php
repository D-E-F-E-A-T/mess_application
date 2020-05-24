<?php 

use MVC\Model;

class ModelsConversation extends Model {
    public function getAllConversation($userName){
         $sql = "SELECT conversation.* FROM CONVERSATION,`messenger`.`conversation_users` 
        WHERE CONVERSATION.conversation_id = CONVERSATION_USERS.conversation_id
         AND CONVERSATION_USERS.USERNAME ='$userName'"; 
         $result = $this->db->query($sql);
        if($result->num_rows > 0 ){
            return $result;
        }
        else{
            return false;
        }
    }   
}
