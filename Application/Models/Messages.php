<?php 

use MVC\Model;

class ModelsMessages extends Model {
    public function getAllMessages($params){
        $conversation_id = $params['conversation_id'];
        $sql = "select messages.* from messages, conversation where messages.conversation_id = conversation.conversation_id and conversation.conversation_id = $conversation_id"; 
        $result = $this->db->query($sql); 
        if($result->num_rows > 0 ){
            return $result;
        }
        else{
            return false;
        }
    }
}
