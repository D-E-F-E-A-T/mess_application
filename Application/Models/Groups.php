<?php 

use MVC\Model;

class ModelsGroups  extends Model {
    
    public function getAllGroups() {

        $sql = "SELECT * FROM messenger.group";
 
        $query = $this->db->query($sql);

        return $query;
    }

    public function getAllTypesOfGroup(){
        
        $sql = "SELECT * FROM messenger.group_type";
 
        $query = $this->db->query($sql);

        return $query;
    }
    public function createGroup($params,$userCreate) { //with trigger in DB, oke fine
        $groupName = $params['groupName'];
        $groupDescription = $params['groupDescription'];
        $grouptTypeId = $params['grouptTypeId'];
        $userAdmin = $userCreate;
        $sql = "INSERT INTO `messenger`.`group`( `group_name`,`group_description`,`userAdmin`,`created_at`,`group_type_id`,`totalMember` ) VALUES ('$groupName' ,'$groupDescription','$userAdmin',NOW(),$grouptTypeId,1 );";
        $query = $this->db->query($sql);
        echo $sql;
         return $query;
    }
    public function createARequest($params,$userCreate) {
        $groupId = $params['groupId'];
        $userRequest = $userCreate;
        $status = 'PENDING';
        $sql = "SELECT * FROM `messenger`.`group_request` WHERE `userRequest` = (SELECT id from user_auth where userName = '$userCreate') AND `groupId` = $groupId AND status = '$status'   ";
        $query = $this->db->query($sql);
        if($query->num_rows < 1) {
            $sql = "INSERT INTO `messenger`.`group_request`( `userRequest`,`groupId`,`status`,`created_at`) VALUES( $userRequest,$groupId,'$status',now());";
            $query = $this->db->query($sql);
            return $query;
        }
        return false;;
        
    }
    public function acceptingARequest($params,$admin) { //with trigger in DB, oke fine
        $requestId = $params['requestId'];
        $groupId = $params['groupId'];
        $userRequest = $params['userRequest'];
        $admin = $admin;
        $status = 'PENDING';
        $sql = "UPDATE `messenger`.`group_request` SET `status` ='ACCEPTED',`accepted_at` = now() WHERE `id` = $requestId ;";
        $query = $this->db->query($sql);
        return $query;
    }

    public function getAdminOfGroup($params) {
        $groupId = $params['groupId'];
        $sql = "SELECT userAdmin from messenger.group where ID = $groupId";
        $query = $this->db->query($sql);
        return $query;
    }
    public function getAllJoinedGroup($userId){
        $sql = "select * from messenger.group, messenger.group_users where messenger.group.id = messenger.group_users.groupId and messenger.group_users.userId  = $userId";
        $query = $this->db->query($sql);
        return $query;
    }
}


 
