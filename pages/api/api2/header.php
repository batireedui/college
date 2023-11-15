<?php
require './dbtoh.php';
require './Middleware/Auth.php';

$allHeaders = getallheaders();
$auth = new Auth($conn, $allHeaders);

$returnData = [
    "success" => 0,
    "status" => 401,
    "message" => "Unauthorized"
];

$json = file_get_contents('php://input');
$obj = json_decode($json, true);