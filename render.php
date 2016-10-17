<?php

if (empty($viewName)) {
    $viewName = 'index';
}

$filePath = 
    VIEW_PATH
    . DIRECTORY_SEPARATOR
    . strtolower($viewName)
    . '.php';
    
if (empty($title)) {
    $title = 'Тестовое задание';
}

require(VIEW_PATH
    . DIRECTORY_SEPARATOR 
    . 'head.php');
require($filePath);
require(VIEW_PATH
    . DIRECTORY_SEPARATOR 
    . 'footer.php');




