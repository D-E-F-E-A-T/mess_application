<?php

use MVC\Controller;
use \Firebase\JWT\JWT;

class ControllersConversation extends Controller{
     public function getAllConversation(){
         if($this->validToken()){
            $model = $this->model('conversation');
            $userName = $this->userName;
            $data = $model->getAllConversation($userName);
            if($data){
                $this->response->sendStatus(201);
                $this->response->setContent($data->rows);
            }
            else{
                $this->response->sendStatus(201);
                $this->response->setContent(null);
            }
        }
    }
    

}


