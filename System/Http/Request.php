<?php

namespace Http;
include_once SCRIPT.'core.php';
include_once JWT.'BeforeValidException.php';
include_once JWT.'ExpiredException.php';
include_once JWT.'SignatureInvalidException.php';
include_once JWT.'JWT.php';
use \Firebase\JWT\JWT;


class Request {

    public $cookie;

    public $request;

    public $files;
 

    public function __construct() {
        $this->request =  ($_REQUEST) ;
        $this->cookie = $this->clean($_COOKIE);
        $this->files = $this->clean($_FILES);
 
    }

    public function get(String $key = '') {
        if ($key != '')
            return isset($_GET[$key]) ? $this->clean($_GET[$key]) : null;

        return  $this->clean($_GET);
    }

    public function post(String $key = '') {
        if ($key != '')
            return isset($_POST[$key]) ? $this->clean($_POST[$key]) : null;

        return  $this->clean($_POST);
    }

    public function input(String $key = '') {
        $postdata = file_get_contents("php://input",true);
        $request = json_decode($postdata, true);
         if ($key != '') {
            return isset($request[$key]) ? $this->clean($request[$key]) : null;
        } 

        return ($request);
    }

    public function server(String $key = '') {
        return isset($_SERVER[strtoupper($key)]) ? $this->clean($_SERVER[strtoupper($key)]) : $this->clean($_SERVER);
    }

    public function getMethod() {
        return strtoupper($this->server('REQUEST_METHOD'));
    }


    public function getClientIp() {
        return $this->server('REMOTE_ADDR');
    }

    public function getUrl() {
        return $this->server('QUERY_STRING');
    }
    public function validToken(){
        //TOOL TIP IF NOT HAVE AUTHEN FROM HEADER https://devhacksandgoodies.wordpress.com/2014/06/27/apache-pass-authorization-header-to-phps-_serverhttp_authorization/
        $jwt = $this->server('HTTP_AUTHORIZATION');
        echo $jwt;
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
         
                // set response code
                // $this->response->sendStatus(200);
    
                // $response = json_encode(array(
                //     "message" => "Access granted.",
                //     "data" => $decoded->data
                // ));
                         
                // $this->response->setContent($response);
                return true;
            }
            catch(Exception $e){
                    // set response code
                // $this->response->sendStatus(401);
                // $response = json_encode(array(
                //     "message" => "Access denied.",
                //         "error" => $e->getMessage()
                // ));
                echo json_encode(array(
                        "message" => "Access denied.",
                            "error" => $e->getMessage()
                        ));
                // $this->response->setContent($response);
                    return false;
            }
        }
        else{
            // $this->response->sendStatus(401);
            // $response = json_encode(array(
            //     "message" => "Access denied."
            // ));
                         
            // $this->response->setContent($response);
            return false;
        }
        return false;
    }
 
    private function clean($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {

                // Delete key
                unset($data[$key]);

                // Set new clean key
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }

        return $data;
    }
}
