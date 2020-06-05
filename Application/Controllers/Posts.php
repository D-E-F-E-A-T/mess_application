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
}
