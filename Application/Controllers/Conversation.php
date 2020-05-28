<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
use MVC\Controller;
 

class ControllersConversation extends Controller{
     public function getAllConversation(){
         if($this->validToken()){
            $model = $this->model('conversation');
            $userName = $this->userName;
            $data = $model->getAllConversation($userName);
            if($data){
                $this->response->sendStatus(200);
                $this->response->setContent( $data->rows );
            }
            else{
                $this->response->sendStatus(200);
                $this->response->setContent(array());
            }
        }
    }
    

}


