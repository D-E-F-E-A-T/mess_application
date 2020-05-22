<?php
// include_once SCRIPT.'core.php';
// include_once JWT.'BeforeValidException.php';
// include_once JWT.'ExpiredException.php';
// include_once JWT.'SignatureInvalidException.php';
// include_once JWT.'JWT.php';

 
// files for decoding jwt will be here

use MVC\Controller;
 

class ControllersUsers extends Controller{
 
    public function getAllUsers(){
        $model = $this->model('users');
        $data = $model->getAllUsers();
        $this->response->sendStatus(201);
        $this->response->setContent($data);
 
    }
}
