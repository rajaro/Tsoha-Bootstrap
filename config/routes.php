<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/keikka', function() {
  HelloWorldController::keikka_lista();
});
$routes->get('/keikka/1', function() {
  HelloWorldController::keikka_nayta();
});

$routes->get('/esiintymispaikka', function() {
    HelloWorldController::esiintymispaikka();
});
