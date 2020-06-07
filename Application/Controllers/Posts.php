<?php

use MVC\Controller;
 
class ControllersPosts extends Controller{
    public function getAllCommentInPost(){
        if($this->validToken()){
            $model = $this->model('posts');
            $params = $this->request->request;
            $data = $model->getAllCommentInPost($params);
            $this->response->sendStatus(201);
            $this->response->setContent($data->rows);

        }
    }
    public function updateViewOfPost(){
        if($this->validToken()){
            $model = $this->model('posts');
            $params = $this->request->request;
            $data = $model->updateViewOfPost($params);
            $this->response->sendStatus(201);
            $this->response->setContent($data);
        }
    }
    public function getAllReplyComment(){
        if($this->validToken()){
            $model = $this->model('posts');
            $params = $this->request->request;
            $data = $model->getAllReplyComment($params);
            $this->response->sendStatus(201);
            $this->response->setContent($data->rows);

        }
    }

    public function createNewPost(){
        if($this->validToken()){
            $model = $this->model('posts');
            $params = $this->request->request;
            $data = $model->createNewPost($params,$this->id);
            if($data->num_rows >0){
                $this->response->sendStatus(201);
                $this->response->setContent($data);
            }
            else{
                $this->response->sendStatus(404);
                $this->response->setContent($data);
            }
        }
    }

    public function updatePost(){
        if($this->validToken()){
            $model = $this->model('posts');
            $params = $this->request->request;
            if($model->checkPostIsOwner($params, $this->id)){
                $data = $model->updatePost($params);
                if($data->num_rows >0){
                    $this->response->sendStatus(201);
                    $this->response->setContent($data);
                }
                else{
                    $this->response->sendStatus(404);
                    $this->response->setContent($data);
                }
            }
            else{
                $response = array(
                    "role" => "Not Allow"
                );
                $this->response->sendStatus(405);
                $this->response->setContent($response);
            }
        }
    }


    public function deletePost(){
        if($this->validToken()){
            $postModel = $this->model('posts');
            $groupModel = $this->model('groups');
            $params = $this->request->request;
            if($postModel->checkPostIsOwner($params, $this->id) ||$groupModel->checkIsAdmin($params, $this->id) ){
                $data = $postModel->deletePost($params);
                if($data->num_rows >0){
                    $this->response->sendStatus(201);
                    $this->response->setContent($data);
                }
                else{
                    $this->response->sendStatus(404);
                    $this->response->setContent($data);
                }
            }
            else{
                $response = array(
                    "role" => "Not Allow"
                );
                $this->response->sendStatus(405);
                $this->response->setContent($response);
            }
        }
    }
}
