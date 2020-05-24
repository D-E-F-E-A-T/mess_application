<?php

use MVC\Controller;
 
class ControllersMessages extends Controller{
     public function getAllMessages(){
         if($this->validToken()){
            $model = $this->model('messages');
            $params = $this->request->request;
             $data = $model->getAllMessages($params);
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


