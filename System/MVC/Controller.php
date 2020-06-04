<?php

namespace MVC;
use \Firebase\JWT\JWT;
include_once SCRIPT.'core.php';
include_once JWT.'BeforeValidException.php';
include_once JWT.'ExpiredException.php';
include_once JWT.'SignatureInvalidException.php';
include_once JWT.'JWT.php';
class Controller {

    public $request;

    public $response;

    public $jwt;

    public $userName; 
    public $id;

    public function __construct() {
        $this->request = $GLOBALS['request'];
        $this->response = $GLOBALS['response'];
        $this->jwt = false;
        $this->userName = false;
        $this->id = false;
    }

    public function model($model) {
        $file = MODELS . ucfirst($model) . '.php';

		// check exists file
        if (file_exists($file)) {
            require_once $file;

            $model = 'Models' . str_replace('/', '', ucwords($model, '/'));
			// check class exists
            if (class_exists($model))
                return new $model;
            else 
                throw new Exception(sprintf('{ %s } this model class not found', $model));
        } else {
            throw new Exception(sprintf('{ %s } this model file not found', $file));
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

                //$this->response->sendStatus(200);
                $array = array(
                    "message" => "Access granted.",
                    "data" => $decoded->data
                );
                $response = json_encode(array(
                    "message" => "Access granted.",
                    "data" => $decoded->data
                ));
                         
                //$this->response->setContent($response);
                $this->userName =  $array['data']->userName ;
                $this->id = $array['data']->id ;
                return true;
            }
            catch(Exception $e){
                 //$this->response->sendStatus(401);
                $response = json_encode(array(
                    "message" => "Access denied.",
                        "error" => $e->getMessage()
                ));
                echo json_encode(array(
                        "message" => "Access denied.",
                            "error" => $e->getMessage()
                        ));
                    $this->response->setContent($response);
                    return false;
            }
        }
        else{
           // $this->response->sendStatus(401);
            $response = json_encode(array(
                "message" => "Access denied.",
                    "error" =>"Login Failed!!!"
                ));
                         
            $this->response->setContent($response);
            return false;
        }
        return false;
    }

	// send response faster
    public function send($status = 200, $msg) {
        $this->response->setHeader(sprintf('HTTP/1.1 ' . $status . ' %s' , $this->response->getStatusCodeText($status)));
        $this->response->setContent($msg);
    }
}
