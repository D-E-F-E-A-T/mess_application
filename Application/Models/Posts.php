<?php 
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
use MVC\Model;

class ModelsPosts extends Model {

     public function getAllCommentInPost($params){
         if(isset($params['postId'])){
            $postId = $params['postId'];
            $sql = "SELECT  ";
            $sql = $sql."`comment`.`id`,";
            $sql = $sql."  `comment`.`userComment`,";
            $sql = $sql."  `comment`.`postId`,";
            $sql = $sql."  `comment`.`created_at`,";
            $sql = $sql."   `comment`.`updated_at`,";
            $sql = $sql."    `comment`.`deleted_at`,";
            $sql = $sql."    `comment`.`comment_content`,";
            $sql = $sql."    `comment`.`parentId`,";
            // $sql = $sql. "`users_profile`.`id` as userProFile_Id,";
            $sql = $sql. "`users_profile`.`firstName`,";
            $sql = $sql. " `users_profile`.`lastName`,";
            $sql = $sql. "`users_profile`.`avatar`,";
            $sql = $sql. " `users_profile`.`background_img`,";
            $sql = $sql. "`users_profile`.`bio`,";
            $sql = $sql. " `users_profile`.`from_address`,";
            $sql = $sql. " `users_profile`.`live_address`,";
            $sql = $sql. " `users_profile`.`study_id`,";
            $sql = $sql. " `users_profile`.`relationship_id`,";
            $sql = $sql.  "`users_profile`.`hobies`,";
            $sql = $sql.  "`users_profile`.`link_id`";
            // $sql = $sql. " `users_profile`.`userName`";

            
            $sql = $sql. "FROM messenger.comment,messenger.users_profile WHERE postId = $postId AND messenger.comment.userComment = messenger.users_profile.id AND messenger.comment.parentId = 0    ORDER BY created_at ASC";
              $query = $this->db->query($sql);
            return $query;
         }
     }
     public function updateViewOfPost($params){
        if(isset($params['postId'])){
            $postId = $params['postId'];
            $sql = " UPDATE `messenger`.`post` SET `views` = `messenger`.`post`.`views` + 1  WHERE `id` = $postId ; ";
            $query = $this->db->query($sql);
             return $query;
         }
     }
     
     public function getAllReplyComment($params){
        if(isset($params['commentId'])){
           $commentId = $params['commentId'];
           $sql = "SELECT  ";
            $sql = $sql."`comment`.`id`,";
            $sql = $sql."  `comment`.`userComment`,";
            $sql = $sql."  `comment`.`postId`,";
            $sql = $sql."  `comment`.`created_at`,";
            $sql = $sql."   `comment`.`updated_at`,";
            $sql = $sql."    `comment`.`deleted_at`,";
            $sql = $sql."    `comment`.`comment_content`,";
            $sql = $sql."    `comment`.`parentId`,";
            // $sql = $sql. "`users_profile`.`id` as userProFile_Id,";
            $sql = $sql. "`users_profile`.`firstName`,";
            $sql = $sql. " `users_profile`.`lastName`,";
            $sql = $sql. "`users_profile`.`avatar`,";
            $sql = $sql. " `users_profile`.`background_img`,";
            $sql = $sql. "`users_profile`.`bio`,";
            $sql = $sql. " `users_profile`.`from_address`,";
            $sql = $sql. " `users_profile`.`live_address`,";
            $sql = $sql. " `users_profile`.`study_id`,";
            $sql = $sql. " `users_profile`.`relationship_id`,";
            $sql = $sql.  "`users_profile`.`hobies`,";
            $sql = $sql.  "`users_profile`.`link_id`";
            // $sql = $sql. " `users_profile`.`userName`";

            
            $sql = $sql. "FROM messenger.comment,messenger.users_profile WHERE parentId = $commentId AND messenger.comment.userComment = messenger.users_profile.id     ORDER BY created_at ASC";
            $query = $this->db->query($sql);
           return $query;
        }
    }
    public function createNewComment(){

    }

  
}
