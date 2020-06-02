<?php

use MVC\Controller;
 
class ControllersMessages extends Controller{
     public function getAllMessages(){
         if($this->validToken()){
            $model = $this->model('messages');
            $params = $this->request->request;
            $data = $model->getAllMessages($params);
            $data['currentUser'] = $this->userName;
            $this->response->sendStatus(201);
            $this->response->setContent($data);
         }
    }
    public function createNewMessage(){
        if($this->validToken()){
            $model = $this->model('messages');
            $data = $model->createNewMessage($this->request->request,$this->userName);
            if($data->num_rows>0){
                $this->response->sendStatus(201);
                $this->response->setContent($model->getLastMessage()->row);
            }
            else{
                $this->response->sendStatus(404);
                $this->response->setContent("No");
            }
        }
    }
    public function deleteMessage(){
        if($this->validToken()){
            $model = $this->model("messages");
            $result = $model->deleteMessage($this->request->request,$this->userName );
            if($result->num_rows>0){
                $this->response->sendStatus(201);
                $this->response->setContent($model->getLastMessage()->row);
            }
            else{
                $this->response->sendStatus(404);
                $this->response->setContent("No");
            }
        }

}

}
