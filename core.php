<?php
// show error reporting
error_reporting(E_ALL);
 
// set your default time-zone
date_default_timezone_set('Asia/Manila');
 
// variables used for jwt
$key = "messenger_key";
$iss = "http://messenger.org";
$aud = "http://messenger.com";
$iat = 1356999524;
$nbf = 1357000000;
