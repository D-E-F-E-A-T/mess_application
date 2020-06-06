<?php

use MVC\Controller;
 

class ControllersGroups extends Controller{
 
    public function getAllGroups(){
        if($this->validToken()){
            $model = $this->model('groups');
            $data = $model->getAllGroups($this->request->request);
            $this->response->sendStatus(200);
            $this->response->setContent($data->rows);
        }
    }
    public function getAllTypesGroup(){
        if($this->validToken()){
            $model = $this->model('groups');
            $data = $model->getAllTypesOfGroup();
            $this->response->sendStatus(200);
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
                $this->response->sendStatus(200);
                $this->response->setContent($response);
            }
            else{
                $response = array(
                    "message" => "Null.",
                    "data" =>$data->rows 
                );
                $this->response->sendStatus(200);
                $this->response->setContent($response);
            }   
 
        }
    }
    public function getAllPostInGroup(){
        if($this->validToken()){
            $model = $this->model('groups');
            $params = $this->request->request;

            $data = $model->getAllPostInGroup($params,$this->id);
            if($data->num_rows>0){
                $response = array(
                    "message" => "Requested.",
                    "data" =>$data->rows 
                );
                $this->response->sendStatus(200);
                $this->response->setContent($response);
            }
            else{
                $response = array(
                    "message" => "Null.",
                    "data" =>$data->rows 
                );
                $this->response->sendStatus(200);
                $this->response->setContent($response);
            }
        }
    }
    public function checkIsAdminGroup(){
        if($this->validToken()){
            $model = $this->model('groups');
            $data = $model->checkIsAdmin($this->request->request,$this->id);
            if($model->checkJoinedGroup($this->request->request, $this->id) >0){
                if($data->num_rows > 0){
                    $response = array(
                        "role" => "admin"
                    );
                    $this->response->sendStatus(200);
                    $this->response->setContent($response);
                }
                else{
                    $response = array(
                        "role" => "member"
                    );
                    $this->response->sendStatus(200);
                    $this->response->setContent($response);
                }
            }
            else{
                $response = array(
                    "role" => "Not Allow"
                );
                $this->response->sendStatus(200);
                $this->response->setContent($response);
            }
        }
    }
    public function getInfoOfGroup(){
        if($this->validToken()){
            $model = $this->model('groups');
            $data = $model->getInfoOfGroup($this->request->request );
            if($data->num_rows){
                $data->row['totalViews'] = $model->getNumberOfView($this->request->request);
                $data->row['totalComments'] = $model->getNumberOfComment($this->request->request);
            }
            $this->response->sendStatus(200);
            $this->response->setContent($data->row);
        }
    }

    public function updateGroup(){
        if($this->validToken()){
            $model = $this->model('groups');
            if($model->checkIsAdmin($this->request->request, $this->id)->num_rows > 0){
                $data = $model->updateGroup($this->request->request);
                $this->response->sendStatus(200);
                $this->response->setContent($data);
            }
            else{
                $response = array(
                    "role" => "Not Allow"
                );
                $this->response->sendStatus(404);
                $this->response->setContent($response);
            }
        }
    }
    
 
 }
