<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
use MVC\Controller;
 

class ControllersFiles extends Controller{
   public function uploadSimpleFile() {
      if ($this->validToken()) {
          $target_dir = UPLOAD;
          $target_file = $target_dir . basename($this->request->files['image']["name"]);
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
          // Check if image file is a actual image or fake image
          $check = getimagesize($this->request->files['image']["tmp_name"]);
          if ($check !== false) {
            $uploadOk = 1;
            } else {
               $uploadOk = 0;
            }
          // Check if file already exists
          if (file_exists($target_file)) {
              //$uploadOk = 0;
              $target_file .= "xxx";
          }
          // Check file size
          if ($this->request->files['image']["size"] > 500000) {
              $uploadOk = 0;
          }
          // Allow certain file formats
          if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
              $uploadOk = 0;
          }
          // Check if $uploadOk is set to 0 by an error
          if ($uploadOk == 0) {
            $response = json_encode(array(
               "message" => "Upload Failed" 
            ));
            $this->response->sendStatus(409);
            $this->response->setContent($response);
              
          } 
          else {
              if (move_uploaded_file($this->request->files['image']["tmp_name"], $target_file)) {
               $response = (array(
                  "url" => "http://localhost/messenger/Application/Upload/" . basename($this->request->files['image']["name"])
               ));
               $this->response->sendStatus(201);
               $this->response->setContent($response);
              } else {
               $response = (array(
                  "message" => "Upload Failed" ,
                  "url" => null
               ));
               $this->response->sendStatus(409);
               $this->response->setContent($response);
              }
          }
      }
   }
    

}


