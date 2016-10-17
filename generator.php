<?php
require (__DIR__ . DIRECTORY_SEPARATOR . 'core.php');

require (__DIR__ . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'customer.php');

$viewName = 'generator';
$count = 500;

$success = false;
if (Customer::generate($count)) {
    $success = true;
}

require (__DIR__ . DIRECTORY_SEPARATOR . 'render.php');