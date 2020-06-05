<?php

use MVC\Controller;
 

class ControllersGroups extends Controller{
 
    public function getAllGroups(){
        if($this->validToken()){
            $model = $this->model('groups');
            $data = $model->getAllGroups($this->request->request);
            $this->response->sendStatus(201);
            $this->response->setContent($data->rows);
        }
    }
    public function getAllTypesGroup(){
        if($this->validToken()){
            $model = $this->model('groups');
            $data = $model->getAllTypesOfGroup();
            $this->response->sendStatus(201);
            $this->response->setContent($data->rows);
        }
    }
    public function createGroup(){
        if($this->validToken()){
            $model = $this->model('groups');
            $data = $model->createGroup($this->request->request,$this->userName,$this->id);
            if($data->num_rows>0){
                $response = array(
                    "message" => "Create Oke."
                );
                $this->response->sendStatus(201);
                $this->response->setContent($response);
            }
            else{
                $response = array(
                    "message" => "Create Fail."
                );
                $this->response->sendStatus(201);
                $this->response->setContent($response);
            }   
        }
         
    }
    public function requestToJoinAGroup(){
        if($this->validToken()){
            $model = $this->model('groups');
            $data = $model->createARequest($this->request->request,$this->id);
            if($data){
                $response = array(
                    "message" => "Requested."
                );
                $this->response->sendStatus(201);
                $this->response->setContent($response);
            }
            else{
                $response = array(
                    "message" => "Requested Fail."
                );
                $this->response->sendStatus(201);
                $this->response->setContent($response);
            }   
        }
    }
    public function acceptingARequest(){
        if($this->validToken()){
            $model = $this->model('groups');
            $params = $this->request->request;

            if($model->getAdminOfGroup($params)->row->userName === $this->userName){
                $data = $model->acceptingARequest($params,$this->userName);
                if($data->num_rows>0){
                    $response = array(
                        "message" => "Requested."
                    );
                    $this->response->sendStatus(201);
                    $this->response->setContent($response);
                }
                else{
                    $response = array(
                        "message" => "Requested Fail."
                    );
                    $this->response->sendStatus(201);
                    $this->response->setContent($response);
                }   
            }

        }
    }
    public function getAllGroupJoined(){
        if($this->validToken()){
            $model = $this->model('groups');
            $params = $this->request->request;
            $data = $model->getAllJoinedGroup($this->request->request,$this->id);
            if($data->num_rows>0){
                $response = array(
                    "message" => "Requested.",
                    "data" =>$data->rows 
                );
                $this->response->sendStatus(201);
                $this->response->setContent($response);
            }
            else{
                $response = array(
                    "message" => "Null.",
                    "data" =>$data->rows 
                );
                $this->response->sendStatus(201);
                $this->response->setContent($response);
            }   
 
        }
    }
    public function getAllPostInGroup(){
        if($this->validToken()){
            $model = $this->model('groups');
            $params = $this->request->request;
            $checkInGroup = $model->checkJoinedGroup($params, $this->id);
            if($checkInGroup  < 1 ){
                $this->response->sendStatus(404);
                $response = array(
                    "message" => "You not in this group"  
                );
                $this->response->setContent($response);
            } 
            else{
                $data = $model->getAllPostInGroup($params );
                if($data->num_rows>0){
                    $response = array(
                        "message" => "Requested.",
                        "data" =>$data->rows 
                    );
                    $this->response->sendStatus(201);
                    $this->response->setContent($response);
                }
                else{
                    $response = array(
                        "message" => "Null.",
                        "data" =>$data->rows 
                    );
                    $this->response->sendStatus(201);
                    $this->response->setContent($response);
            }  
            }
        }
    }
    public function checkIsAdminGroup(){
        if($this->validToken()){
            $model = $this->model('groups');
            $data = $model->checkIsAdmin($this->request->request,$this->id);
            if($data->num_rows > 0){
                $response = array(
                    "role" => "admin"
                );
                $this->response->sendStatus(201);
                $this->response->setContent($response);
            }
            else{
                $response = array(
                    "role" => "member"
                );
                $this->response->sendStatus(201);
                $this->response->setContent($response);
            }   
        }
    }
    
 
 }
