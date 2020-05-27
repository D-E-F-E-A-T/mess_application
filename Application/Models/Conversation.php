<?php 
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
use MVC\Model;

class ModelsConversation extends Model {
    public function getAllConversation($userName){
        $sql = "SELECT T.*, users_profile.id as 'partnerId',users_profile.firstName,users_profile.lastName,users_profile.avatar,users_profile.background_img,users_profile.from_address,users_profile.bio,users_profile.live_address,
        users_profile.study_id,users_profile.relationship_id,users_profile.hobies,users_profile.link_id
         FROM (SELECT *, CASE WHEN userName_1 = '$userName' THEN userName_2 ELSE userName_1 END AS 'partner' ";
         
        $sql = $sql . "FROM (SELECT conversation.* FROM CONVERSATION WHERE USERNAME_1 = '$userName' UNION SELECT conversation.* FROM CONVERSATION WHERE USERNAME_2 = '$userName')AS F) AS T, users_profile ";
         
        $sql = $sql . "WHERE users_profile.userName = T.partner"; 
        $result = $this->db->query($sql);
        if($result->num_rows > 0 ){
            return $result;
        }
        else{
            return false;
        }
    }   
 
}
