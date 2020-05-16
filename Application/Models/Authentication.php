<?php 


use MVC\Model;

class ModelsAuthentication  extends Model {

 
    public function login($params) {
        $email = $params['email'];
        $password = $params['password'];
        $sql = "SELECT * FROM MESSENGER.USERS WHERE email = '$email' AND password='$password' LIMIT 0,1";
        echo $sql;
        if($this->db->query($sql)->num_rows>0){
            return true;
        }
        else{
            return false;
        }
    }

    public function registration($params){
        $phone = $params['phone'];
        $email = $params['email'];
        $password = password_hash($params['password'],PASSWORD_BCRYPT);
        $firstName = $params['firstName'];
        $lastName = $params['lastName'];
        $isActive = 1;
        $isReported = 0;
        $isBlocked = 0;
        $preference = $params['preference'];
        $sql = "INSERT INTO MESSENGER.USERS(phone, email, password, first_name, last_name, is_active, is_reported,is_blocked, preferences,created_at,updated_at)
                VALUES('$phone','$email','$password','$firstName','$lastName',$isActive,$isReported,$isBlocked,'$preference',". "@now,@now"    .")";
        if( $this->db->query($sql)->num_rows>0){
            return true;
        }
        return false;
    }
}
