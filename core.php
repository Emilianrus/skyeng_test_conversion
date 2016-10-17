<?php

define('APP_PATH', realpath(__DIR__));
define('VIEW_PATH', realpath(__DIR__) . DIRECTORY_SEPARATOR . 'views');

$GLOBALS['params'] = include(APP_PATH . DIRECTORY_SEPARATOR . 'params.php');