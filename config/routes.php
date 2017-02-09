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
  
  $routes->post('/yhtye', function(){
    YhtyeController::store();
});

$routes->post('/yhtye', function(){
    YhtyeController::create();
});

$routes->get('/yhtye/:id/edit', function($id) {
    YhtyeController::yhtye_nayta($id);
});

$routes->post('/yhtye/:id', function($id) {
    YhtyeController::update($id);
});

$routes->post('/yhtye/:id/delete', function($id) {
   YhtyeController::destroy($id); 
});

  $routes->get('/keikka', function() {
  KeikkaController::index();
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

$routes->get('/login', function(){
  // Kirjautumislomakkeen esittäminen
  KayttajaController::login();
});
$routes->post('/login', function(){
  // Kirjautumisen käsittely
  KayttajaController::handle_login();
});

