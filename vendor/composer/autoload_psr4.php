<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

return array(
    'Views\\' => array($baseDir . '/App/views'),
    'Stripe\\' => array($vendorDir . '/stripe/stripe-php/lib'),
    'Models\\' => array($baseDir . '/App/models'),
    'Lib\\' => array($baseDir . '/lib'),
    'Controllers\\' => array($baseDir . '/App/controllers'),
    'App\\' => array($baseDir . '/App'),
);
