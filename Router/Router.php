<?php
header("Access-Control-Allow-Origin: *");

// paths
$router->get('/', function() {
    echo '<div style="text-align: center;width: 350px;margin: 50px auto;font-size: 25px;padding: 50px;box-shadow: 0 0 10px #dedede;border-radius: 5px;">
        Welcome To The Pure PHP Rest-Endpoint <br><br>
        <a href="https://github.com/LingDev/mess_application" title="lingdev-github"> My profile </a>
    </div>';
});

//Authentication
$router->post('/authentication/registration', 'Authentication@registration');
$router->post('/authentication/login', 'Authentication@login');
$router->post('/authentication/validtoken', 'Authentication@validToken');

//Users
$router->get('/users/getAllUsers','Users@getAllUsers');

$router->post('/users/getAllUsers','Users@getAllUsers');
$router->get('/request/badrequest','Badrequest@response');
$router->get('/users/getInfoUser', 'Users@getInfoUser');
//Conversation

$router->get('/conversation/getAllConversation', 'Conversation@getAllConversation');


//Messages

$router->post('/messages/getAllMessages', 'Messages@getAllMessages');
$router->post('/messages/createNewMessage', 'Messages@createNewMessage');


//groups

$router->post('/groups/getAllGroups', 'Groups@getAllGroups');
$router->get('/groups/getAllTypesGroup', 'Groups@getAllTypesGroup');

$router->post('/groups/createGroup', 'Groups@createGroup');
$router->post('/groups/requestToJoinAGroup', 'Groups@requestToJoinAGroup');
$router->post('/groups/getAllGroupJoined', 'Groups@getAllGroupJoined');
$router->post('/groups/getAllPostInGroup', 'Groups@getAllPostInGroup');
$router->post('/groups/checkIsAdminGroup', 'Groups@checkIsAdminGroup');

//post
$router->post('/posts/getAllCommentInPost', 'Posts@getAllCommentInPost');
$router->post('/posts/updateViewOfPost', 'Posts@updateViewOfPost');
$router->post('/posts/getAllReplyComment', 'Posts@getAllReplyComment');

?>

 


