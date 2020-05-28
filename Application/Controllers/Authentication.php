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
            $message = ['jwt' => $jwt, 'user'=>$model->login($params)->row];
            $this->response->setContent($message);
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
    public function validToken(){
        //TOOL TIP IF NOT HAVE AUTHEN FROM HEADER https://devhacksandgoodies.wordpress.com/2014/06/27/apache-pass-authorization-header-to-phps-_serverhttp_authorization/
        $jwt = $this->request->server('HTTP_AUTHORIZATION');
         if (preg_match('/Bearer\s(\S+)/', $jwt, $matches)) {
            $jwt =  $matches[1];
        }
        else{
            $jwt =  "";
        }
         if($jwt!=""){
            try {
                // decode jwt
                $decoded = JWT::decode($jwt, 'messenger_key', array('HS256'));

                $this->response->sendStatus(200);
                $array = array(
                    "message" => "Access granted.",
                    "data" => $decoded->data
                );
                $response = json_encode(array(
                    "message" => "Access granted.",
                    "data" => $decoded->data
                ));
                         
                $this->response->setContent($response);
                $this->userName =  ($array['data']->userName) ;
                return true;
            }
            catch(Exception $e){
                 $this->response->sendStatus(401);
                $response = json_encode(array(
                    "message" => "Access denied.",
                        "error" => $e->getMessage()
                ));
                echo json_encode(array(
                        "message" => "Access denied.",
                            "error" => $e->getMessage()
                        ));
                 //$this->response->setContent($response);
                    return false;
            }
        }
        else{
            $this->response->sendStatus(401);
            $response = json_encode(array(
               "message" => "Access denied."
            ));
                         
            $this->response->setContent($response);
            return false;
        }
        return false;
    }
}
