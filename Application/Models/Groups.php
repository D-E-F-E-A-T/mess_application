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
        $imgUrl =  $params['imgUrl'];
        $userAdmin = $userCreate;
        $userAdminId = $userCreateId;
        $sql = "INSERT INTO `messenger`.`group`( `group_name`,`group_description`,`adminId`,`userAdmin`,`created_at`,`group_type_id`,`group_avatar` ) VALUES ('$groupName' ,'$groupDescription',$userAdminId,'$userAdmin',NOW(),$grouptTypeId,'$imgUrl' );";
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

    public function checkIsAdmin($params,$userId) {
        $groupId = $params['groupId'];
        $sql = "SELECT userAdmin from messenger.group where ID = $groupId AND adminId = $userId" ;
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
    public function getAllPostInGroup($params,$userId){
        $groupId = $params['groupId'];
        $sql = "SELECT ";
        $sql.= "`post`.`id`,";
        $sql.= "`post`.`userPost`,";
        $sql.= "`post`.`groupId`,";
        $sql.= "`post`.`created_at`,";
        $sql.=  "`post`.`updated_at`,";
        $sql.=  "`post`.`deleted_at`,";
        $sql.= "`post`.`post_title`,";
        $sql.= "`post`.`post_content`,";
        $sql.= "`post`.`post_img_id`,";
        $sql.= "`post`.`views`,";
        $sql.= "`post`.`totalComment`,";
        $sql.= "`users_profile`.`firstName`,";
        $sql.= " `users_profile`.`lastName`,";
        $sql.= "`users_profile`.`avatar`,";
        $sql.= "`users_profile`.`background_img`,";
        $sql.= "`users_profile`.`bio`,";
        $sql.= "`users_profile`.`from_address`,";
        $sql.= "`users_profile`.`live_address`,";
        $sql.=  "`users_profile`.`study_id`,";
        $sql.= "`users_profile`.`relationship_id`,";
        $sql.= " `users_profile`.`hobies`,";
        $sql.= "`users_profile`.`link_id`,";
        $sql.= "`users_profile`.`userName` ";
        $sql.= " FROM messenger.post,messenger.users_profile WHERE groupId = $groupId and  messenger.post.userPost = messenger.users_profile.id";
        if(isset($params['owner'])){
            $sql .= " AND userPost = $userId";
        }
        $sql .= " ORDER BY created_at DESC";
          $query = $this->db->query($sql);
        return $query;
    }
    public function getNumberOfView($params){
        $groupId = $params['groupId'];
        $sql = "SELECT SUM(views) as 'totalViews' from  messenger.post where   messenger.post.groupId =  $groupId";
        $query = $this->db->query($sql);
        if(isset($query->row['totalViews'])){
               return $query->row['totalViews'];
        }else{
            return 0;
        }
        
    }
    public function getNumberOfComment($params){
        $groupId = $params['groupId'];
        $sql = "SELECT SUM(totalComment) as 'totalComments'  from  messenger.post where   messenger.post.groupId =  $groupId";
        $query = $this->db->query($sql);
        if(isset($query->row['totalComments'])){
            return $query->row['totalComments'] ;
        }
        else{
            return 0;
        }
    }
    public function getInfoOfGroup($params){
        $groupId = $params['groupId'];
        $sql = "SELECT  * FROM messenger.group  where   messenger.group.id =  $groupId";
        $query = $this->db->query($sql);
        return $query;
    }

    public function updateGroup($params){
        $groupId = $params['groupId'];
        $groupName = $params['groupName'];
        $groupDes = $params['groupDes'];
        $imgUrl = $params['imgUrl'];
        $sql = "UPDATE messenger.group ";
        $sql .= "SET group_name = '$groupName', group_description = '$groupDes', group_avatar = '$imgUrl' , updated_at =now() WHERE id = $groupId ";
        $query = $this->db->query($sql);
        return $query;
    }
    public function deleteGroup($params){
        $groupId = $params['groupId'];
        $sql = "DELETE FROM `messenger`.`group`WHERE `id` = $groupId ";
        $query = $this->db->query($sql);
        return $query;
    }
}


 
