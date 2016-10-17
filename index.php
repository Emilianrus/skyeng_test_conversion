<?php

require (__DIR__ . DIRECTORY_SEPARATOR . 'core.php');

require (__DIR__ . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'customer.php');

$viewName = 'index';

$daysInterval = 7;
if (!empty($_POST['days_interval'])) {
    $daysInterval = (int)$_POST['days_interval'];
}

if ($daysInterval < 1) {
    $daysInterval = 1;
}
if ($daysInterval > 365) {
    $daysInterval = 365;
}

$lastDate = Customer::getLastDateStamp();
$firstDate = Customer::getFirstDateStamp();
$conversions = Customer::ConversionReport($daysInterval);

require (__DIR__ . DIRECTORY_SEPARATOR . 'render.php');