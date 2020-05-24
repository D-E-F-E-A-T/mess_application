<?php
include_once SCRIPT.'core.php';
include_once JWT.'BeforeValidException.php';
include_once JWT.'ExpiredException.php';
include_once JWT.'SignatureInvalidException.php';
include_once JWT.'JWT.php';
 
// files for decoding jwt will be here

use MVC\Controller;

use \Firebase\JWT\JWT;

class ControllersAuthentication extends Controller{
 
    public function login(){
        $model = $this->model('authentication');
        $params = $this->request->request;
        if ($model->login($params)) {
            $token = array(
                "iss" => 'http://messenger.org',
                "aud" => 'http://messenger.org',
                "iat" => 1356999524,
                "nbf" => 1357000000,
                "data" => array(
                     "userName" => $params['userName']
                )
            );
            // set response code
            $this->response->sendStatus(200);
            // generate jwt
            $jwt = JWT::encode($token, 'messenger_key','HS256');
            $message = ['jwt' => $jwt];
            $this->response->setContent(json_encode($message));
            $this->jwt = $message['jwt'];
        }
        else{
            $this->response->sendStatus(412);
            $this->response->setContent("Login Failed!!!");
        }
    }
    public function logout(){
    }
    public function registration(){
        $model = $this->model('authentication');
        $params = $this->request->request;
        if ($params) {
            if ($model->registration($params) == true) {
                $this->response->sendStatus(201);
                $this->response->setContent($params);
            } else {
                $this->response->sendStatus(412);
                $this->response->setContent("Created Fail!!!");
            }
        }
    }
    
    
 
}
