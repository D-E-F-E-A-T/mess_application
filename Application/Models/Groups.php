<?php 

use MVC\Model;

class ModelsGroups  extends Model {
    
    public function getAllGroups($params) {

        $sql = "SELECT * FROM messenger.group ";
        if(!empty($params) ) {
            if(isset($params['type'])){
                $type = $params['type'];
                $sql = $sql. " WHERE group_type_id in ($type)";
                if(isset($params['keySearch'])){
                    $keySearch = $params['keySearch'];
                    $sql = $sql. " AND group_name like N'%" . "$keySearch" . "%'"   ;
                 }
            }else{
                if(isset($params['keySearch'])){
                    $keySearch = $params['keySearch'];
                    $sql = $sql. " WHERE  group_name like N'%" . "$keySearch" . "%'"   ;
                }
            }
        }
         $query = $this->db->query($sql);
        return $query;
    }

    public function getAllTypesOfGroup(){
        
        $sql = "SELECT * FROM messenger.group_type";
 
        $query = $this->db->query($sql);

        return $query;
    }
    public function createGroup($params,$userCreate,$userCreateId) {  
        $groupName = $params['groupName'];
        $groupDescription = $params['groupDescription'];
        $grouptTypeId = $params['grouptTypeId'];
        $userAdmin = $userCreate;
        $userAdminId = $userCreateId;
        $sql = "INSERT INTO `messenger`.`group`( `group_name`,`group_description`,`adminId`,`userAdmin`,`created_at`,`group_type_id` ) VALUES ('$groupName' ,'$groupDescription',$userAdminId,'$userAdmin',NOW(),$grouptTypeId );";
        $query = $this->db->query($sql);
         if($query->num_rows > 0){
            $groupId = $this->db->getLastId();
            $sqlAfterInsert = "INSERT INTO `messenger`.`group_users` (`groupId`,`userId`) VALUES($groupId , $userAdminId );";
            $query = $this->db->query($sqlAfterInsert);
        }
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
    public function getAllJoinedGroup($params,$userId){
        $sql = "select * from messenger.group, messenger.group_users where messenger.group.id = messenger.group_users.groupId and messenger.group_users.userId  = $userId";
        if(!empty($params) ) {
            if(isset($params['type'])){
                $type = $params['type'];
                $sql = $sql. " AND group_type_id in ($type)";
                if(isset($params['keySearch'])){
                    $keySearch = $params['keySearch'];
                    $sql = $sql. " AND group_name like N'%" . "$keySearch" . "%'"   ;
                 }
            }else{
                if(isset($params['keySearch'])){
                    $keySearch = $params['keySearch'];
                    $sql = $sql. " AND  group_name like N'%" . "$keySearch" . "%'"   ;
                }
            }
        }
        $query = $this->db->query($sql);
        return $query;
    }

    public function checkJoinedGroup($params,$userId){
         $groupId = $params['groupId'];
        $sql = "SELECT * from  messenger.group_users WHERE  messenger.group_users.groupId = $groupId AND  messenger.group_users.userId = $userId ";
        $query = $this->db->query($sql);
         return $query->num_rows;
    }
    public function getAllPostInGroup($params){
        $groupId = $params['groupId'];
        $sql = "SELECT * FROM messenger.post WHERE groupId = $groupId;";
        $query = $this->db->query($sql);
        return $query;
    }
}


 
