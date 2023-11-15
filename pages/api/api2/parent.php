<?php
require './header.php';
if ($auth->checkToken()) {
    
}

echo json_encode($returnData);