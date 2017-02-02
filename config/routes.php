<?php

  $routes->get('/', function() {
      KeikkaController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/yhtyeet', function() {
      YhtyeController::yhtyeet();
  });
  
  $routes->get('/yhtye/new', function() {
      YhtyeController::yhtye_new();
  });
  
  $routes->get('/yhtye/:id', function($id) {
      YhtyeController::yhtye_nayta($id);
  });

  $routes->get('/keikka', function() {
  KeikkaController::index();
});

$routes->post('/yhtye', function(){
    YhtyeController::store();
});

$routes->post('/yhtye', function(){
    YhtyeController::create();
});

$routes->get('/keikka/:id', function($id) {
  KeikkaController::keikka_nayta($id);
});

$routes->get('/esiintymispaikka', function() {
    HelloWorldController::esiintymispaikka();
});

$routes->get('/keikka/new', function() {
    KeikkaController::keikka_new();
});

$routes->post('/keikka', function(){
    KeikkaController::store();
});

$routes->post('/keikka', function(){
    KeikkaController::create();
});

