<?php 

use MVC\Model;

class ModelsMessages extends Model {
    public function getAllMessages($params){
        $conversation_id = $params['conversation_id'];
        $sql = "select messages.* from messages, conversation where messages.conversation_id = conversation.conversation_id and conversation.conversation_id = $conversation_id"; 
        $query = $this->db->query($sql);

        $data = [];
        // Conclusion
        if ($query->num_rows) {
            foreach($query->rows as $key => $value):
                $data['messages'][] =  $value;
            endforeach;
        } else {
            $data['messages'][] = [
                'message'       => array(),
            ];
        }
        return $data;
    }
    public function createNewMessage($params,$userName){
        $conversation_id = $params['conversation_id'];
        $userName_sender = $userName;
        $messageContent = $params['messageContent'];
        $messageType = $params['massageType'];
        $sql = "INSERT INTO `messenger`.`messages`(`conversation_id`,`userName_sender`,`message_type`,`message`,`created_at`)VALUES($conversation_id,'$userName_sender','$messageType',' $messageContent',now());";
        $result = $this->db->query($sql);
        return $result;
    }
    public function getLastMessage(){
        $sql = "select * from `messenger`.`messages` ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($sql);
        return $result ;

    }
    public function deleteMessage($params,$userName){
        $messageId = $params['message_id'];
        $sql = "UPDATE messenger.messages SET MESSAGE = '', deleted_at = now() WHERE ID = $messageId  ";
        $result = $this->db->query($sql);
        return $result;
    }
}
