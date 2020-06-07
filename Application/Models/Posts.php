<?php 
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
use MVC\Model;
 
class ModelsPosts extends Model {

    public function checkPostIsOwner($params,$userId){
        $postId = $params['postId'];
        $userPost = $userId;
        $sql = "SELECT * FROM `messenger`.`post` where id = $postId and userPost = $userPost";
         return $this->db->query($sql);
    }

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
            $sql = $sql."    `comment`.`parrentTag`,";
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

            
            $sql = $sql. "FROM messenger.comment,messenger.users_profile WHERE postId = $postId AND messenger.comment.userComment = messenger.users_profile.id AND messenger.comment.parentId = 0    ORDER BY created_at ASC   ";
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
            $sql = $sql."    `comment`.`parrentTag`,";
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
    public function createNewPost($params, $userId){
        $userPost = $userId;
        $groupId = $params['groupId'];
        $postTitle = $params['postTitle'];
        $postContent = $params['postContent'];
        $postImgUrl = $params['imgUrl'];
        $sql = " INSERT INTO `messenger`.`post` (";
        $sql .="`userPost`,";
        $sql .="`groupId`,";
        $sql .="`created_at`,";
        $sql .="`post_title`,";
        $sql .="`post_content`,";
        $sql .="`postImgUrl`)";
        $sql .=" VALUES (";
        $sql .="$userPost,";
        $sql .="$groupId,";
        $sql .="now(),";
        $sql .="'$postTitle',";
        $sql .="'$postContent',";
        $sql .="'$postImgUrl');";
        $query = $this->db->query($sql);
        echo $sql;
        return $query;
    }

    public function updatePost($params){
        $postId = $params['postId'];
        $postTitle = $params['postTitle'];
        $postContent = $params['postContent'];
        $postImgUrl = $params['postImgUrl'];
        $sql = "UPDATE `messenger`.`post` SET";
        $sql .= "`updated_at` = now(),";
        $sql .= "`post_title` = '$postTitle',";
        $sql .= "`post_content` = '$postContent',";
        $sql .= "`postImgUrl` = '$postImgUrl'";
        $sql .= "WHERE `id` = $postId";
        $query = $this->db->query($sql);
         return $query;
    }
    public function deletePost($params){
        $postId = $params['postId']; 
        $sql = "DELETE FROM `messenger`.`post`  where id = $postId";
         $query = $this->db->query($sql);
        return $query;
    }

    public function postComment($params,$userId){
        $userComment = $userId;
        $postId = $params['postId'];
        $commentContent = $params['commentContent'];
        $parentId = $params['parentId'];
        $parrentTag = $params['parrentTag'];
        $sql = "INSERT INTO `messenger`.`comment` ( `userComment`,`postId`,`created_at`, `comment_content`,`parentId`,`parrentTag`) value ($userComment, $postId,now(),'$commentContent',$parentId,'$parrentTag') ";
         return $this->db->query($sql);
    }
  
}
