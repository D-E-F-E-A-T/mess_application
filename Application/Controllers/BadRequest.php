<?php
include_once SCRIPT.'core.php';
include_once JWT.'BeforeValidException.php';
include_once JWT.'ExpiredException.php';
include_once JWT.'SignatureInvalidException.php';
include_once JWT.'JWT.php';
 
// files for decoding jwt will be here

use MVC\Controller;

use \Firebase\JWT\JWT;

class ControllersBadrequest extends Controller{
    public function  response(){
         $this->response->setStatus(412);
         
    }
    

}
